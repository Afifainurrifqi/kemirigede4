<?php

namespace App\Http\Controllers;

use App\Models\surat_pernyataan_pembetulan_data_tidak_merubah_lagi;
use Illuminate\Http\Request;
use App\Services\NomorSuratService;

class SuratPernyataanPembetulanDataTidakMerubahLagiController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    protected function maybeAssignNomorSurat($suratOrNull, array &$payload): void
    {
        $status = $payload['status_surat'] ?? ($suratOrNull->status_surat ?? null);
        $verif  = $payload['status_verif'] ?? ($suratOrNull->status_verif ?? null);

        if ($status === 'Di terima' && $verif === 'Terverifikasi'
            && empty($payload['nomor_surat'])
            && empty($suratOrNull?->nomor_surat)) {

            $issued = $this->svc->issue('pembetulandata'); // pastikan sudah ada di NomorSuratService
            $payload['nomor_urut']  = $issued['urut'];
            $payload['tahun_nomor'] = $issued['tahun'];
            $payload['nomor_surat'] = $issued['nomor_surat'];
        }
    }

    public function index()
    {
        $data = surat_pernyataan_pembetulan_data_tidak_merubah_lagi::orderBy('_id', 'desc')->get();
        return view('surat.surat_pernyataan_pembetulan_data_tidak_merubah_lagi', compact('data'));
    }

    public function user()
    {
        return view('surat.user_surat_pernyataan_pembetulan_data_tidak_merubah_lagi');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'alamat'             => 'required|string',
            'uraian_pembetulan'  => 'required|string',
            'data_pendukung_1'   => 'nullable|string|max:255',
            'data_pendukung_2'   => 'nullable|string|max:255',
            'data_pendukung_3'   => 'nullable|string|max:255',
            'data_pendukung_4'   => 'nullable|string|max:255',
            'data_pendukung_5'   => 'nullable|string|max:255',
            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'nullable|string',
            'status_verif'       => 'nullable|string',
        ]);

        $payload = $validated;
        $this->maybeAssignNomorSurat(null, $payload);

        surat_pernyataan_pembetulan_data_tidak_merubah_lagi::create($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil disimpan.');
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'alamat'             => 'required|string',
            'uraian_pembetulan'  => 'required|string',
            'data_pendukung_1'   => 'nullable|string|max:255',
            'data_pendukung_2'   => 'nullable|string|max:255',
            'data_pendukung_3'   => 'nullable|string|max:255',
            'data_pendukung_4'   => 'nullable|string|max:255',
            'data_pendukung_5'   => 'nullable|string|max:255',
            'nowa'               => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_pernyataan_pembetulan_data_tidak_merubah_lagi::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit(surat_pernyataan_pembetulan_data_tidak_merubah_lagi $surat)
    {
        return view('surat.edit_surat_pernyataan_pembetulan_data_tidak_merubah_lagi', compact('surat'));
    }

    public function update(Request $request, surat_pernyataan_pembetulan_data_tidak_merubah_lagi $surat)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'alamat'             => 'required|string',
            'uraian_pembetulan'  => 'required|string',
            'data_pendukung_1'   => 'nullable|string|max:255',
            'data_pendukung_2'   => 'nullable|string|max:255',
            'data_pendukung_3'   => 'nullable|string|max:255',
            'data_pendukung_4'   => 'nullable|string|max:255',
            'data_pendukung_5'   => 'nullable|string|max:255',
            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'nullable|string',
            'status_verif'       => 'nullable|string',
        ]);

        $this->maybeAssignNomorSurat($surat, $validated);
        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(surat_pernyataan_pembetulan_data_tidak_merubah_lagi $surat)
    {
        $surat->delete();
        return back()->with('success', 'Surat berhasil dihapus.');
    }
}
