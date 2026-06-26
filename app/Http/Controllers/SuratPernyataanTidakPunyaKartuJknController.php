<?php

namespace App\Http\Controllers;

use App\Models\SuratPernyataanTidakPunyaKartuJkn;
use Illuminate\Http\Request;

class SuratPernyataanTidakPunyaKartuJknController extends Controller
{
    public function index() // Admin Form
    {
        return view('surat.surat_pernyataan_tidak_punya_kartu_jkn');
    }

    public function userForm()
    {
        return view('surat.user_surat_pernyataan_tidak_punya_kartu_jkn');
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

        SuratPernyataanTidakPunyaKartuJkn::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Pernyataan berhasil dikirim.');
    }

    public function store(Request $request) // Admin Create
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

        SuratPernyataanTidakPunyaKartuJkn::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratPernyataanTidakPunyaKartuJkn $surat)
    {
        return view('surat.edit_surat_pernyataan_tidak_punya_kartu_jkn', compact('surat'));
    }

    public function update(Request $request, SuratPernyataanTidakPunyaKartuJkn $surat)
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
