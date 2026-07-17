<?php

namespace App\Imports;

use App\Models\akses_pendidikan;
use App\Models\akseskesehatan;
use App\Models\aksessarpras;
use App\Models\aksestenagakerja;
use App\Models\dataindividu;
use App\Models\laink;
use App\Models\lokasipemukiman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
     * Urutan kelompok pendidikan sesuai file export.
     */
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

    /**
     * Urutan fasilitas kesehatan sesuai file export.
     */
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

    /**
     * Urutan tenaga kesehatan sesuai file export.
     */
    private const TENAGA_KESEHATAN = [
        'dr_spesialis',
        'dr_umum',
        'bidan',
        'tenagakes',
        'dukun',
    ];

    /**
     * Urutan sarana dan prasarana sesuai file export.
     */
    private const SARPRAS = [
        'lokasipu',
        'lahanpertanian',
        'sekolah',
        'berobat',
        'beribadah',
        'rekreasi',
    ];

    /**
     * Program pemerintah.
     */
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
     * No KK yang telah berhasil diproses dalam file ini.
     */
    private array $processedNoKk = [];

    /**
     * Cache data kepala keluarga berdasarkan No KK.
     */
    private ?array $kepalaKeluargaMap = null;

    /**
     * Cache daftar kolom tabel.
     */
    private array $tableColumns = [];

    /**
     * Ringkasan proses import.
     */
    private int $inserted = 0;
    private int $updated = 0;
    private int $skippedNonHead = 0;
    private int $skippedDuplicateKk = 0;
    private int $invalid = 0;

    /**
     * Peringatan.
     */
    private array $warnings = [];
    private int $warningLimit = 150;
    private int $warningOverflow = 0;

    /**
     * Baris pertama adalah heading.
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Membaca file secara bertahap.
     */
    public function chunkSize(): int
    {
        return 300;
    }

    /**
     * Memproses setiap baris.
     */
    public function onRow(Row $excelRow): void
    {
        $rowNumber = $excelRow->getIndex();
        $row = array_values($excelRow->toArray());

        try {
            /*
             * =====================================================
             * IDENTITAS FILE
             * =====================================================
             */

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

            /*
             * Cari kepala keluarga yang benar berdasarkan No KK
             * pada database.
             */
            $kepala = $this->findKepalaKeluarga($noKk);

            if (!$kepala) {
                throw new \InvalidArgumentException(
                    "No KK {$noKk} tidak mempunyai penduduk " .
                    'berstatus Kepala Keluarga di database.'
                );
            }

            $nikKepala = (string) $kepala['nik'];

            /*
             * Jika NIK pada kolom NIK adalah anggota keluarga
             * selain kepala keluarga, baris dilewati.
             */
            if (
                $nikBaris !== null &&
                $nikBaris !== $nikKepala
            ) {
                $this->skippedNonHead++;

                $this->addWarning(
                    "Baris {$rowNumber}: NIK {$nikBaris} bukan " .
                    "Kepala Keluarga untuk No KK {$noKk}. " .
                    'Baris dilewati.'
                );

                return;
            }

            /*
             * Kolom NIK kepala keluarga pada file harus sesuai
             * dengan database.
             */
            if (
                $nikKepalaFile !== null &&
                $nikKepalaFile !== $nikKepala
            ) {
                $this->addWarning(
                    "Baris {$rowNumber}: NIK Kepala Keluarga pada " .
                    "file ({$nikKepalaFile}) berbeda dengan database " .
                    "({$nikKepala}). Sistem menggunakan NIK database."
                );
            }

            /*
             * Satu No KK hanya diproses satu kali.
             */
            if (isset($this->processedNoKk[$noKk])) {
                $this->skippedDuplicateKk++;

                $this->addWarning(
                    "Baris {$rowNumber}: No KK {$noKk} muncul " .
                    'lebih dari satu kali dan dilewati.'
                );

                return;
            }

            $alreadyExists = lokasipemukiman::query()
                ->where('nik', $nikKepala)
                ->exists();

            /*
             * =====================================================
             * SIMPAN SELURUH DATA
             * =====================================================
             */

            DB::transaction(function () use (
                $row,
                $noKk,
                $nikKepala,
                $kepala
            ): void {
                $namaKepala = $this->cleanText(
                    $kepala['nama'] ?? ''
                );

                $alamatKepala = $this->cleanText(
                    $kepala['alamat'] ?? ''
                );

                $noHp = $this->cellString($row[4] ?? null);

                /*
                 * Kolom ke-5 pada export saat ini berjudul
                 * NO. TELPON RUMAH dan berasal dari field nowa.
                 */
                $noTeleponRumah = $this->cellString(
                    $row[5] ?? null
                );

                /*
                 * =================================================
                 * LOKASI DAN PEMUKIMAN
                 * =================================================
                 */

                $lokasiValues = [
                    'nokk' => $noKk,
                    'kk' => $noKk,

                    'nik' => $nikKepala,
                    'nama' => $namaKepala,
                    'alamat' => $alamatKepala,

                    'nohp' => $noHp,
                    'nowa' => $noTeleponRumah,
                    'telpon_rumah' => $noTeleponRumah,

                    /*
                     * Selalu gunakan NIK kepala keluarga yang
                     * diperoleh dari database.
                     */
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
                ];

                $this->upsertByNik(
                    new lokasipemukiman(),
                    $nikKepala,
                    $lokasiValues
                );

                /*
                 * =================================================
                 * DATA INDIVIDU
                 * =================================================
                 *
                 * Nomor HP pada DataTables diambil dari tabel
                 * dataindividu, sehingga perlu ikut diperbarui.
                 */

                $individuValues = [
                    'nokk' => $noKk,
                    'kk' => $noKk,

                    'nik' => $nikKepala,
                    'nama' => $namaKepala,
                    'alamat' => $alamatKepala,

                    'nohp' => $noHp,
                    'nowa' => $noTeleponRumah,
                    'telpon_rumah' => $noTeleponRumah,
                ];

                $this->upsertByNik(
                    new dataindividu(),
                    $nikKepala,
                    $individuValues
                );

                /*
                 * =================================================
                 * AKSES PENDIDIKAN
                 *
                 * Indeks 28 sampai 54
                 * 9 kelompok x 3 kolom.
                 * =================================================
                 */

                $pendidikanValues = $this->identityValues(
                    $noKk,
                    $nikKepala,
                    $namaKepala
                );

                $offset = 28;

                foreach (self::PENDIDIKAN as $prefix) {
                    $pendidikanValues[
                        'jaraktempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset] ?? null
                    );

                    $pendidikanValues[
                        'waktutempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 1] ?? null
                    );

                    $pendidikanValues[
                        'kemudahan_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 2] ?? null
                    );

                    $offset += 3;
                }

                $this->upsertByNik(
                    new akses_pendidikan(),
                    $nikKepala,
                    $pendidikanValues
                );

                /*
                 * =================================================
                 * AKSES FASILITAS KESEHATAN
                 *
                 * Indeks 55 sampai 78
                 * 8 kelompok x 3 kolom.
                 * =================================================
                 */

                $kesehatanValues = $this->identityValues(
                    $noKk,
                    $nikKepala,
                    $namaKepala
                );

                $offset = 55;

                foreach (self::FASILITAS_KESEHATAN as $prefix) {
                    $kesehatanValues[
                        'jaraktempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset] ?? null
                    );

                    $kesehatanValues[
                        'waktutempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 1] ?? null
                    );

                    $kesehatanValues[
                        'kemudahan_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 2] ?? null
                    );

                    $offset += 3;
                }

                $this->upsertByNik(
                    new akseskesehatan(),
                    $nikKepala,
                    $kesehatanValues
                );

                /*
                 * =================================================
                 * AKSES TENAGA KESEHATAN
                 *
                 * Indeks 79 sampai 93
                 * 5 kelompok x 3 kolom.
                 * =================================================
                 */

                $tenagaValues = $this->identityValues(
                    $noKk,
                    $nikKepala,
                    $namaKepala
                );

                $offset = 79;

                foreach (self::TENAGA_KESEHATAN as $prefix) {
                    $tenagaValues[
                        'jaraktempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset] ?? null
                    );

                    $tenagaValues[
                        'waktutempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 1] ?? null
                    );

                    $tenagaValues[
                        'kemudahan_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 2] ?? null
                    );

                    $offset += 3;
                }

                $this->upsertByNik(
                    new aksestenagakerja(),
                    $nikKepala,
                    $tenagaValues
                );

                /*
                 * =================================================
                 * AKSES SARANA DAN PRASARANA
                 *
                 * Indeks 94 sampai 123
                 * 6 kelompok x 5 kolom.
                 * =================================================
                 */

                $sarprasValues = $this->identityValues(
                    $noKk,
                    $nikKepala,
                    $namaKepala
                );

                $offset = 94;

                foreach (self::SARPRAS as $prefix) {
                    $sarprasValues[
                        'jenistrasport_' . $prefix
                    ] = $this->cellString(
                        $row[$offset] ?? null
                    );

                    $sarprasValues[
                        'pengtransportumum_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 1] ?? null
                    );

                    $sarprasValues[
                        'waktutempuh_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 2] ?? null
                    );

                    $sarprasValues[
                        'biaya_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 3] ?? null
                    );

                    $sarprasValues[
                        'kemudahan_' . $prefix
                    ] = $this->cellString(
                        $row[$offset + 4] ?? null
                    );

                    $offset += 5;
                }

                $this->upsertByNik(
                    new aksessarpras(),
                    $nikKepala,
                    $sarprasValues
                );

                /*
                 * =================================================
                 * TRANSPORTASI, PROGRAM PEMERINTAH DAN PENGELUARAN
                 *
                 * Transportasi: indeks 124–125
                 * Program:      indeks 126–133
                 * Pengeluaran:  indeks 134
                 * =================================================
                 */

                $lainValues = $this->identityValues(
                    $noKk,
                    $nikKepala,
                    $namaKepala
                );

                $lainValues['pengtransportsebelum'] =
                    $this->cellString($row[124] ?? null);

                $lainValues['pengtransportsesudah'] =
                    $this->cellString($row[125] ?? null);

                $offset = 126;

                foreach (self::PROGRAM_PEMERINTAH as $field) {
                    $lainValues[$field] =
                        $this->cellString(
                            $row[$offset] ?? null
                        );

                    $offset++;
                }

                $lainValues['rata_rata'] =
                    $this->cellString($row[134] ?? null);

                $this->upsertByNik(
                    new laink(),
                    $nikKepala,
                    $lainValues
                );
            }, 3);

            /*
             * No KK baru ditandai setelah seluruh transaksi berhasil.
             */
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
     * Data dasar untuk tabel-tabel relasi.
     */
    private function identityValues(
        string $noKk,
        string $nik,
        string $nama
    ): array {
        return [
            'nokk' => $noKk,
            'kk' => $noKk,
            'nik' => $nik,
            'nama' => $nama,
        ];
    }

    /**
     * Insert atau update berdasarkan NIK.
     *
     * Hanya kolom yang benar-benar ada di tabel yang akan disimpan.
     */
    private function upsertByNik(
        Model $model,
        string $nik,
        array $values
    ): void {
        $values['nik'] = $nik;

        $values = $this->filterExistingColumns(
            $model,
            $values
        );

        $record = $model->newQuery()
            ->firstOrNew([
                'nik' => $nik,
            ]);

        /*
         * forceFill dipakai agar tidak terganggu pengaturan
         * fillable yang belum lengkap pada model lama.
         */
        $record->forceFill($values);
        $record->save();
    }

    /**
     * Hanya ambil field yang tersedia pada tabel.
     *
     * Hal ini membuat kode tetap berjalan apabila suatu tabel
     * menggunakan kolom "kk", sedangkan tabel lain memakai "nokk".
     */
    private function filterExistingColumns(
        Model $model,
        array $values
    ): array {
        $table = $model->getTable();

        if (!isset($this->tableColumns[$table])) {
            $this->tableColumns[$table] = array_flip(
                Schema::getColumnListing($table)
            );
        }

        return array_intersect_key(
            $values,
            $this->tableColumns[$table]
        );
    }

    /**
     * Cari kepala keluarga yang benar dari database.
     */
    private function findKepalaKeluarga(
        string $noKk
    ): ?array {
        $this->loadKepalaKeluargaMap();

        return $this->kepalaKeluargaMap[$noKk]
            ?? null;
    }

    /**
     * Memuat seluruh kepala keluarga satu kali.
     */
    private function loadKepalaKeluargaMap(): void
    {
        if ($this->kepalaKeluargaMap !== null) {
            return;
        }

        $this->kepalaKeluargaMap = [];

        $records = DB::table('datapenduduks as dp')
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

            if ($noKk === '' || $nik === '') {
                continue;
            }

            /*
             * Jika satu No KK memiliki dua kepala keluarga,
             * gunakan data dengan ID paling kecil.
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
     * Normalisasi No KK dan NIK.
     */
    private function normalizeIdentity(
        mixed $value,
        string $fieldName
    ): string {
        $value = $this->normalizeOptionalIdentity(
            $value,
            $fieldName
        );

        if ($value === null) {
            throw new \InvalidArgumentException(
                "{$fieldName} kosong."
            );
        }

        return $value;
    }

    /**
     * Normalisasi identitas yang boleh kosong.
     */
    private function normalizeOptionalIdentity(
        mixed $value,
        string $fieldName
    ): ?string {
        if ($value === null) {
            return null;
        }

        /*
         * Excel hanya mempertahankan presisi sampai sekitar
         * 15 digit. Float besar tidak boleh dipaksakan karena
         * berpotensi telah kehilangan digit.
         */
        if (
            is_float($value) &&
            abs($value) >= 100000000000000
        ) {
            throw new \InvalidArgumentException(
                "{$fieldName} dibaca sebagai angka Excel dan " .
                'berpotensi kehilangan digit. Ubah kolom menjadi Text.'
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
                "\"{$raw}\". Ubah format kolom menjadi Text."
            );
        }

        $raw = preg_replace(
            '/\.0+$/',
            '',
            $raw
        );

        $digits = $this->digitsOnly($raw);

        /*
         * Dibuat 8–20 digit agar tetap menerima data lama,
         * tetapi NIK dan No KK sebaiknya 16 digit.
         */
        $length = strlen($digits);

        if ($length < 8 || $length > 20) {
            throw new \InvalidArgumentException(
                "{$fieldName} harus terdiri dari 8–20 digit. " .
                "Nilai diterima: \"{$raw}\"."
            );
        }

        return $digits;
    }

    /**
     * Hanya mengambil angka.
     */
    private function digitsOnly(
        mixed $value
    ): string {
        return preg_replace(
            '/\D+/',
            '',
            trim((string) $value)
        );
    }

    /**
     * Membersihkan teks.
     */
    private function cleanText(
        mixed $value
    ): string {
        if ($value === null) {
            return '';
        }

        $value = preg_replace(
            '/\s+/u',
            ' ',
            trim((string) $value)
        );

        return $value;
    }

    /**
     * Menyiapkan nilai umum untuk disimpan.
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
            /*
             * Menghindari notasi ilmiah untuk angka jarak,
             * waktu, biaya, atau luas.
             */
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
            'updated' => $this->updated,

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
