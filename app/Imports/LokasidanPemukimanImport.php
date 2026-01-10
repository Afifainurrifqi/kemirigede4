<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Models\Lokasipemukiman;
use App\Models\Akses_pendidikan;

class LokasiPemukimanKKUPImport implements ToCollection, WithChunkReading
{
    protected $skipHeader = true;

    public function collection(Collection $rows)
    {
        if ($this->skipHeader) {
            $rows = $rows->skip(1);
            $this->skipHeader = false;
        }

        DB::transaction(function () use ($rows) {
            $rows->each(function ($row) {

                // Struktur file KK UP:
                // 0 NO KK, 1 NIK, 2 NAMA, 3 ALAMAT, 4 NO HP, 5 NO Telpon Rumah, 6 NIK Kepala, dst

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

                // Kolom spesifik (sesuai file)
                $mL->alamat                   = $this->asString($row[3] ?? null);
                $mL->nohp                     = $this->asString($row[4] ?? null);
                $mL->nowa                     = $this->asString($row[5] ?? null); // kalau ini memang WA / telp rumah
                $mL->nik_kepala               = $this->asString($row[6] ?? null);
                $mL->tempat_tinggal           = $this->asString($row[7] ?? null);
                $mL->status_lahan             = $this->asString($row[8] ?? null);
                $mL->luas_lantai_tinggal      = $this->asString($row[9] ?? null);
                $mL->luas_tanah_tinggal       = $this->asString($row[10] ?? null);
                $mL->jenis_lantai_tinggal     = $this->asString($row[11] ?? null);
                $mL->dinding_sebagian         = $this->asString($row[12] ?? null);
                $mL->jendela                  = $this->asString($row[13] ?? null);
                $mL->atap                     = $this->asString($row[14] ?? null);
                $mL->penerangan               = $this->asString($row[15] ?? null);
                $mL->energi_masak             = $this->asString($row[16] ?? null);
                $mL->jika_kayu_jenis          = $this->asString($row[17] ?? null);
                $mL->tempat_sampah            = $this->asString($row[18] ?? null);
                $mL->mck                      = $this->asString($row[19] ?? null);
                $mL->sumber_air_mandi         = $this->asString($row[20] ?? null);
                $mL->sumber_air_mck           = $this->asString($row[21] ?? null); // di file ini "FASILITAS BUANG AIR BESAR"
                $mL->sumber_air_minum         = $this->asString($row[22] ?? null);
                $mL->tempat_pembuangan_limbah = $this->asString($row[23] ?? null);
                $mL->rumah_sutet              = $this->asString($row[24] ?? null);
                $mL->rumah_sungai             = $this->asString($row[25] ?? null);
                $mL->rumah_lereng_gunung      = $this->asString($row[26] ?? null);
                $mL->kondi_rumah_kumuh        = $this->asString($row[27] ?? null);

                $mL->save();

                // =========================
                // 2) akses_pendidikan (hanya PAUD karena file hanya sampai PAUD)
                // =========================
                $mAP = Akses_pendidikan::firstOrNew(['nik' => $nik]);
                $mAP->kk   = $kk;
                $mAP->nik  = $nik;
                $mAP->nama = $nama;

                $mAP->jaraktempuh_paud = $this->asString($row[28] ?? null);
                $mAP->waktutempuh_paud = $this->asString($row[29] ?? null);
                $mAP->kemudahan_paud   = $this->asString($row[30] ?? null);

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
        return trim((string) $val);
    }
}
