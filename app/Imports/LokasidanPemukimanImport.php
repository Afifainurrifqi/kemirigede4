<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\Lokasipemukiman;
use App\Models\Akses_pendidikan;
use App\Models\Akseskesehatan;
use App\Models\Aksestenagakerja;
use App\Models\Aksessarpras;
use App\Models\Laink;

class LokasidanPemukimanImport implements ToCollection, WithChunkReading
{
    /**
     * SUSUNAN KOLOM (index mulai 0)
     *  0: KK
     *  1: NIK
     *  2: Gelar Awal
     *  3: Nama
     *  4: Gelar Akhir
     *  5: Jenis Kelamin   (Jeniskelamin)
     *  6: Tempat Lahir    (tempatlahir)
     *
     *  Mulai index 7 ke atas = kolom Lokasi & Pemukiman + Akses.
     */

    // Kalau server < PHP 7.4, ganti "private array" jadi "protected $idx = [...]"
    private array $idx = [
        // ---------- lokasipemukiman ----------
        'alamat'                   => 7,
        'nohp'                     => 8,
        'nowa'                     => 9,
        'nik_kepala'               => 10,
        'tempat_tinggal'           => 11,
        'status_lahan'             => 12,
        'luas_lantai_tinggal'      => 13,
        'luas_tanah_tinggal'       => 14,
        'jenis_lantai_tinggal'     => 15,
        'dinding_sebagian'         => 16,
        'jendela'                  => 17,
        'atap'                     => 18,
        'penerangan'               => 19,
        'energi_masak'             => 20,
        'jika_kayu_jenis'          => 21,
        'tempat_sampah'            => 22,
        'mck'                      => 23,
        'sumber_air_mandi'         => 24,
        'sumber_air_mck'           => 25,
        'sumber_air_minum'         => 26,
        'tempat_pembuangan_limbah' => 27,
        'rumah_sungai'             => 28,
        'rumah_sutet'              => 29,
        'rumah_lereng_gunung'      => 30,
        'kondi_rumah_kumuh'        => 31,

        // ---------- akses_pendidikan ----------
        'paud_jarak'               => 32,
        'paud_waktu' => 33,
        'paud_kemudahan' => 34,
        'tk_jarak'                 => 35,
        'tk_waktu'   => 36,
        'tk_kemudahan'   => 37,
        'sd_jarak'                 => 38,
        'sd_waktu'   => 39,
        'sd_kemudahan'   => 40,
        'smp_jarak'                => 41,
        'smp_waktu'  => 42,
        'smp_kemudahan'  => 43,
        'sma_jarak'                => 44,
        'sma_waktu'  => 45,
        'sma_kemudahan'  => 46,
        'pt_jarak'                 => 47,
        'pt_waktu'   => 48,
        'pt_kemudahan'   => 49,
        'ps_jarak'                 => 50,
        'ps_waktu'   => 51,
        'ps_kemudahan'   => 52,
        'seminari_jarak'           => 53,
        'seminari_waktu' => 54,
        'seminari_kemudahan' => 55,
        'pagamalain_jarak'         => 56,
        'pagamalain_waktu' => 57,
        'pagamalain_kemudahan' => 58,

        // ---------- akseskesehatan ----------
        'rs_jarak'                 => 59,
        'rs_waktu'      => 60,
        'rs_kemudahan'      => 61,
        'rsb_jarak'                => 62,
        'rsb_waktu'     => 63,
        'rsb_kemudahan'     => 64,
        'poliklinik_jarak'         => 65,
        'poliklinik_waktu' => 66,
        'poliklinik_kemudahan' => 67,
        'puskesmas_jarak'          => 68,
        'puskesmas_waktu' => 69,
        'puskesmas_kemudahan' => 70,
        'poskedes_jarak'           => 71,
        'poskedes_waktu' => 72,
        'poskedes_kemudahan' => 73,
        'posyandu_jarak'           => 74,
        'posyandu_waktu' => 75,
        'posyandu_kemudahan' => 76,
        'apotik_jarak'             => 77,
        'apotik_waktu'  => 78,
        'apotik_kemudahan'  => 79,
        'toko_obat_jarak'          => 80,
        'toko_obat_waktu' => 81,
        'toko_obat_kemudahan' => 82,

        // ---------- aksestenagakerja ----------
        'drsp_jarak'               => 83,
        'drsp_waktu'   => 84,
        'drsp_kemudahan'   => 85,
        'drumum_jarak'             => 86,
        'drumum_waktu' => 87,
        'drumum_kemudahan' => 88,
        'bidan_jarak'              => 89,
        'bidan_waktu'  => 90,
        'bidan_kemudahan'  => 91,
        'tenagakes_jarak'          => 92,
        'tenagakes_waktu' => 93,
        'tenagakes_kemudahan' => 94,
        'dukun_jarak'              => 95,
        'dukun_waktu'  => 96,
        'dukun_kemudahan'  => 97,

        // ---------- aksessarpras ----------
        'lokasipu_jenis'           => 98,
        'lokasipu_angkutan' => 99,
        'lokasipu_waktu' => 100,
        'lokasipu_biaya' => 101,
        'lokasipu_kemudahan' => 102,
        'lahan_jenis'              => 103,
        'lahan_angkutan'    => 104,
        'lahan_waktu'    => 105,
        'lahan_biaya'    => 106,
        'lahan_kemudahan'    => 107,
        'sekolah_jenis'            => 108,
        'sekolah_angkutan'  => 109,
        'sekolah_waktu'  => 110,
        'sekolah_biaya'  => 111,
        'sekolah_kemudahan'  => 112,
        'berobat_jenis'            => 113,
        'berobat_angkutan'  => 114,
        'berobat_waktu'  => 115,
        'berobat_biaya'  => 116,
        'berobat_kemudahan'  => 117,
        'beribadah_jenis'          => 118,
        'beribadah_angkutan' => 119,
        'beribadah_waktu' => 120,
        'beribadah_biaya' => 121,
        'beribadah_kemudahan' => 122,
        'rekreasi_jenis'           => 123,
        'rekreasi_angkutan' => 124,
        'rekreasi_waktu' => 125,
        'rekreasi_biaya' => 126,
        'rekreasi_kemudahan' => 127,

        // ---------- laink ----------
        'pengtransportsebelum'     => 128,
        'pengtransportsesudah'     => 129,
        'blt'                      => 130,
        'pkh'                      => 131,
        'bst'                      => 132,
        'bantuan_presiden'         => 133,
        'bantuan_umkm'             => 134,
        'bantuan_pekerja'          => 135,
        'bantuan_anak'             => 136,
        'lainnya'                  => 137,
        'rata_rata'                => 138,
    ];

