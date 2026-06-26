<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganDesaMiskin;
use Illuminate\Http\Request;

class SuratKeteranganDesaMiskinController extends Controller
{
    public function index()
    {
        $data = SuratKeteranganDesaMiskin::all();

        return view('surat.surat_keterangan_desa_miskin', compact('data'));
    }

    public function usermiskin()
    {
        $data = SuratKeteranganDesaMiskin::all();

        return view('surat.user_surat_keterangan_desa_miskin', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        SuratKeteranganDesaMiskin::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Desa Miskin berhasil dibuat.');
    }

    public function userstore(Request $request)
    {
        $validated = $this->validateData($request);

        SuratKeteranganDesaMiskin::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Surat Keterangan Desa Miskin berhasil diajukan.');
    }

    public function edit($id)
    {
        $surat = SuratKeteranganDesaMiskin::findOrFail($id);

        return view('surat.edit_surat_keterangan_desa_miskin', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeteranganDesaMiskin::findOrFail($id);

        $validated = $this->validateData($request);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Desa Miskin berhasil diperbarui.');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'nik'             => 'required|string|max:32',
            'nama'            => 'required|string|max:255',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'jenis_kelamin'   => 'required|string|max:20',
            'kewarganegaraan' => 'required|string|max:50',
            'alamat'          => 'required|string',
            'keperluan'       => 'required|string|max:255',
            'nowa'            => 'required|string|max:20',
            'status_surat'    => 'nullable|string',
            'status_verif'    => 'nullable|string',
        ]);
    }
}
