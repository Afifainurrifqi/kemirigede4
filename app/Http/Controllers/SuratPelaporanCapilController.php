<?php

namespace App\Http\Controllers;

use App\Models\surat_pelaporan_capil;
use Illuminate\Http\Request;

class SuratPelaporanCapilController extends Controller
{
    public function index()
    {
        return view('surat.surat_pelaporan_capil');
    }

    public function user()
    {
        return view('surat.user_surat_pelaporan_capil');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelapor'        => 'required|string|max:255',
            'nik_pelapor'         => 'required|string|max:32',
            'nomor_kk_pelapor'    => 'nullable|string|max:32',
            'kewarganegaraan_pelapor' => 'nullable|string|max:50',

            'jenis_pelaporan'     => 'required|array',
            'nama_subjek'         => 'nullable|string|max:255',
            'nik_subjek'          => 'nullable|string|max:32',
            'ttl_subjek'          => 'nullable|string|max:100',
            'alamat_subjek'       => 'nullable|string',

            'nama_saksi1'         => 'nullable|string|max:255',
            'nik_saksi1'          => 'nullable|string|max:32',
            'nama_saksi2'         => 'nullable|string|max:255',
            'nik_saksi2'          => 'nullable|string|max:32',

            'nama_ayah'           => 'nullable|string|max:255',
            'nik_ayah'            => 'nullable|string|max:32',
            'nama_ibu'            => 'nullable|string|max:255',
            'nik_ibu'             => 'nullable|string|max:32',

            'nama_anak'           => 'nullable|string|max:255',
            'jenis_kelamin_anak'  => 'nullable|string|max:20',
            'tempat_lahir_anak'   => 'nullable|string|max:100',
            'tanggal_lahir_anak'  => 'nullable|date',

            'nomor_kk'            => 'nullable|string|max:32',
            'nowa'                => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_pelaporan_capil::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan Pelaporan Capil berhasil dikirim.');
    }

    public function edit(surat_pelaporan_capil $surat)
    {
        return view('surat.edit_surat_pelaporan_capil', compact('surat'));
    }

    public function update(Request $request, surat_pelaporan_capil $surat)
    {
        $validated = $request->validate([
            'nama_pelapor'        => 'required|string|max:255',
            'nik_pelapor'         => 'required|string|max:32',
            'nomor_kk_pelapor'    => 'nullable|string|max:32',
            'kewarganegaraan_pelapor' => 'nullable|string|max:50',

            'jenis_pelaporan'     => 'required|array',
            'nama_subjek'         => 'nullable|string|max:255',
            'nik_subjek'          => 'nullable|string|max:32',
            'ttl_subjek'          => 'nullable|string|max:100',
            'alamat_subjek'       => 'nullable|string',

            'nama_saksi1'         => 'nullable|string|max:255',
            'nik_saksi1'          => 'nullable|string|max:32',
            'nama_saksi2'         => 'nullable|string|max:255',
            'nik_saksi2'          => 'nullable|string|max:32',

            'nama_ayah'           => 'nullable|string|max:255',
            'nik_ayah'            => 'nullable|string|max:32',
            'nama_ibu'            => 'nullable|string|max:255',
            'nik_ibu'             => 'nullable|string|max:32',

            'nama_anak'           => 'nullable|string|max:255',
            'jenis_kelamin_anak'  => 'nullable|string|max:20',
            'tempat_lahir_anak'   => 'nullable|string|max:100',
            'tanggal_lahir_anak'  => 'nullable|date',

            'nomor_kk'            => 'nullable|string|max:32',
            'nowa'                => 'required|string|max:20',

            'status_surat'        => 'nullable|string',
            'status_verif'        => 'nullable|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Data berhasil diperbarui.');
    }
}
