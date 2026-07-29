<?php

namespace App\Http\Controllers;

use App\Models\pekerjaan;
use App\Models\status;
use App\Models\surat_keterangan_penghasilan;
use Illuminate\Http\Request;

class SuratKeteranganPenghasilanController extends Controller
{
    public function index()
    {
        $status = status::all();
        $pekerjaan = pekerjaan::all();
        return view('surat.surat_keterangan_penghasilan', compact('status', 'pekerjaan'));
    }

    public function user_penghasilan()
    {
        $status = Status::all();
        $pekerjaan = Pekerjaan::all();
        return view('surat.user_surat_keterangan_penghasilan', compact('status', 'pekerjaan'));
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'kewarganegaraan' => 'required|string|max:50',
            'status' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat' => 'required|string',
            'nominal_penghasilan' => 'required|string',
            'keperluan' => 'required|string',

            'nama_anak' => 'required|string|max:255',
            'nik_anak' => 'required|string|max:16',
            'jenis_kelamin_anak' => 'required|string',
            'tempat_lahir_anak' => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'sekolah_universitas' => 'required|string|max:255',

            'nowa' => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_keterangan_penghasilan::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Surat Keterangan Penghasilan berhasil diajukan.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'kewarganegaraan' => 'required|string|max:50',
            'status' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat' => 'required|string',
            'nominal_penghasilan' => 'required|string',
            'keperluan' => 'required|string',

            'nama_anak' => 'required|string|max:255',
            'nik_anak' => 'required|string|max:16',
            'jenis_kelamin_anak' => 'required|string',
            'tempat_lahir_anak' => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'sekolah_universitas' => 'required|string|max:255',

            'nomor_surat' => 'nullable|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
            'nowa' => 'required|string|max:20',
        ]);

        surat_keterangan_penghasilan::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Penghasilan berhasil dibuat oleh Admin.');
    }

    public function edit(surat_keterangan_penghasilan $surat)
    {
        $status = Status::all();
        $pekerjaan = Pekerjaan::all();
        return view('surat.edit_surat_keterangan_penghasilan', compact('surat', 'status', 'pekerjaan'));
    }

    public function update(Request $request, surat_keterangan_penghasilan $surat)
    {
        $validated = $request->validate([
            'nik' => 'required|string|max:16',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'kewarganegaraan' => 'required|string|max:50',
            'status' => 'required|string',
            'pekerjaan' => 'required|string',
            'alamat' => 'required|string',
            'nominal_penghasilan' => 'required|string',
            'keperluan' => 'required|string',

            'nama_anak' => 'required|string|max:255',
            'nik_anak' => 'required|string|max:16',
            'jenis_kelamin_anak' => 'required|string',
            'tempat_lahir_anak' => 'required|string|max:100',
            'tanggal_lahir_anak' => 'required|date',
            'sekolah_universitas' => 'required|string|max:255',

            'nomor_surat' => 'nullable|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
            'nowa' => 'required|string|max:20',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Penghasilan berhasil diperbarui.');
    }
}
