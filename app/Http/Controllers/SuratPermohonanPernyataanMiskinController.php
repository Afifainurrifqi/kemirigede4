<?php

namespace App\Http\Controllers;

use App\Models\SuratPermohonanPernyataanMiskin;
use Illuminate\Http\Request;

class SuratPermohonanPernyataanMiskinController extends Controller
{
    public function index()
    {
        return view('surat.surat_permohonan_pernyataan_miskin');
    }

    public function userForm()
    {
        return view('surat.user_permohonan_pernyataan_miskin');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'nowa' => 'required|string',
            'nama_pasien' => 'required|string',
            'alamat_pasien' => 'required|string',
            'diagnosa' => 'required|string',
            'rumah_sakit_tujuan' => 'required|string',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';
        $validated['tanggal_surat'] = now();

        SuratPermohonanPernyataanMiskin::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Permohonan Pernyataan Miskin berhasil dikirim.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'nowa' => 'required|string',
            'nama_pasien' => 'required|string',
            'alamat_pasien' => 'required|string',
            'diagnosa' => 'required|string',
            'rumah_sakit_tujuan' => 'required|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $validated['tanggal_surat'] = now();

        SuratPermohonanPernyataanMiskin::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Permohonan Pernyataan Miskin berhasil disimpan.');
    }

    public function edit(SuratPermohonanPernyataanMiskin $surat)
    {
        return view('surat.edit_permohonan_pernyataan_miskin', compact('surat'));
    }

    public function update(Request $request, SuratPermohonanPernyataanMiskin $surat)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:20',
            'nama_lengkap' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'nowa' => 'required|string',
            'nama_pasien' => 'required|string',
            'alamat_pasien' => 'required|string',
            'diagnosa' => 'required|string',
            'rumah_sakit_tujuan' => 'required|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
