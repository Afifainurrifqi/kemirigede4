<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\Lokasipemukiman;
use App\Models\Akses_pendidikan;

class LokasidanPemukimanImport implements ToCollection, WithChunkReading
{
    // index sesuai Lokasi.xlsx
    protected $idx = [
        // lokasipemukiman
        'alamat'                   => 3,
        'nohp'                     => 4,
        'nowa'                     => 5,  // di file kamu: NO. Telpon Rumah (kalau ini bukan WA, ganti fieldnya)
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
        'fasilitas_bab'            => 21, // di file kamu: "FASILITAS BUANG AIR BESAR"
        'sumber_air_minum'         => 22,
        'tempat_pembuangan_limbah' => 23,
        'rumah_sutet'              => 24,
        'rumah_sungai'             => 25,
        'rumah_lereng_gunung'      => 26,
        'kondi_rumah_kumuh'        => 27,

        // akses_pendidikan (di file kamu cuma PAUD)
        'paud_jarak'               => 28,
        'paud_waktu'               => 29,
        'paud_kemudahan'           => 30,
    ];

    protected $skipHeader = true;

    public function collection(Collection $rows)
    {
        if ($this->skipHeader) {
            $rows = $rows->skip(1);
            $this->skipHeader = false;
        }

        $rows->each(function ($row) {
            $kk   = $this->asString($row[0] ?? null);
            $nik  = $this->asString($row[1] ?? null);
            $nama = $this->asString($row[2] ?? null);

            if (!$nik) return;

            // =========================
            // 1) lokasipemukiman
            // =========================
            $mL = Lokasipemukiman::firstOrNew(['nik' => $nik]);
            $mL->kk  = $kk;
            $mL->nik = $nik;
            $mL->nama = $nama;

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
                    'tempat_pembuangan_limbah',
                    'rumah_sutet',
                    'rumah_sungai',
                    'rumah_lereng_gunung',
                    'kondi_rumah_kumuh',
                    'sumber_air_minum'
                ] as $k
            ) {
                $mL->{$k} = $this->colS($row, $k);
            }

            // kalau field di tabel kamu namanya "fasilitas_bab" beda, sesuaikan:
            if (property_exists($mL, 'fasilitas_bab')) {
                $mL->fasilitas_bab = $this->colS($row, 'fasilitas_bab');
            }

            $mL->save();

            // =========================
            // 2) akses_pendidikan (cuma PAUD)
            // =========================
            $mAP = Akses_pendidikan::firstOrNew(['nik' => $nik]);
            $mAP->kk  = $kk;
            $mAP->nik = $nik;
            $mAP->nama = $nama;

            $mAP->jaraktempuh_paud = $this->colS($row, 'paud_jarak');
            $mAP->waktutempuh_paud = $this->colS($row, 'paud_waktu');
            $mAP->kemudahan_paud   = $this->colS($row, 'paud_kemudahan');

            $mAP->save();
        });
    }

    public function chunkSize(): int
    {
        return 500;
    }

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
