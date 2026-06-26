<?php

namespace App\Http\Controllers;

use App\Models\SuratPerintahTugas;
use Illuminate\Http\Request;

class SuratPerintahTugasController extends Controller
{
    public function index() // Admin Form
    {
        return view('surat.surat_perintah_tugas');
    }

    public function userForm()
    {
        return view('surat.user_surat_perintah_tugas');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_penerima'     => 'required|string|max:255',
            'jabatan_penerima'  => 'required|string',
            'nik_penerima'      => 'nullable|string|max:16',
            'hari'              => 'required|string',
            'tanggal_kegiatan'  => 'required|date',
            'waktu_mulai'       => 'required',
            'tempat_kegiatan'   => 'required|string',
            'untuk_mengikuti'   => 'required|string',
            'keterangan_tugas'  => 'nullable|string',
            'dasar'             => 'nullable|array',
            'nowa'              => 'required|string|max:20',
        ]);

        // Auto generate nomor surat dan tanggal
        $tahun = date('Y');
        $lastNumber = SuratPerintahTugas::whereYear('created_at', $tahun)->count() + 1;
        $validated['nomor_surat'] = sprintf("%03d / / 409.41.2 / %s", $lastNumber, $tahun);
        $validated['tanggal_surat'] = now();

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPerintahTugas::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Perintah Tugas berhasil.');
    }

    public function store(Request $request) // Admin
    {
        $validated = $request->validate([
            'nama_penerima'     => 'required|string|max:255',
            'jabatan_penerima'  => 'required|string',
            'nik_penerima'      => 'nullable|string|max:16',
            'hari'              => 'required|string',
            'tanggal_kegiatan'  => 'required|date',
            'waktu_mulai'       => 'required',
            'tempat_kegiatan'   => 'required|string',
            'untuk_mengikuti'   => 'required|string',
            'keterangan_tugas'  => 'nullable|string',
            'dasar'             => 'nullable|array',
            'nowa'              => 'required|string|max:20',
            'status_surat'      => 'required|string',
            'status_verif'      => 'required|string',
        ]);

        // Auto generate nomor surat dan tanggal
        $tahun = date('Y');
        $lastNumber = SuratPerintahTugas::whereYear('created_at', $tahun)->count() + 1;
        $validated['nomor_surat'] = sprintf("%03d / / 409.41.2 / %s", $lastNumber, $tahun);
        $validated['tanggal_surat'] = now();

        SuratPerintahTugas::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratPerintahTugas $surat)
    {
        return view('surat.edit_surat_perintah_tugas', compact('surat'));
    }

    public function update(Request $request, SuratPerintahTugas $surat)
    {
        $validated = $request->validate([
            'nama_penerima'     => 'required|string|max:255',
            'jabatan_penerima'  => 'required|string',
            'nik_penerima'      => 'nullable|string|max:16',
            'hari'              => 'required|string',
            'tanggal_kegiatan'  => 'required|date',
            'waktu_mulai'       => 'required',
            'tempat_kegiatan'   => 'required|string',
            'untuk_mengikuti'   => 'required|string',
            'keterangan_tugas'  => 'nullable|string',
            'dasar'             => 'nullable|array',
            'nowa'              => 'required|string|max:20',
            'status_surat'      => 'required|string',
            'status_verif'      => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
