<?php

namespace App\Http\Controllers;

use App\Models\SuratKuasa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;   // Pastikan sudah diimport jika pakai export PDF

class SuratKuasaController extends Controller
{
    /**
     * Halaman Form Admin
     */
    public function index()
    {
        return view('surat.surat_kuasa');
    }

    /**
     * Halaman Form User
     */
    public function userForm()
    {
        return view('surat.user_surat_kuasa');
    }

    /**
     * Simpan dari User
     */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            // Pihak I (Pemberi Kuasa)
            'nama_pihak1'          => 'required|string|max:255',
            'jenis_kelamin_pihak1' => 'required|string',
            'tempat_lahir_pihak1'  => 'required|string',
            'tanggal_lahir_pihak1' => 'required|date',
            'agama_pihak1'         => 'required|string',
            'status_pihak1'        => 'required|string',
            'nik_pihak1'           => 'required|string|max:16',
            'pekerjaan_pihak1'     => 'required|string',
            'alamat_pihak1'        => 'required|string',

            // Pihak II (Penerima Kuasa)
            'nama_pihak2'          => 'required|string|max:255',
            'jenis_kelamin_pihak2' => 'required|string',
            'tempat_lahir_pihak2'  => 'required|string',
            'tanggal_lahir_pihak2' => 'required|date',
            'agama_pihak2'         => 'required|string',
            'status_pihak2'        => 'required|string',
            'nik_pihak2'           => 'required|string|max:16',
            'pekerjaan_pihak2'     => 'required|string',
            'alamat_pihak2'        => 'required|string',

            // Isi Kuasa
            'keterangan_kuasa'     => 'required|string',

            // Umum
            'nowa'                 => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratKuasa::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Kuasa berhasil dikirim.');
    }

    /**
     * Simpan dari Admin
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Pihak I
            'nama_pihak1'          => 'required|string|max:255',
            'jenis_kelamin_pihak1' => 'required|string',
            'tempat_lahir_pihak1'  => 'required|string',
            'tanggal_lahir_pihak1' => 'required|date',
            'agama_pihak1'         => 'required|string',
            'status_pihak1'        => 'required|string',
            'nik_pihak1'           => 'required|string|max:16',
            'pekerjaan_pihak1'     => 'required|string',
            'alamat_pihak1'        => 'required|string',

            // Pihak II
            'nama_pihak2'          => 'required|string|max:255',
            'jenis_kelamin_pihak2' => 'required|string',
            'tempat_lahir_pihak2'  => 'required|string',
            'tanggal_lahir_pihak2' => 'required|date',
            'agama_pihak2'         => 'required|string',
            'status_pihak2'        => 'required|string',
            'nik_pihak2'           => 'required|string|max:16',
            'pekerjaan_pihak2'     => 'required|string',
            'alamat_pihak2'        => 'required|string',

            'keterangan_kuasa'     => 'required|string',
            'nowa'                 => 'required|string|max:20',
            'nomor_surat'          => 'nullable|string',
            'status_surat'         => 'required|string',
            'status_verif'         => 'required|string',
        ]);

        $validated['nomor_surat'] = $validated['nomor_surat'] ?? '470 / --- / 409.42.1 / ' . now()->year;

        SuratKuasa::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Kuasa berhasil dibuat.');
    }

    /**
     * Halaman Edit (Admin)
     */
    public function edit(SuratKuasa $surat)
    {
        return view('surat.edit_surat_kuasa', compact('surat'));
    }

    /**
     * Update Surat
     */
    public function update(Request $request, SuratKuasa $surat)
    {
        $validated = $request->validate([
            // Semua field sama seperti di store
            'nama_pihak1'          => 'required|string|max:255',
            'jenis_kelamin_pihak1' => 'required|string',
            'tempat_lahir_pihak1'  => 'required|string',
            'tanggal_lahir_pihak1' => 'required|date',
            'agama_pihak1'         => 'required|string',
            'status_pihak1'        => 'required|string',
            'nik_pihak1'           => 'required|string|max:16',
            'pekerjaan_pihak1'     => 'required|string',
            'alamat_pihak1'        => 'required|string',

            'nama_pihak2'          => 'required|string|max:255',
            'jenis_kelamin_pihak2' => 'required|string',
            'tempat_lahir_pihak2'  => 'required|string',
            'tanggal_lahir_pihak2' => 'required|date',
            'agama_pihak2'         => 'required|string',
            'status_pihak2'        => 'required|string',
            'nik_pihak2'           => 'required|string|max:16',
            'pekerjaan_pihak2'     => 'required|string',
            'alamat_pihak2'        => 'required|string',

            'keterangan_kuasa'     => 'required|string',
            'nowa'                 => 'required|string|max:20',
            'nomor_surat'          => 'nullable|string',
            'status_surat'         => 'required|string',
            'status_verif'         => 'required|string',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Kuasa berhasil diperbarui.');
    }
}
