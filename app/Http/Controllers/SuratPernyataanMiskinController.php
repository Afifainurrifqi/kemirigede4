<?php

namespace App\Http\Controllers;

use App\Models\SuratPernyataanMiskin;
use Illuminate\Http\Request;

class SuratPernyataanMiskinController extends Controller
{
    public function index() // Admin
    {
        return view('surat.surat_pernyataan_miskin');
    }

    public function userForm()
    {
        return view('surat.user_surat_pernyataan_miskin');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nik'           => 'required|string|max:16',
            'pekerjaan'     => 'required|string',
            'alamat'        => 'required|string',
            'nowa'          => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPernyataanMiskin::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Pernyataan Miskin berhasil.');
    }

    public function store(Request $request) // Admin
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nik'           => 'required|string|max:16',
            'pekerjaan'     => 'required|string',
            'alamat'        => 'required|string',
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'required|string',
            'status_verif'  => 'required|string',
        ]);

        SuratPernyataanMiskin::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratPernyataanMiskin $surat)
    {
        return view('surat.edit_surat_pernyataan_miskin', compact('surat'));
    }

    public function update(Request $request, SuratPernyataanMiskin $surat)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nik'           => 'required|string|max:16',
            'pekerjaan'     => 'required|string',
            'alamat'        => 'required|string',
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'required|string',
            'status_verif'  => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
