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
     * SUSUNAN KOLOM (sesuai File Import.xlsx, index mulai 0)
     *  0: NO KK
     *  1: NIK
     *  2: NAMA
     *  3: ALAMAT
     *  4: NO. HP
     *  5: NO. Telpon Rumah
     *  6: NIK Kepala Keluarga
     *  7: TEMPAT TINGGAL YANG DITEMPATI
     *  8: STATUS LAHAN
     *  ...
     *  28: PAUD - JARAK (KM)
     *  29: PAUD - WAKTU (JAM)
     *  30: PAUD - KEMUDAHAN
     */

    protected $idx = [
        // ---------- lokasipemukiman ----------
        'alamat'                   => 3,
        'nohp'                     => 4,  // NO. HP
        'nowa'                     => 5,  // NO. Telpon Rumah (kalau sebenarnya WA, tinggal tukar)
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
        'sumber_air_mck'           => 21, // di file: "FASILITAS BUANG AIR BESAR"
        'sumber_air_minum'         => 22,
        'tempat_pembuangan_limbah' => 23,
        'rumah_sutet'              => 24,
        'rumah_sungai'             => 25,
        'rumah_lereng_gunung'      => 26,
        'kondi_rumah_kumuh'        => 27,

        // ---------- akses_pendidikan (hanya PAUD di file ini) ----------
        'paud_jarak'               => 28,
        'paud_waktu'               => 29,
        'paud_kemudahan'           => 30,
    ];

    /**
     * Flag untuk skip header hanya di chunk pertama
     */
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

            if (!$nik) {
                return;
            }

            // =========================
            // 1) lokasipemukiman
            // =========================
            $mL = lokasipemukiman::firstOrNew(['nik' => $nik]);

            // Common minimal (sesuai file)
            $mL->kk   = $kk;
            $mL->nik  = $nik;
            if ($nama !== null && $nama !== '') {
                $mL->nama = $nama;
            }

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
            // 2) akses_pendidikan (PAUD saja)
            // =========================
            $hasPaud = $this->hasAny($row, ['paud_jarak', 'paud_waktu', 'paud_kemudahan']);
            if ($hasPaud) {
                $mAP = akses_pendidikan::firstOrNew(['nik' => $nik]);
                $mAP->kk  = $kk;
                $mAP->nik = $nik;
                if ($nama !== null && $nama !== '') {
                    $mAP->nama = $nama;
                }

                $mAP->jaraktempuh_paud = $this->colString($row, 'paud_jarak');
                $mAP->waktutempuh_paud = $this->colString($row, 'paud_waktu');
                $mAP->kemudahan_paud   = $this->colString($row, 'paud_kemudahan');
                $mAP->save();
            }
        });
    }

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
        $s = trim((string) $val);
        return $s === '' ? null : $s;
    }

    private function colString($row, string $key): ?string
    {
        $i = $this->idx[$key] ?? null;
        if ($i === null) {
            return null;
        }
        return $this->asString($row[$i] ?? null);
    }

    private function hasAny($row, array $keys): bool
    {
        foreach ($keys as $k) {
            $v = $this->colString($row, $k);
            if ($v !== null && $v !== '') {
                return true;
            }
        }
        return false;
    }
}
