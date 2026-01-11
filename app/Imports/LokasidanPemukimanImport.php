<?php

namespace App\Imports;

use Illuminate\Support\Collection;
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
     *  5: Jenis Kelamin   (disimpan ke: Jeniskelamin)
     *  6: Tempat Lahir    (disimpan ke: tempatlahir)
     *
     *  Mulai index 7 ke atas = kolom-kolom Lokasi & Pemukiman + Akses.
     */

    // ❗JANGAN pakai "private array $idx" kalau PHP hosting masih < 7.4
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

        // ---------- akses_pendidikan (tiap entitas: jarak, waktu, kemudahan) ----------
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

        // ---------- aksessarpras (tiap entitas: jenis, angkutan, waktu, biaya, kemudahan) ----------
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

    /**
     * Flag untuk skip header hanya di chunk pertama
     */
    protected $skipHeader = true;

    /**
     * Dipanggil per chunk (bukan seluruh file sekaligus).
     */
    public function collection(Collection $rows)
    {
        // Kalau ini chunk pertama, buang header baris pertama
        if ($this->skipHeader) {
            $rows = $rows->skip(1);
            $this->skipHeader = false;
        }

        $rows->each(function ($row) {

            // ------ KOLOM UMUM 0–6 ------
            $kk           = $this->asString($row[0] ?? null);
            $nik          = $this->asString($row[1] ?? null);
            $gelarAwal    = $this->asString($row[2] ?? null);
            $nama         = $this->asString($row[3] ?? null);
            $gelarAkhir   = $this->asString($row[4] ?? null);
            $jenisKelamin = $this->asString($row[5] ?? null);
            $tempatLahir  = $this->asString($row[6] ?? null);

            if (!$nik) {
                // NIK wajib, kalau kosong skip baris
                return;
            }

            $namaFull = trim(implode(' ', array_filter([$gelarAwal, $nama, $gelarAkhir])));

            // =========================
            // 1) lokasipemukiman
            // =========================
            $mL = lokasipemukiman::firstOrNew(['nik' => $nik]);
            $this->fillCommon($mL, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir);

            foreach (
                [
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
                ] as $k
            ) {
                $mL->{$k} = $this->colString($row, $k);
            }
            $mL->save();

            // =========================
            // 2) akses_pendidikan
            // =========================
            $mAP = akses_pendidikan::firstOrNew(['nik' => $nik]);
            $this->fillCommon($mAP, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir);

            $mAP->jaraktempuh_paud        = $this->colString($row, 'paud_jarak');
            $mAP->waktutempuh_paud        = $this->colString($row, 'paud_waktu');
            $mAP->kemudahan_paud          = $this->colString($row, 'paud_kemudahan');
            $mAP->jaraktempuh_tk          = $this->colString($row, 'tk_jarak');
            $mAP->waktutempuh_tk          = $this->colString($row, 'tk_waktu');
            $mAP->kemudahan_tk            = $this->colString($row, 'tk_kemudahan');
            $mAP->jaraktempuh_sd          = $this->colString($row, 'sd_jarak');
            $mAP->waktutempuh_sd          = $this->colString($row, 'sd_waktu');
            $mAP->kemudahan_sd            = $this->colString($row, 'sd_kemudahan');
            $mAP->jaraktempuh_smp         = $this->colString($row, 'smp_jarak');
            $mAP->waktutempuh_smp         = $this->colString($row, 'smp_waktu');
            $mAP->kemudahan_smp           = $this->colString($row, 'smp_kemudahan');
            $mAP->jaraktempuh_sma         = $this->colString($row, 'sma_jarak');
            $mAP->waktutempuh_sma         = $this->colString($row, 'sma_waktu');
            $mAP->kemudahan_sma           = $this->colString($row, 'sma_kemudahan');
            $mAP->jaraktempuh_pt          = $this->colString($row, 'pt_jarak');
            $mAP->waktutempuh_pt          = $this->colString($row, 'pt_waktu');
            $mAP->kemudahan_pt            = $this->colString($row, 'pt_kemudahan');
            $mAP->jaraktempuh_ps          = $this->colString($row, 'ps_jarak');
            $mAP->waktutempuh_ps          = $this->colString($row, 'ps_waktu');
            $mAP->kemudahan_ps            = $this->colString($row, 'ps_kemudahan');
            $mAP->jaraktempuh_seminari    = $this->colString($row, 'seminari_jarak');
            $mAP->waktutempuh_seminari    = $this->colString($row, 'seminari_waktu');
            $mAP->kemudahan_seminari      = $this->colString($row, 'seminari_kemudahan');
            $mAP->jaraktempuh_pagamalain  = $this->colString($row, 'pagamalain_jarak');
            $mAP->waktutempuh_pagamalain  = $this->colString($row, 'pagamalain_waktu');
            $mAP->kemudahan_pagamalain    = $this->colString($row, 'pagamalain_kemudahan');
            $mAP->save();

            // =========================
            // 3) akseskesehatan
            // =========================
            $mAK = akseskesehatan::firstOrNew(['nik' => $nik]);
            $this->fillCommon($mAK, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir);

            $mAK->jaraktempuh_rumahs       = $this->colString($row, 'rs_jarak');
            $mAK->waktutempuh_rumahs       = $this->colString($row, 'rs_waktu');
            $mAK->kemudahan_rumahs         = $this->colString($row, 'rs_kemudahan');
            $mAK->jaraktempuh_rumahb       = $this->colString($row, 'rsb_jarak');
            $mAK->waktutempuh_rumahb       = $this->colString($row, 'rsb_waktu');
            $mAK->kemudahan_rumahb         = $this->colString($row, 'rsb_kemudahan');
            $mAK->jaraktempuh_poliklinik   = $this->colString($row, 'poliklinik_jarak');
            $mAK->waktutempuh_poliklinik   = $this->colString($row, 'poliklinik_waktu');
            $mAK->kemudahan_poliklinik     = $this->colString($row, 'poliklinik_kemudahan');
            $mAK->jaraktempuh_puskesmas    = $this->colString($row, 'puskesmas_jarak');
            $mAK->waktutempuh_puskesmas    = $this->colString($row, 'puskesmas_waktu');
            $mAK->kemudahan_puskesmas      = $this->colString($row, 'puskesmas_kemudahan');
            $mAK->jaraktempuh_poskedes     = $this->colString($row, 'poskedes_jarak');
            $mAK->waktutempuh_poskedes     = $this->colString($row, 'poskedes_waktu');
            $mAK->kemudahan_poskedes       = $this->colString($row, 'poskedes_kemudahan');
            $mAK->jaraktempuh_posyandu     = $this->colString($row, 'posyandu_jarak');
            $mAK->waktutempuh_posyandu     = $this->colString($row, 'posyandu_waktu');
            $mAK->kemudahan_posyandu       = $this->colString($row, 'posyandu_kemudahan');
            $mAK->jaraktempuh_apotik       = $this->colString($row, 'apotik_jarak');
            $mAK->waktutempuh_apotik       = $this->colString($row, 'apotik_waktu');
            $mAK->kemudahan_apotik         = $this->colString($row, 'apotik_kemudahan');
            $mAK->jaraktempuh_toko_obat    = $this->colString($row, 'toko_obat_jarak');
            $mAK->waktutempuh_toko_obat    = $this->colString($row, 'toko_obat_waktu');
            $mAK->kemudahan_toko_obat      = $this->colString($row, 'toko_obat_kemudahan');
            $mAK->save();

            // =========================
            // 4) aksestenagakerja
            // =========================
            $mAT = aksestenagakerja::firstOrNew(['nik' => $nik]);
            $this->fillCommon($mAT, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir);

            $mAT->jaraktempuh_dr_spesialis = $this->colString($row, 'drsp_jarak');
            $mAT->waktutempuh_dr_spesialis = $this->colString($row, 'drsp_waktu');
            $mAT->kemudahan_dr_spesialis   = $this->colString($row, 'drsp_kemudahan');
            $mAT->jaraktempuh_dr_umum      = $this->colString($row, 'drumum_jarak');
            $mAT->waktutempuh_dr_umum      = $this->colString($row, 'drumum_waktu');
            $mAT->kemudahan_dr_umum        = $this->colString($row, 'drumum_kemudahan');
            $mAT->jaraktempuh_bidan        = $this->colString($row, 'bidan_jarak');
            $mAT->waktutempuh_bidan        = $this->colString($row, 'bidan_waktu');
            $mAT->kemudahan_bidan          = $this->colString($row, 'bidan_kemudahan');
            $mAT->jaraktempuh_tenagakes    = $this->colString($row, 'tenagakes_jarak');
            $mAT->waktutempuh_tenagakes    = $this->colString($row, 'tenagakes_waktu');
            $mAT->kemudahan_tenagakes      = $this->colString($row, 'tenagakes_kemudahan');
            $mAT->jaraktempuh_dukun        = $this->colString($row, 'dukun_jarak');
            $mAT->waktutempuh_dukun        = $this->colString($row, 'dukun_waktu');
            $mAT->kemudahan_dukun          = $this->colString($row, 'dukun_kemudahan');
            $mAT->save();

            // =========================
            // 5) aksessarpras
            // =========================
            $mSP = aksessarpras::firstOrNew(['nik' => $nik]);
            $this->fillCommon($mSP, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir);

            $mSP->jenistrasport_lokasipu       = $this->colString($row, 'lokasipu_jenis');
            $mSP->pengtransportumum_lokasipu   = $this->colString($row, 'lokasipu_angkutan');
            $mSP->waktutempuh_lokasipu         = $this->colString($row, 'lokasipu_waktu');
            $mSP->biaya_lokasipu               = $this->colString($row, 'lokasipu_biaya');
            $mSP->kemudahan_lokasipu           = $this->colString($row, 'lokasipu_kemudahan');

            $mSP->jenistrasport_lahanpertanian     = $this->colString($row, 'lahan_jenis');
            $mSP->pengtransportumum_lahanpertanian = $this->colString($row, 'lahan_angkutan');
            $mSP->waktutempuh_lahanpertanian       = $this->colString($row, 'lahan_waktu');
            $mSP->biaya_lahanpertanian             = $this->colString($row, 'lahan_biaya');
            $mSP->kemudahan_lahanpertanian         = $this->colString($row, 'lahan_kemudahan');

            $mSP->jenistrasport_sekolah     = $this->colString($row, 'sekolah_jenis');
            $mSP->pengtransportumum_sekolah = $this->colString($row, 'sekolah_angkutan');
            $mSP->waktutempuh_sekolah       = $this->colString($row, 'sekolah_waktu');
            $mSP->biaya_sekolah             = $this->colString($row, 'sekolah_biaya');
            $mSP->kemudahan_sekolah         = $this->colString($row, 'sekolah_kemudahan');

            $mSP->jenistrasport_berobat     = $this->colString($row, 'berobat_jenis');
            $mSP->pengtransportumum_berobat = $this->colString($row, 'berobat_angkutan');
            $mSP->waktutempuh_berobat       = $this->colString($row, 'berobat_waktu');
            $mSP->biaya_berobat             = $this->colString($row, 'berobat_biaya');
            $mSP->kemudahan_berobat         = $this->colString($row, 'berobat_kemudahan');

            $mSP->jenistrasport_beribadah     = $this->colString($row, 'beribadah_jenis');
            $mSP->pengtransportumum_beribadah = $this->colString($row, 'beribadah_angkutan');
            $mSP->waktutempuh_beribadah       = $this->colString($row, 'beribadah_waktu');
            $mSP->biaya_beribadah             = $this->colString($row, 'beribadah_biaya');
            $mSP->kemudahan_beribadah         = $this->colString($row, 'beribadah_kemudahan');

            $mSP->jenistrasport_rekreasi     = $this->colString($row, 'rekreasi_jenis');
            $mSP->pengtransportumum_rekreasi = $this->colString($row, 'rekreasi_angkutan');
            $mSP->waktutempuh_rekreasi       = $this->colString($row, 'rekreasi_waktu');
            $mSP->biaya_rekreasi             = $this->colString($row, 'rekreasi_biaya');
            $mSP->kemudahan_rekreasi         = $this->colString($row, 'rekreasi_kemudahan');
            $mSP->save();

            // =========================
            // 6) laink
            // =========================
            $mLN = laink::firstOrNew(['nik' => $nik]);
            $this->fillCommon($mLN, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir);

            foreach (
                [
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
                ] as $k
            ) {
                $mLN->{$k} = $this->colString($row, $k);
            }
            $mLN->save();
        });
    }

    /**
     * Ukuran chunk (berapa baris diproses sekali jalan).
     * Silakan sesuaikan: 200 / 500 / 1000
     */
    public function chunkSize(): int
    {
        return 500;
    }

    // ---------------- Helpers ----------------

    private function asString($val): ?string
    {
        if ($val === null) {
            return null;
        }
        return trim((string) $val);
    }

    private function colString($row, string $key): ?string
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) {
            return null;
        }
        return $this->asString($row[$i] ?? null);
    }

    /**
     * Opsional: kalau ada kolom angka yang mau dipastikan integer.
     * Saat ini belum dipakai, tapi disediakan biar konsisten seperti Code B.
     */
    private function colInt($row, string $key): ?int
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) {
            return null;
        }

        $val = $row[$i] ?? null;
        if ($val === null || $val === '') {
            return null;
        }

        if (is_string($val)) {
            $val = str_replace(['.', ',', ' '], '', $val);
        }

        return (int) $val;
    }

    /**
     * Helper untuk menghindari pengulangan assign kolom umum
     */
    private function fillCommon($model, $kk, $nik, $gelarAwal, $nama, $namaFull, $gelarAkhir, $jenisKelamin, $tempatLahir): void
    {
        $model->kk           = $kk;
        $model->nik          = $nik;
        $model->gelarawal    = $gelarAwal;
        $model->nama         = $nama ?: $namaFull;
        $model->gelarakhir   = $gelarAkhir;
        $model->Jeniskelamin = $jenisKelamin;
        $model->tempatlahir  = $tempatLahir;
    }
}
