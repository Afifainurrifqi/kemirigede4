<?php

namespace App\Http\Controllers;

use App\Models\status;
use App\Models\surat_keterangan_ghoib;
use Illuminate\Http\Request;

class SuratKeteranganGhoibController extends Controller
{
    public function index()
    {
        $status = status::all();
        return view('surat.surat_keterangan_ghoib', compact('status'));
    }

    public function user_ghoib()
    {
        $status = status::all();
        return view('surat.user_surat_keterangan_ghoib', compact('status'));
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik'                  => 'required|string|max:20',
            'nama_pemohon'         => 'required|string|max:255',
            'tempat_lahir'         => 'required|string',
            'tanggal_lahir'        => 'required|date',
            'jenis_kelamin'        => 'required|string',
            'kewarganegaraan'      => 'required|string',
            'agama'                => 'required|string',
            'status'               => 'required|string',
            'pekerjaan'            => 'required|string',
            'alamat'               => 'required|string',
            'nama_suami_istri'     => 'required|string',
            'tanggal_hilang'       => 'required|date',
            'tanggal_pernyataan'   => 'required|date',
            'keperluan'            => 'required|string|max:255',
            'keterangan_tambahan'  => 'nullable|string',
            'status_surat'         => 'nullable|string',
            'status_verif'         => 'nullable|string',
            'nowa'                 => 'required|string|max:20',
        ]);
        surat_keterangan_ghoib::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Surat Keterangan Ghoib berhasil dibuat.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik'                  => 'required|string|max:20',
            'nama_pemohon'         => 'required|string|max:255',
            'tempat_lahir'         => 'required|string',
            'tanggal_lahir'        => 'required|date',
            'jenis_kelamin'        => 'required|string',
            'kewarganegaraan'      => 'required|string',
            'agama'                => 'required|string',
            'status'               => 'required|string',
            'pekerjaan'            => 'required|string',
            'alamat'               => 'required|string',
            'nama_suami_istri'     => 'required|string',
            'tanggal_hilang'       => 'required|date',
            'tanggal_pernyataan'   => 'required|date',
            'keperluan'            => 'required|string|max:255',
            'keterangan_tambahan'  => 'nullable|string',
            'status_surat'         => 'nullable|string',
            'status_verif'         => 'nullable|string',
            'nowa'                 => 'required|string|max:20',
        ]);
        surat_keterangan_ghoib::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Ghoib berhasil dibuat.');
    }

    public function edit(surat_keterangan_ghoib $surat)
    {
        $status = \App\Models\Status::all();
        return view('surat.edit_surat_keterangan_ghoib', compact('surat', 'status'));
    }

    public function update(Request $request, surat_keterangan_ghoib $surat)
    {
        $validated = $request->validate([
            'nik'                  => 'required|string|max:20',
            'nama_pemohon'         => 'required|string|max:255',
            'tempat_lahir'         => 'required|string',
            'tanggal_lahir'        => 'required|date',
            'jenis_kelamin'        => 'required|string',
            'kewarganegaraan'      => 'required|string',
            'agama'                => 'required|string',
            'status'               => 'required|string',
            'pekerjaan'            => 'required|string',
            'alamat'               => 'required|string',
            'nama_suami_istri'     => 'required|string',
            'tanggal_hilang'       => 'required|date',
            'tanggal_pernyataan'   => 'required|date',
            'keperluan'            => 'required|string|max:255',
            'keterangan_tambahan'  => 'nullable|string',
            'status_surat'         => 'nullable|string',
            'status_verif'         => 'nullable|string',
            'nowa'                 => 'required|string|max:20',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Ghoib berhasil diperbarui.');
    }
}
