<?php
namespace App\Http\Controllers;

use App\Models\status;
use App\Models\surat_keterangan_ahli_waris_desa;
use Illuminate\Http\Request;

class SuratKeteranganAhliWarisDesaController extends Controller
{
    public function index()
    {
        $status = Status::all();
        return view('surat.surat_keterangan_ahli_waris_desa', compact('status'));
    }

    public function user_ahliwaris_desa()
    {
        $status = Status::all();
        return view('surat.user_surat_keterangan_ahli_waris_desa', compact('status'));
    }

    public function userstore(Request $request)
    {
        $validated = $request->validate([
            'nama_almarhum' => 'required|string|max:255',
            'tanggal_meninggal' => 'required|date',
            'hari_meninggal' => 'required|string',
            'tempat_meninggal' => 'required|string|max:255',
            'nomor_surat_kematian' => 'required|string',
            'tanggal_surat_kematian' => 'required|date',
            'ahli_waris' => 'required|array',
            'simpanan_nama' => 'required|string',
            'simpanan_jenis' => 'required|string',
            'simpanan_rekening' => 'required|string',
            'status_surat' => 'nullable|string',
            'status_verif' => 'nullable|string',
            'nowa' => 'required|string|max:20',
        ]);

        surat_keterangan_ahli_waris_desa::create($validated);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Surat Keterangan Ahli Waris Desa berhasil dibuat.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_almarhum' => 'required|string|max:255',
            'tanggal_meninggal' => 'required|date',
            'hari_meninggal' => 'required|string',
            'tempat_meninggal' => 'required|string|max:255',
            'nomor_surat_kematian' => 'required|string',
            'tanggal_surat_kematian' => 'required|date',
            'ahli_waris' => 'required|array',
            'simpanan_nama' => 'required|string',
            'simpanan_jenis' => 'required|string',
            'simpanan_rekening' => 'required|string',
            'status_surat' => 'nullable|string',
            'status_verif' => 'nullable|string',
            'nowa' => 'required|string|max:20',
        ]);

        surat_keterangan_ahli_waris_desa::create($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Ahli Waris Desa berhasil dibuat.');
    }

    public function edit(surat_keterangan_ahli_waris_desa $surat)
    {
        $status = status::all();
        return view('surat.edit_surat_keterangan_ahli_waris_desa', compact('surat', 'status'));
    }

    public function update(Request $request, surat_keterangan_ahli_waris_desa $surat)
    {
        $validated = $request->validate([
            'nama_almarhum' => 'required|string|max:255',
            'tanggal_meninggal' => 'required|date',
            'hari_meninggal' => 'required|string',
            'tempat_meninggal' => 'required|string|max:255',
            'nomor_surat_kematian' => 'required|string',
            'tanggal_surat_kematian' => 'required|date',
            'ahli_waris' => 'required|array',
            'simpanan_nama' => 'required|string',
            'simpanan_jenis' => 'required|string',
            'simpanan_rekening' => 'required|string',
            'status_surat' => 'nullable|string',
            'status_verif' => 'nullable|string',
            'nowa' => 'required|string|max:20',
        ]);

        $surat->update($validated);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Ahli Waris Desa berhasil diperbarui.');
    }
}
