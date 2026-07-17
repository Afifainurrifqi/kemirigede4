<?php

namespace App\Imports;

use App\Models\agama;
use App\Models\Datapenduduk;
use App\Models\detailkk;
use App\Models\goldar;
use App\Models\kk;
use App\Models\pekerjaan;
use App\Models\pendidikan;
use App\Models\status;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class Importdatapenduduk implements
    OnEachRow,
    WithHeadingRow,
    WithChunkReading,
    SkipsEmptyRows
{
    use Importable;

    /**
     * Menyimpan NIK yang sudah diproses dalam file yang sama.
     */
    private array $processedNiks = [];

    /**
     * Menyimpan daftar NIK yang sudah ada di database.
     */
    private ?array $databaseNiks = null;

    /**
     * Cache data master.
     */
    private array $referenceMaps = [];

    /**
     * Ringkasan import.
     */
    private int $inserted = 0;
    private int $skippedExisting = 0;
    private int $skippedDuplicateFile = 0;
    private int $invalid = 0;

    /**
     * Peringatan.
     */
    private array $warnings = [];
    private int $warningLimit = 150;
    private int $warningOverflow = 0;

    /**
     * Memproses setiap baris XLSX.
     */
    public function onRow(Row $excelRow): void
    {
        $rowNumber = $excelRow->getIndex();

        /*
         * Normalisasi nama header agar tetap terbaca walaupun
         * konfigurasi heading Laravel Excel berbeda.
         */
        $row = $this->normalizeRowKeys(
            $excelRow->toArray()
        );

        $nik = null;

        try {
            /*
             * =====================================================
             * NO KK DAN NIK
             * =====================================================
             */

            $nokk = $this->normalizeIdentity(
                $this->rowValue($row, [
                    'no_kk',
                    'nokk',
                    'nomor_kk',
                    'nomor_kartu_keluarga',
                ]),
                'No. KK'
            );

            $nik = $this->normalizeIdentity(
                $this->rowValue($row, [
                    'nik',
                    'nomor_induk_kependudukan',
                ]),
                'NIK'
            );

            /*
             * Apabila NIK sudah berhasil diproses dalam file ini,
             * baris berikutnya dengan NIK yang sama dilewati.
             */
            if (isset($this->processedNiks[$nik])) {
                $this->skippedDuplicateFile++;

                $this->addWarning(
                    "Baris {$rowNumber}: NIK {$nik} muncul lebih dari " .
                        'satu kali dalam file dan dilewati.'
                );

                return;
            }

            /*
             * Apabila NIK sudah ada di database, jangan diperbarui.
             */
            if ($this->nikExistsInDatabase($nik)) {
                $this->processedNiks[$nik] = true;
                $this->skippedExisting++;

                $this->addWarning(
                    "Baris {$rowNumber}: NIK {$nik} sudah ada " .
                        'di database dan dilewati.'
                );

                return;
            }

            /*
             * =====================================================
             * DATA WAJIB
             * =====================================================
             */

            $nama = $this->cleanText(
                $this->rowValue($row, ['nama'])
            );

            if ($nama === null) {
                throw new \InvalidArgumentException(
                    'Nama penduduk wajib diisi.'
                );
            }

            $jenisKelamin = $this->normalizeJenisKelamin(
                $this->rowValue($row, [
                    'jenis_kelamin',
                    'jk',
                    'kelamin',
                ])
            );

            $tanggalLahir = $this->parseDate(
                $this->rowValue($row, [
                    'tanggal_lahir',
                    'tgl_lahir',
                ]),
                true,
                'Tanggal lahir'
            );

            $tanggalPerkawinan = $this->parseMarriageDate(
                $this->rowValue($row, [
                    'tanggal_perkawinan',
                    'tahun_perkawinan',
                ])
            );

            /*
             * =====================================================
             * DATA MASTER
             * =====================================================
             */

            $agamaId = $this->resolveReferenceId(
                agama::class,
                $this->rowValue($row, [
                    'agama',
                    'agama_id',
                ]),
                'Agama'
            );

            $pendidikanId = $this->resolveReferenceId(
                pendidikan::class,
                $this->rowValue($row, [
                    'pendidikan',
                    'pendidikan_id',
                ]),
                'Pendidikan'
            );

            $pekerjaanId = $this->resolveReferenceId(
                pekerjaan::class,
                $this->rowValue($row, [
                    'pekerjaan',
                    'pekerjaan_id',
                ]),
                'Pekerjaan'
            );

            $goldarId = $this->resolveReferenceId(
                goldar::class,
                $this->rowValue($row, [
                    'golongan_darah',
                    'goldar',
                    'goldar_id',
                ]),
                'Golongan darah'
            );

            $statusId = $this->resolveReferenceId(
                status::class,
                $this->rowValue($row, [
                    'status_perkawinan',
                    'status',
                    'status_id',
                ]),
                'Status perkawinan'
            );

            $statusKependudukan = $this->normalizeDatak(
                $this->rowValue($row, [
                    'status_kependudukan',
                    'datak',
                ])
            );

            /*
             * =====================================================
             * SIMPAN DATA
             * =====================================================
             */

            DB::transaction(function () use (
                $row,
                $nokk,
                $nik,
                $nama,
                $jenisKelamin,
                $tanggalLahir,
                $tanggalPerkawinan,
                $agamaId,
                $pendidikanId,
                $pekerjaanId,
                $goldarId,
                $statusId,
                $statusKependudukan
            ): void {
                /*
                 * Cek kembali di dalam transaction untuk mencegah
                 * duplikasi ketika ada proses import bersamaan.
                 */
                if (
                    Datapenduduk::query()
                    ->where('nik', $nik)
                    ->exists()
                ) {
                    throw new \RuntimeException(
                        'NIK sudah tersedia di database.'
                    );
                }

                $penduduk = new Datapenduduk();

                $penduduk->user_id = null;

                $penduduk->nik = $nik;

                $penduduk->gelarawal = $this->cleanText(
                    $this->rowValue($row, [
                        'gelar_awal',
                        'gelarawal',
                    ])
                );

                $penduduk->nama = $nama;

                $penduduk->gelarakhir = $this->cleanText(
                    $this->rowValue($row, [
                        'gelar_akhir',
                        'gelarakhir',
                    ])
                );

                $penduduk->jenis_kelamin = $jenisKelamin;

                $penduduk->tempat_lahir = $this->cleanText(
                    $this->rowValue($row, [
                        'tempat_lahir',
                    ])
                );

                $penduduk->tanggal_lahir = $tanggalLahir;
                $penduduk->agama_id = $agamaId;
                $penduduk->pendidikan_id = $pendidikanId;
                $penduduk->pekerjaan_id = $pekerjaanId;
                $penduduk->goldar_id = $goldarId;
                $penduduk->status_id = $statusId;
                $penduduk->tanggal_perkawinan = $tanggalPerkawinan;

                $penduduk->hubungan = $this->cleanText(
                    $this->rowValue($row, [
                        'hubungan',
                        'hubungan_dalam_keluarga',
                    ])
                );

                $penduduk->ayah = $this->cleanText(
                    $this->rowValue($row, [
                        'ayah',
                        'nama_ayah',
                    ])
                );

                $penduduk->ibu = $this->cleanText(
                    $this->rowValue($row, [
                        'ibu',
                        'nama_ibu',
                    ])
                );

                $penduduk->alamat = $this->cleanText(
                    $this->rowValue($row, [
                        'alamat',
                    ])
                );

                $penduduk->rt = $this->cleanCode(
                    $this->rowValue($row, ['rt'])
                );

                $penduduk->rw = $this->cleanCode(
                    $this->rowValue($row, ['rw'])
                );

                $penduduk->datak = $statusKependudukan;
                $penduduk->save();

                /*
                 * No KK yang sama menggunakan record KK yang sama.
                 */
                $kartuKeluarga = kk::query()
                    ->firstOrCreate([
                        'nokk' => $nokk,
                    ]);

                /*
                 * Satu penduduk hanya mempunyai satu detail KK.
                 */
                detailkk::query()->updateOrCreate(
                    [
                        'idpenduduk' => $penduduk->getKey(),
                    ],
                    [
                        'idkk' => $kartuKeluarga->getKey(),
                    ]
                );
            }, 3);

            /*
             * Tandai NIK setelah transaksi berhasil.
             */
            $this->processedNiks[$nik] = true;

            if ($this->databaseNiks === null) {
                $this->databaseNiks = [];
            }

            $this->databaseNiks[$nik] = true;
            $this->inserted++;
        } catch (Throwable $e) {
            /*
             * Apabila NIK ternyata sudah dimasukkan oleh proses lain,
             * catat sebagai NIK yang sudah ada.
             */
            if (
                $nik !== null &&
                Datapenduduk::query()
                ->where('nik', $nik)
                ->exists()
            ) {
                $this->processedNiks[$nik] = true;

                if ($this->databaseNiks === null) {
                    $this->databaseNiks = [];
                }

                $this->databaseNiks[$nik] = true;
                $this->skippedExisting++;

                $this->addWarning(
                    "Baris {$rowNumber}: NIK {$nik} sudah ada " .
                        'di database dan dilewati.'
                );

                return;
            }

            $this->invalid++;

            $identity = $nik !== null
                ? "NIK {$nik}"
                : "baris {$rowNumber}";

            $this->addWarning(
                "Baris {$rowNumber} ({$identity}): " .
                    $e->getMessage()
            );
        }
    }

    /**
     * Membaca XLSX per 500 baris.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Normalisasi seluruh nama header.
     */
    private function normalizeRowKeys(array $row): array
    {
        $normalized = [];

        foreach ($row as $key => $value) {
            $normalizedKey = $this->normalizeHeader(
                (string) $key
            );

            $normalized[$normalizedKey] = $value;
        }

        return $normalized;
    }

    /**
     * Mengubah nama header menjadi snake_case sederhana.
     */
    private function normalizeHeader(string $header): string
    {
        $header = mb_strtolower(
            trim($header),
            'UTF-8'
        );

        $header = preg_replace(
            '/[^a-z0-9]+/u',
            '_',
            $header
        );

        return trim($header, '_');
    }

    /**
     * Mengambil nilai berdasarkan beberapa kemungkinan header.
     */
    private function rowValue(
        array $row,
        array $keys
    ): mixed {
        foreach ($keys as $key) {
            $normalizedKey = $this->normalizeHeader($key);

            if (! array_key_exists($normalizedKey, $row)) {
                continue;
            }

            $value = $row[$normalizedKey];

            if ($value === null) {
                continue;
            }

            if (
                is_string($value) &&
                trim($value) === ''
            ) {
                continue;
            }

            return $value;
        }

        return null;
    }

    /**
     * Membersihkan teks dan mengganti enter/tab/spasi ganda
     * menjadi satu spasi.
     *
     * Contoh:
     * "BELUM/TIDAK \nBEKERJA"
     * menjadi:
     * "BELUM/TIDAK BEKERJA"
     */
    private function cleanText(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = preg_replace(
            '/\s+/u',
            ' ',
            trim((string) $value)
        );

        return $value === '' ? null : $value;
    }

    /**
     * Membersihkan kode RT/RW tanpa menghilangkan nol di depan.
     */
    private function cleanCode(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        $value = preg_replace('/\.0+$/', '', $value);

        return $value === '' ? null : $value;
    }

    /**
     * Normalisasi NIK dan No KK.
     */
    private function normalizeIdentity(
        mixed $value,
        string $fieldName
    ): string {
        if ($value === null) {
            throw new \InvalidArgumentException(
                "{$fieldName} kosong."
            );
        }

        $rawValue = trim((string) $value);

        if ($rawValue === '') {
            throw new \InvalidArgumentException(
                "{$fieldName} kosong."
            );
        }

        /*
         * Hilangkan apostrof pembuka dari Excel.
         */
        $rawValue = ltrim($rawValue, "'");

        /*
         * Hilangkan akhiran .0 apabila terbaca sebagai angka.
         */
        $rawValue = preg_replace(
            '/\.0+$/',
            '',
            $rawValue
        );

        /*
         * Scientific notation tidak aman untuk NIK 16 digit.
         */
        if (
            preg_match(
                '/[eE][+-]?\d+/',
                $rawValue
            )
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} menggunakan notasi ilmiah " .
                    "\"{$rawValue}\". Atur kolom menjadi Text di Excel."
            );
        }

        $digits = preg_replace(
            '/\D+/',
            '',
            $rawValue
        );

        if (strlen($digits) !== 16) {
            throw new \InvalidArgumentException(
                "{$fieldName} harus tepat 16 digit. " .
                    "Nilai diterima: \"{$rawValue}\"."
            );
        }

        return $digits;
    }

    /**
     * Jenis kelamin disimpan sebagai kode 1 dan 2.
     */
    private function normalizeJenisKelamin(
        mixed $value
    ): string {
        $value = strtoupper(
            preg_replace(
                '/[^A-Za-z0-9]/',
                '',
                trim((string) $value)
            )
        );

        return match ($value) {
            '1',
            'L',
            'LK',
            'LAKI',
            'LAKILAKI',
            'PRIA',
            'MALE' => '1',

            '0',
            '2',
            'P',
            'PR',
            'PEREMPUAN',
            'WANITA',
            'FEMALE' => '2',

            default => throw new \InvalidArgumentException(
                'Jenis kelamin tidak dikenali.'
            ),
        };
    }

    /**
     * Normalisasi status kependudukan.
     */
    private function normalizeDatak(
        mixed $value
    ): string {
        $value = mb_strtolower(
            $this->cleanText($value) ?? '',
            'UTF-8'
        );

        $value = preg_replace(
            '/[^a-z]/',
            '',
            $value
        );

        return match ($value) {
            'tetap' => 'tetap',

            'tidaktetap' => 'tidaktetap',

            default => throw new \InvalidArgumentException(
                'Status kependudukan harus Tetap atau Tidak Tetap.'
            ),
        };
    }

    /**
     * Menyelesaikan nama data master menjadi ID.
     *
     * Pencocokan tidak membedakan:
     * - huruf besar dan kecil;
     * - enter;
     * - tab;
     * - spasi ganda.
     */
    private function resolveReferenceId(
        string $modelClass,
        mixed $value,
        string $fieldName
    ): ?int {
        $value = $this->cleanText($value);

        if ($value === null) {
            return null;
        }

        /*
         * Apabila XLSX berisi ID data master.
         */
        if (ctype_digit($value)) {
            $id = (int) $value;

            if (
                $modelClass::query()
                ->whereKey($id)
                ->exists()
            ) {
                return $id;
            }
        }

        $lookupValue = $this->normalizeLookup($value);
        $referenceMap = $this->getReferenceMap($modelClass);

        if (array_key_exists($lookupValue, $referenceMap)) {
            return $referenceMap[$lookupValue];
        }

        throw new \InvalidArgumentException(
            "{$fieldName} \"{$value}\" tidak ditemukan " .
                'pada data master.'
        );
    }

    /**
     * Memuat data master ke cache.
     */
    private function getReferenceMap(
        string $modelClass
    ): array {
        if (isset($this->referenceMaps[$modelClass])) {
            return $this->referenceMaps[$modelClass];
        }

        $map = [];

        $records = $modelClass::query()
            ->get(['id', 'nama']);

        foreach ($records as $record) {
            $normalizedName = $this->normalizeLookup(
                $record->nama
            );

            if ($normalizedName !== '') {
                $map[$normalizedName] = (int) $record->id;
            }
        }

        $this->referenceMaps[$modelClass] = $map;

        return $map;
    }

    /**
     * Normalisasi nilai untuk pencocokan data master.
     */
    private function normalizeLookup(
        mixed $value
    ): string {
        $value = $this->cleanText($value) ?? '';

        return mb_strtolower(
            $value,
            'UTF-8'
        );
    }

    /**
     * Parsing tanggal.
     */
    private function parseDate(
        mixed $value,
        bool $required,
        string $fieldName
    ): ?string {
        if (
            $value === null ||
            (
                is_string($value) &&
                trim($value) === ''
            )
        ) {
            if ($required) {
                throw new \InvalidArgumentException(
                    "{$fieldName} wajib diisi."
                );
            }

            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value)
                ->format('Y-m-d');
        }

        /*
         * Nomor serial tanggal Excel.
         */
        if (
            is_numeric($value) &&
            (float) $value > 1000 &&
            (float) $value < 100000
        ) {
            return Carbon::instance(
                ExcelDate::excelToDateTimeObject(
                    (float) $value
                )
            )->format('Y-m-d');
        }

        $dateValue = trim((string) $value);

        /*
         * Tahun 0000 tidak disimpan karena merupakan tanggal
         * yang tidak valid.
         */
        if (
            preg_match(
                '/^0000[-\/]/',
                $dateValue
            )
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} \"{$dateValue}\" memiliki tahun 0000. " .
                    'Perbaiki tahun kelahirannya pada file XLSX.'
            );
        }

        $formats = [
            'Y-m-d',
            'Y-m-d H:i:s',
            'd/m/Y',
            'd-m-Y',
            'm/d/Y',
            'm-d-Y',
        ];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat(
                    '!' . $format,
                    $dateValue
                );

                $errors = Carbon::getLastErrors();

                if (
                    $errors === false ||
                    (
                        ($errors['warning_count'] ?? 0) === 0 &&
                        ($errors['error_count'] ?? 0) === 0
                    )
                ) {
                    return $date->format('Y-m-d');
                }
            } catch (Throwable $e) {
                // Lanjut ke format berikutnya.
            }
        }

        throw new \InvalidArgumentException(
            "{$fieldName} \"{$dateValue}\" tidak dikenali."
        );
    }

    /**
     * Tahun perkawinan dapat berisi tahun atau tanggal lengkap.
     */
    private function parseMarriageDate(
        mixed $value
    ): ?string {
        if (
            $value === null ||
            (
                is_string($value) &&
                trim($value) === ''
            )
        ) {
            return null;
        }

        $stringValue = trim((string) $value);
        $stringValue = preg_replace('/\.0+$/', '', $stringValue);

        if (
            preg_match(
                '/^\d{4}$/',
                $stringValue
            )
        ) {
            $year = (int) $stringValue;

            if (
                $year < 1900 ||
                $year > ((int) date('Y') + 1)
            ) {
                throw new \InvalidArgumentException(
                    "Tahun perkawinan {$year} tidak valid."
                );
            }

            return $year . '-01-01';
        }

        return $this->parseDate(
            $value,
            false,
            'Tanggal perkawinan'
        );
    }

    /**
     * Memuat NIK database satu kali.
     */
    private function loadDatabaseNiks(): void
    {
        if ($this->databaseNiks !== null) {
            return;
        }

        $this->databaseNiks = [];

        Datapenduduk::query()
            ->select('nik')
            ->orderBy('id')
            ->chunkById(
                1000,
                function ($records): void {
                    foreach ($records as $record) {
                        $nik = preg_replace(
                            '/\D+/',
                            '',
                            (string) $record->nik
                        );

                        if ($nik !== '') {
                            $this->databaseNiks[$nik] = true;
                        }
                    }
                }
            );
    }

    /**
     * Memeriksa NIK di database.
     */
    private function nikExistsInDatabase(
        string $nik
    ): bool {
        $this->loadDatabaseNiks();

        return isset($this->databaseNiks[$nik]);
    }

    /**
     * Menambahkan pesan peringatan.
     */
    private function addWarning(
        string $message
    ): void {
        if (count($this->warnings) < $this->warningLimit) {
            $this->warnings[] = $message;

            return;
        }

        $this->warningOverflow++;
    }

    /**
     * Ringkasan hasil import.
     */
    public function getSummary(): array
    {
        return [
            'inserted' => $this->inserted,

            'skipped_existing' =>
            $this->skippedExisting,

            'skipped_duplicate_file' =>
            $this->skippedDuplicateFile,

            'invalid' => $this->invalid,

            'skipped' =>
            $this->skippedExisting +
                $this->skippedDuplicateFile +
                $this->invalid,

            'warnings' => $this->warnings,

            'warning_overflow' =>
            $this->warningOverflow,
        ];
    }
}
