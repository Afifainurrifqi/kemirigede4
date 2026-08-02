<?php

namespace App\Providers;

use App\Listeners\BuatNotifikasiPengajuanSurat;
use App\Models\NotifikasiSurat;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Listener global semua model
        |--------------------------------------------------------------------------
        |
        | Menggunakan saved agar dapat menangkap:
        | - save()
        | - create()
        | - status yang baru diisi pada penyimpanan berikutnya
        |
        | firstOrCreate pada listener mencegah notifikasi ganda.
        |
        */
        Event::listen(
            'eloquent.saved: *',
            function (string $eventName, array $payload): void {
                app(BuatNotifikasiPengajuanSurat::class)
                    ->handle($eventName, $payload);
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Data notifikasi untuk layout admin
        |--------------------------------------------------------------------------
        */
        View::composer('layout.main2', function ($view): void {
            $jumlahNotifikasiSurat = 0;
            $notifikasiSurat = collect();

            if (
                auth()->check()
                && strtolower(trim((string) auth()->user()->role)) === 'admin'
            ) {
                $jumlahNotifikasiSurat = NotifikasiSurat::where(
                    'dibaca',
                    false
                )->count();

                $notifikasiSurat = NotifikasiSurat::where(
                    'dibaca',
                    false
                )
                    ->orderBy('created_at', 'desc')
                    ->limit(7)
                    ->get();
            }

            $view->with([
                'jumlahNotifikasiSurat' => $jumlahNotifikasiSurat,
                'notifikasiSurat'       => $notifikasiSurat,
            ]);
        });
    }
}
