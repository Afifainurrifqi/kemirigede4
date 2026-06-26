<?php

namespace App\Http\Controllers;

use App\Models\SuratKeteranganMiskinSkm;
use Illuminate\Http\Request;

class SuratKeteranganMiskinSkmController extends Controller
{
    public function index()
    {
        $data = SuratKeteranganMiskinSkm::all();

        return view('surat.surat_keterangan_miskin_skm', compact('data'));
    }

    public function userskm()
    {
        $data = SuratKeteranganMiskinSkm::all();

        return view('surat.user_surat_keterangan_miskin_skm', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        SuratKeteranganMiskinSkm::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Miskin SKM berhasil dibuat.');
    }

    public function userstore(Request $request)
    {
        $validated = $this->validateData($request);

        SuratKeteranganMiskinSkm::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Surat Keterangan Miskin SKM berhasil diajukan.');
    }

    public function edit($id)
    {
        $surat = SuratKeteranganMiskinSkm::findOrFail($id);

        return view('surat.edit_surat_keterangan_miskin_skm', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = SuratKeteranganMiskinSkm::findOrFail($id);

        $validated = $this->validateData($request);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Miskin SKM berhasil diperbarui.');
    }

    private function validateData(Request $request)
    {
        return $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'nik'           => 'required|string|max:32',
            'pekerjaan'     => 'required|string|max:100',
            'alamat'        => 'required|string',
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'nullable|string',
            'status_verif'  => 'nullable|string',
        ]);
    }
}
