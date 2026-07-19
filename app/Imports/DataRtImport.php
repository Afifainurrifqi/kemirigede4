<?php

namespace App\Imports;

use App\Models\Datart;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use RuntimeException;
use Throwable;

/**
 * Import hasil Export Excel Data RT.
 *
 * Satu baris Excel menggunakan NIK sebagai kunci. Setiap kelompok kolom
 * disimpan ke model masing-masing. Data umum Ketua RT juga disalin ke
 * setiap dokumen MongoDB agar strukturnya konsisten dengan data lama.
 */
class DataRtImport extends StringValueBinder implements
    ToCollection,
    WithChunkReading,
    WithCustomValueBinder,
    SkipsEmptyRows
{
    private int $absoluteRow = 0;
    private int $processed = 0;
    private int $imported = 0;
    private int $failed = 0;
    private int $skipped = 0;
    private int $duplicates = 0;
    private array $seenNiks = [];
    private array $errors = [];

    /**
     * true  = sel kosong tidak menghapus nilai lama.
     * false = database mengikuti isi file, termasuk nilai kosong.
     */
    public function __construct(
        private bool $skipBlankUpdates = false
    ) {
    }

    public function chunkSize(): int
    {
        return max(
            1,
            (int) config('data_rt_import.chunk_size', 10)
        );
    }

    public function collection(Collection $rows): void
    {
        $mappedRows = [];

        foreach ($rows as $row) {
            $this->absoluteRow++;

            $values = $row instanceof Collection
                ? array_values($row->all())
                : array_values((array) $row);

            if ($this->isHeaderRow($values)) {
                continue;
            }

            if ($this->isEmptyRow($values)) {
                $this->skipped++;
                continue;
            }

            $this->processed++;

            try {
                $mapped = $this->mapRow($values);
                $nik = $mapped['nik'];

                if (isset($this->seenNiks[$nik])) {
                    $this->duplicates++;
                }

                $this->seenNiks[$nik] = true;
                $mappedRows[$nik] = $mapped;
            } catch (Throwable $exception) {
                $this->failed++;
                $this->recordError(
                    $this->absoluteRow,
                    null,
                    $exception->getMessage()
                );
            }
        }

        if ($mappedRows === []) {
            return;
        }

        $failedNiks = $this->persistRows($mappedRows);

        foreach ($mappedRows as $nik => $mappedRow) {
            if (!isset($failedNiks[$nik])) {
                $this->imported++;
            } else {
                $this->failed++;
            }
        }
    }

    private function mapRow(array $row): array
    {
        $expectedColumns = (int) config(
            'data_rt_import.expected_columns',
            872
        );

        if (count($row) < $expectedColumns) {
            throw new RuntimeException(
                'Jumlah kolom hanya '
                . count($row)
                . ". File export harus memiliki {$expectedColumns} kolom."
            );
        }

        $nik = $this->normalizeNik($row[1] ?? null);

        /*
         * Kolom umum hasil export:
         * 0 = No
         * 1 = NIK
         * 2 = Nama Ketua RT
         * 3 = Alamat
         * 4 = RT
         * 5 = RW
         * 6 = Nomor HP
         *
         * Collection MongoDB lama Anda menyimpan data umum tersebut pada
         * setiap dokumen. Oleh karena itu, semua model selain Datart harus
         * menerima nama_ketua, alamat, rt, rw, dan nohp yang sama.
         */
        $commonPayload = [
            'nama_ketua' => $this->normalizeValue($row[2] ?? null),
            'alamat' => $this->normalizeValue($row[3] ?? null),
            'rt' => $this->normalizeValue($row[4] ?? null),
            'rw' => $this->normalizeValue($row[5] ?? null),
            'nohp' => $this->normalizeValue($row[6] ?? null),
        ];

        if ($this->skipBlankUpdates) {
            $commonPayload = array_filter(
                $commonPayload,
                fn ($value): bool => !$this->isBlank($value)
            );
        }

        $documents = [];

        foreach ($this->configuredModels() as $model) {
            $documents[$model] = $model === Datart::class
                ? []
                : $commonPayload;
        }

        foreach (config('data_rt_import.columns', []) as $column) {
            $model = $column['model'];
            $attribute = $column['attribute'];
            $index = $column['index'];

            if ($model === Datart::class && $attribute === 'nik') {
                continue;
            }

            $value = $this->normalizeValue($row[$index] ?? null);

            if (
                $this->skipBlankUpdates
                && $this->isBlank($value)
            ) {
                continue;
            }

            $documents[$model] ??= $model === Datart::class
                ? []
                : $commonPayload;

            if (
                !array_key_exists($attribute, $documents[$model])
                || !$this->isBlank($value)
            ) {
                $documents[$model][$attribute] = $value;
            }
        }

        return [
            'nik' => $nik,
            'row' => $this->absoluteRow,
            'documents' => $documents,
        ];
    }

    /**
     * Datart disimpan pada koneksi default.
     * Model lainnya mengikuti koneksi MongoDB milik class masing-masing.
     */
    private function persistRows(array $mappedRows): array
    {
        $failedNiks = [];
        $niks = array_map(
            static fn ($nik): string => (string) $nik,
            array_keys($mappedRows)
        );

        foreach ($this->configuredModels() as $model) {
            try {
                /*
                 * Versi importer sebelumnya sempat menyimpan NIK MongoDB
                 * sebagai angka. Query memakai dua bentuk agar dokumen lama
                 * tetap ditemukan, kemudian NIK dikonversi menjadi string
                 * saat disimpan ulang.
                 */
                $lookupNiks = $niks;

                if ($model !== Datart::class && PHP_INT_SIZE >= 8) {
                    foreach ($niks as $nik) {
                        $lookupNiks[] = (int) $nik;
                    }
                }

                $existing = $model::query()
                    ->whereIn('nik', array_values(array_unique($lookupNiks)))
                    ->get()
                    ->keyBy(
                        static fn ($document): string =>
                            (string) ($document->nik ?? '')
                    );
            } catch (Throwable $exception) {
                foreach ($mappedRows as $nik => $mappedRow) {
                    $failedNiks[$nik] = true;
                    $this->recordError(
                        $mappedRow['row'],
                        $nik,
                        "Gagal membaca {$model}: "
                        . $exception->getMessage()
                    );
                }

                continue;
            }

            foreach ($mappedRows as $nik => $mappedRow) {
                $payload = $mappedRow['documents'][$model] ?? [];

                try {
                    $document = $existing->get($nik);

                    if (!$document) {
                        $document = new $model();
                    }

                    /*
                     * NIK ditetapkan langsung karena mayoritas model MongoDB
                     * belum memasukkan nik ke dalam $fillable.
                     */
                    $document->nik = (string) $nik;

                    foreach ($payload as $attribute => $value) {
                        $document->{$attribute} = $value;
                    }

                    $document->save();
                } catch (Throwable $exception) {
                    $failedNiks[$nik] = true;
                    $this->recordError(
                        $mappedRow['row'],
                        $nik,
                        "Gagal menyimpan {$model}: "
                        . $exception->getMessage()
                    );
                }
            }
        }

        return $failedNiks;
    }

    private function configuredModels(): array
    {
        static $models = null;

        if ($models !== null) {
            return $models;
        }

        $models = [];

        foreach (config('data_rt_import.columns', []) as $column) {
            $models[] = $column['model'];
        }

        return $models = array_values(array_unique($models));
    }

    private function normalizeNik($value): string
    {
        $nik = $this->normalizeValue($value);

        if ($this->isBlank($nik)) {
            throw new RuntimeException('NIK kosong.');
        }

        $nik = ltrim((string) $nik, "'");
        $nik = preg_replace('/[\s\-]/u', '', $nik) ?? $nik;

        if (preg_match('/[eE][+-]?\d+$/', $nik)) {
            throw new RuntimeException(
                'NIK terbaca sebagai notasi ilmiah. Ubah format NIK '
                . 'menjadi Text, lalu simpan ulang file.'
            );
        }

        if (preg_match('/^\d+\.0+$/', $nik)) {
            $nik = strstr($nik, '.', true);
        }

        if (!preg_match('/^\d{16}$/', $nik)) {
            throw new RuntimeException(
                "NIK '{$nik}' harus berupa tepat 16 digit."
            );
        }

        return $nik;
    }

    private function normalizeValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        $value = str_replace(
            ["\xC2\xA0", "\r\n", "\r"],
            [' ', "\n", "\n"],
            (string) $value
        );

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function isHeaderRow(array $row): bool
    {
        $first = mb_strtoupper(
            trim((string) ($row[0] ?? ''))
        );
        $second = mb_strtoupper(
            trim((string) ($row[1] ?? ''))
        );

        return $first === 'NO' && $second === 'NIK';
    }

    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $value) {
            if (!$this->isBlank($this->normalizeValue($value))) {
                return false;
            }
        }

        return true;
    }

    private function isBlank($value): bool
    {
        return $value === null
            || (is_string($value) && trim($value) === '');
    }

    private function recordError(
        int $row,
        ?string $nik,
        string $message
    ): void {
        $maxErrors = max(
            1,
            (int) config('data_rt_import.max_errors', 50)
        );

        if (count($this->errors) >= $maxErrors) {
            return;
        }

        $this->errors[] = [
            'row' => $row,
            'nik' => $nik,
            'message' => $message,
        ];
    }

    public function summary(): array
    {
        return [
            'processed' => $this->processed,
            'imported' => $this->imported,
            'failed' => $this->failed,
            'skipped' => $this->skipped,
            'duplicates' => $this->duplicates,
        ];
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
