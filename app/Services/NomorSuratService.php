<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class NomorSuratService
{
    protected string $globalKey = 'global_surat_keluar';

    /**
     * Inisialisasi nomor awal (jalankan sekali saja)
     */
    public function initializeGlobalCounter(int $startFrom = 127): void
    {
        $col = DB::connection('mongodb')->getMongoDB()->selectCollection('counters');

        $existing = $col->findOne(['_id' => $this->globalKey]);

        if (!$existing) {
            $col->insertOne([
                '_id'        => $this->globalKey,
                'seq'        => $startFrom - 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function nextGlobal(): int
    {
        $col = DB::connection('mongodb')->getMongoDB()->selectCollection('counters');

        $doc = $col->findOneAndUpdate(
            ['_id' => $this->globalKey],
            ['$inc' => ['seq' => 1], '$set' => ['updated_at' => now()]],
            ['upsert' => true, 'returnDocument' => 1]
        );

        return (int)($doc['seq'] ?? 127);
    }

    public function format(string $jenis, int $urut, int $tahun = null): string
    {
        $tahun  = $tahun ?? now('Asia/Jakarta')->year;
        $prefix = $this->prefixMap[$jenis] ?? 400;
        $nnn    = str_pad((string)$urut, 3, '0', STR_PAD_LEFT);

        return "{$prefix} / {$nnn} / 409.41.2 / {$tahun}";
    }

    public function maybeAssignNomorSurat($modelOrNull, array &$payload, string $jenis = 'default'): void
    {
        $status = $payload['status_surat'] ?? ($modelOrNull->status_surat ?? null);
        $verif  = $payload['status_verif'] ?? ($modelOrNull->status_verif ?? null);

        if (
            $status === 'Di terima' &&
            $verif === 'Terverifikasi' &&
            empty($payload['nomor_surat']) &&
            empty($modelOrNull?->nomor_surat)
        ) {
            $urut  = $this->nextGlobal();
            $tahun = now('Asia/Jakarta')->year;

            $payload['nomor_urut']  = $urut;
            $payload['tahun_nomor'] = $tahun;
            $payload['nomor_surat'] = $this->format($jenis, $urut, $tahun);
        }
    }

    /**
     * Prefix Map - Update ini setiap kali ada jenis surat baru
     */
    protected array $prefixMap = [
        // === KETERANGAN ===
        'sktm'                    => 475,
        'spktp'                   => 300,
        'kehilangan'              => 430,
        'kematian_desa'           => 470,
        'pernah_menikah'          => 465,

        // === PERNYATAAN ===
        'numpangkk'                        => 400,
        'alias'                            => 410,
        'alias_ortu'                       => 411,
        'jaminan'                          => 420,
        'belumakta'                        => 410,
        'bedanama'                         => 440,
        'anakseorangibu'                   => 450,
        'aktabarcode'                      => 460,
        'perubahdatapendidikan'            => 480,
        'pembetulandata'                   => 485,
        'izinkk'                           => 490,
        'pernyataan_memiliki_kk_asli'      => 495,

        // === SPTJM ===
        'sptjmkematian'           => 470,
        'sptjm_suami_istri'       => 472,

        // === LAINNYA ===
        'formulir_user_id'        => 500,
        'pelaporan_capil_f201'    => 510,
        'batal_pindah'            => 520,
    ];
}
