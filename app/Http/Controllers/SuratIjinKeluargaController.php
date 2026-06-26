<?php

namespace App\Http\Controllers;

use App\Models\SuratIjinKeluarga;
use Illuminate\Http\Request;

class SuratIjinKeluargaController extends Controller
{
    public function index() // Admin Form
    {
        return view('surat.surat_ijin_keluarga');
    }

    public function userForm()
    {
        return view('surat.user_surat_ijin_keluarga');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_suami'          => 'required|string|max:255',
            'tempat_lahir_suami'  => 'required|string',
            'tanggal_lahir_suami' => 'required|date',
            'pekerjaan_suami'     => 'required|string',
            'alamat_suami'        => 'required|string',

            'nama_istri'          => 'required|string|max:255',
            'tempat_lahir_istri'  => 'required|string',
            'tanggal_lahir_istri' => 'required|date',
            'pekerjaan_istri'     => 'required|string',
            'alamat_istri'        => 'required|string',
            'negara_tujuan'       => 'required|string',
            'sebagai'             => 'required|string',

            'nowa'                => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratIjinKeluarga::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Ijin Keluarga berhasil.');
    }

    public function store(Request $request) // Admin
    {
        $validated = $request->validate([
            'nama_suami'          => 'required|string|max:255',
            'tempat_lahir_suami'  => 'required|string',
            'tanggal_lahir_suami' => 'required|date',
            'pekerjaan_suami'     => 'required|string',
            'alamat_suami'        => 'required|string',

            'nama_istri'          => 'required|string|max:255',
            'tempat_lahir_istri'  => 'required|string',
            'tanggal_lahir_istri' => 'required|date',
            'pekerjaan_istri'     => 'required|string',
            'alamat_istri'        => 'required|string',
            'negara_tujuan'       => 'required|string',
            'sebagai'             => 'required|string',

            'nowa'                => 'required|string|max:20',
            'status_surat'        => 'required|string',
            'status_verif'        => 'required|string',
        ]);

        SuratIjinKeluarga::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratIjinKeluarga $surat)
    {
        return view('surat.edit_surat_ijin_keluarga', compact('surat'));
    }

    public function update(Request $request, SuratIjinKeluarga $surat)
    {
        $validated = $request->validate([
            'nama_suami'          => 'required|string|max:255',
            'tempat_lahir_suami'  => 'required|string',
            'tanggal_lahir_suami' => 'required|date',
            'pekerjaan_suami'     => 'required|string',
            'alamat_suami'        => 'required|string',

            'nama_istri'          => 'required|string|max:255',
            'tempat_lahir_istri'  => 'required|string',
            'tanggal_lahir_istri' => 'required|date',
            'pekerjaan_istri'     => 'required|string',
            'alamat_istri'        => 'required|string',
            'negara_tujuan'       => 'required|string',
            'sebagai'             => 'required|string',

            'nowa'                => 'required|string|max:20',
            'status_surat'        => 'required|string',
            'status_verif'        => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
