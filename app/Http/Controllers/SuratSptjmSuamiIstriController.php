<?php

namespace App\Http\Controllers;

use App\Models\surat_sptjm_suami_istri;
use Illuminate\Http\Request;

class SuratSptjmSuamiIstriController extends Controller
{
    public function index()
    {
        return view('surat.surat_sptjm_suami_istri');
    }

    public function user()
    {
        return view('surat.user_surat_sptjm_suami_istri');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_deklaran'       => 'required|string|max:255',
            'nik_deklaran'        => 'required|string|max:32',
            'ttl_deklaran'        => 'nullable|string|max:100',
            'pekerjaan_deklaran'  => 'nullable|string|max:100',
            'alamat_deklaran'     => 'required|string',

            'nama_pasangan'       => 'required|string|max:255',
            'nik_pasangan'        => 'required|string|max:32',
            'ttl_pasangan'        => 'nullable|string|max:100',
            'alamat_pasangan'     => 'required|string',

            'nomor_kk'            => 'nullable|string|max:32',
            'nowa'                => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_sptjm_suami_istri::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan SPTJM berhasil dikirim.');
    }

      public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_deklaran'       => 'required|string|max:255',
            'nik_deklaran'        => 'required|string|max:32',
            'ttl_deklaran'        => 'nullable|string|max:100',
            'pekerjaan_deklaran'  => 'nullable|string|max:100',
            'alamat_deklaran'     => 'required|string',

            'nama_pasangan'       => 'required|string|max:255',
            'nik_pasangan'        => 'required|string|max:32',
            'ttl_pasangan'        => 'nullable|string|max:100',
            'alamat_pasangan'     => 'required|string',

            'nomor_kk'            => 'nullable|string|max:32',
            'nowa'                => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_sptjm_suami_istri::create($validated);

        return redirect()->route('surat.suratkeluar')->with('success', 'Pengajuan SPTJM berhasil dikirim.');
    }

    public function edit(surat_sptjm_suami_istri $surat)
    {
        return view('surat.edit_surat_sptjm_suami_istri', compact('surat'));
    }

    public function update(Request $request, surat_sptjm_suami_istri $surat)
    {
        $validated = $request->validate([
            'nama_deklaran'       => 'required|string|max:255',
            'nik_deklaran'        => 'required|string|max:32',
            'ttl_deklaran'        => 'nullable|string|max:100',
            'pekerjaan_deklaran'  => 'nullable|string|max:100',
            'alamat_deklaran'     => 'required|string',

            'nama_pasangan'       => 'required|string|max:255',
            'nik_pasangan'        => 'required|string|max:32',
            'ttl_pasangan'        => 'nullable|string|max:100',
            'alamat_pasangan'     => 'required|string',

            'nomor_kk'            => 'nullable|string|max:32',
            'nowa'                => 'required|string|max:20',
            'status_surat'        => 'nullable|string',
            'status_verif'        => 'nullable|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Data berhasil diperbarui.');
    }
}
