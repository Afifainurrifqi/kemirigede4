<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\lokasipemukiman;
use App\Models\akses_pendidikan;

class LokasidanPemukimanImport implements ToCollection, WithChunkReading
{
    protected $idx = [
        // lokasipemukiman (sesuai file KK UP)
        'alamat'                   => 3,
        'nohp'                     => 4,
        'nowa'                     => 5,  // kalau ini memang WA / telp rumah
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
        'sumber_air_mck'           => 21, // fasilitas BAB
        'sumber_air_minum'         => 22,
        'tempat_pembuangan_limbah' => 23,
        'rumah_sutet'              => 24,
        'rumah_sungai'             => 25,
        'rumah_lereng_gunung'      => 26,
        'kondi_rumah_kumuh'        => 27,

        // akses pendidikan (file ini hanya PAUD)
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

        DB::transaction(function () use ($rows) {
            $rows->each(function ($row) {

                $kk   = $this->asString($row[0] ?? null);
                $nik  = $this->asString($row[1] ?? null);
                $nama = $this->asString($row[2] ?? null);

                if (!$nik) return;

                // =========================
                // 1) lokasipemukiman
                // =========================
                $mL = lokasipemukiman::firstOrNew(['nik' => $nik]);
                $mL->kk   = $kk;
                $mL->nik  = $nik;
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
                        'sumber_air_mck',
                        'sumber_air_minum',
                        'tempat_pembuangan_limbah',
                        'rumah_sutet',
                        'rumah_sungai',
                        'rumah_lereng_gunung',
                        'kondi_rumah_kumuh'
                    ] as $k
                ) {
                    $mL->{$k} = $this->colString($row, $k);
                }

                $mL->save();

                // =========================
                // 2) akses_pendidikan (PAUD only)
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
        });
    }

    public function chunkSize(): int
    {
        return 500;
    }

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
