<?php

namespace App\Imports;

use App\Models\akses_pendidikan;
use App\Models\akseskesehatan;
use App\Models\aksessarpras;
use App\Models\aksestenagakerja;
use App\Models\dataindividu;
use App\Models\datapenduduk;
use App\Models\laink;
use App\Models\lokasipemukiman;
use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Throwable;

class LokasidanPemukimanImport implements
    OnEachRow,
    WithChunkReading,
    WithStartRow,
    SkipsEmptyRows
{
    /**
     * File export Lokasi dan Pemukiman mempunyai 135 kolom.
     */
    private const EXPECTED_COLUMNS = 135;

    private const PENDIDIKAN = [
        'paud',
        'tk',
        'sd',
        'smp',
        'sma',
        'pt',
        'ps',
        'seminari',
        'pagamalain',
    ];

    private const FASILITAS_KESEHATAN = [
        'rumahs',
        'rumahb',
        'poliklinik',
        'puskesmas',
        'poskedes',
        'posyandu',
        'apotik',
        'toko_obat',
    ];

    private const TENAGA_KESEHATAN = [
        'dr_spesialis',
        'dr_umum',
        'bidan',
        'tenagakes',
        'dukun',
    ];

    private const SARPRAS = [
        'lokasipu',
        'lahanpertanian',
        'sekolah',
        'berobat',
        'beribadah',
        'rekreasi',
    ];

    private const PROGRAM_PEMERINTAH = [
        'blt',
        'pkh',
        'bst',
        'bantuan_presiden',
        'bantuan_umkm',
        'bantuan_pekerja',
        'bantuan_anak',
        'lainnya',
    ];

    /**
     * Satu No KK hanya diproses satu kali dalam satu file.
     */
    private array $processedNoKk = [];

    /**
     * Cache kepala keluarga dari database relasional.
     */
    private ?array $kepalaKeluargaMap = null;

    /**
     * Ringkasan hasil import.
     */
    private int $inserted = 0;
    private int $updated = 0;
    private int $skippedNonHead = 0;
    private int $skippedDuplicateKk = 0;
    private int $invalid = 0;

    /**
     * Peringatan yang dikirim ke halaman.
     */
    private array $warnings = [];
    private int $warningLimit = 150;
    private int $warningOverflow = 0;

    /**
     * Baris pertama adalah header.
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Chunk dibuat kecil karena satu baris berisi 135 kolom
     * dan ditulis ke tujuh collection MongoDB.
     */
    public function chunkSize(): int
    {
        return 150;
    }

    /**
     * Satu baris Excel akan ditulis ke:
     * 1. dataindividu
     * 2. aksespendidikan
     * 3. akseskesehatan
     * 4. aksestenagakerja
     * 5. aksessarpras
     * 6. kk_lain
     * 7. lokasipemukiman
     */
    public function onRow(Row $excelRow): void
    {
        $rowNumber = $excelRow->getIndex();
        $row = array_values($excelRow->toArray());

        try {
            if ($this->isEmptyRow($row)) {
                return;
            }

            if (count($row) < self::EXPECTED_COLUMNS) {
                throw new \InvalidArgumentException(
                    'Jumlah kolom tidak sesuai. Ditemukan ' .
                    count($row) . ' kolom, seharusnya minimal ' .
                    self::EXPECTED_COLUMNS .
                    ' kolom sesuai hasil export Lokasi dan Pemukiman.'
                );
            }

            /*
             * Pastikan indeks 0 sampai 134 selalu tersedia.
             */
            $row = array_pad(
                $row,
                self::EXPECTED_COLUMNS,
                null
            );

            $noKk = $this->normalizeIdentity(
                $row[0] ?? null,
                'No KK'
            );

            $nikBaris = $this->normalizeOptionalIdentity(
                $row[1] ?? null,
                'NIK'
            );

            $nikKepalaFile = $this->normalizeOptionalIdentity(
                $row[6] ?? null,
                'NIK Kepala Keluarga'
            );

            $kepala = $this->findKepalaKeluarga($noKk);

            if ($kepala === null) {
                throw new \InvalidArgumentException(
                    "No KK {$noKk} tidak mempunyai penduduk " .
                    'berstatus Kepala Keluarga di database penduduk.'
                );
            }

            $nikKepala = (string) $kepala['nik'];

            /*
             * File export semestinya hanya berisi kepala keluarga.
             */
            if (
                $nikBaris !== null &&
                $nikBaris !== $nikKepala
            ) {
                $this->skippedNonHead++;

                $this->addWarning(
                    "Baris {$rowNumber}: NIK {$nikBaris} bukan " .
                    "Kepala Keluarga untuk No KK {$noKk}; baris dilewati."
                );

                return;
            }

            if (
                $nikKepalaFile !== null &&
                $nikKepalaFile !== $nikKepala
            ) {
                $this->addWarning(
                    "Baris {$rowNumber}: NIK Kepala Keluarga pada file " .
                    "({$nikKepalaFile}) berbeda dengan database " .
                    "({$nikKepala}); sistem menggunakan NIK database."
                );
            }

            if (isset($this->processedNoKk[$noKk])) {
                $this->skippedDuplicateKk++;

                $this->addWarning(
                    "Baris {$rowNumber}: No KK {$noKk} muncul " .
                    'lebih dari satu kali; baris berikutnya dilewati.'
                );

                return;
            }

            /*
             * Collection lokasipemukiman digunakan sebagai penanda
             * bahwa satu paket data KK pernah berhasil disimpan.
             */
            $alreadyExists = lokasipemukiman::query()
                ->where('nik', $nikKepala)
                ->exists();

            $documents = $this->buildDocuments(
                $row,
                $noKk,
                $nikKepala,
                $kepala
            );

            /*
             * Seluruh collection ditulis dalam satu alur.
             *
             * filterExistingColumns() dan Schema::getColumnListing()
             * sengaja tidak digunakan karena MongoDB bersifat schemaless.
             */
            $this->persistAllMongoDocuments(
                $nikKepala,
                $documents
            );

            $this->processedNoKk[$noKk] = true;

            if ($alreadyExists) {
                $this->updated++;
            } else {
                $this->inserted++;
            }
        } catch (Throwable $e) {
            $this->invalid++;

            $this->addWarning(
                "Baris {$rowNumber}: {$e->getMessage()}"
            );
        }
    }

    /**
     * Membangun tujuh dokumen MongoDB dari satu baris Excel.
     */
    private function buildDocuments(
        array $row,
        string $noKk,
        string $nikKepala,
        array $kepala
    ): array {
        $namaKepala = $this->cleanText(
            $kepala['nama'] ?? ''
        );

        $alamatKepala = $this->cleanText(
            $kepala['alamat'] ?? ''
        );

        $identity = $this->identityValues(
            $noKk,
            $nikKepala,
            $namaKepala,
            $alamatKepala
        );

        $noHp = $this->cellString($row[4] ?? null);
        $noTeleponRumah = $this->cellString($row[5] ?? null);

        /*
         * =========================================================
         * DATA INDIVIDU
         * =========================================================
         */
        $individu = array_merge(
            $identity,
            [
                'nohp' => $noHp,
                'nowa' => $noTeleponRumah,
                'telpon_rumah' => $noTeleponRumah,
            ]
        );

        /*
         * =========================================================
         * LOKASI DAN PEMUKIMAN — indeks 7 sampai 27
         * =========================================================
         */
        $lokasi = array_merge(
            $identity,
            [
                'nohp' => $noHp,
                'nowa' => $noTeleponRumah,
                'telpon_rumah' => $noTeleponRumah,
                'nik_kepala' => $nikKepala,

                'tempat_tinggal' =>
                    $this->cellString($row[7] ?? null),

                'status_lahan' =>
                    $this->cellString($row[8] ?? null),

                'luas_lantai_tinggal' =>
                    $this->cellString($row[9] ?? null),

                'luas_tanah_tinggal' =>
                    $this->cellString($row[10] ?? null),

                'jenis_lantai_tinggal' =>
                    $this->cellString($row[11] ?? null),

                'dinding_sebagian' =>
                    $this->cellString($row[12] ?? null),

                'jendela' =>
                    $this->cellString($row[13] ?? null),

                'atap' =>
                    $this->cellString($row[14] ?? null),

                'penerangan' =>
                    $this->cellString($row[15] ?? null),

                'energi_masak' =>
                    $this->cellString($row[16] ?? null),

                'jika_kayu_jenis' =>
                    $this->cellString($row[17] ?? null),

                'tempat_sampah' =>
                    $this->cellString($row[18] ?? null),

                'mck' =>
                    $this->cellString($row[19] ?? null),

                'sumber_air_mandi' =>
                    $this->cellString($row[20] ?? null),

                'sumber_air_mck' =>
                    $this->cellString($row[21] ?? null),

                'sumber_air_minum' =>
                    $this->cellString($row[22] ?? null),

                'tempat_pembuangan_limbah' =>
                    $this->cellString($row[23] ?? null),

                'rumah_sutet' =>
                    $this->cellString($row[24] ?? null),

                'rumah_sungai' =>
                    $this->cellString($row[25] ?? null),

                'rumah_lereng_gunung' =>
                    $this->cellString($row[26] ?? null),

                'kondi_rumah_kumuh' =>
                    $this->cellString($row[27] ?? null),
            ]
        );

        /*
         * =========================================================
         * AKSES PENDIDIKAN — indeks 28 sampai 54
         * =========================================================
         */
        $pendidikan = $identity;
        $offset = 28;

        foreach (self::PENDIDIKAN as $prefix) {
            $pendidikan['jaraktempuh_' . $prefix] =
                $this->cellString($row[$offset] ?? null);

            $pendidikan['waktutempuh_' . $prefix] =
                $this->cellString($row[$offset + 1] ?? null);

            $pendidikan['kemudahan_' . $prefix] =
                $this->cellString($row[$offset + 2] ?? null);

            $offset += 3;
        }

        /*
         * =========================================================
         * AKSES FASILITAS KESEHATAN — indeks 55 sampai 78
         * =========================================================
         */
        $kesehatan = $identity;
        $offset = 55;

        foreach (self::FASILITAS_KESEHATAN as $prefix) {
            $kesehatan['jaraktempuh_' . $prefix] =
                $this->cellString($row[$offset] ?? null);

            $kesehatan['waktutempuh_' . $prefix] =
                $this->cellString($row[$offset + 1] ?? null);

            $kesehatan['kemudahan_' . $prefix] =
                $this->cellString($row[$offset + 2] ?? null);

            $offset += 3;
        }

        /*
         * =========================================================
         * AKSES TENAGA KESEHATAN — indeks 79 sampai 93
         * =========================================================
         */
        $tenaga = $identity;
        $offset = 79;

        foreach (self::TENAGA_KESEHATAN as $prefix) {
            $tenaga['jaraktempuh_' . $prefix] =
                $this->cellString($row[$offset] ?? null);

            $tenaga['waktutempuh_' . $prefix] =
                $this->cellString($row[$offset + 1] ?? null);

            $tenaga['kemudahan_' . $prefix] =
                $this->cellString($row[$offset + 2] ?? null);

            $offset += 3;
        }

        /*
         * =========================================================
         * AKSES SARANA PRASARANA — indeks 94 sampai 123
         * =========================================================
         */
        $sarpras = $identity;
        $offset = 94;

        foreach (self::SARPRAS as $prefix) {
            /*
             * Nama field "jenistrasport" mengikuti model lama.
             */
            $sarpras['jenistrasport_' . $prefix] =
                $this->cellString($row[$offset] ?? null);

            $sarpras['pengtransportumum_' . $prefix] =
                $this->cellString($row[$offset + 1] ?? null);

            $sarpras['waktutempuh_' . $prefix] =
                $this->cellString($row[$offset + 2] ?? null);

            $sarpras['biaya_' . $prefix] =
                $this->cellString($row[$offset + 3] ?? null);

            $sarpras['kemudahan_' . $prefix] =
                $this->cellString($row[$offset + 4] ?? null);

            $offset += 5;
        }

        /*
         * =========================================================
         * DATA LAIN — indeks 124 sampai 134
         * =========================================================
         */
        $lain = $identity;

        $lain['pengtransportsebelum'] =
            $this->cellString($row[124] ?? null);

        $lain['pengtransportsesudah'] =
            $this->cellString($row[125] ?? null);

        $offset = 126;

        foreach (self::PROGRAM_PEMERINTAH as $field) {
            $lain[$field] =
                $this->cellString($row[$offset] ?? null);

            $offset++;
        }

        $lain['rata_rata'] =
            $this->cellString($row[134] ?? null);

        return [
            'individu' => $individu,
            'pendidikan' => $pendidikan,
            'kesehatan' => $kesehatan,
            'tenaga' => $tenaga,
            'sarpras' => $sarpras,
            'lain' => $lain,
            'lokasi' => $lokasi,
        ];
    }

    /**
     * Menulis satu paket data ke tujuh collection MongoDB.
     *
     * lokasipemukiman disimpan terakhir dan menjadi penanda bahwa
     * seluruh model pada baris tersebut telah melewati proses simpan.
     */
    private function persistAllMongoDocuments(
        string $nik,
        array $documents
    ): void {
        $this->upsertMongoByNik(
            new dataindividu(),
            $nik,
            $documents['individu']
        );

        $this->upsertMongoByNik(
            new akses_pendidikan(),
            $nik,
            $documents['pendidikan']
        );

        $this->upsertMongoByNik(
            new akseskesehatan(),
            $nik,
            $documents['kesehatan']
        );

        $this->upsertMongoByNik(
            new aksestenagakerja(),
            $nik,
            $documents['tenaga']
        );

        $this->upsertMongoByNik(
            new aksessarpras(),
            $nik,
            $documents['sarpras']
        );

        $this->upsertMongoByNik(
            new laink(),
            $nik,
            $documents['lain']
        );

        /*
         * Penanda paket lengkap disimpan terakhir.
         */
        $this->upsertMongoByNik(
            new lokasipemukiman(),
            $nik,
            $documents['lokasi']
        );
    }

    /**
     * Insert atau update dokumen MongoDB berdasarkan NIK.
     *
     * Tidak memakai Schema::getColumnListing() karena MongoDB
     * tidak mempunyai daftar kolom seperti MySQL.
     */
    private function upsertMongoByNik(
        MongoModel $model,
        string $nik,
        array $values
    ): void {
        $connectionName = $model->getConnectionName()
            ?: (string) config('database.default');

        if ($connectionName !== 'mongodb') {
            throw new \RuntimeException(
                'Model ' . get_class($model) .
                ' tidak menggunakan connection mongodb. ' .
                "Connection saat ini: {$connectionName}."
            );
        }

        $values['nik'] = $nik;

        $record = $model->newQuery()
            ->where('nik', $nik)
            ->first();

        if ($record === null) {
            $record = $model->newInstance();
        }

        /*
         * forceFill memastikan field identitas tetap tersimpan
         * walaupun fillable model lama belum lengkap.
         */
        $record->forceFill($values);

        if (!$record->save()) {
            throw new \RuntimeException(
                'Gagal menyimpan model ' .
                class_basename($model) .
                " untuk NIK {$nik}."
            );
        }
    }

    /**
     * Field identitas yang ditanam pada setiap collection.
     */
    private function identityValues(
        string $noKk,
        string $nik,
        string $nama,
        string $alamat
    ): array {
        return [
            'nokk' => $noKk,
            'kk' => $noKk,
            'nik' => $nik,
            'nama' => $nama,
            'alamat' => $alamat,
        ];
    }

    /**
     * Mencari kepala keluarga berdasarkan No KK.
     */
    private function findKepalaKeluarga(
        string $noKk
    ): ?array {
        $this->loadKepalaKeluargaMap();

        return $this->kepalaKeluargaMap[$noKk]
            ?? null;
    }

    /**
     * Memuat seluruh kepala keluarga dari database relasional satu kali.
     */
    private function loadKepalaKeluargaMap(): void
    {
        if ($this->kepalaKeluargaMap !== null) {
            return;
        }

        $this->kepalaKeluargaMap = [];

        $pendudukModel = new datapenduduk();
        $sqlConnection = $pendudukModel->getConnectionName();

        $query = $sqlConnection
            ? DB::connection($sqlConnection)
            : DB::connection();

        $records = $query
            ->table('datapenduduks as dp')
            ->join(
                'detailkks as dkk',
                'dkk.idpenduduk',
                '=',
                'dp.id'
            )
            ->join(
                'kks as k',
                'k.id',
                '=',
                'dkk.idkk'
            )
            ->whereRaw(
                'LOWER(TRIM(dp.Datak)) IN (?, ?)',
                [
                    'tetap',
                    'tidaktetap',
                ]
            )
            ->whereRaw(
                'LOWER(TRIM(dp.hubungan)) = ?',
                [
                    'kepala keluarga',
                ]
            )
            ->select([
                'dp.id',
                'dp.nik',
                'dp.nama',
                'dp.alamat',
                'k.nokk',
            ])
            ->orderBy('dp.id')
            ->get();

        foreach ($records as $record) {
            $noKk = $this->digitsOnly(
                $record->nokk
            );

            $nik = $this->digitsOnly(
                $record->nik
            );

            if (
                strlen($noKk) !== 16 ||
                strlen($nik) !== 16
            ) {
                continue;
            }

            /*
             * Apabila terdapat dua kepala keluarga pada satu KK,
             * gunakan record dengan ID paling kecil.
             */
            if (isset($this->kepalaKeluargaMap[$noKk])) {
                continue;
            }

            $this->kepalaKeluargaMap[$noKk] = [
                'id' => $record->id,
                'nik' => $nik,
                'nama' => $record->nama ?? '',
                'alamat' => $record->alamat ?? '',
            ];
        }
    }

    /**
     * Normalisasi No KK/NIK wajib.
     */
    private function normalizeIdentity(
        mixed $value,
        string $fieldName
    ): string {
        $normalized = $this->normalizeOptionalIdentity(
            $value,
            $fieldName
        );

        if ($normalized === null) {
            throw new \InvalidArgumentException(
                "{$fieldName} kosong."
            );
        }

        return $normalized;
    }

    /**
     * Normalisasi No KK/NIK opsional.
     */
    private function normalizeOptionalIdentity(
        mixed $value,
        string $fieldName
    ): ?string {
        if ($value === null) {
            return null;
        }

        if (
            is_float($value) &&
            abs($value) >= 100000000000000
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} dibaca sebagai angka Excel dan " .
                'berpotensi kehilangan digit. Gunakan format Text.'
            );
        }

        $raw = trim((string) $value);

        if ($raw === '') {
            return null;
        }

        $raw = ltrim($raw, "'");

        if (
            preg_match(
                '/[eE][+-]?\d+/',
                $raw
            )
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} menggunakan notasi ilmiah " .
                "\"{$raw}\". Gunakan format Text."
            );
        }

        $raw = preg_replace('/\.0+$/', '', $raw);
        $digits = $this->digitsOnly($raw);

        if (strlen($digits) !== 16) {
            throw new \InvalidArgumentException(
                "{$fieldName} harus tepat 16 digit. " .
                "Nilai diterima: \"{$raw}\"."
            );
        }

        return $digits;
    }

    /**
     * Memeriksa apakah satu baris benar-benar kosong.
     */
    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $value) {
            if ($this->cleanText($value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function digitsOnly(
        mixed $value
    ): string {
        return preg_replace(
            '/\D+/',
            '',
            trim((string) $value)
        );
    }

    private function cleanText(
        mixed $value
    ): string {
        if ($value === null) {
            return '';
        }

        return preg_replace(
            '/\s+/u',
            ' ',
            trim((string) $value)
        );
    }

    /**
     * Menjaga angka Excel agar tidak berubah ke notasi ilmiah.
     */
    private function cellString(
        mixed $value
    ): string {
        if ($value === null) {
            return '';
        }

        if (is_int($value)) {
            return (string) $value;
        }

        if (is_float($value)) {
            return rtrim(
                rtrim(
                    sprintf('%.10F', $value),
                    '0'
                ),
                '.'
            );
        }

        return $this->cleanText($value);
    }

    private function addWarning(
        string $message
    ): void {
        if (count($this->warnings) < $this->warningLimit) {
            $this->warnings[] = $message;

            return;
        }

        $this->warningOverflow++;
    }

    public function getSummary(): array
    {
        $successfulKk = $this->inserted + $this->updated;

        return [
            'inserted' => $this->inserted,
            'updated' => $this->updated,

            'successful_kk' => $successfulKk,

            /*
             * Setiap KK yang berhasil ditulis ke tujuh collection.
             */
            'documents_written' => $successfulKk * 7,

            'skipped_non_head' =>
                $this->skippedNonHead,

            'skipped_duplicate_kk' =>
                $this->skippedDuplicateKk,

            'invalid' => $this->invalid,

            'warnings' => $this->warnings,

            'warning_overflow' =>
                $this->warningOverflow,
        ];
    }
}
