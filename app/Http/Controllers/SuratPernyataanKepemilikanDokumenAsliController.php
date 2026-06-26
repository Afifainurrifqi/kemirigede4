<?php

namespace App\Http\Controllers;

use App\Models\SuratPernyataanKepemilikanDokumenAsli;
use Illuminate\Http\Request;

class SuratPernyataanKepemilikanDokumenAsliController extends Controller
{
    public function index()
    {
        return view('surat.surat_pernyataan_kepemilikan_dokumen_asli');
    }

    public function userForm()
    {
        return view('surat.user_surat_pernyataan_kepemilikan_dokumen_asli');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'pekerjaan' => 'required|string',
            'nowa' => 'required|string|max:20',           // ← Hanya nowa
            'alamat' => 'required|string',
            'nama_dokumen' => 'required|string',
            'nomor_dokumen' => 'required|string',
            'nama_pemilik_dokumen' => 'required|string|max:255',
            'tanggal_lahir_pemilik' => 'required|date',
            'alamat_dokumen' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPernyataanKepemilikanDokumenAsli::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Pernyataan Kepemilikan Dokumen Asli berhasil.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'pekerjaan' => 'required|string',
            'nowa' => 'required|string|max:20',
            'alamat' => 'required|string',
            'nama_dokumen' => 'required|string',
            'nomor_dokumen' => 'required|string',
            'nama_pemilik_dokumen' => 'required|string|max:255',
            'tanggal_lahir_pemilik' => 'required|date',
            'alamat_dokumen' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nomor_surat' => 'nullable|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.41.2 / ' . now()->year;

        SuratPernyataanKepemilikanDokumenAsli::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratPernyataanKepemilikanDokumenAsli $surat)
    {
        return view('surat.edit_surat_pernyataan_kepemilikan_dokumen_asli', compact('surat'));
    }

    public function update(Request $request, SuratPernyataanKepemilikanDokumenAsli $surat)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'pekerjaan' => 'required|string',
            'nowa' => 'required|string|max:20',
            'alamat' => 'required|string',
            'nama_dokumen' => 'required|string',
            'nomor_dokumen' => 'required|string',
            'nama_pemilik_dokumen' => 'required|string|max:255',
            'tanggal_lahir_pemilik' => 'required|date',
            'alamat_dokumen' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nomor_surat' => 'nullable|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
