<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\Lokasipemukiman;
use App\Models\Akses_pendidikan;

class LokasidanPemukimanImport implements ToCollection, WithChunkReading
{
    /**
     * SUSUNAN KOLOM (index mulai 0) - FORMAT FILE: SITAKRO KK UP.xlsx
     *  0: NO KK
     *  1: NIK
     *  2: NAMA
     *  3: ALAMAT
     *  4: NO. HP
     *  5: NO. Telpon Rumah
     *  6: NIK Kepala Keluarga
     *  7: TEMPAT TINGGAL YANG DITEMPATI
     *  8: STATUS LAHAN
     *  9: LUAS LANTAI TEMPAT TINGGAL
     * 10: LUAS TANAH TEMPAT TINGGAL
     * 11: JENIS LANTAI TEMPAT TINGGAL TERLUAS
     * 12: DINDING SEBAGIAN BESAR RUMAH
     * 13: JENDELA
     * 14: ATAP
     * 15: PENERANGAN RUMAH
     * 16: ENERGI UNTUK MEMASAK
     * 17: JIKA MENGGUNAKAN KAYU BAKAR...
     * 18: TEMPAT PEMBUANGAN SAMPAH
     * 19: FASILITAS MCK
     * 20: SUMBER AIR MANDI TERBANYAK DARI
     * 21: FASILITAS BUANG AIR BESAR
     * 22: SUMBER AIR MINUM TERBANYAK
     * 23: TEMPAT PEMBUANGAN AIR LIMBAH
     * 24: RUMAH DILEWATI SUTET
     * 25: RUMAH DIPANTARAN SUNGAI
     * 26: RUMAH DI LERENG GUNUNG / BUKIT
     * 27: KONDISI RUMAH KUMUH / TIDAK
     * 28: PAUD - JARAK (KM)
     * 29: PAUD - WAKTU (JAM)
     * 30: PAUD - KEMUDAHAN
     */

    protected $idx = [
        // lokasipemukiman
        'alamat'                   => 3,
        'nohp'                     => 4,
        'telp_rumah'               => 5,  // dari kolom "No. Telpon Rumah" (opsional kalau ada field)
        'nik_kepala'               => 6,
        'tempat_tinggal'           => 7,
        'status_lahan'             => 8,
        'luas_lantai_tinggal'      => 9,
        'luas_tanah_tinggal'       => 10,
        'jenis_lantai_tinggal'     => 11,
        'dinding_sebagian'         => 12,
        'jendela'                  => 13,
        'atap'                     => 14,
        'penerangan'               => 15,
        'energi_masak'             => 16,
        'jika_kayu_jenis'          => 17,
        'tempat_sampah'            => 18,
        'mck'                      => 19,
        'sumber_air_mandi'         => 20,
        'fasilitas_bab'            => 21, // kalau tidak ada field di DB bisa abaikan
        'sumber_air_minum'         => 22,
        'tempat_pembuangan_limbah' => 23,
        'rumah_sutet'              => 24,
        'rumah_sungai'             => 25,
        'rumah_lereng_gunung'      => 26,
        'kondi_rumah_kumuh'        => 27,

        // akses_pendidikan (PAUD saja karena file hanya sampai PAUD)
        'paud_jarak'               => 28,
        'paud_waktu'               => 29,
        'paud_kemudahan'           => 30,
    ];

    /**
     * Skip header hanya di chunk pertama
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

                // ------ KOLOM UMUM FILE KK UP ------
                $kk   = $this->asString($row[0] ?? null);
                $nik  = $this->asString($row[1] ?? null);
                $nama = $this->asString($row[2] ?? null);

                if (!$nik) return;

                // =========================
                // 1) Lokasi Pemukiman
                // =========================
                $mL = Lokasipemukiman::firstOrNew(['nik' => $nik]);

                $mL->kk   = $kk;
                $mL->nik  = $nik;
                $mL->nama = $nama;

                foreach ([
                    'alamat', 'nohp', 'nik_kepala', 'tempat_tinggal', 'status_lahan',
                    'luas_lantai_tinggal', 'luas_tanah_tinggal', 'jenis_lantai_tinggal',
                    'dinding_sebagian', 'jendela', 'atap', 'penerangan', 'energi_masak',
                    'jika_kayu_jenis', 'tempat_sampah', 'mck', 'sumber_air_mandi',
                    'sumber_air_minum', 'tempat_pembuangan_limbah', 'rumah_sutet',
                    'rumah_sungai', 'rumah_lereng_gunung', 'kondi_rumah_kumuh'
                ] as $k) {
                    $mL->{$k} = $this->colString($row, $k);
                }

                // optional: kalau punya kolom telp_rumah / fasilitas_bab di DB, baru simpan
                if (isset($this->idx['telp_rumah']) && \Schema::hasColumn($mL->getTable(), 'telp_rumah')) {
                    $mL->telp_rumah = $this->colString($row, 'telp_rumah');
                }
                if (isset($this->idx['fasilitas_bab']) && \Schema::hasColumn($mL->getTable(), 'fasilitas_bab')) {
                    $mL->fasilitas_bab = $this->colString($row, 'fasilitas_bab');
                }

                $mL->save();

                // =========================
                // 2) Akses Pendidikan (PAUD)
                // =========================
                $mAP = Akses_pendidikan::firstOrNew(['nik' => $nik]);

                $mAP->kk   = $kk;
                $mAP->nik  = $nik;
                $mAP->nama = $nama;

                $mAP->jaraktempuh_paud = $this->colString($row, 'paud_jarak');
                $mAP->waktutempuh_paud = $this->colString($row, 'paud_waktu');
                $mAP->kemudahan_paud   = $this->colString($row, 'paud_kemudahan');

                $mAP->save();
            });
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
        return trim((string)$val);
    }

    private function colString($row, string $key): ?string
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) return null;
        return $this->asString($row[$i] ?? null);
    }
}
