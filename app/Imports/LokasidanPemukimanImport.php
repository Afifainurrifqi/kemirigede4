<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\lokasipemukiman;
use App\Models\akses_pendidikan;

class LokasidanPemukimanImport implements ToCollection, WithChunkReading
{
    /**
     * FORMAT FILE "SITAKRO KK UP.xlsx" (index mulai 0):
     * 0 NO KK
     * 1 NIK
     * 2 NAMA
     * 3 ALAMAT
     * 4 NO. HP
     * 5 NO. Telpon Rumah
     * 6 NIK Kepala Keluarga
     * 7 TEMPAT TINGGAL YANG DITEMPATI
     * 8 STATUS LAHAN
     * 9 LUAS LANTAI
     * 10 LUAS TANAH
     * 11 JENIS LANTAI
     * 12 DINDING
     * 13 JENDELA
     * 14 ATAP
     * 15 PENERANGAN
     * 16 ENERGI MEMASAK
     * 17 JIKA KAYU, SUMBER KAYU
     * 18 TEMPAT SAMPAH
     * 19 FASILITAS MCK
     * 20 SUMBER AIR MANDI
     * 21 FASILITAS BUANG AIR BESAR
     * 22 SUMBER AIR MINUM
     * 23 TEMPAT PEMBUANGAN AIR LIMBAH
     * 24 RUMAH DILEWATI SUTET
     * 25 RUMAH DIPANTARAN SUNGAI
     * 26 RUMAH DI LERENG
     * 27 KONDISI RUMAH KUMUH
     * 28 PAUD - JARAK
     * 29 PAUD - WAKTU
     * 30 PAUD - KEMUDAHAN
     */

    protected $idx = [
        // lokasipemukiman
        'kk'                     => 0,
        'nik'                    => 1,
        'nama'                   => 2,
        'alamat'                 => 3,
        'nohp'                   => 4,
        'telpon_rumah'           => 5,  // pastikan kolom ini ada di tabel kamu (atau abaikan)
        'nik_kepala'             => 6,
        'tempat_tinggal'         => 7,
        'status_lahan'           => 8,
        'luas_lantai_tinggal'    => 9,
        'luas_tanah_tinggal'     => 10,
        'jenis_lantai_tinggal'   => 11,
        'dinding_sebagian'       => 12,
        'jendela'                => 13,
        'atap'                   => 14,
        'penerangan'             => 15,
        'energi_masak'           => 16,
        'jika_kayu_jenis'        => 17,
        'tempat_sampah'          => 18,
        'mck'                    => 19,
        'sumber_air_mandi'       => 20,
        'sumber_air_mck'         => 21, // "FASILITAS BUANG AIR BESAR"
        'sumber_air_minum'       => 22,
        'tempat_pembuangan_limbah' => 23,
        'rumah_sutet'            => 24,
        'rumah_sungai'           => 25,
        'rumah_lereng_gunung'    => 26,
        'kondi_rumah_kumuh'      => 27,

        // akses_pendidikan (PAUD saja ada di file ini)
        'paud_jarak'             => 28,
        'paud_waktu'             => 29,
        'paud_kemudahan'         => 30,
    ];

    /**
     * Flag untuk skip header hanya di chunk pertama
     */
    protected $skipHeader = true;

    public function collection(Collection $rows)
    {
        // buang header hanya sekali
        if ($this->skipHeader) {
            $rows = $rows->skip(1);
            $this->skipHeader = false;
        }

        $rows->each(function ($row) {

            $kk   = $this->colString($row, 'kk');
            $nik  = $this->colString($row, 'nik');
            $nama = $this->colString($row, 'nama');

            if (!$nik) return;

            // =========================
            // 1) lokasipemukiman
            // =========================
            $mL = lokasipemukiman::firstOrNew(['nik' => $nik]);

            $mL->kk   = $kk;
            $mL->nik  = $nik;
            $mL->nama = $nama;

            $mL->alamat                   = $this->colString($row, 'alamat');
            $mL->nohp                     = $this->colString($row, 'nohp');
            $mL->nowa                     = $this->colString($row, 'nohp'); // opsional: samakan WA dengan HP
            $mL->nik_kepala               = $this->colString($row, 'nik_kepala');
            $mL->tempat_tinggal           = $this->colString($row, 'tempat_tinggal');
            $mL->status_lahan             = $this->colString($row, 'status_lahan');
            $mL->luas_lantai_tinggal      = $this->colString($row, 'luas_lantai_tinggal');
            $mL->luas_tanah_tinggal       = $this->colString($row, 'luas_tanah_tinggal');
            $mL->jenis_lantai_tinggal     = $this->colString($row, 'jenis_lantai_tinggal');
            $mL->dinding_sebagian         = $this->colString($row, 'dinding_sebagian');
            $mL->jendela                  = $this->colString($row, 'jendela');
            $mL->atap                     = $this->colString($row, 'atap');
            $mL->penerangan               = $this->colString($row, 'penerangan');
            $mL->energi_masak             = $this->colString($row, 'energi_masak');
            $mL->jika_kayu_jenis          = $this->colString($row, 'jika_kayu_jenis');
            $mL->tempat_sampah            = $this->colString($row, 'tempat_sampah');
            $mL->mck                      = $this->colString($row, 'mck');
            $mL->sumber_air_mandi         = $this->colString($row, 'sumber_air_mandi');
            $mL->sumber_air_mck           = $this->colString($row, 'sumber_air_mck');
            $mL->sumber_air_minum         = $this->colString($row, 'sumber_air_minum');
            $mL->tempat_pembuangan_limbah = $this->colString($row, 'tempat_pembuangan_limbah');
            $mL->rumah_sutet              = $this->colString($row, 'rumah_sutet');
            $mL->rumah_sungai             = $this->colString($row, 'rumah_sungai');
            $mL->rumah_lereng_gunung      = $this->colString($row, 'rumah_lereng_gunung');
            $mL->kondi_rumah_kumuh        = $this->colString($row, 'kondi_rumah_kumuh');

            // kalau ada kolom telpon rumah di tabel, aktifkan:
            if (property_exists($mL, 'telpon_rumah') || isset($mL->telpon_rumah)) {
                $mL->telpon_rumah = $this->colString($row, 'telpon_rumah');
            }

            $mL->save();

            // =========================
            // 2) akses_pendidikan (PAUD)
            // =========================
            $mAP = akses_pendidikan::firstOrNew(['nik' => $nik]);

            $mAP->kk   = $kk;
            $mAP->nik  = $nik;
            $mAP->nama = $nama;

            $mAP->jaraktempuh_paud = $this->colString($row, 'paud_jarak');
            $mAP->waktutempuh_paud = $this->colString($row, 'paud_waktu');
            $mAP->kemudahan_paud   = $this->colString($row, 'paud_kemudahan');

            $mAP->save();
        });
    }

    public function chunkSize(): int
    {
        return 500;
    }

    // ---------------- Helpers ----------------
    private function asString($val): ?string
    {
        if ($val === null) return null;

        // penting: kalau nilainya numeric besar (KK/NIK), jangan jadi scientific notation
        if (is_float($val) || is_int($val)) {
            // ini aman jika excel menyimpan sebagai angka biasa, tapi tetap lebih baik kolom KK/NIK di-excel dibuat TEXT
            $val = rtrim(sprintf('%.0f', $val), '.');
        }

        return trim((string) $val);
    }

    private function colString($row, string $key): ?string
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) return null;

        return $this->asString($row[$i] ?? null);
    }
}
