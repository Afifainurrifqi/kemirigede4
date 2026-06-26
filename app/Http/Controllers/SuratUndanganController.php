<?php

namespace App\Http\Controllers;

use App\Models\SuratUndangan;
use Illuminate\Http\Request;

class SuratUndanganController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_undangan');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_undangan');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'kepada_yth'         => 'required|string|max:255',
            'perihal'            => 'required|string',
            'hari'               => 'required|string',
            'tanggal_acara'      => 'required|date',
            'jam'                => 'required',
            'tempat'             => 'required|string',
            'acara'              => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'               => 'required|string|max:20',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("005 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        // Auto set status
        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratUndangan::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Undangan berhasil.');
    }
    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kepada_yth'         => 'required|string|max:255',
            'perihal'            => 'required|string',
            'hari'               => 'required|string',
            'tanggal_acara'      => 'required|date',
            'jam'                => 'required',
            'tempat'             => 'required|string',
            'acara'              => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'required|string',
            'status_verif'       => 'required|string',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $lastNumber = SuratUndangan::whereYear('created_at', $tahun)->count() + 1;
        $validated['nomor_surat'] = sprintf("005 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        SuratUndangan::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Undangan berhasil dibuat.');
    }

    /**
     * Halaman Edit Admin
     */
    public function edit(SuratUndangan $surat)
    {
        return view('surat.edit_surat_undangan', compact('surat'));
    }

    /**
     * Update Surat
     */
    public function update(Request $request, SuratUndangan $surat)
    {
        $validated = $request->validate([
            'kepada_yth'         => 'required|string|max:255',
            'perihal'            => 'required|string',
            'hari'               => 'required|string',
            'tanggal_acara'      => 'required|date',
            'jam'                => 'required',
            'tempat'             => 'required|string',
            'acara'              => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'required|string',
            'status_verif'       => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Undangan berhasil diperbarui.');
    }
}
