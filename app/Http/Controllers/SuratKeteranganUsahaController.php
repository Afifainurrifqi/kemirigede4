<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganUsaha;
use Illuminate\Http\Request;

class SuratKeteranganUsahaController extends Controller
{
    public function index()
    {
        $data = SuratKeteranganUsaha::all();

        return view('surat.surat_keterangan_usaha', compact('data'));
    }

    public function userusaha()
    {
        $data = SuratKeteranganUsaha::all();

        return view('surat.user_surat_keterangan_usaha', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        SuratKeteranganUsaha::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Usaha berhasil dibuat.');
    }

    public function userstore(Request $request)
    {
        $validated = $this->validateData($request);

        SuratKeteranganUsaha::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Surat Keterangan Usaha berhasil diajukan.');
    }

    public function edit($id)
    {
        $surat = SuratKeteranganUsaha::findOrFail($id);

        return view('surat.edit_surat_keterangan_usaha', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeteranganUsaha::findOrFail($id);

        $validated = $this->validateData($request);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Usaha berhasil diperbarui.');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'nama'              => 'required|string|max:255',
            'nama_usaha'        => 'required|string|max:255',
            'alamat'            => 'required|string',
            'nik'               => 'required|string|max:32',
            'tempat_lahir'      => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date',
            'jenis_kelamin'     => 'required|string|max:20',
            'kewarganegaraan'   => 'required|string|max:50',
            'keperluan'         => 'required|string|max:255',
            'nowa'              => 'required|string|max:20',
            'status_surat'      => 'nullable|string',
            'status_verif'      => 'nullable|string',
        ]);
    }
}
