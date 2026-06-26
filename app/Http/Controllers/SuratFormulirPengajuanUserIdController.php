<?php

namespace App\Http\Controllers;

use App\Models\surat_formulir_pengajuan_user_id;
use Illuminate\Http\Request;
use App\Services\NomorSuratService;

class SuratFormulirPengajuanUserIdController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    public function index()
    {
        return view('surat.surat_formulir_pengajuan_user_id');
    }

    public function user()
    {
        return view('surat.user_surat_formulir_pengajuan_user_id');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'instansi_pemohon' => 'required|string|max:255',
            'alamat_instansi'  => 'nullable|string',
            'nama_pemohon'     => 'required|string|max:255',
            'nik_pemohon'      => 'required|string|max:32',
            'jabatan_pemohon'  => 'nullable|string|max:100',
            'nowa'             => 'required|string|max:20',
            'personil'         => 'nullable|array',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_formulir_pengajuan_user_id::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan User ID berhasil dikirim.');
    }

    public function edit(surat_formulir_pengajuan_user_id $surat)
    {
        return view('surat.edit_surat_formulir_pengajuan_user_id', compact('surat'));
    }

    public function update(Request $request, surat_formulir_pengajuan_user_id $surat)
    {
        $validated = $request->validate([
            'instansi_pemohon' => 'required|string|max:255',
            'alamat_instansi'  => 'nullable|string',
            'nama_pemohon'     => 'required|string|max:255',
            'nik_pemohon'      => 'required|string|max:32',
            'jabatan_pemohon'  => 'nullable|string|max:100',
            'nowa'             => 'required|string|max:20',
            'personil'         => 'nullable|array',
            'status_surat'     => 'nullable|string',
            'status_verif'     => 'nullable|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Data berhasil diperbarui.');
    }
}
