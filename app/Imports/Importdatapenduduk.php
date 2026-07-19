<?php

namespace App\Imports;

use App\Models\agama;
use App\Models\datapenduduk as DataPendudukModel;
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
     * NIK yang sudah diproses pada file yang sedang diimpor.
     */
    private array $processedNiks = [];

    /**
     * Cache pemeriksaan NIK di database.
     */
    private array $databaseNikCache = [];

    /**
     * Cache isi tabel master.
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
     * Jumlah status kependudukan kosong yang otomatis diisi Tetap.
     */
    private int $defaultedStatusKependudukan = 0;

    /**
     * Jumlah pekerjaan yang tidak ada di master dan diarahkan ke Lainnya.
     */
    private int $fallbackPekerjaanLainnya = 0;

    /**
     * Peringatan yang ditampilkan kepada pengguna.
     */
    private array $warnings = [];
    private int $warningLimit = 150;
    private int $warningOverflow = 0;

    /**
     * Status kependudukan default untuk baris yang kolomnya kosong.
     * Dataset Kemirigede pada file ini merupakan penduduk tetap.
     */
    private const DEFAULT_STATUS_KEPENDUDUKAN = 'tetap';

    /**
     * Alias nilai file XLSX ke nama yang tersedia pada data master.
     *
     * Nilai sebelah kanan harus sesuai dengan kolom "nama"
     * pada tabel master di database.
     */
    private const REFERENCE_ALIASES = [
        agama::class => [
            'katholik' => 'katolik',
        ],

        pekerjaan::class => [
            'mengurus rumah tangga' => 'ibu rumah tangga',
            'perdagangan' => 'pedagang',

            /*
             * File hanya menuliskan PETANI/PEKEBUN tanpa
             * membedakan pemilik lahan atau penyewa.
             */
            'petani/pekebun' => 'petani/pekebun pemilik lahan',

            'tukang batu' => 'konstruksi',
            'tukang kayu' => 'konstruksi',
            'tukang cukur' => 'lainnya',
            'pastor' => 'lainnya',
            'imam masjid' => 'ustadz/mubaligh',
            'tukang jahit' => 'lainnya',
            'transportasi' => 'sopir',
            'tukang sol sepatu' => 'lainnya',
            'pendeta' => 'lainnya',
            'wartawan' => 'lainnya',
            'jurnalis' => 'lainnya',
        ],

        status::class => [
            /*
             * Master status:
             * 1 = Kawin
             * 2 = Belum Kawin
             * 3 = Cerai Hidup
             * 4 = Cerai
             *
             * Karena tidak ada "Cerai Mati", nilai tersebut
             * diarahkan ke master "Cerai".
             */
            'cerai mati' => 'cerai',
            'cerai karena mati' => 'cerai',
            'cerai karena pasangan meninggal' => 'cerai',

            'cerai hidup' => 'cerai hidup',
            'cerai karena perceraian' => 'cerai hidup',
        ],
    ];

    /**
     * Header XLSX berada pada baris pertama.
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * Membaca file per 500 baris agar lebih ringan di hosting.
     */
    public function chunkSize(): int
    {
        return 500;
    }

    /**
     * Memproses satu baris XLSX.
     */
    public function onRow(Row $excelRow): void
    {
        $rowNumber = $excelRow->getIndex();

        /*
         * Normalisasi nama header agar konsisten di lokal dan hosting.
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
             * NIK ganda dalam file hanya diproses satu kali.
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
             * NIK yang sudah tersedia tidak diperbarui.
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
                 * Cek ulang dalam transaction untuk mencegah
                 * duplikasi pada import yang berjalan bersamaan.
                 */
                if (
                    DataPendudukModel::query()
                        ->where('nik', $nik)
                        ->exists()
                ) {
                    throw new \RuntimeException(
                        'NIK sudah tersedia di database.'
                    );
                }

                $penduduk = new DataPendudukModel();

                $penduduk->user_id = auth()->id();
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
            $this->databaseNikCache[$nik] = true;
            $this->inserted++;
        } catch (Throwable $e) {
            /*
             * Error satu baris tidak menghentikan seluruh import.
             */
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
     * Normalisasi seluruh nama header.
     */
    private function normalizeRowKeys(array $row): array
    {
        $normalized = [];

        foreach ($row as $key => $value) {
            $normalizedKey = $this->normalizeHeader(
                (string) $key
            );

            if ($normalizedKey === '') {
                continue;
            }

            $normalized[$normalizedKey] = $value;
        }

        return $normalized;
    }

    /**
     * Mengubah nama header menjadi snake_case.
     */
    private function normalizeHeader(string $header): string
    {
        /*
         * Hilangkan BOM apabila terbawa pada header pertama.
         */
        $header = preg_replace(
            '/^\xEF\xBB\xBF/',
            '',
            $header
        );

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
     * Mengambil nilai dari beberapa kemungkinan nama header.
     */
    private function rowValue(
        array $row,
        array $keys
    ): mixed {
        foreach ($keys as $key) {
            $normalizedKey = $this->normalizeHeader($key);

            if (!array_key_exists($normalizedKey, $row)) {
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
     * Membersihkan teks, tab, enter, dan spasi ganda.
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
     * Membersihkan RT/RW tanpa menghilangkan nol di depan.
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

        /*
         * Float besar berpotensi sudah kehilangan digit di Excel.
         */
        if (
            is_float($value) &&
            abs($value) >= 100000000000000
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} dibaca sebagai angka Excel dan " .
                'berpotensi kehilangan digit. Gunakan format Text.'
            );
        }

        $rawValue = trim((string) $value);

        if ($rawValue === '') {
            throw new \InvalidArgumentException(
                "{$fieldName} kosong."
            );
        }

        /*
         * Hilangkan apostrof pembuka Excel.
         */
        $rawValue = ltrim($rawValue, "'");

        /*
         * Notasi ilmiah tidak aman untuk identitas 16 digit.
         */
        if (
            preg_match(
                '/[eE][+-]?\d+/',
                $rawValue
            )
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} menggunakan notasi ilmiah " .
                "\"{$rawValue}\". Gunakan format Text di Excel."
            );
        }

        /*
         * Hilangkan akhiran .0.
         */
        $rawValue = preg_replace(
            '/\.0+$/',
            '',
            $rawValue
        );

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
        $cleanValue = $this->cleanText($value);

        /*
         * Pada file sumber, mulai baris tertentu kolom status
         * kependudukan memang kosong. Karena seluruh dataset ini
         * merupakan data penduduk Kemirigede, nilai kosong otomatis
         * disimpan sebagai penduduk tetap.
         */
        if ($cleanValue === null) {
            $this->defaultedStatusKependudukan++;

            return self::DEFAULT_STATUS_KEPENDUDUKAN;
        }

        $normalized = mb_strtolower(
            $cleanValue,
            'UTF-8'
        );

        $normalized = preg_replace(
            '/[^a-z0-9]/',
            '',
            $normalized
        );

        return match ($normalized) {
            'tetap',
            'penduduktetap',
            'wargatetap',
            'domisili',
            '1' => 'tetap',

            'tidaktetap',
            'penduduktidaktetap',
            'wargatidaktetap',
            'pendatang',
            'sementara',
            'nondomisili',
            'nonpermanen',
            '0',
            '2' => 'tidaktetap',

            default => throw new \InvalidArgumentException(
                'Status kependudukan "' . $cleanValue . '" tidak dikenali. ' .
                'Gunakan Tetap, Tidak Tetap, atau kosongkan untuk default Tetap.'
            ),
        };
    }

    /**
     * Menyelesaikan nilai data master menjadi ID.
     */
    private function resolveReferenceId(
        string $modelClass,
        mixed $value,
        string $fieldName
    ): ?int {
        $value = $this->cleanText($value);

        /*
         * Nilai master boleh kosong.
         */
        if ($value === null) {
            return null;
        }

        /*
         * File boleh langsung berisi ID master.
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

        /*
         * Coba nama persis terlebih dahulu.
         */
        if (array_key_exists($lookupValue, $referenceMap)) {
            return $referenceMap[$lookupValue];
        }

        /*
         * Coba alias.
         */
        $aliasCandidates = $this->getAliasCandidates(
            $modelClass,
            $lookupValue
        );

        foreach ($aliasCandidates as $candidate) {
            $normalizedCandidate = $this->normalizeLookup(
                $candidate
            );

            if (
                array_key_exists(
                    $normalizedCandidate,
                    $referenceMap
                )
            ) {
                return $referenceMap[$normalizedCandidate];
            }
        }

        /*
         * Master pekerjaan menyediakan kategori Lainnya.
         * Pekerjaan baru yang belum ada pada master tidak perlu
         * menggagalkan seluruh baris; data diarahkan ke Lainnya.
         */
        if (
            $modelClass === pekerjaan::class &&
            array_key_exists('lainnya', $referenceMap)
        ) {
            $this->fallbackPekerjaanLainnya++;

            return $referenceMap['lainnya'];
        }

        throw new \InvalidArgumentException(
            "{$fieldName} \"{$value}\" tidak ditemukan " .
            'pada data master.'
        );
    }

    /**
     * Mengambil kandidat alias data master.
     */
    private function getAliasCandidates(
        string $modelClass,
        string $lookupValue
    ): array {
        $modelAliases = self::REFERENCE_ALIASES[$modelClass]
            ?? [];

        if (!array_key_exists($lookupValue, $modelAliases)) {
            return [];
        }

        $aliases = $modelAliases[$lookupValue];

        return is_array($aliases)
            ? $aliases
            : [$aliases];
    }

    /**
     * Memuat data master satu kali ke cache.
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
     * Normalisasi pencocokan data master.
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
     * Parsing tanggal lahir atau tanggal lain.
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

        if (
            preg_match(
                '/^0000[-\/]/',
                $dateValue
            )
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} \"{$dateValue}\" memiliki tahun 0000."
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
                // Coba format berikutnya.
            }
        }

        throw new \InvalidArgumentException(
            "{$fieldName} \"{$dateValue}\" tidak dikenali."
        );
    }

    /**
     * Tahun perkawinan dapat berupa tahun atau tanggal lengkap.
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
        $stringValue = preg_replace(
            '/\.0+$/',
            '',
            $stringValue
        );

        if (preg_match('/^\d{4}$/', $stringValue)) {
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
     * Memeriksa NIK pada database dengan cache.
     */
    private function nikExistsInDatabase(
        string $nik
    ): bool {
        if (
            array_key_exists(
                $nik,
                $this->databaseNikCache
            )
        ) {
            return $this->databaseNikCache[$nik];
        }

        $exists = DataPendudukModel::query()
            ->where('nik', $nik)
            ->exists();

        $this->databaseNikCache[$nik] = $exists;

        return $exists;
    }

    /**
     * Menambahkan peringatan.
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

            'defaulted_status_kependudukan' =>
                $this->defaultedStatusKependudukan,

            'fallback_pekerjaan_lainnya' =>
                $this->fallbackPekerjaanLainnya,

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
