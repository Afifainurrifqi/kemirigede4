<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\lokasipemukiman;
use App\Models\akses_pendidikan;
use App\Models\akseskesehatan;
use App\Models\aksestenagakerja;
use App\Models\aksessarpras;
use App\Models\laink;

class LokasidanPemukimanImport implements ToCollection, WithChunkReading
{
    /**
     * SUSUNAN KOLOM (index mulai 0)
     *  0: KK
     *  1: NIK
     *  2: Gelar Awal
     *  3: Nama
     *  4: Gelar Akhir
     *  5: Jenis Kelamin
     *  6: Tempat Lahir
     *
     *  Mulai index 7 ke atas = kolom lokasi & pemukiman + akses.
     */

    // ✅ Jangan typed property (biar aman PHP < 7.4)
    protected $idx = [
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
        'paud_jarak' => 32, 'paud_waktu' => 33, 'paud_kemudahan' => 34,
        'tk_jarak'   => 35, 'tk_waktu'   => 36, 'tk_kemudahan'   => 37,
        'sd_jarak'   => 38, 'sd_waktu'   => 39, 'sd_kemudahan'   => 40,
        'smp_jarak'  => 41, 'smp_waktu'  => 42, 'smp_kemudahan'  => 43,
        'sma_jarak'  => 44, 'sma_waktu'  => 45, 'sma_kemudahan'  => 46,
        'pt_jarak'   => 47, 'pt_waktu'   => 48, 'pt_kemudahan'   => 49,
        'ps_jarak'   => 50, 'ps_waktu'   => 51, 'ps_kemudahan'   => 52,
        'seminari_jarak' => 53, 'seminari_waktu' => 54, 'seminari_kemudahan' => 55,
        'pagamalain_jarak' => 56, 'pagamalain_waktu' => 57, 'pagamalain_kemudahan' => 58,

        // ---------- akseskesehatan ----------
        'rs_jarak' => 59, 'rs_waktu' => 60, 'rs_kemudahan' => 61,
        'rsb_jarak' => 62, 'rsb_waktu' => 63, 'rsb_kemudahan' => 64,
        'poliklinik_jarak' => 65, 'poliklinik_waktu' => 66, 'poliklinik_kemudahan' => 67,
        'puskesmas_jarak' => 68, 'puskesmas_waktu' => 69, 'puskesmas_kemudahan' => 70,
        'poskedes_jarak' => 71, 'poskedes_waktu' => 72, 'poskedes_kemudahan' => 73,
        'posyandu_jarak' => 74, 'posyandu_waktu' => 75, 'posyandu_kemudahan' => 76,
        'apotik_jarak' => 77, 'apotik_waktu' => 78, 'apotik_kemudahan' => 79,
        'toko_obat_jarak' => 80, 'toko_obat_waktu' => 81, 'toko_obat_kemudahan' => 82,

        // ---------- aksestenagakerja ----------
        'drsp_jarak' => 83, 'drsp_waktu' => 84, 'drsp_kemudahan' => 85,
        'drumum_jarak' => 86, 'drumum_waktu' => 87, 'drumum_kemudahan' => 88,
        'bidan_jarak' => 89, 'bidan_waktu' => 90, 'bidan_kemudahan' => 91,
        'tenagakes_jarak' => 92, 'tenagakes_waktu' => 93, 'tenagakes_kemudahan' => 94,
        'dukun_jarak' => 95, 'dukun_waktu' => 96, 'dukun_kemudahan' => 97,

        // ---------- aksessarpras ----------
        'lokasipu_jenis' => 98, 'lokasipu_angkutan' => 99, 'lokasipu_waktu' => 100, 'lokasipu_biaya' => 101, 'lokasipu_kemudahan' => 102,
        'lahan_jenis' => 103, 'lahan_angkutan' => 104, 'lahan_waktu' => 105, 'lahan_biaya' => 106, 'lahan_kemudahan' => 107,
        'sekolah_jenis' => 108, 'sekolah_angkutan' => 109, 'sekolah_waktu' => 110, 'sekolah_biaya' => 111, 'sekolah_kemudahan' => 112,
        'berobat_jenis' => 113, 'berobat_angkutan' => 114, 'berobat_waktu' => 115, 'berobat_biaya' => 116, 'berobat_kemudahan' => 117,
        'beribadah_jenis' => 118, 'beribadah_angkutan' => 119, 'beribadah_waktu' => 120, 'beribadah_biaya' => 121, 'beribadah_kemudahan' => 122,
        'rekreasi_jenis' => 123, 'rekreasi_angkutan' => 124, 'rekreasi_waktu' => 125, 'rekreasi_biaya' => 126, 'rekreasi_kemudahan' => 127,

        // ---------- laink ----------
        'pengtransportsebelum' => 128,
        'pengtransportsesudah' => 129,
        'blt' => 130,
        'pkh' => 131,
        'bst' => 132,
        'bantuan_presiden' => 133,
        'bantuan_umkm' => 134,
        'bantuan_pekerja' => 135,
        'bantuan_anak' => 136,
        'lainnya' => 137,
        'rata_rata' => 138,
    ];

