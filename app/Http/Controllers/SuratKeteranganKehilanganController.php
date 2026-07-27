<?php

namespace App\Http\Controllers;

use App\Models\surat_keterangan_kehilangan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\NomorSuratService;

class SuratKeteranganKehilanganController extends Controller
{
    public function __construct(private NomorSuratService $svc) {}

    /**
     * Assign nomor surat kalau status "Di terima" + "Terverifikasi"
     */
    /**
     * Cek & assign nomor_surat bila eligible.
     */
    protected function maybeAssignNomorSurat($sktmOrNull, array &$payload): void
    {
        $status = $payload['status_surat'] ?? ($sktmOrNull->status_surat ?? null);
        $verif  = $payload['status_verif'] ?? ($sktmOrNull->status_verif ?? null);

        if (
            $status === 'Di terima' && $verif === 'Terverifikasi'
            && empty($payload['nomor_surat'])
            && empty($sktmOrNull?->nomor_surat)
        ) {
            $tahun = now('Asia/Jakarta')->year;

            // Perbaikan: gunakan nextGlobal() dan sertakan jenis surat 'sktm' pada method format()
            $urut  = $this->svc->nextGlobal();
            $payload['nomor_urut']  = $urut;
            $payload['tahun_nomor'] = $tahun;
            $payload['nomor_surat'] = $this->svc->format('sktm', $urut, $tahun);
        }
    }
    /** List arsip/admin */
    public function index()
    {
        $data = surat_keterangan_kehilangan::orderBy('_id', 'desc')->get();
        return view('surat.surat_keterangan_kehilangan', compact('data'));
    }

    /** Form user */
    public function userkehilangan()
    {
        return view('surat.user_pengajuan_keterangan_kehilangan');
    }

    /** Export PDF */
    public function exportPdf($id)
    {
        $data = surat_keterangan_kehilangan::findOrFail($id);

        $pdf = Pdf::loadView('surat.pdfsuratketerangankehilangan', compact('data'))
            ->setPaper('a4', 'portrait');

        $filename = 'surat_keterangan_kehilangan_' . preg_replace('/[^A-Za-z0-9\-]/', '_', (string)$data->_id) . '.pdf';

        return $pdf->download($filename);
    }

    /** Store (admin) */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nowa' => 'required|string|max:20',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
            'nama_pelapor' => 'required|string|max:255',
            'tempat_lahir_pelapor' => 'required|string|max:100',
            'tanggal_lahir_pelapor' => 'required|date',
            'jenis_kelamin_pelapor' => 'required|in:Laki-laki,Perempuan',
            'nik_pelapor' => 'required|string|max:50',
            'agama_pelapor' => 'required|string|max:100',
            'status_pelapor' => 'required|string|max:100',
            'pekerjaan_pelapor' => 'required|string|max:100',
            'alamat_pelapor' => 'required|string',
            'jenis_kehilangan' => 'required|string|max:100',
            'atas_nama' => 'required|string|max:255',
            'berisi' => 'required|string|max:255',
            'tanggal_kehilangan' => 'required|date',
            'hilang_saat' => 'required|string|max:255',
        ]);

        $payload = $validated;
        // admin bisa langsung dapat nomor (kalau status/verify memenuhi)
        $this->maybeAssignNomorSurat(null, $payload);

        surat_keterangan_kehilangan::create($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat Kehilangan berhasil dibuat.');
    }

    /** Store (user) */
    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nowa' => 'required|string|max:20',
            'status_surat' => 'nullable|string',
            'status_verif' => 'nullable|string',
            'nama_pelapor' => 'required|string|max:255',
            'tempat_lahir_pelapor' => 'required|string|max:100',
            'tanggal_lahir_pelapor' => 'required|date',
            'jenis_kelamin_pelapor' => 'required|in:Laki-laki,Perempuan',
            'nik_pelapor' => 'required|string|max:50',
            'agama_pelapor' => 'required|string|max:100',
            'status_pelapor' => 'required|string|max:100',
            'pekerjaan_pelapor' => 'required|string|max:100',
            'alamat_pelapor' => 'required|string',
            'jenis_kehilangan' => 'required|string|max:100',
            'atas_nama' => 'required|string|max:255',
            'berisi' => 'required|string|max:255',
            'tanggal_kehilangan' => 'required|date',
            'hilang_saat' => 'required|string|max:255',
        ]);

        $payload = array_merge($validated, [
            'status_surat' => $validated['status_surat'] ?? 'Pending',
            'status_verif' => $validated['status_verif'] ?? 'Belum Verifikasi',
        ]);

        // user tidak di-assign nomor dulu
        surat_keterangan_kehilangan::create($payload);

        return redirect()->route('surat.suratberhasil')->with('success', 'Pengajuan Surat Kehilangan berhasil dikirim.');
    }

    /** Edit */
    public function edit(surat_keterangan_kehilangan $surat_keterangan_kehilangan)
    {
        return view('surat.edit_surat_keterangan_kehilangan', compact('surat_keterangan_kehilangan'));
    }

    /** Update */
    public function update(Request $request, surat_keterangan_kehilangan $surat_keterangan_kehilangan)
    {
        $validated = $request->validate([
            'nowa' => 'required|string|max:20',
            'status_surat' => 'required|string',
            'status_verif' => 'required|string',
            'nama_pelapor' => 'required|string|max:255',
            'tempat_lahir_pelapor' => 'required|string|max:100',
            'tanggal_lahir_pelapor' => 'required|date',
            'jenis_kelamin_pelapor' => 'required|in:Laki-laki,Perempuan',
            'nik_pelapor' => 'required|string|max:50',
            'agama_pelapor' => 'required|string|max:100',
            'status_pelapor' => 'required|string|max:100',
            'pekerjaan_pelapor' => 'required|string|max:100',
            'alamat_pelapor' => 'required|string',
            'jenis_kehilangan' => 'required|string|max:100',
            'atas_nama' => 'required|string|max:255',
            'berisi' => 'required|string|max:255',
            'tanggal_kehilangan' => 'required|date',
            'hilang_saat' => 'required|string|max:255',
        ]);

        $payload = $validated;

        // assign nomor jika baru lolos
        $this->maybeAssignNomorSurat($surat_keterangan_kehilangan, $payload);

        $surat_keterangan_kehilangan->update($payload);

        return redirect()->route('surat.keluar')->with('success', 'Surat Kehilangan berhasil diperbarui.');
    }

    public function destroy(surat_keterangan_kehilangan $surat)
    {
        $surat->delete();
        return back()->with('success', 'Surat Kehilangan berhasil dihapus.');
    }
}
