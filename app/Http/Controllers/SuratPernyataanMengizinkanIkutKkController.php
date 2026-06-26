<?php

namespace App\Http\Controllers;

use App\Models\surat_pernyataan_mengizinkan_ikut_kk;
use Illuminate\Http\Request;
use App\Services\NomorSuratService;

class SuratPernyataanMengizinkanIkutKkController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    protected function maybeAssignNomorSurat($suratOrNull, array &$payload): void
    {
        $this->svc->maybeAssignNomorSurat($suratOrNull, $payload, 'izinkk');
    }

    public function index()
    {
        return view('surat.surat_pernyataan_mengizinkan_ikut_kk');
    }

    public function user()
    {
        return view('surat.user_surat_pernyataan_mengizinkan_ikut_kk');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'ttl_tempat'         => 'nullable|string|max:100',
            'ttl_tanggal'        => 'nullable|date',
            'pekerjaan'          => 'nullable|string|max:100',
            'alamat'             => 'required|string',

            'nama_izin'          => 'required|string|max:255',
            'nik_izin'           => 'required|string|max:32',
            'ttl_tempat_izin'    => 'nullable|string|max:100',
            'ttl_tanggal_izin'   => 'nullable|date',
            'alamat_izin'        => 'required|string',

            'tujuan_pindah'      => 'required|string|max:255',
            'alasan_pindah'      => 'required|string',

            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'nullable|string',
            'status_verif'       => 'nullable|string',
        ]);

        $payload = $validated;
        $this->maybeAssignNomorSurat(null, $payload);

        surat_pernyataan_mengizinkan_ikut_kk::create($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil disimpan.');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'ttl_tempat'         => 'nullable|string|max:100',
            'ttl_tanggal'        => 'nullable|date',
            'pekerjaan'          => 'nullable|string|max:100',
            'alamat'             => 'required|string',

            'nama_izin'          => 'required|string|max:255',
            'nik_izin'           => 'required|string|max:32',
            'ttl_tempat_izin'    => 'nullable|string|max:100',
            'ttl_tanggal_izin'   => 'nullable|date',
            'alamat_izin'        => 'required|string',

            'tujuan_pindah'      => 'required|string|max:255',
            'alasan_pindah'      => 'required|string',

            'nowa'               => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_pernyataan_mengizinkan_ikut_kk::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit(surat_pernyataan_mengizinkan_ikut_kk $surat)
    {
        return view('surat.edit_surat_pernyataan_mengizinkan_ikut_kk', compact('surat'));
    }

    public function update(Request $request, surat_pernyataan_mengizinkan_ikut_kk $surat)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'ttl_tempat'         => 'nullable|string|max:100',
            'ttl_tanggal'        => 'nullable|date',
            'pekerjaan'          => 'nullable|string|max:100',
            'alamat'             => 'required|string',

            'nama_izin'          => 'required|string|max:255',
            'nik_izin'           => 'required|string|max:32',
            'ttl_tempat_izin'    => 'nullable|string|max:100',
            'ttl_tanggal_izin'   => 'nullable|date',
            'alamat_izin'        => 'required|string',

            'tujuan_pindah'      => 'required|string|max:255',
            'alasan_pindah'      => 'required|string',

            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'nullable|string',
            'status_verif'       => 'nullable|string',
        ]);

        $this->maybeAssignNomorSurat($surat, $validated);
        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(surat_pernyataan_mengizinkan_ikut_kk $surat)
    {
        $surat->delete();
        return back()->with('success', 'Surat berhasil dihapus.');
    }
}
