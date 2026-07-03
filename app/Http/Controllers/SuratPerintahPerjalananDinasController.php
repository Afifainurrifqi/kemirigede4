<?php

namespace App\Http\Controllers;

use App\Models\SuratPerintahPerjalananDinas;
use Illuminate\Http\Request;

class SuratPerintahPerjalananDinasController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_perintah_perjalanan_dinas');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_perintah_perjalanan_dinas');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai'       => 'required|string|max:255',
            'pangkat_golongan'   => 'required|string',
            'jabatan'            => 'required|string',
            'maksud_perjalanan'  => 'required|string',
            'alat_angkutan'      => 'required|string',
            'tempat_berangkat'   => 'required|string',
            'tempat_tujuan'      => 'required|string',
            'lama_perjalanan'    => 'required|string',
            'tanggal_berangkat'  => 'required|date',
            'tanggal_kembali'    => 'required|date|after_or_equal:tanggal_berangkat',
            'instansi_anggaran'  => 'nullable|string',
            'sumber_anggaran'    => 'required|string',
            'nowa'               => 'required|string|max:20',
        ]);

        // Auto Generate Nomor SPPD
        $tahun = date('Y');
        $lastNumber = SuratPerintahPerjalananDinas::whereYear('created_at', $tahun)->count() + 1;
        $validated['nomor_sppd'] = "B/010.02/{$lastNumber}/409.41.2/{$tahun}";
        $validated['tanggal_surat'] = now();
        $validated['pejabat_pemberi_perintah'] = 'KEPALA DESA KEMIRIGEDE Kecamatan Kesamben Kabupaten Blitar';

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPerintahPerjalananDinas::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Perintah Perjalanan Dinas berhasil.');
    }

    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pegawai'       => 'required|string|max:255',
            'pangkat_golongan'   => 'required|string',
            'jabatan'            => 'required|string',
            'maksud_perjalanan'  => 'required|string',
            'alat_angkutan'      => 'required|string',
            'tempat_berangkat'   => 'required|string',
            'tempat_tujuan'      => 'required|string',
            'lama_perjalanan'    => 'required|string',
            'tanggal_berangkat'  => 'required|date',
            'tanggal_kembali'    => 'required|date|after_or_equal:tanggal_berangkat',
            'instansi_anggaran'  => 'nullable|string',
            'sumber_anggaran'    => 'required|string',
            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'required|string',
            'status_verif'       => 'required|string',
        ]);

        // Auto Generate Nomor SPPD
        $tahun = date('Y');
        $lastNumber = SuratPerintahPerjalananDinas::whereYear('created_at', $tahun)->count() + 1;
        $validated['nomor_sppd'] = "B/010.02/{$lastNumber}/409.41.2/{$tahun}";
        $validated['tanggal_surat'] = now();
        $validated['pejabat_pemberi_perintah'] = 'KEPALA DESA KEMIRIGEDE Kecamatan Kesamben Kabupaten Blitar';

        SuratPerintahPerjalananDinas::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Perintah Perjalanan Dinas berhasil dibuat.');
    }

    /**
     * Halaman Edit (Admin)
     */
    public function edit(SuratPerintahPerjalananDinas $surat)
    {
        return view('surat.edit_surat_perintah_perjalanan_dinas', compact('surat'));
    }

    /**
     * Update Data
     */
    public function update(Request $request, SuratPerintahPerjalananDinas $surat)
    {
        $validated = $request->validate([
            'nama_pegawai'       => 'required|string|max:255',
            'pangkat_golongan'   => 'required|string',
            'jabatan'            => 'required|string',
            'maksud_perjalanan'  => 'required|string',
            'alat_angkutan'      => 'required|string',
            'tempat_berangkat'   => 'required|string',
            'tempat_tujuan'      => 'required|string',
            'lama_perjalanan'    => 'required|string',
            'tanggal_berangkat'  => 'required|date',
            'tanggal_kembali'    => 'required|date|after_or_equal:tanggal_berangkat',
            'instansi_anggaran'  => 'nullable|string',
            'sumber_anggaran'    => 'required|string',
            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'required|string',
            'status_verif'       => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Perintah Perjalanan Dinas berhasil diperbarui.');
    }
}
