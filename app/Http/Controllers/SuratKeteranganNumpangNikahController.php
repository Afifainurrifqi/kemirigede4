<?php

namespace App\Http\Controllers;

use App\Models\surat_keterangan_numpang_nikah;
use Illuminate\Http\Request;

class SuratKeteranganNumpangNikahController extends Controller
{
    public function index()
    {
        return view('surat.surat_keterangan_numpang_nikah');
    }

    public function create()
    {
        return view('surat.surat_keterangan_numpang_nikah');
    }

    public function user_numpang_nikah()
    {
        return view('surat.user_surat_keterangan_numpang_nikah');
    }

    protected function rules(bool $isAdmin = false): array
    {
        $rules = [
            'nik' => ['required', 'string', 'max:32'],
            'nama' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string', 'max:50'],
            'pekerjaan' => ['required', 'string', 'max:100'],
            'status_perkawinan' => ['required', 'string', 'max:50'],
            'alamat' => ['required', 'string'],

            'keperluan' => ['required', 'string', 'max:255'],
            'alamat_tujuan' => ['required', 'string'],
            'mulai_berangkat' => ['required', 'date'],
            'pembawaan' => ['required', 'string', 'max:255'],

            'jumlah_pengikut' => ['nullable', 'integer', 'min:0'],
            'nama_pengikut' => ['nullable', 'array'],
            'nama_pengikut.*' => ['nullable', 'string', 'max:255'],
            'umur_pengikut' => ['nullable', 'array'],
            'umur_pengikut.*' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin_pengikut' => ['nullable', 'array'],
            'jenis_kelamin_pengikut.*' => ['nullable', 'string', 'max:30'],
            'hubungan_keluarga_pengikut' => ['nullable', 'array'],
            'hubungan_keluarga_pengikut.*' => ['nullable', 'string', 'max:100'],
            'keterangan_pengikut' => ['nullable', 'array'],
            'keterangan_pengikut.*' => ['nullable', 'string', 'max:255'],

            'nowa' => ['required', 'string', 'max:20'],
        ];

        if ($isAdmin) {
            $rules['status_surat'] = ['required', 'string', 'in:Pending,Di cek,Di terima,Ditolak'];
            $rules['status_verif'] = ['required', 'string', 'in:Belum Verifikasi,Terverifikasi'];
        }

        return $rules;
    }

    protected function normalizePengikut(array &$payload): void
    {
        $jumlah = (int) ($payload['jumlah_pengikut'] ?? 0);

        $nama = $payload['nama_pengikut'] ?? [];
        $umur = $payload['umur_pengikut'] ?? [];
        $jk = $payload['jenis_kelamin_pengikut'] ?? [];
        $hub = $payload['hubungan_keluarga_pengikut'] ?? [];
        $ket = $payload['keterangan_pengikut'] ?? [];

        $payload['nama_pengikut'] = [];
        $payload['umur_pengikut'] = [];
        $payload['jenis_kelamin_pengikut'] = [];
        $payload['hubungan_keluarga_pengikut'] = [];
        $payload['keterangan_pengikut'] = [];

        for ($i = 0; $i < $jumlah; $i++) {
            $payload['nama_pengikut'][] = $nama[$i] ?? '';
            $payload['umur_pengikut'][] = $umur[$i] ?? '';
            $payload['jenis_kelamin_pengikut'][] = $jk[$i] ?? '';
            $payload['hubungan_keluarga_pengikut'][] = $hub[$i] ?? '';
            $payload['keterangan_pengikut'][] = $ket[$i] ?? '';
        }
    }

    protected function maybeAssignNomorSurat(?surat_keterangan_numpang_nikah $surat, array &$payload): void
    {
        $status = $payload['status_surat'] ?? ($surat->status_surat ?? null);
        $verif = $payload['status_verif'] ?? ($surat->status_verif ?? null);

        if (
            $status === 'Di terima'
            && $verif === 'Terverifikasi'
            && empty($payload['nomor_surat'])
            && empty($surat?->nomor_surat)
        ) {
            $tahun = now('Asia/Jakarta')->year;

            $last = surat_keterangan_numpang_nikah::where('tahun_nomor', $tahun)
                ->orderBy('nomor_urut', 'desc')
                ->first();

            $urut = ((int) ($last->nomor_urut ?? 0)) + 1;

            $payload['nomor_urut'] = $urut;
            $payload['tahun_nomor'] = $tahun;
            $payload['nomor_surat'] = '474.2 / ' . str_pad($urut, 3, '0', STR_PAD_LEFT) . ' / 409.41.2 / ' . $tahun;
        }
    }

    public function store(Request $request)
    {
        $payload = $request->validate($this->rules(isAdmin: true));

        $this->normalizePengikut($payload);
        $this->maybeAssignNomorSurat(null, $payload);

        surat_keterangan_numpang_nikah::create($payload);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Numpang Nikah berhasil disimpan.');
    }

    public function userstore(Request $request)
    {
        $payload = $request->validate($this->rules(isAdmin: false));

        $payload['status_surat'] = 'Pending';
        $payload['status_verif'] = 'Belum Verifikasi';

        $this->normalizePengikut($payload);

        surat_keterangan_numpang_nikah::create($payload);

        return redirect()->route('surat.suratberhasil')
            ->with('success', 'Pengajuan Surat Keterangan Numpang Nikah berhasil dikirim.');
    }

    public function edit(surat_keterangan_numpang_nikah $surat)
    {
        return view('surat.edit_surat_keterangan_numpang_nikah', compact('surat'));
    }

    public function update(Request $request, surat_keterangan_numpang_nikah $surat)
    {
        $payload = $request->validate($this->rules(isAdmin: true));

        $this->normalizePengikut($payload);
        $this->maybeAssignNomorSurat($surat, $payload);

        $surat->update($payload);

        return redirect()->route('surat.keluar')
            ->with('success', 'Surat Keterangan Numpang Nikah berhasil diperbarui.');
    }

    public function destroy(surat_keterangan_numpang_nikah $surat)
    {
        $surat->delete();

        return back()->with('success', 'Surat Keterangan Numpang Nikah berhasil dihapus.');
    }
}