    /**
     * ✅ Skip header hanya pada chunk pertama
     */
    protected $skipHeader = true;

    public function collection(Collection $rows)
    {
        if ($this->skipHeader) {
            $rows = $rows->skip(1);
            $this->skipHeader = false;
        }

        DB::transaction(function () use ($rows) {

            $rows->each(function ($row) {

                // ------ KOLOM UMUM 0–6 ------
                $kk           = $this->asString($row[0] ?? null);
                $nik          = $this->asString($row[1] ?? null);
                $gelarAwal    = $this->asString($row[2] ?? null);
                $nama         = $this->asString($row[3] ?? null);
                $gelarAkhir   = $this->asString($row[4] ?? null);
                $jenisKelamin = $this->asString($row[5] ?? null);
                $tempatLahir  = $this->asString($row[6] ?? null);

                if (!$nik) return; // NIK wajib

                $namaFull = trim(implode(' ', array_filter([$gelarAwal, $nama, $gelarAkhir])));

                // helper set common biar gak copy paste
                $setCommon = function ($model) use ($kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir) {
                    $model->kk           = $kk;
                    $model->nik          = $nik;
                    $model->gelarawal    = $gelarAwal;
                    $model->nama         = $nama ?: $namaFull;
                    $model->gelarakhir   = $gelarAkhir;
                    $model->Jeniskelamin = $jenisKelamin;
                    $model->tempatlahir  = $tempatLahir;
                };

                // =========================
                // 1) lokasipemukiman
                // =========================
                $mL = lokasipemukiman::firstOrNew(['nik' => $nik]);
                $setCommon($mL);

                foreach ([
                    'alamat','nohp','nowa','nik_kepala','tempat_tinggal','status_lahan','luas_lantai_tinggal',
                    'luas_tanah_tinggal','jenis_lantai_tinggal','dinding_sebagian','jendela','atap','penerangan',
                    'energi_masak','jika_kayu_jenis','tempat_sampah','mck','sumber_air_mandi','sumber_air_mck',
                    'sumber_air_minum','tempat_pembuangan_limbah','rumah_sungai','rumah_sutet','rumah_lereng_gunung','kondi_rumah_kumuh'
                ] as $k) {
                    $mL->{$k} = $this->colS($row, $k);
                }
                $mL->save();

                // =========================
                // 2) akses_pendidikan
                // =========================
                $mAP = akses_pendidikan::firstOrNew(['nik' => $nik]);
                $setCommon($mAP);

                $mAP->jaraktempuh_paud       = $this->colS($row, 'paud_jarak');
                $mAP->waktutempuh_paud       = $this->colS($row, 'paud_waktu');
                $mAP->kemudahan_paud         = $this->colS($row, 'paud_kemudahan');
                $mAP->jaraktempuh_tk         = $this->colS($row, 'tk_jarak');
                $mAP->waktutempuh_tk         = $this->colS($row, 'tk_waktu');
                $mAP->kemudahan_tk           = $this->colS($row, 'tk_kemudahan');
                $mAP->jaraktempuh_sd         = $this->colS($row, 'sd_jarak');
                $mAP->waktutempuh_sd         = $this->colS($row, 'sd_waktu');
                $mAP->kemudahan_sd           = $this->colS($row, 'sd_kemudahan');
                $mAP->jaraktempuh_smp        = $this->colS($row, 'smp_jarak');
                $mAP->waktutempuh_smp        = $this->colS($row, 'smp_waktu');
                $mAP->kemudahan_smp          = $this->colS($row, 'smp_kemudahan');
                $mAP->jaraktempuh_sma        = $this->colS($row, 'sma_jarak');
                $mAP->waktutempuh_sma        = $this->colS($row, 'sma_waktu');
                $mAP->kemudahan_sma          = $this->colS($row, 'sma_kemudahan');
                $mAP->jaraktempuh_pt         = $this->colS($row, 'pt_jarak');
                $mAP->waktutempuh_pt         = $this->colS($row, 'pt_waktu');
                $mAP->kemudahan_pt           = $this->colS($row, 'pt_kemudahan');
                $mAP->jaraktempuh_ps         = $this->colS($row, 'ps_jarak');
                $mAP->waktutempuh_ps         = $this->colS($row, 'ps_waktu');
                $mAP->kemudahan_ps           = $this->colS($row, 'ps_kemudahan');
                $mAP->jaraktempuh_seminari   = $this->colS($row, 'seminari_jarak');
                $mAP->waktutempuh_seminari   = $this->colS($row, 'seminari_waktu');
                $mAP->kemudahan_seminari     = $this->colS($row, 'seminari_kemudahan');
                $mAP->jaraktempuh_pagamalain = $this->colS($row, 'pagamalain_jarak');
                $mAP->waktutempuh_pagamalain = $this->colS($row, 'pagamalain_waktu');
                $mAP->kemudahan_pagamalain   = $this->colS($row, 'pagamalain_kemudahan');
                $mAP->save();

                // =========================
                // 3) akseskesehatan
                // =========================
                $mAK = akseskesehatan::firstOrNew(['nik' => $nik]);
                $setCommon($mAK);

                $mAK->jaraktempuh_rumahs        = $this->colS($row, 'rs_jarak');
                $mAK->waktutempuh_rumahs        = $this->colS($row, 'rs_waktu');
                $mAK->kemudahan_rumahs          = $this->colS($row, 'rs_kemudahan');
                $mAK->jaraktempuh_rumahb        = $this->colS($row, 'rsb_jarak');
                $mAK->waktutempuh_rumahb        = $this->colS($row, 'rsb_waktu');
                $mAK->kemudahan_rumahb          = $this->colS($row, 'rsb_kemudahan');
                $mAK->jaraktempuh_poliklinik    = $this->colS($row, 'poliklinik_jarak');
                $mAK->waktutempuh_poliklinik    = $this->colS($row, 'poliklinik_waktu');
                $mAK->kemudahan_poliklinik      = $this->colS($row, 'poliklinik_kemudahan');
                $mAK->jaraktempuh_puskesmas     = $this->colS($row, 'puskesmas_jarak');
                $mAK->waktutempuh_puskesmas     = $this->colS($row, 'puskesmas_waktu');
                $mAK->kemudahan_puskesmas       = $this->colS($row, 'puskesmas_kemudahan');
                $mAK->jaraktempuh_poskedes      = $this->colS($row, 'poskedes_jarak');
                $mAK->waktutempuh_poskedes      = $this->colS($row, 'poskedes_waktu');
                $mAK->kemudahan_poskedes        = $this->colS($row, 'poskedes_kemudahan');
                $mAK->jaraktempuh_posyandu      = $this->colS($row, 'posyandu_jarak');
                $mAK->waktutempuh_posyandu      = $this->colS($row, 'posyandu_waktu');
                $mAK->kemudahan_posyandu        = $this->colS($row, 'posyandu_kemudahan');
                $mAK->jaraktempuh_apotik        = $this->colS($row, 'apotik_jarak');
                $mAK->waktutempuh_apotik        = $this->colS($row, 'apotik_waktu');
                $mAK->kemudahan_apotik          = $this->colS($row, 'apotik_kemudahan');
                $mAK->jaraktempuh_toko_obat     = $this->colS($row, 'toko_obat_jarak');
                $mAK->waktutempuh_toko_obat     = $this->colS($row, 'toko_obat_waktu');
                $mAK->kemudahan_toko_obat       = $this->colS($row, 'toko_obat_kemudahan');
                $mAK->save();

                // =========================
                // 4) aksestenagakerja
                // =========================
                $mAT = aksestenagakerja::firstOrNew(['nik' => $nik]);
                $setCommon($mAT);

                $mAT->jaraktempuh_dr_spesialis  = $this->colS($row, 'drsp_jarak');
                $mAT->waktutempuh_dr_spesialis  = $this->colS($row, 'drsp_waktu');
                $mAT->kemudahan_dr_spesialis    = $this->colS($row, 'drsp_kemudahan');
                $mAT->jaraktempuh_dr_umum       = $this->colS($row, 'drumum_jarak');
                $mAT->waktutempuh_dr_umum       = $this->colS($row, 'drumum_waktu');
                $mAT->kemudahan_dr_umum         = $this->colS($row, 'drumum_kemudahan');
                $mAT->jaraktempuh_bidan         = $this->colS($row, 'bidan_jarak');
                $mAT->waktutempuh_bidan         = $this->colS($row, 'bidan_waktu');
                $mAT->kemudahan_bidan           = $this->colS($row, 'bidan_kemudahan');
                $mAT->jaraktempuh_tenagakes     = $this->colS($row, 'tenagakes_jarak');
                $mAT->waktutempuh_tenagakes     = $this->colS($row, 'tenagakes_waktu');
                $mAT->kemudahan_tenagakes       = $this->colS($row, 'tenagakes_kemudahan');
                $mAT->jaraktempuh_dukun         = $this->colS($row, 'dukun_jarak');
                $mAT->waktutempuh_dukun         = $this->colS($row, 'dukun_waktu');
                $mAT->kemudahan_dukun           = $this->colS($row, 'dukun_kemudahan');
                $mAT->save();

                // =========================
                // 5) aksessarpras
                // =========================
                $mSP = aksessarpras::firstOrNew(['nik' => $nik]);
                $setCommon($mSP);

                $mSP->jenistrasport_lokasipu       = $this->colS($row, 'lokasipu_jenis');
                $mSP->pengtransportumum_lokasipu   = $this->colS($row, 'lokasipu_angkutan');
                $mSP->waktutempuh_lokasipu         = $this->colS($row, 'lokasipu_waktu');
                $mSP->biaya_lokasipu               = $this->colS($row, 'lokasipu_biaya');
                $mSP->kemudahan_lokasipu           = $this->colS($row, 'lokasipu_kemudahan');

                $mSP->jenistrasport_lahanpertanian     = $this->colS($row, 'lahan_jenis');
                $mSP->pengtransportumum_lahanpertanian = $this->colS($row, 'lahan_angkutan');
                $mSP->waktutempuh_lahanpertanian       = $this->colS($row, 'lahan_waktu');
                $mSP->biaya_lahanpertanian             = $this->colS($row, 'lahan_biaya');
                $mSP->kemudahan_lahanpertanian         = $this->colS($row, 'lahan_kemudahan');

                $mSP->jenistrasport_sekolah     = $this->colS($row, 'sekolah_jenis');
                $mSP->pengtransportumum_sekolah = $this->colS($row, 'sekolah_angkutan');
                $mSP->waktutempuh_sekolah       = $this->colS($row, 'sekolah_waktu');
                $mSP->biaya_sekolah             = $this->colS($row, 'sekolah_biaya');
                $mSP->kemudahan_sekolah         = $this->colS($row, 'sekolah_kemudahan');

                $mSP->jenistrasport_berobat     = $this->colS($row, 'berobat_jenis');
                $mSP->pengtransportumum_berobat = $this->colS($row, 'berobat_angkutan');
                $mSP->waktutempuh_berobat       = $this->colS($row, 'berobat_waktu');
                $mSP->biaya_berobat             = $this->colS($row, 'berobat_biaya');
                $mSP->kemudahan_berobat         = $this->colS($row, 'berobat_kemudahan');

                $mSP->jenistrasport_beribadah     = $this->colS($row, 'beribadah_jenis');
                $mSP->pengtransportumum_beribadah = $this->colS($row, 'beribadah_angkutan');
                $mSP->waktutempuh_beribadah       = $this->colS($row, 'beribadah_waktu');
                $mSP->biaya_beribadah             = $this->colS($row, 'beribadah_biaya');
                $mSP->kemudahan_beribadah         = $this->colS($row, 'beribadah_kemudahan');

                $mSP->jenistrasport_rekreasi     = $this->colS($row, 'rekreasi_jenis');
                $mSP->pengtransportumum_rekreasi = $this->colS($row, 'rekreasi_angkutan');
                $mSP->waktutempuh_rekreasi       = $this->colS($row, 'rekreasi_waktu');
                $mSP->biaya_rekreasi             = $this->colS($row, 'rekreasi_biaya');
                $mSP->kemudahan_rekreasi         = $this->colS($row, 'rekreasi_kemudahan');

                $mSP->save();

                // =========================
                // 6) laink
                // =========================
                $mLN = laink::firstOrNew(['nik' => $nik]);
                $setCommon($mLN);

                foreach ([
                    'pengtransportsebelum','pengtransportsesudah','blt','pkh','bst',
                    'bantuan_presiden','bantuan_umkm','bantuan_pekerja','bantuan_anak','lainnya','rata_rata'
                ] as $k) {
                    $mLN->{$k} = $this->colS($row, $k);
                }
                $mLN->save();
            });
        });
    }

    /**
     * ✅ chunkSize wajib untuk WithChunkReading
     */
    public function chunkSize(): int
    {
        return 300; // boleh 200/500 tergantung server
    }

    // ---------------- Helpers ----------------
    private function asString($val): ?string
    {
        if ($val === null) return null;
        return trim((string)$val);
    }

    private function colS($row, string $key): ?string
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) return null;
        return $this->asString($row[$i] ?? null);
    }
}
