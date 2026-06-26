<?php

namespace App\Http\Controllers;

use App\Models\surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak;
use Illuminate\Http\Request;
use App\Services\NomorSuratService;

class SuratPermohonanPengantarKeabsahanAktaKelahiranAnakController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    protected function maybeAssignNomorSurat($suratOrNull, array &$payload): void
    {
        $this->svc->maybeAssignNomorSurat($suratOrNull, $payload, 'pengantar_keabsahan_anak');
    }

    public function index()
    {
        return view('surat.surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak');
    }

    public function user()
    {
        return view('surat.user_surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|max:32',
            'jenis_kelamin' => 'required|string|max:20',
            'ttl_tempat'    => 'nullable|string|max:100',
            'ttl_tanggal'   => 'nullable|date',
            'alamat'        => 'required|string',
            'nama_anak'     => 'required|string|max:255',   // ← Wajib
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'nullable|string',
            'status_verif'  => 'nullable|string',
        ]);

        $payload = $validated;
        $this->maybeAssignNomorSurat(null, $payload);

        surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak::create($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil disimpan.');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|max:32',
            'jenis_kelamin' => 'required|string|max:20',
            'ttl_tempat'    => 'nullable|string|max:100',
            'ttl_tanggal'   => 'nullable|date',
            'alamat'        => 'required|string',
            'nama_anak'     => 'required|string|max:255',
            'nowa'          => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit(surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak $surat)
    {
        return view('surat.edit_surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak', compact('surat'));
    }

    public function update(Request $request, surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak $surat)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|max:32',
            'jenis_kelamin' => 'required|string|max:20',
            'ttl_tempat'    => 'nullable|string|max:100',
            'ttl_tanggal'   => 'nullable|date',
            'alamat'        => 'required|string',
            'nama_anak'     => 'required|string|max:255',
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'nullable|string',
            'status_verif'  => 'nullable|string',
        ]);

        $this->maybeAssignNomorSurat($surat, $validated);
        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil diperbarui.');
    }
}
