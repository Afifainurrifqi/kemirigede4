<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganDomisiliLembaga;
use Illuminate\Http\Request;

class SuratKeteranganDomisiliLembagaController extends Controller
{
    public function index() // Admin
    {
        return view('surat.surat_keterangan_domisili_lembaga');
    }

    public function userForm()
    {
        return view('surat.user_surat_keterangan_domisili_lembaga');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_lembaga'     => 'required|string|max:255',
            'jenis_kegiatan'   => 'required|string|max:255',
            'alamat_lembaga'   => 'required|string',
            'nama_pengurus'    => 'required|string|max:255',
            'nik_pengurus'     => 'required|string|max:16',
            'alamat_pengurus'  => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'             => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratKeteranganDomisiliLembaga::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Keterangan Domisili Lembaga berhasil.');
    }

    public function store(Request $request) // Admin
    {
        $validated = $request->validate([
            'nama_lembaga'     => 'required|string|max:255',
            'jenis_kegiatan'   => 'required|string|max:255',
            'alamat_lembaga'   => 'required|string',
            'nama_pengurus'    => 'required|string|max:255',
            'nik_pengurus'     => 'required|string|max:16',
            'alamat_pengurus'  => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'             => 'required|string|max:20',
            'nomor_surat'      => 'nullable|string',
            'status_surat'     => 'required|string',
            'status_verif'     => 'required|string',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '220 / --- / 409.41.2 / ' . now()->year;

        SuratKeteranganDomisiliLembaga::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratKeteranganDomisiliLembaga $surat)
    {
        return view('surat.edit_surat_keterangan_domisili_lembaga', compact('surat'));
    }

    public function update(Request $request, SuratKeteranganDomisiliLembaga $surat)
    {
        $validated = $request->validate([
            'nama_lembaga'     => 'required|string|max:255',
            'jenis_kegiatan'   => 'required|string|max:255',
            'alamat_lembaga'   => 'required|string',
            'nama_pengurus'    => 'required|string|max:255',
            'nik_pengurus'     => 'required|string|max:16',
            'alamat_pengurus'  => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'             => 'required|string|max:20',
            'nomor_surat'      => 'nullable|string',
            'status_surat'     => 'required|string',
            'status_verif'     => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
