<?php

namespace App\Http\Controllers;

use App\Models\SuratPermohonanTebangPohon;
use Illuminate\Http\Request;

class SuratPermohonanTebangPohonController extends Controller
{
    public function index()
    {
        return view('surat.surat_permohonan_tebang_pohon');
    }

    public function userForm()
    {
        return view('surat.user_permohonan_tebang_pohon');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'nowa' => 'required|string',
            'alasan_tebang' => 'required|string',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';
        $validated['tanggal_surat'] = now();

        SuratPermohonanTebangPohon::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Permohonan Tebang Pohon berhasil dikirim.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'nowa' => 'required|string',
            'alasan_tebang' => 'required|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $validated['tanggal_surat'] = now();

        SuratPermohonanTebangPohon::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Permohonan Tebang Pohon berhasil disimpan.');
    }

    public function edit(SuratPermohonanTebangPohon $surat)
    {
        return view('surat.edit_permohonan_tebang_pohon', compact('surat'));
    }

    public function update(Request $request, SuratPermohonanTebangPohon $surat)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama' => 'required|string',
            'jabatan' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'nowa' => 'required|string',
            'alasan_tebang' => 'required|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