    protected bool $skipHeader = true;

    public function chunkSize(): int
    {
        return 500;
    }

    public function collection(Collection $rows)
    {
        if ($this->skipHeader) {
            $rows = $rows->skip(1);
            $this->skipHeader = false;
        }

        $rows->each(function ($row) {
            $kk           = $this->asString($row[0] ?? null);
            $nik          = $this->asString($row[1] ?? null);
            $gelarAwal    = $this->asString($row[2] ?? null);
            $nama         = $this->asString($row[3] ?? null);
            $gelarAkhir   = $this->asString($row[4] ?? null);
            $jenisKelamin = $this->asString($row[5] ?? null);
            $tempatLahir  = $this->asString($row[6] ?? null);

            if (!$nik) return;

            $namaFull = trim(implode(' ', array_filter([$gelarAwal, $nama, $gelarAkhir])));

            // Biar konsisten: set kolom umum ke semua model
            $common = [
                'kk' => $kk,
                'nik' => $nik,
                'gelarawal' => $gelarAwal,
                'nama' => $nama ?: $namaFull,
                'gelarakhir' => $gelarAkhir,
                'Jeniskelamin' => $jenisKelamin,
                'tempatlahir' => $tempatLahir,
            ];

            DB::transaction(function () use ($row, $nik, $common) {

                // =========================
                // 1) Lokasi Pemukiman (FULL FIELD)
                // =========================
                $mL = Lokasipemukiman::firstOrNew(['nik' => $nik]);
                foreach ($common as $k => $v) $mL->{$k} = $v;

                $lokasiFields = [
                    'alamat',
                    'nohp',
                    'nowa',
                    'nik_kepala',
                    'tempat_tinggal',
                    'status_lahan',
                    'luas_lantai_tinggal',
                    'luas_tanah_tinggal',
                    'jenis_lantai_tinggal',
                    'dinding_sebagian',
                    'jendela',
                    'atap',
                    'penerangan',
                    'energi_masak',
                    'jika_kayu_jenis',
                    'tempat_sampah',
                    'mck',
                    'sumber_air_mandi',
                    'sumber_air_mck',
                    'sumber_air_minum',
                    'tempat_pembuangan_limbah',
                    'rumah_sungai',
                    'rumah_sutet',
                    'rumah_lereng_gunung',
                    'kondi_rumah_kumuh'
                ];
                foreach ($lokasiFields as $f) $mL->{$f} = $this->colS($row, $f);
                $mL->save();

                // =========================
                // 2) Akses Pendidikan (FULL FIELD)
                // =========================
                $mAP = Akses_pendidikan::firstOrNew(['nik' => $nik]);
                foreach ($common as $k => $v) $mAP->{$k} = $v;

                $mapPendidikan = [
                    'paud' => ['jaraktempuh_paud', 'waktutempuh_paud', 'kemudahan_paud'],
                    'tk'   => ['jaraktempuh_tk', 'waktutempuh_tk', 'kemudahan_tk'],
                    'sd'   => ['jaraktempuh_sd', 'waktutempuh_sd', 'kemudahan_sd'],
                    'smp'  => ['jaraktempuh_smp', 'waktutempuh_smp', 'kemudahan_smp'],
                    'sma'  => ['jaraktempuh_sma', 'waktutempuh_sma', 'kemudahan_sma'],
                    'pt'   => ['jaraktempuh_pt', 'waktutempuh_pt', 'kemudahan_pt'],
                    'ps'   => ['jaraktempuh_ps', 'waktutempuh_ps', 'kemudahan_ps'],
                    'seminari'   => ['jaraktempuh_seminari', 'waktutempuh_seminari', 'kemudahan_seminari'],
                    'pagamalain' => ['jaraktempuh_pagamalain', 'waktutempuh_pagamalain', 'kemudahan_pagamalain'],
                ];

                foreach ($mapPendidikan as $prefix => [$fJarak, $fWaktu, $fKem]) {
                    $mAP->{$fJarak} = $this->colS($row, "{$prefix}_jarak");
                    $mAP->{$fWaktu} = $this->colS($row, "{$prefix}_waktu");
                    $mAP->{$fKem}   = $this->colS($row, "{$prefix}_kemudahan");
                }
                $mAP->save();

                // =========================
                // 3) Akses Kesehatan (FULL FIELD)
                // =========================
                $mAK = Akseskesehatan::firstOrNew(['nik' => $nik]);
                foreach ($common as $k => $v) $mAK->{$k} = $v;

                $mapKesehatan = [
                    'rs'         => ['jaraktempuh_rumahs', 'waktutempuh_rumahs', 'kemudahan_rumahs'],
                    'rsb'        => ['jaraktempuh_rumahb', 'waktutempuh_rumahb', 'kemudahan_rumahb'],
                    'poliklinik' => ['jaraktempuh_poliklinik', 'waktutempuh_poliklinik', 'kemudahan_poliklinik'],
                    'puskesmas'  => ['jaraktempuh_puskesmas', 'waktutempuh_puskesmas', 'kemudahan_puskesmas'],
                    'poskedes'   => ['jaraktempuh_poskedes', 'waktutempuh_poskedes', 'kemudahan_poskedes'],
                    'posyandu'   => ['jaraktempuh_posyandu', 'waktutempuh_posyandu', 'kemudahan_posyandu'],
                    'apotik'     => ['jaraktempuh_apotik', 'waktutempuh_apotik', 'kemudahan_apotik'],
                    'toko_obat'  => ['jaraktempuh_toko_obat', 'waktutempuh_toko_obat', 'kemudahan_toko_obat'],
                ];

                foreach ($mapKesehatan as $prefix => [$fJarak, $fWaktu, $fKem]) {
                    $mAK->{$fJarak} = $this->colS($row, "{$prefix}_jarak");
                    $mAK->{$fWaktu} = $this->colS($row, "{$prefix}_waktu");
                    $mAK->{$fKem}   = $this->colS($row, "{$prefix}_kemudahan");
                }
                $mAK->save();

                // =========================
                // 4) Akses Tenaga Kerja (FULL FIELD)
                // =========================
                $mAT = Aksestenagakerja::firstOrNew(['nik' => $nik]);
                foreach ($common as $k => $v) $mAT->{$k} = $v;

                $mapTenaga = [
                    'drsp'     => ['jaraktempuh_dr_spesialis', 'waktutempuh_dr_spesialis', 'kemudahan_dr_spesialis'],
                    'drumum'   => ['jaraktempuh_dr_umum', 'waktutempuh_dr_umum', 'kemudahan_dr_umum'],
                    'bidan'    => ['jaraktempuh_bidan', 'waktutempuh_bidan', 'kemudahan_bidan'],
                    'tenagakes' => ['jaraktempuh_tenagakes', 'waktutempuh_tenagakes', 'kemudahan_tenagakes'],
                    'dukun'    => ['jaraktempuh_dukun', 'waktutempuh_dukun', 'kemudahan_dukun'],
                ];

                foreach ($mapTenaga as $prefix => [$fJarak, $fWaktu, $fKem]) {
                    $mAT->{$fJarak} = $this->colS($row, "{$prefix}_jarak");
                    $mAT->{$fWaktu} = $this->colS($row, "{$prefix}_waktu");
                    $mAT->{$fKem}   = $this->colS($row, "{$prefix}_kemudahan");
                }
                $mAT->save();

                // =========================
                // 5) Akses Sarpras (FULL FIELD)
                // =========================
                $mSP = Aksessarpras::firstOrNew(['nik' => $nik]);
                foreach ($common as $k => $v) $mSP->{$k} = $v;

                $mapSarpras = [
                    'lokasipu' => [
                        'jenistrasport_lokasipu',
                        'pengtransportumum_lokasipu',
                        'waktutempuh_lokasipu',
                        'biaya_lokasipu',
                        'kemudahan_lokasipu'
                    ],
                    'lahan' => [
                        'jenistrasport_lahanpertanian',
                        'pengtransportumum_lahanpertanian',
                        'waktutempuh_lahanpertanian',
                        'biaya_lahanpertanian',
                        'kemudahan_lahanpertanian'
                    ],
                    'sekolah' => [
                        'jenistrasport_sekolah',
                        'pengtransportumum_sekolah',
                        'waktutempuh_sekolah',
                        'biaya_sekolah',
                        'kemudahan_sekolah'
                    ],
                    'berobat' => [
                        'jenistrasport_berobat',
                        'pengtransportumum_berobat',
                        'waktutempuh_berobat',
                        'biaya_berobat',
                        'kemudahan_berobat'
                    ],
                    'beribadah' => [
                        'jenistrasport_beribadah',
                        'pengtransportumum_beribadah',
                        'waktutempuh_beribadah',
                        'biaya_beribadah',
                        'kemudahan_beribadah'
                    ],
                    'rekreasi' => [
                        'jenistrasport_rekreasi',
                        'pengtransportumum_rekreasi',
                        'waktutempuh_rekreasi',
                        'biaya_rekreasi',
                        'kemudahan_rekreasi'
                    ],
                ];

                foreach ($mapSarpras as $prefix => $targets) {
                    // urutan idx: jenis, angkutan, waktu, biaya, kemudahan
                    $mSP->{$targets[0]} = $this->colS($row, "{$prefix}_jenis");
                    $mSP->{$targets[1]} = $this->colS($row, "{$prefix}_angkutan");
                    $mSP->{$targets[2]} = $this->colS($row, "{$prefix}_waktu");
                    $mSP->{$targets[3]} = $this->colS($row, "{$prefix}_biaya");
                    $mSP->{$targets[4]} = $this->colS($row, "{$prefix}_kemudahan");
                }
                $mSP->save();

                // =========================
                // 6) Laink (FULL FIELD)
                // =========================
                $mLN = Laink::firstOrNew(['nik' => $nik]);
                foreach ($common as $k => $v) $mLN->{$k} = $v;

                $lainFields = [
                    'pengtransportsebelum',
                    'pengtransportsesudah',
                    'blt',
                    'pkh',
                    'bst',
                    'bantuan_presiden',
                    'bantuan_umkm',
                    'bantuan_pekerja',
                    'bantuan_anak',
                    'lainnya',
                    'rata_rata'
                ];
                foreach ($lainFields as $f) $mLN->{$f} = $this->colS($row, $f);
                $mLN->save();
            });
        });
    }

    // ---------------- Helpers ----------------
    private function asString($val): ?string
    {
        if ($val === null) return null;
        return trim((string) $val);
    }

    private function colS($row, string $key): ?string
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) return null;
        return $this->asString($row[$i] ?? null);
    }
}
