<?php

namespace App\Http\Controllers;

use App\Models\SuratRekomendasi;
use Illuminate\Http\Request;

class SuratRekomendasiController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_rekomendasi');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_rekomendasi');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'nik'             => 'required|string|max:16',
            'alamat'          => 'required|string',
            'perihal'         => 'required|string',
            'kegiatan'        => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu'           => 'required|string',
            'tempat'          => 'required|string',
            'keperluan'       => 'required|string',
            'nowa'            => 'required|string|max:20',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("500 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratRekomendasi::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Rekomendasi berhasil.');
    }

    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'nik'             => 'required|string|max:16',
            'alamat'          => 'required|string',
            'perihal'         => 'required|string',
            'kegiatan'        => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu'           => 'required|string',
            'tempat'          => 'required|string',
            'keperluan'       => 'required|string',
            'nowa'            => 'required|string|max:20',
            'status_surat'    => 'required|string',
            'status_verif'    => 'required|string',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("500 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        SuratRekomendasi::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Rekomendasi berhasil dibuat.');
    }

    /**
     * Halaman Edit Admin
     */
    public function edit(SuratRekomendasi $surat)
    {
        return view('surat.edit_surat_rekomendasi', compact('surat'));
    }

    /**
     * Update Surat
     */
    public function update(Request $request, SuratRekomendasi $surat)
    {
        $validated = $request->validate([
            'nama'            => 'required|string|max:255',
            'nik'             => 'required|string|max:16',
            'alamat'          => 'required|string',
            'perihal'         => 'required|string',
            'kegiatan'        => 'required|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu'           => 'required|string',
            'tempat'          => 'required|string',
            'keperluan'       => 'required|string',
            'nowa'            => 'required|string|max:20',
            'status_surat'    => 'required|string',
            'status_verif'    => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Rekomendasi berhasil diperbarui.');
    }
}
