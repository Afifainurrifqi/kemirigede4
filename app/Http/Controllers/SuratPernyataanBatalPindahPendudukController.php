<?php

namespace App\Http\Controllers;

use App\Models\surat_pernyataan_batal_pindah_penduduk;
use Illuminate\Http\Request;
use App\Services\NomorSuratService;

class SuratPernyataanBatalPindahPendudukController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    protected function maybeAssignNomorSurat($suratOrNull, array &$payload): void
    {
        $this->svc->maybeAssignNomorSurat($suratOrNull, $payload, 'batal_pindah');
    }

    public function index()
    {
        return view('surat.surat_pernyataan_batal_pindah_penduduk');
    }

    public function user()
    {
        $agama = \App\Models\agama::all();
        $status = \App\Models\status::all();

        return view('surat.user_surat_pernyataan_batal_pindah_penduduk', compact('agama', 'status'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'ttl_tempat'    => 'nullable|string|max:100',
            'ttl_tanggal'   => 'nullable|date',
            'alamat'        => 'required|string',
            'nik'           => 'required|string|max:32',
            'agama'         => 'nullable|string|max:50',
            'status'        => 'nullable|string|max:50',
            'ke_alamat'     => 'required|string',
            'alasan_batal'  => 'required|string',
            'alamat_asal'   => 'required|string',
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'nullable|string',
            'status_verif'  => 'nullable|string',
        ]);

        $payload = $validated;
        $this->maybeAssignNomorSurat(null, $payload);

        surat_pernyataan_batal_pindah_penduduk::create($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil disimpan.');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'ttl_tempat'    => 'nullable|string|max:100',
            'ttl_tanggal'   => 'nullable|date',
            'alamat'        => 'required|string',
            'nik'           => 'required|string|max:32',
            'agama'         => 'nullable|string|max:50',
            'status'        => 'nullable|string|max:50',
            'ke_alamat'     => 'required|string',
            'alasan_batal'  => 'required|string',
            'alamat_asal'   => 'required|string',
            'nowa'          => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_pernyataan_batal_pindah_penduduk::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit(surat_pernyataan_batal_pindah_penduduk $surat)
    {
        return view('surat.edit_surat_pernyataan_batal_pindah_penduduk', compact('surat'));
    }

    public function update(Request $request, surat_pernyataan_batal_pindah_penduduk $surat)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'ttl_tempat'    => 'nullable|string|max:100',
            'ttl_tanggal'   => 'nullable|date',
            'alamat'        => 'required|string',
            'nik'           => 'required|string|max:32',
            'agama'         => 'nullable|string|max:50',
            'status'        => 'nullable|string|max:50',
            'ke_alamat'     => 'required|string',
            'alasan_batal'  => 'required|string',
            'alamat_asal'   => 'required|string',
            'nowa'          => 'required|string|max:20',
            'status_surat'  => 'nullable|string',
            'status_verif'  => 'nullable|string',
        ]);

        $this->maybeAssignNomorSurat($surat, $validated);
        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil diperbarui.');
    }
}
