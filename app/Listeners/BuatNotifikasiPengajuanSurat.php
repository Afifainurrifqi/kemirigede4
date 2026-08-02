<?php

namespace App\Listeners;

use App\Models\NotifikasiSurat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class BuatNotifikasiPengajuanSurat
{
    /**
     * Menangani event Eloquent saved.
     *
     * @param string $eventName
     * @param array<int, mixed> $payload
     */
    public function handle(string $eventName, array $payload): void
    {
        $model = $payload[0] ?? null;

        /*
        |--------------------------------------------------------------------------
        | Pastikan payload merupakan Eloquent Model
        |--------------------------------------------------------------------------
        */
        if (!$model instanceof Model) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Hindari recursive event
        |--------------------------------------------------------------------------
        |
        | Ketika NotifikasiSurat disimpan, event saved juga berjalan.
        |
        */
        if ($model instanceof NotifikasiSurat) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Deteksi berdasarkan status, bukan nama class
        |--------------------------------------------------------------------------
        |
        | Tidak semua model surat Anda memiliki kata "surat"
        | dalam nama class, contohnya nama_alias_ortu.
        |
        */
        $statusVerif = $this->normalisasiStatus(
            $model->getAttribute('status_verif')
        );

        $statusSurat = $this->normalisasiStatus(
            $model->getAttribute('status_surat')
        );

        /*
        |--------------------------------------------------------------------------
        | Hanya pengajuan yang belum diverifikasi
        |--------------------------------------------------------------------------
        */
        $statusVerifikasiBaru = [
            'belum verifikasi',
            'belum diverifikasi',
        ];

        if (!in_array($statusVerif, $statusVerifikasiBaru, true)) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Periksa status surat jika atributnya tersedia
        |--------------------------------------------------------------------------
        |
        | Beberapa model mungkin tidak memiliki status_surat.
        | Selama status_verif adalah Belum Verifikasi, tetap diterima.
        |
        */
        $statusPengajuanBaru = [
            'pending',
            'diajukan',
            'menunggu',
            'menunggu verifikasi',
            'belum diproses',
        ];

        if (
            $statusSurat !== ''
            && !in_array($statusSurat, $statusPengajuanBaru, true)
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil ID surat
        |--------------------------------------------------------------------------
        */
        $suratId = (string) $model->getKey();

        if ($suratId === '') {
            Log::warning('Notifikasi surat gagal: ID surat kosong.', [
                'model' => get_class($model),
            ]);

            return;
        }

        try {
            $notifikasi = NotifikasiSurat::firstOrCreate(
                [
                    'surat_id'   => $suratId,
                    'model_type' => get_class($model),
                ],
                [
                    'jenis_surat'  => $this->ambilJenisSurat($model),
                    'nama_pemohon' => $this->ambilNamaPemohon($model),
                    'target_url'   => route('surat.keluar'),
                    'dibaca'       => false,
                    'dibaca_at'    => null,
                ]
            );

            Log::info('Notifikasi pengajuan surat diproses.', [
                'notifikasi_id' => (string) $notifikasi->getKey(),
                'surat_id'      => $suratId,
                'model_type'    => get_class($model),
                'jenis_surat'   => $notifikasi->jenis_surat,
                'baru_dibuat'   => $notifikasi->wasRecentlyCreated,
            ]);
        } catch (Throwable $exception) {
            /*
             * Kesalahan notifikasi tidak menggagalkan penyimpanan surat,
             * tetapi tetap dicatat ke laravel.log.
             */
            Log::error('Gagal membuat notifikasi pengajuan surat.', [
                'surat_id'   => $suratId,
                'model_type' => get_class($model),
                'error'      => $exception->getMessage(),
                'file'       => $exception->getFile(),
                'line'       => $exception->getLine(),
            ]);
        }
    }

    /**
     * Menyamakan berbagai format status.
     *
     * Contoh:
     * - Belum_Verifikasi
     * - Belum-Verifikasi
     * - BELUM VERIFIKASI
     *
     * Menjadi:
     * - belum verifikasi
     */
    private function normalisasiStatus(mixed $value): string
    {
        return Str::of((string) $value)
            ->replace(['_', '-'], ' ')
            ->lower()
            ->squish()
            ->toString();
    }

    /**
     * Mengambil nama pemohon dari kemungkinan field berbeda.
     */
    private function ambilNamaPemohon(Model $model): string
    {
        $kemungkinanField = [
            'nama_pemohon',
            'nama_pelapor',
            'nama_lengkap',
            'nama_deklaran',
            'nama_pihak1',
            'nama_pihak_pertama',
            'nama_pemilik',
            'nama_ketua',
            'nama_penanggung_jawab',
            'pemohon',
            'nama',
        ];

        foreach ($kemungkinanField as $field) {
            $nilai = trim(
                (string) $model->getAttribute($field)
            );

            if ($nilai !== '') {
                return $nilai;
            }
        }

        return 'Pemohon';
    }

    /**
     * Mengambil nama jenis surat.
     */
    private function ambilJenisSurat(Model $model): string
    {
        $kemungkinanField = [
            'jenis_surat',
            'nama_surat',
            'jenis_form',
            'judul_surat',
        ];

        foreach ($kemungkinanField as $field) {
            $nilai = trim(
                (string) $model->getAttribute($field)
            );

            if ($nilai !== '') {
                return Str::headline($nilai);
            }
        }

        return Str::headline(
            class_basename($model)
        );
    }
}
