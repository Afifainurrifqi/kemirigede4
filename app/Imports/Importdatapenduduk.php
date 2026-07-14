<?php

namespace App\Imports;

use App\Models\datapenduduk;
use App\Models\detailkk;
use App\Models\kk;
use Carbon\Carbon;
use DateTimeInterface;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class Importdatapenduduk implements IReadFilter
{
    /**
     * Menyimpan NIK yang sudah diproses pada file yang sama.
     *
     * Ini mencegah satu NIK diproses dua kali apabila terdapat
     * baris ganda di dalam CSV/XLS/XLSX.
     */
    private array $processedNiks = [];

    /**
     * Ringkasan proses import.
     */
    private int $inserted = 0;
    private int $updated = 0;
    private int $skipped = 0;

    /**
     * Daftar peringatan untuk baris yang tidak dapat diproses.
     */
    private array $warnings = [];

    /**
     * Baca seluruh baris.
     *
     * Header akan dideteksi dan dilewati di method model().
     * Dengan demikian file dengan header maupun tanpa header
     * sama-sama dapat diproses.
     */
    public function readCell(
        $column,
        $row,
        $worksheetName = ''
    ): bool {
        return $row >= 1;
    }

    /**
     * Dipertahankan untuk kompatibilitas dengan kode lama.
     */
    public function readFilter(
        $column,
        $row,
        $worksheetName = ''
    ): bool {
        return $this->readCell(
            $column,
            $row,
            $worksheetName
        );
    }

    /**
     * Proses satu baris data penduduk.
     */
    public function model(array $row): void
    {
        $row = array_values($row);

        if ($this->isEmptyRow($row)) {
            $this->skipped++;
            return;
        }

        /*
         * File dengan header akan dilewati.
         * File tanpa header tetap dimulai dari baris pertama.
         */
        if ($this->isHeaderRow($row)) {
            $this->skipped++;
            return;
        }

        if (count($row) < 21) {
            $this->addWarning(
                $row,
                'Jumlah kolom kurang dari 21.'
            );

            return;
        }

        try {
            $nokk = $this->normalizeIdentity(
                $row[0] ?? null,
                'No. KK'
            );

            $nik = $this->normalizeIdentity(
                $row[1] ?? null,
                'NIK'
            );
        } catch (Throwable $e) {
            $this->addWarning(
                $row,
                $e->getMessage()
            );

            return;
        }

        /*
         * Jangan memproses NIK yang sama dua kali
         * dalam satu file import.
         */
        if (isset($this->processedNiks[$nik])) {
            $this->skipped++;

            $this->warnings[] =
                "NIK {$nik} dilewati karena muncul lebih dari satu kali " .
                'dalam file import.';

            return;
        }

        $this->processedNiks[$nik] = true;

        try {
            $tanggalLahir = $this->parseDate(
                $row[7] ?? null,
                true
            );

            $tanggalPerkawinan = $this->parseDate(
                $row[13] ?? null,
                false
            );
        } catch (Throwable $e) {
            $this->addWarning(
                $row,
                "NIK {$nik}: {$e->getMessage()}"
            );

            return;
        }

        /*
         * =========================================================
         * DATA PENDUDUK
         * =========================================================
         *
         * firstOrNew berdasarkan NIK membuat import aman diulang:
         * - NIK baru     => insert
         * - NIK tersedia => update
         */
        $penduduk = datapenduduk::firstOrNew([
            'nik' => $nik,
        ]);

        $isNewPenduduk = ! $penduduk->exists;

        $penduduk->nik = $nik;
        $penduduk->gelarawal = $this->cleanValue($row[2] ?? null);
        $penduduk->nama = $this->cleanValue($row[3] ?? null);
        $penduduk->gelarakhir = $this->cleanValue($row[4] ?? null);
        $penduduk->jenis_kelamin = $this->cleanValue($row[5] ?? null);
        $penduduk->tempat_lahir = $this->cleanValue($row[6] ?? null);
        $penduduk->tanggal_lahir = $tanggalLahir;
        $penduduk->agama_id = $this->cleanValue($row[8] ?? null);
        $penduduk->pendidikan_id = $this->cleanValue($row[9] ?? null);
        $penduduk->pekerjaan_id = $this->cleanValue($row[10] ?? null);
        $penduduk->goldar_id = $this->cleanValue($row[11] ?? null);
        $penduduk->status_id = $this->cleanValue($row[12] ?? null);
        $penduduk->tanggal_perkawinan = $tanggalPerkawinan;
        $penduduk->hubungan = $this->cleanValue($row[14] ?? null);
        $penduduk->ayah = $this->cleanValue($row[15] ?? null);
        $penduduk->ibu = $this->cleanValue($row[16] ?? null);
        $penduduk->alamat = $this->cleanValue($row[17] ?? null);
        $penduduk->rt = $this->cleanValue($row[18] ?? null);
        $penduduk->rw = $this->cleanValue($row[19] ?? null);
        $penduduk->datak = $this->cleanValue($row[20] ?? null);

        /*
         * Hanya satu kali save().
         *
         * Pada kode lama terdapat dua kali:
         * $datapenduduk->save();
         */
        $penduduk->save();

        if ($isNewPenduduk) {
            $this->inserted++;
        } else {
            $this->updated++;
        }

        /*
         * =========================================================
         * KARTU KELUARGA
         * =========================================================
         *
         * Satu No. KK hanya memiliki satu record KK.
         * Anggota keluarga dengan No. KK yang sama menggunakan
         * record KK yang sudah ada.
         */
        $kartuKeluarga = kk::firstOrNew([
            'nokk' => $nokk,
        ]);

        if (! $kartuKeluarga->exists) {
            $kartuKeluarga->nokk = $nokk;
            $kartuKeluarga->save();
        }

        /*
         * =========================================================
         * DETAIL KK
         * =========================================================
         *
         * Satu penduduk hanya mempunyai satu relasi KK aktif.
         * Apabila No. KK berubah, relasi lama diperbarui,
         * bukan ditambahkan sebagai record baru.
         */
        $detailKk = detailkk::firstOrNew([
            'idpenduduk' => $penduduk->getKey(),
        ]);

        $detailKk->idpenduduk = $penduduk->getKey();
        $detailKk->idkk = $kartuKeluarga->getKey();
        $detailKk->save();
    }

    /**
     * Bersihkan nilai umum.
     */
    private function cleanValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    /**
     * Normalisasi NIK dan No. KK.
     *
     * Nilai harus terdiri dari tepat 16 digit.
     * Notasi ilmiah ditolak karena angka 16 digit yang sudah
     * diubah Excel menjadi 3,51E+15 tidak dapat dikembalikan
     * secara akurat.
     */
    private function normalizeIdentity(
        mixed $value,
        string $fieldName
    ): string {
        if ($value === null || trim((string) $value) === '') {
            throw new \InvalidArgumentException(
                "{$fieldName} kosong."
            );
        }

        $rawValue = trim((string) $value);

        /*
         * Hapus apostrof yang biasa digunakan agar Excel
         * memperlakukan NIK sebagai teks.
         */
        $rawValue = ltrim($rawValue, "'");

        /*
         * Tolak scientific notation seperti:
         * 3,51E+15 atau 3.51E+15.
         */
        if (preg_match('/[eE][+-]?\d+/', $rawValue)) {
            throw new \InvalidArgumentException(
                "{$fieldName} \"{$rawValue}\" menggunakan notasi ilmiah. " .
                'Ubah kolom NIK/No. KK menjadi format Text di Excel, ' .
                'lalu ekspor ulang.'
            );
        }

        $digits = preg_replace('/\D+/', '', $rawValue);

        if (strlen($digits) !== 16) {
            throw new \InvalidArgumentException(
                "{$fieldName} harus terdiri dari tepat 16 digit. " .
                "Nilai diterima: \"{$rawValue}\"."
            );
        }

        return $digits;
    }

    /**
     * Parsing tanggal dari Excel, CSV, XLS, atau XLSX.
     *
     * CSV yang dikirim menggunakan pola bulan/hari/tahun,
     * misalnya 5/19/1988. Format lain tetap didukung.
     */
    private function parseDate(
        mixed $value,
        bool $required
    ): ?string {
        if (
            $value === null ||
            trim((string) $value) === ''
        ) {
            if ($required) {
                throw new \InvalidArgumentException(
                    'Tanggal lahir wajib diisi.'
                );
            }

            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return Carbon::instance($value)->format('Y-m-d');
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
                ExcelDate::excelToDateTimeObject((float) $value)
            )->format('Y-m-d');
        }

        $dateValue = trim((string) $value);

        /*
         * Tentukan prioritas format untuk tanggal dengan "/".
         *
         * Contoh:
         * - 19/5/1988 => d/m/Y
         * - 5/19/1988 => m/d/Y
         * - 5/2/1966  => m/d/Y mengikuti CSV yang dikirim
         */
        $formats = [];

        if (
            preg_match(
                '/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/',
                $dateValue,
                $matches
            )
        ) {
            $first = (int) $matches[1];
            $second = (int) $matches[2];

            if ($first > 12) {
                $formats[] = 'd/m/Y';
            } elseif ($second > 12) {
                $formats[] = 'm/d/Y';
            } else {
                /*
                 * Tanggal ambigu mengikuti format CSV pengguna:
                 * bulan/hari/tahun.
                 */
                $formats[] = 'm/d/Y';
                $formats[] = 'd/m/Y';
            }
        }

        $formats = array_values(
            array_unique(
                array_merge(
                    $formats,
                    [
                        'Y-m-d',
                        'd/m/Y',
                        'm/d/Y',
                        'd-m-Y',
                        'm-d-Y',
                    ]
                )
            )
        );

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
                // Coba format berikutnya.
            }
        }

        throw new \InvalidArgumentException(
            "Format tanggal \"{$dateValue}\" tidak dikenali."
        );
    }

    /**
     * Deteksi header.
     */
    private function isHeaderRow(array $row): bool
    {
        $firstColumn = strtolower(
            trim((string) ($row[0] ?? ''))
        );

        $secondColumn = strtolower(
            trim((string) ($row[1] ?? ''))
        );

        $firstColumn = preg_replace(
            '/[^a-z0-9]/',
            '',
            $firstColumn
        );

        $secondColumn = preg_replace(
            '/[^a-z0-9]/',
            '',
            $secondColumn
        );

        return in_array(
            $firstColumn,
            ['nokk', 'nomorkk', 'no']
        ) || in_array(
            $secondColumn,
            ['nik', 'nomorindukkependudukan']
        );
    }

    /**
     * Deteksi baris kosong.
     */
    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $value) {
            if (
                $value !== null &&
                trim((string) $value) !== ''
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Tambahkan peringatan dan tandai baris sebagai dilewati.
     */
    private function addWarning(
        array $row,
        string $message
    ): void {
        $this->skipped++;

        $nama = trim((string) ($row[3] ?? ''));
        $nik = trim((string) ($row[1] ?? ''));

        $identity = $nama !== ''
            ? "Nama {$nama}"
            : "NIK {$nik}";

        $this->warnings[] =
            "{$identity}: {$message}";
    }

    /**
     * Ringkasan dapat dipanggil dari Controller setelah import.
     */
    public function getSummary(): array
    {
        return [
            'inserted' => $this->inserted,
            'updated' => $this->updated,
            'skipped' => $this->skipped,
            'warnings' => $this->warnings,
        ];
    }
}
