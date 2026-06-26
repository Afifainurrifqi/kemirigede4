<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganDomisiliWarga;
use Illuminate\Http\Request;

class SuratKeteranganDomisiliWargaController extends Controller
{
    public function index()
    {
        return view('surat.surat_keterangan_domisili_warga');
    }

    public function userForm()
    {
        return view('surat.user_surat_keterangan_domisili_warga');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik'              => 'required|string|max:16|unique:surat_keterangan_domisili_warga,nik',
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'    => 'required|string',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string',
            'status'           => 'required|string',
            'pekerjaan'        => 'required|string',
            'alamat_asal'      => 'required|string',
            'alamat_domisili'  => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'             => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratKeteranganDomisiliWarga::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Keterangan Domisili Warga berhasil.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'              => 'required|string|max:16',
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'    => 'required|string',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string',
            'status'           => 'required|string',
            'pekerjaan'        => 'required|string',
            'alamat_asal'      => 'required|string',
            'alamat_domisili'  => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'             => 'required|string|max:20',
            'nomor_surat'      => 'nullable|string',
            'status_surat'     => 'required|string',
            'status_verif'     => 'required|string',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.41.2 / ' . now()->year;

        SuratKeteranganDomisiliWarga::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratKeteranganDomisiliWarga $surat)
    {
        return view('surat.edit_surat_keterangan_domisili_warga', compact('surat'));
    }

    public function update(Request $request, SuratKeteranganDomisiliWarga $surat)
    {
        $validated = $request->validate([
            'nik'              => 'required|string|max:16',
            'nama_lengkap'     => 'required|string|max:255',
            'jenis_kelamin'    => 'required|string',
            'tempat_lahir'     => 'required|string|max:100',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string',
            'status'           => 'required|string',
            'pekerjaan'        => 'required|string',
            'alamat_asal'      => 'required|string',
            'alamat_domisili'  => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'             => 'required|string|max:20',
            'nomor_surat'      => 'nullable|string',
            'status_surat'     => 'required|string',
            'status_verif'     => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
