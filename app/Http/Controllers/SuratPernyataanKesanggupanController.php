<?php

namespace App\Http\Controllers;

use App\Models\SuratPernyataanKesanggupan;
use Illuminate\Http\Request;

class SuratPernyataanKesanggupanController extends Controller
{
    public function index()
    {
        return view('surat.surat_pernyataan_kesanggupan');
    }

    public function userForm()
    {
        return view('surat.user_surat_pernyataan_kesanggupan');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kegiatan' => 'required|string',
            'hari' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'waktu' => 'required|string',
            'tempat_kegiatan' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa' => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPernyataanKesanggupan::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Pernyataan Kesanggupan berhasil.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kegiatan' => 'required|string',
            'hari' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'waktu' => 'required|string',
            'tempat_kegiatan' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa' => 'required|string|max:20',
            'nomor_surat' => 'nullable|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.41.2 / ' . now()->year;

        SuratPernyataanKesanggupan::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratPernyataanKesanggupan $surat)
    {
        return view('surat.edit_surat_pernyataan_kesanggupan', compact('surat'));
    }

    public function update(Request $request, SuratPernyataanKesanggupan $surat)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'kegiatan' => 'required|string',
            'hari' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'waktu' => 'required|string',
            'tempat_kegiatan' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'nowa' => 'required|string|max:20',
            'nomor_surat' => 'nullable|string',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
