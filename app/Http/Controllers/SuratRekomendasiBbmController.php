<?php

namespace App\Http\Controllers;

use App\Models\SuratRekomendasiBbm;
use Illuminate\Http\Request;

class SuratRekomendasiBbmController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_rekomendasi_bbm');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_rekomendasi_bbm');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik'                     => 'required|string|max:20',
            'nama_lengkap'            => 'required|string|max:255',
            'no_hp'                   => 'required|string|max:20',
            'alamat_usaha'            => 'required|string',
            'sektor_konsumen'         => 'required|string|max:255',
            'jenis_usaha_kegiatan'    => 'required|string|max:255',
            'jenis_alat'              => 'required|string',
            'jumlah_alat'             => 'required|integer|min:1',
            'fungsi_alat'             => 'required|string',
            'daya_alat'               => 'required|string',
            'kebutuhan_bbm'           => 'required|string',
            'jam_operasi'             => 'required|string',
            'konsumsi_bbm'            => 'required|string',
            'alokasi_pertalite'       => 'required|string',
            'tempat_pengambilan'      => 'required|string',
            'nomor_lembaga_penyalur'  => 'required|string',
            'lokasi_penyalur'         => 'required|string',
            'jangka_waktu'            => 'required|date',
            'nowa'                    => 'required|string|max:20',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("541 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        // Default Status
        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratRekomendasiBbm::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Rekomendasi Pembelian BBM berhasil dikirim.');
    }

    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'                     => 'required|string|max:20',
            'nama_lengkap'            => 'required|string|max:255',
            'no_hp'                   => 'required|string|max:20',
            'alamat_usaha'            => 'required|string',
            'sektor_konsumen'         => 'required|string|max:255',
            'jenis_usaha_kegiatan'    => 'required|string|max:255',
            'jenis_alat'              => 'required|string',
            'jumlah_alat'             => 'required|integer|min:1',
            'fungsi_alat'             => 'required|string',
            'daya_alat'               => 'required|string',
            'kebutuhan_bbm'           => 'required|string',
            'jam_operasi'             => 'required|string',
            'konsumsi_bbm'            => 'required|string',
            'alokasi_pertalite'       => 'required|string',
            'tempat_pengambilan'      => 'required|string',
            'nomor_lembaga_penyalur'  => 'required|string',
            'lokasi_penyalur'         => 'required|string',
            'jangka_waktu'            => 'required|date',
            'nowa'                    => 'required|string|max:20',
            'status_surat'            => 'required|string',
            'status_verif'            => 'required|string',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("541 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        SuratRekomendasiBbm::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Rekomendasi Pembelian BBM berhasil dibuat.');
    }

    /**
     * Halaman Edit Admin
     */
    public function edit(SuratRekomendasiBbm $surat)
    {
        return view('surat.edit_surat_rekomendasi_bbm', compact('surat'));
    }

    /**
     * Update Surat
     */
    public function update(Request $request, SuratRekomendasiBbm $surat)
    {
        $validated = $request->validate([
            'nik'                     => 'required|string|max:20',
            'nama_lengkap'            => 'required|string|max:255',
            'no_hp'                   => 'required|string|max:20',
            'alamat_usaha'            => 'required|string',
            'sektor_konsumen'         => 'required|string|max:255',
            'jenis_usaha_kegiatan'    => 'required|string|max:255',
            'jenis_alat'              => 'required|string',
            'jumlah_alat'             => 'required|integer|min:1',
            'fungsi_alat'             => 'required|string',
            'daya_alat'               => 'required|string',
            'kebutuhan_bbm'           => 'required|string',
            'jam_operasi'             => 'required|string',
            'konsumsi_bbm'            => 'required|string',
            'alokasi_pertalite'       => 'required|string',
            'tempat_pengambilan'      => 'required|string',
            'nomor_lembaga_penyalur'  => 'required|string',
            'lokasi_penyalur'         => 'required|string',
            'jangka_waktu'            => 'required|date',
            'nowa'                    => 'required|string|max:20',
            'status_surat'            => 'required|string',
            'status_verif'            => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Rekomendasi Pembelian BBM berhasil diperbarui.');
    }
}
