<?php

namespace App\Http\Controllers;

use App\Models\SuratPermohonanPembukaanRekening;
use Illuminate\Http\Request;

class SuratPermohonanPembukaanRekeningController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_permohonan_pembukaan_rekening');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_permohonan_pembukaan_rekening');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_kepala_desa'   => 'required|string|max:255',
            'jabatan'            => 'required|string',
            'alamat_kepala_desa' => 'required|string',

            'atas_nama_rekening' => 'required|string|max:255',
            'alamat_rekening'    => 'required|string',

            'nama_pejabat1'      => 'required|string|max:255',
            'jabatan1'           => 'required|string',
            'nama_pejabat2'      => 'required|string|max:255',
            'jabatan2'           => 'required|string',

            'nowa'               => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPermohonanPembukaanRekening::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Permohonan Pembukaan Rekening berhasil dikirim.');
    }

    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kepala_desa'   => 'required|string|max:255',
            'jabatan'            => 'required|string',
            'alamat_kepala_desa' => 'required|string',

            'atas_nama_rekening' => 'required|string|max:255',
            'alamat_rekening'    => 'required|string',

            'nama_pejabat1'      => 'required|string|max:255',
            'jabatan1'           => 'required|string',
            'nama_pejabat2'      => 'required|string|max:255',
            'jabatan2'           => 'required|string',

            'nomor_surat'        => 'nullable|string',
            'status_surat'       => 'required|string',
            'status_verif'       => 'required|string',
            'nowa'               => 'required|string|max:20',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.41.2 / ' . now()->year;

        SuratPermohonanPembukaanRekening::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Permohonan Pembukaan Rekening berhasil dibuat.');
    }

    /**
     * Halaman Edit (Admin)
     */
    public function edit(SuratPermohonanPembukaanRekening $surat)
    {
        return view('surat.edit_surat_permohonan_pembukaan_rekening', compact('surat'));
    }

    /**
     * Update Surat
     */
    public function update(Request $request, SuratPermohonanPembukaanRekening $surat)
    {
        $validated = $request->validate([
            'nama_kepala_desa'   => 'required|string|max:255',
            'jabatan'            => 'required|string',
            'alamat_kepala_desa' => 'required|string',

            'atas_nama_rekening' => 'required|string|max:255',
            'alamat_rekening'    => 'required|string',

            'nama_pejabat1'      => 'required|string|max:255',
            'jabatan1'           => 'required|string',
            'nama_pejabat2'      => 'required|string|max:255',
            'jabatan2'           => 'required|string',

            'nomor_surat'        => 'nullable|string',
            'status_surat'       => 'required|string',
            'status_verif'       => 'required|string',
            'nowa'               => 'required|string|max:20',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Permohonan Pembukaan Rekening berhasil diperbarui.');
    }
}
