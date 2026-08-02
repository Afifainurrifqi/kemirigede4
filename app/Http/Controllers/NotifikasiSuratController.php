<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiSurat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class NotifikasiSuratController extends Controller
{
    public function data(): JsonResponse
    {
        $jumlah = NotifikasiSurat::where(
            'dibaca',
            false
        )->count();

        $notifikasi = NotifikasiSurat::where(
            'dibaca',
            false
        )
            ->orderBy('created_at', 'desc')
            ->limit(7)
            ->get()
            ->map(function ($item): array {
                return [
                    'id' => (string) $item->getKey(),

                    'jenis_surat' => $item->jenis_surat
                        ?: 'Pengajuan Surat',

                    'nama_pemohon' => $item->nama_pemohon
                        ?: 'Pemohon',

                    'waktu' => $item->created_at
                        ? $item->created_at->diffForHumans()
                        : '',

                    'url' => route(
                        'notifikasi-surat.buka',
                        ['id' => (string) $item->getKey()]
                    ),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'count'   => $jumlah,
            'items'   => $notifikasi,
        ]);
    }

    public function buka(string $id): RedirectResponse
    {
        $notifikasi = NotifikasiSurat::findOrFail($id);

        $targetUrl = $notifikasi->target_url
            ?: route('surat.keluar');

        $notifikasi->dibaca = true;
        $notifikasi->dibaca_at = now();
        $notifikasi->save();

        return redirect()->to($targetUrl);
    }

    public function tandaiSemuaDibaca(): JsonResponse
    {
        /*
         * Query update boleh digunakan di sini karena kita tidak
         * membutuhkan event untuk masing-masing notifikasi.
         */
        NotifikasiSurat::where('dibaca', false)
            ->update([
                'dibaca'    => true,
                'dibaca_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi sudah dibaca.',
        ]);
    }
}
