<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\Lokasipemukiman;
use App\Models\Akses_pendidikan;
use App\Models\Akseskesehatan;
use App\Models\Aksestenagakerja;
use App\Models\Aksessarpras;
use App\Models\Laink;

class LokasidanPemukimanImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 300;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // $row = array header->value
            // Header akan diubah oleh Laravel Excel jadi snake_case
            // contoh: "NO. HP" => "no_hp"

            $kk   = $this->H($row, ['no_kk', 'no_kk_kk', 'kk']);
            $nik  = $this->H($row, ['nik']);
            $nama = $this->H($row, ['nama']);

            if (!$nik) continue;

            try {
                DB::transaction(function () use ($row, $kk, $nik, $nama) {

                    // =========================
                    // COMMON untuk semua model (kalau tabel kamu memang punya kolom ini)
                    // Kalau tabel kamu tidak punya gelar/jk/tempatlahir, hapus saja.
                    // =========================
                    $common = [
                        'kk' => $kk,
                        'nik' => $nik,
                        'nama' => $nama,
                    ];

                    // =========================
                    // 1) Lokasi Pemukiman
                    // =========================
                    $mL = Lokasipemukiman::firstOrNew(['nik' => $nik]);
                    $this->setCommon($mL, $common);

                    $mL->alamat = $this->H($row, ['alamat']);
                    $mL->nohp   = $this->H($row, ['no_hp', 'nohp']);
                    // Nomor telpon rumah (di excel biasanya "no_telpon_rumah")
                    $telpRumah = $this->H($row, ['no_telpon_rumah', 'no_telepon_rumah', 'no_telp_rumah']);
                    if ($this->hasAttr($mL, 'no_telpon_rumah')) $mL->no_telpon_rumah = $telpRumah;
                    else $mL->nowa = $telpRumah;

                    $mL->nik_kepala = $this->H($row, ['nik_kepala_keluarga', 'nik_kepala']);
                    $mL->tempat_tinggal = $this->H($row, ['tempat_tinggal_yang_ditempati', 'tempat_tinggal']);
                    $mL->status_lahan = $this->H($row, ['status_lahan']);

                    $mL->luas_lantai_tinggal  = $this->H($row, ['luas_lantai_tempat_tinggal_m2', 'luas_lantai', 'luas_lantai_tinggal']);
                    $mL->luas_tanah_tinggal   = $this->H($row, ['luas_tanah_tempat_tinggal_m2', 'luas_tanah', 'luas_tanah_tinggal']);
                    $mL->jenis_lantai_tinggal = $this->H($row, ['jenis_lantai_tempat_tinggal_terluas', 'jenis_lantai', 'jenis_lantai_tinggal']);

                    $mL->dinding_sebagian = $this->H($row, ['dinding_sebagian_besar_rumah', 'dinding_sebagian', 'dinding']);
                    $mL->jendela          = $this->H($row, ['jendela']);
                    $mL->atap             = $this->H($row, ['atap']);
                    $mL->penerangan       = $this->H($row, ['penerangan_rumah', 'penerangan']);
                    $mL->energi_masak     = $this->H($row, ['energi_untuk_memasak', 'energi_masak']);

                    $mL->jika_kayu_jenis  = $this->H($row, ['jika_menggunakan_kayu_bakar_sumber_kayu_bakar', 'jika_kayu_jenis']);
                    $mL->tempat_sampah    = $this->H($row, ['tempat_pembuangan_sampah', 'tempat_sampah']);
                    $mL->mck              = $this->H($row, ['fasilitas_mck', 'mck']);
                    $mL->sumber_air_mandi = $this->H($row, ['sumber_air_mandi_cuci', 'sumber_air_mandi']);
                    // fasilitas BAB
                    $bab = $this->H($row, ['fasilitas_buang_air_besar', 'fasilitas_bab']);
                    if ($this->hasAttr($mL, 'fasilitas_bab')) $mL->fasilitas_bab = $bab;

                    $mL->sumber_air_minum         = $this->H($row, ['sumber_air_minum', 'sumber_air_minum_minum']);
                    $mL->tempat_pembuangan_limbah = $this->H($row, ['tempat_pembuangan_air_limbah', 'tempat_pembuangan_limbah']);

                    // catatan: beberapa excel kamu urutannya beda, tapi ini aman karena pakai header
                    $mL->rumah_sutet         = $this->H($row, ['rumah_dilewati_sutet', 'rumah_sutet']);
                    $mL->rumah_sungai        = $this->H($row, ['rumah_di_pinggiran_sungai', 'rumah_sungai']);
                    $mL->rumah_lereng_gunung = $this->H($row, ['rumah_di_lereng_gunung', 'rumah_lereng_gunung']);
                    $mL->kondi_rumah_kumuh   = $this->H($row, ['kondisi_rumah_kumuh', 'kondi_rumah_kumuh']);

                    $mL->save();

                    // =========================
                    // 2) Akses Pendidikan (PAUD/TK/SD/SMP/SMA/PT/PS/SEMINARI/PAGAMALAIN)
                    // =========================
                    $mAP = Akses_pendidikan::firstOrNew(['nik' => $nik]);
                    $this->setCommon($mAP, $common);

                    $this->set3($mAP, $row, 'paud', 'jaraktempuh_paud', 'waktutempuh_paud', 'kemudahan_paud');
                    $this->set3($mAP, $row, 'tk',   'jaraktempuh_tk',   'waktutempuh_tk',   'kemudahan_tk');
                    $this->set3($mAP, $row, 'sd',   'jaraktempuh_sd',   'waktutempuh_sd',   'kemudahan_sd');
                    $this->set3($mAP, $row, 'smp',  'jaraktempuh_smp',  'waktutempuh_smp',  'kemudahan_smp');
                    $this->set3($mAP, $row, 'sma',  'jaraktempuh_sma',  'waktutempuh_sma',  'kemudahan_sma');
                    $this->set3($mAP, $row, 'pt',   'jaraktempuh_pt',   'waktutempuh_pt',   'kemudahan_pt');
                    $this->set3($mAP, $row, 'ps',   'jaraktempuh_ps',   'waktutempuh_ps',   'kemudahan_ps');
                    $this->set3($mAP, $row, 'seminari',  'jaraktempuh_seminari',  'waktutempuh_seminari',  'kemudahan_seminari');
                    $this->set3($mAP, $row, 'pagamalain', 'jaraktempuh_pagamalain', 'waktutempuh_pagamalain', 'kemudahan_pagamalain');

                    $mAP->save();

                    // =========================
                    // 3) Akses Kesehatan
                    // =========================
                    $mAK = Akseskesehatan::firstOrNew(['nik' => $nik]);
                    $this->setCommon($mAK, $common);

                    $this->set3($mAK, $row, 'rs',         'jaraktempuh_rumahs',     'waktutempuh_rumahs',     'kemudahan_rumahs');
                    $this->set3($mAK, $row, 'rsb',        'jaraktempuh_rumahb',     'waktutempuh_rumahb',     'kemudahan_rumahb');
                    $this->set3($mAK, $row, 'poliklinik', 'jaraktempuh_poliklinik', 'waktutempuh_poliklinik', 'kemudahan_poliklinik');
                    $this->set3($mAK, $row, 'puskesmas',  'jaraktempuh_puskesmas',  'waktutempuh_puskesmas',  'kemudahan_puskesmas');
                    $this->set3($mAK, $row, 'poskedes',   'jaraktempuh_poskedes',   'waktutempuh_poskedes',   'kemudahan_poskedes');
                    $this->set3($mAK, $row, 'posyandu',   'jaraktempuh_posyandu',   'waktutempuh_posyandu',   'kemudahan_posyandu');
                    $this->set3($mAK, $row, 'apotik',     'jaraktempuh_apotik',     'waktutempuh_apotik',     'kemudahan_apotik');
                    $this->set3($mAK, $row, 'toko_obat',  'jaraktempuh_toko_obat',  'waktutempuh_toko_obat',  'kemudahan_toko_obat');

                    $mAK->save();

                    // =========================
                    // 4) Akses Tenaga Kerja / Tenaga Kesehatan
                    // =========================
                    $mAT = Aksestenagakerja::firstOrNew(['nik' => $nik]);
                    $this->setCommon($mAT, $common);

                    $this->set3($mAT, $row, 'drsp',     'jaraktempuh_dr_spesialis', 'waktutempuh_dr_spesialis', 'kemudahan_dr_spesialis');
                    $this->set3($mAT, $row, 'drumum',   'jaraktempuh_dr_umum',      'waktutempuh_dr_umum',      'kemudahan_dr_umum');
                    $this->set3($mAT, $row, 'bidan',    'jaraktempuh_bidan',        'waktutempuh_bidan',        'kemudahan_bidan');
                    $this->set3($mAT, $row, 'tenagakes', 'jaraktempuh_tenagakes',    'waktutempuh_tenagakes',    'kemudahan_tenagakes');
                    $this->set3($mAT, $row, 'dukun',    'jaraktempuh_dukun',        'waktutempuh_dukun',        'kemudahan_dukun');

                    $mAT->save();

                    // =========================
                    // 5) Akses Sarpras (jenis/angkutan/waktu/biaya/kemudahan)
                    // =========================
                    $mSP = Aksessarpras::firstOrNew(['nik' => $nik]);
                    $this->setCommon($mSP, $common);

                    $this->set5(
                        $mSP,
                        $row,
                        'lokasipu',
                        'jenistrasport_lokasipu',
                        'pengtransportumum_lokasipu',
                        'waktutempuh_lokasipu',
                        'biaya_lokasipu',
                        'kemudahan_lokasipu'
                    );

                    $this->set5(
                        $mSP,
                        $row,
                        'lahan',
                        'jenistrasport_lahanpertanian',
                        'pengtransportumum_lahanpertanian',
                        'waktutempuh_lahanpertanian',
                        'biaya_lahanpertanian',
                        'kemudahan_lahanpertanian'
                    );

                    $this->set5(
                        $mSP,
                        $row,
                        'sekolah',
                        'jenistrasport_sekolah',
                        'pengtransportumum_sekolah',
                        'waktutempuh_sekolah',
                        'biaya_sekolah',
                        'kemudahan_sekolah'
                    );

                    $this->set5(
                        $mSP,
                        $row,
                        'berobat',
                        'jenistrasport_berobat',
                        'pengtransportumum_berobat',
                        'waktutempuh_berobat',
                        'biaya_berobat',
                        'kemudahan_berobat'
                    );

                    $this->set5(
                        $mSP,
                        $row,
                        'beribadah',
                        'jenistrasport_beribadah',
                        'pengtransportumum_beribadah',
                        'waktutempuh_beribadah',
                        'biaya_beribadah',
                        'kemudahan_beribadah'
                    );

                    $this->set5(
                        $mSP,
                        $row,
                        'rekreasi',
                        'jenistrasport_rekreasi',
                        'pengtransportumum_rekreasi',
                        'waktutempuh_rekreasi',
                        'biaya_rekreasi',
                        'kemudahan_rekreasi'
                    );

                    $mSP->save();

                    // =========================
                    // 6) Laink
                    // =========================
                    $mLN = Laink::firstOrNew(['nik' => $nik]);
                    $this->setCommon($mLN, $common);

                    $mLN->pengtransportsebelum = $this->H($row, ['pengtransportsebelum', 'peng_transport_sebelum']);
                    $mLN->pengtransportsesudah = $this->H($row, ['pengtransportsesudah', 'peng_transport_sesudah']);
                    $mLN->blt                  = $this->H($row, ['blt']);
                    $mLN->pkh                  = $this->H($row, ['pkh']);
                    $mLN->bst                  = $this->H($row, ['bst']);
                    $mLN->bantuan_presiden     = $this->H($row, ['bantuan_presiden']);
                    $mLN->bantuan_umkm         = $this->H($row, ['bantuan_umkm']);
                    $mLN->bantuan_pekerja      = $this->H($row, ['bantuan_pekerja']);
                    $mLN->bantuan_anak         = $this->H($row, ['bantuan_anak']);
                    $mLN->lainnya              = $this->H($row, ['lainnya']);
                    $mLN->rata_rata            = $this->H($row, ['rata_rata']);

                    $mLN->save();
                });
            } catch (\Throwable $e) {
                Log::error('Import Lokasi (OPSI B) gagal', [
                    'nik' => $nik,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    // ========= Helpers =========

    /**
     * Ambil value dari beberapa kemungkinan key header.
     * Laravel-Excel biasanya mengubah header jadi snake_case.
     */
    private function H($row, array $keys): ?string
    {
        foreach ($keys as $k) {
            if (isset($row[$k]) && $row[$k] !== null && $row[$k] !== '') {
                return trim((string)$row[$k]);
            }
        }
        return null;
    }

    private function setCommon($model, array $common): void
    {
        foreach ($common as $k => $v) {
            if ($this->hasAttr($model, $k)) {
                $model->{$k} = $v;
            }
        }
    }

    private function hasAttr($model, string $attr): bool
    {
        return array_key_exists($attr, $model->getAttributes()) || $model->isFillable($attr);
    }

    // set 3 kolom: jarak/waktu/kemudahan
    private function set3($model, $row, string $prefix, string $fJarak, string $fWaktu, string $fKem): void
    {
        $model->{$fJarak} = $this->H($row, ["{$prefix}_jarak", "{$prefix}_jarak_km", "{$prefix}_jarak_tempuh"]);
        $model->{$fWaktu} = $this->H($row, ["{$prefix}_waktu", "{$prefix}_waktu_jam", "{$prefix}_waktu_tempuh"]);
        $model->{$fKem}   = $this->H($row, ["{$prefix}_kemudahan", "{$prefix}_kemudahan_akses"]);
    }

    // set 5 kolom: jenis/angkutan/waktu/biaya/kemudahan
    private function set5($model, $row, string $prefix, string $fJenis, string $fAngkutan, string $fWaktu, string $fBiaya, string $fKem): void
    {
        $model->{$fJenis}    = $this->H($row, ["{$prefix}_jenis"]);
        $model->{$fAngkutan} = $this->H($row, ["{$prefix}_angkutan"]);
        $model->{$fWaktu}    = $this->H($row, ["{$prefix}_waktu"]);
        $model->{$fBiaya}    = $this->H($row, ["{$prefix}_biaya"]);
        $model->{$fKem}      = $this->H($row, ["{$prefix}_kemudahan"]);
    }
}
