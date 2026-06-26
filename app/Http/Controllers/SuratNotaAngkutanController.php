<?php

namespace App\Http\Controllers;

use App\Models\SuratNotaAngkutan;
use Illuminate\Http\Request;

class SuratNotaAngkutanController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_nota_angkutan');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_nota_angkutan');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim'         => 'required|string|max:255',
            'nik'                   => 'required|string|max:16',
            'alamat_pengirim'       => 'required|string',
            'bukti_kepemilikan'     => 'required|string',
            'nomor_bukti_kepemilikan'=> 'required|string',
            'jenis_kayu'            => 'required|string',
            'jumlah'                => 'required|string',
            'volume'                => 'required|string',
            'alat_angkut'           => 'required|string',
            'tempat_muat'           => 'required|string',
            'nama_penerima'         => 'required|string',
            'alamat_penerima'       => 'required|string',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',
            'nowa'                  => 'required|string|max:20',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("500 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratNotaAngkutan::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Nota Angkutan berhasil.');
    }

    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim'         => 'required|string|max:255',
            'nik'                   => 'required|string|max:16',
            'alamat_pengirim'       => 'required|string',
            'bukti_kepemilikan'     => 'required|string',
            'nomor_bukti_kepemilikan'=> 'required|string',
            'jenis_kayu'            => 'required|string',
            'jumlah'                => 'required|string',
            'volume'                => 'required|string',
            'alat_angkut'           => 'required|string',
            'tempat_muat'           => 'required|string',
            'nama_penerima'         => 'required|string',
            'alamat_penerima'       => 'required|string',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',
            'nowa'                  => 'required|string|max:20',
            'status_surat'          => 'required|string',
            'status_verif'          => 'required|string',
        ]);

        // Auto Generate Nomor Surat
        $tahun = date('Y');
        $validated['nomor_surat'] = sprintf("500 / / 409.41.2 / %s", $tahun);
        $validated['tanggal_surat'] = now();

        SuratNotaAngkutan::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Nota Angkutan berhasil dibuat.');
    }

    /**
     * Halaman Edit Admin
     */
    public function edit(SuratNotaAngkutan $surat)
    {
        return view('surat.edit_surat_nota_angkutan', compact('surat'));
    }

    /**
     * Update Surat
     */
    public function update(Request $request, SuratNotaAngkutan $surat)
    {
        $validated = $request->validate([
            'nama_pengirim'         => 'required|string|max:255',
            'nik'                   => 'required|string|max:16',
            'alamat_pengirim'       => 'required|string',
            'bukti_kepemilikan'     => 'required|string',
            'nomor_bukti_kepemilikan'=> 'required|string',
            'jenis_kayu'            => 'required|string',
            'jumlah'                => 'required|string',
            'volume'                => 'required|string',
            'alat_angkut'           => 'required|string',
            'tempat_muat'           => 'required|string',
            'nama_penerima'         => 'required|string',
            'alamat_penerima'       => 'required|string',
            'tanggal_mulai'         => 'required|date',
            'tanggal_selesai'       => 'required|date|after_or_equal:tanggal_mulai',
            'nowa'                  => 'required|string|max:20',
            'status_surat'          => 'required|string',
            'status_verif'          => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Nota Angkutan berhasil diperbarui.');
    }
}
