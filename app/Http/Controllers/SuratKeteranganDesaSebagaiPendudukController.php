<?php

namespace App\Http\Controllers;

use App\Models\status;
use App\Models\SuratKeteranganDesaSebagaiPenduduk;
use Illuminate\Http\Request;

class SuratKeteranganDesaSebagaiPendudukController extends Controller
{
    public function index() // Admin
    {
        $status = status::all();
        return view('surat.surat_keterangan_desa_sebagai_penduduk', compact('status'));
    }

    public function userForm()
    {
        $status = status::all();
        return view('surat.user_surat_keterangan_desa_sebagai_penduduk', compact('status'));
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
            'pekerjaan' => 'required|string',
            'status' => 'required|string',
            'alamat' => 'required|string',
            'keterangan_tambahan' => 'required|string',
            'nowa' => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratKeteranganDesaSebagaiPenduduk::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Keterangan Desa Sebagai Penduduk berhasil.');
    }

    public function store(Request $request) // Admin
    {
        $validated = $request->validate([ /* rules sama seperti di atas */ ]);
        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.41.2 / ' . now()->year;

        SuratKeteranganDesaSebagaiPenduduk::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil dibuat.');
    }

    public function edit(SuratKeteranganDesaSebagaiPenduduk $surat)
    {
        $status = \App\Models\Status::all();
        return view('surat.edit_surat_keterangan_desa_sebagai_penduduk', compact('surat', 'status'));
    }

    public function update(Request $request, SuratKeteranganDesaSebagaiPenduduk $surat)
    {
        $validated = $request->validate([ /* rules sama */ ]);
        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat berhasil diperbarui.');
    }
}
