<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganKepemilikanAset;
use Illuminate\Http\Request;

class SuratKeteranganKepemilikanAsetController extends Controller
{
    public function index()
    {
        return view('surat.surat_keterangan_kepemilikan_aset');
    }

    public function userForm()
    {
        return view('surat.user_surat_keterangan_kepemilikan_aset');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'                => 'required|string|max:255',
            'tempat_lahir'        => 'required|string|max:100',
            'tanggal_lahir'       => 'required|date',
            'nik'                 => 'required|string|max:16',
            'pekerjaan'           => 'required|string',
            'alamat'              => 'required|string',
            'pendapatan_bulanan'  => 'required|string',
            'pekarangan'          => 'nullable|string',
            'sawah'               => 'nullable|string',
            'perkebunan'          => 'nullable|string',
            'mobil'               => 'nullable|string',
            'sepeda_motor'        => 'nullable|string',
            'perhiasan_emas'      => 'nullable|string',
            'lainnya'             => 'nullable|string',
            'kepemilikan_rumah'   => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'                => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratKeteranganKepemilikanAset::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Keterangan Kepemilikan Aset berhasil.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'                => 'required|string|max:255',
            'tempat_lahir'        => 'required|string|max:100',
            'tanggal_lahir'       => 'required|date',
            'nik'                 => 'required|string|max:16',
            'pekerjaan'           => 'required|string',
            'alamat'              => 'required|string',
            'pendapatan_bulanan'  => 'required|string',
            'pekarangan'          => 'nullable|string',
            'sawah'               => 'nullable|string',
            'perkebunan'          => 'nullable|string',
            'mobil'               => 'nullable|string',
            'sepeda_motor'        => 'nullable|string',
            'perhiasan_emas'      => 'nullable|string',
            'lainnya'             => 'nullable|string',
            'kepemilikan_rumah'   => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'                => 'required|string|max:20',
            'nomor_surat'         => 'nullable|string',
            'status_surat'        => 'required|string',
            'status_verif'        => 'required|string',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.41.2 / ' . now()->year;

        SuratKeteranganKepemilikanAset::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratKeteranganKepemilikanAset $surat)
    {
        return view('surat.edit_surat_keterangan_kepemilikan_aset', compact('surat'));
    }

    public function update(Request $request, SuratKeteranganKepemilikanAset $surat)
    {
        $validated = $request->validate([
            'nama'                => 'required|string|max:255',
            'tempat_lahir'        => 'required|string|max:100',
            'tanggal_lahir'       => 'required|date',
            'nik'                 => 'required|string|max:16',
            'pekerjaan'           => 'required|string',
            'alamat'              => 'required|string',
            'pendapatan_bulanan'  => 'required|string',
            'pekarangan'          => 'nullable|string',
            'sawah'               => 'nullable|string',
            'perkebunan'          => 'nullable|string',
            'mobil'               => 'nullable|string',
            'sepeda_motor'        => 'nullable|string',
            'perhiasan_emas'      => 'nullable|string',
            'lainnya'             => 'nullable|string',
            'kepemilikan_rumah'   => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa'                => 'required|string|max:20',
            'nomor_surat'         => 'nullable|string',
            'status_surat'        => 'required|string',
            'status_verif'        => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
