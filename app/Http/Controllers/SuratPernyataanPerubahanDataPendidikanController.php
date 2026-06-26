<?php

namespace App\Http\Controllers;

use App\Models\pendidikan;
use App\Models\surat_pernyataan_perubahan_data_pendidikan;
use Illuminate\Http\Request;
use App\Services\NomorSuratService;

class SuratPernyataanPerubahanDataPendidikanController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    protected function maybeAssignNomorSurat($suratOrNull, array &$payload): void
    {
        $this->svc->maybeAssignNomorSurat($suratOrNull, $payload, 'perubahdatapendidikan');
    }

    public function index()
    {
        $pendidikan = pendidikan::orderBy('nama')->get();

        return view('surat.surat_pernyataan_perubahan_data_pendidikan', compact('pendidikan'));
    }

    public function user()
    {
        $pendidikan = Pendidikan::orderBy('nama')->get();

        return view('surat.user_surat_pernyataan_perubahan_data_pendidikan', compact('pendidikan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'ttl_tempat'         => 'nullable|string|max:100',
            'ttl_tanggal'        => 'nullable|date',
            'pekerjaan'          => 'nullable|string|max:100',
            'alamat'             => 'required|string',

            'nama_subjek'        => 'required|string|max:255',
            'nik_subjek'         => 'nullable|string|max:32',

            'pendidikan_lama'    => 'required|string|max:255',
            'pendidikan_baru'    => 'required|string|max:255',
            'alasan_perubahan'   => 'required|string',

            // Field Baru
            'jenis_data_pendukung'   => 'nullable|string|max:255',
            'nomor_dokumen_pendukung' => 'nullable|string|max:255',
            'tanggal_diterbitkan'    => 'nullable|date',
            'instansi_penerbit'      => 'nullable|string|max:255',

            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'nullable|string',
            'status_verif'       => 'nullable|string',
        ]);

        $payload = $validated;
        $this->maybeAssignNomorSurat(null, $payload);

        surat_pernyataan_perubahan_data_pendidikan::create($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil disimpan.');
    }

    // ==================== STORE USER ====================
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'ttl_tempat'         => 'nullable|string|max:100',
            'ttl_tanggal'        => 'nullable|date',
            'pekerjaan'          => 'nullable|string|max:100',
            'alamat'             => 'required|string',

            'nama_subjek'        => 'required|string|max:255',
            'nik_subjek'         => 'nullable|string|max:32',

            'pendidikan_lama'    => 'required|string|max:255',
            'pendidikan_baru'    => 'required|string|max:255',
            'alasan_perubahan'   => 'required|string',

            'jenis_data_pendukung'   => 'nullable|string|max:255',
            'nomor_dokumen_pendukung' => 'nullable|string|max:255',
            'tanggal_diterbitkan'    => 'nullable|date',
            'instansi_penerbit'      => 'nullable|string|max:255',

            'nowa' => 'required|string|max:20',
        ]);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        surat_pernyataan_perubahan_data_pendidikan::create($validated);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function edit(surat_pernyataan_perubahan_data_pendidikan $surat)
    {
        return view('surat.edit_surat_pernyataan_perubahan_data_pendidikan', compact('surat'));
    }

    public function update(Request $request, surat_pernyataan_perubahan_data_pendidikan $surat)
    {
        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'nik'                => 'required|string|max:32',
            'ttl_tempat'         => 'nullable|string|max:100',
            'ttl_tanggal'        => 'nullable|date',
            'pekerjaan'          => 'nullable|string|max:100',
            'alamat'             => 'required|string',

            'nama_subjek'        => 'required|string|max:255',
            'nik_subjek'         => 'nullable|string|max:32',

            'pendidikan_lama'    => 'required|string|max:255',
            'pendidikan_baru'    => 'required|string|max:255',
            'alasan_perubahan'   => 'required|string',

            'jenis_data_pendukung'   => 'nullable|string|max:255',
            'nomor_dokumen_pendukung' => 'nullable|string|max:255',
            'tanggal_diterbitkan'    => 'nullable|date',
            'instansi_penerbit'      => 'nullable|string|max:255',

            'nowa'               => 'required|string|max:20',
            'status_surat'       => 'nullable|string',
            'status_verif'       => 'nullable|string',
        ]);

        $this->maybeAssignNomorSurat($surat, $validated);
        $surat->update($validated);

        return redirect()->route('surat.keluar')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(surat_pernyataan_perubahan_data_pendidikan $surat)
    {
        $surat->delete();
        return back()->with('success', 'Surat berhasil dihapus.');
    }
}
