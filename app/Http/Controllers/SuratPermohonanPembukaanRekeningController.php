<?php

namespace App\Http\Controllers;

use App\Models\surat_permohonan_pembukaan_rekening;
use App\Models\SuratPermohonanPembukaanRekening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuratPermohonanPembukaanRekeningController extends Controller
{
    /**
     * Halaman form admin.
     */
    public function index(): View
    {
        return view('surat.surat_permohonan_pembukaan_rekening');
    }

    /**
     * Halaman form user.
     */
    public function userForm(): View
    {
        return view('surat.user_surat_permohonan_pembukaan_rekening');
    }

    /**
     * Simpan pengajuan dari user.
     */
    public function userstore(Request $request): RedirectResponse
    {
        $validated = $this->validateSurat($request, false);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPermohonanPembukaanRekening::create($validated);

        return redirect()
            ->route('surat.suratberhasil')
            ->with(
                'success',
                'Pengajuan Permohonan Pembukaan Rekening berhasil dikirim.'
            );
    }

    /**
     * Simpan surat dari admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSurat($request, true);

        SuratPermohonanPembukaanRekening::create($validated);

        return redirect()
            ->route('surat.keluar')
            ->with(
                'success',
                'Surat Permohonan Pembukaan Rekening berhasil dibuat.'
            );
    }

    /**
     * Halaman edit admin.
     *
     * Menggunakan ID secara eksplisit agar aman untuk MongoDB ObjectId.
     */
    public function edit(string $surat): View
    {
        $surat =  SuratPermohonanPembukaanRekening::findOrFail($surat);

        return view('surat.edit_surat_permohonan_pembukaan_rekening',compact('surat')
        );
    }

    /**
     * Perbarui surat.
     */
    public function update(Request $request, string $surat): RedirectResponse
    {
        $surat =  SuratPermohonanPembukaanRekening::findOrFail($surat);

        $validated = $this->validateSurat($request, true);

        $surat->update($validated);

        return redirect()
            ->route('surat.keluar')
            ->with(
                'success',
                'Surat Permohonan Pembukaan Rekening berhasil diperbarui.'
            );
    }

    /**
     * Validasi data surat.
     *
     * Field disesuaikan langsung dengan $fillable pada model:
     * - kepada_nama_instansi
     * - kepada_alamat
     * - ybt_nama
     * - ybt_jabatan
     * - ybt_alamat
     * - rekening_atas_nama
     * - rekening_alamat
     * - berwenang_jumlah
     * - berwenang_nama[]
     * - berwenang_jabatan[]
     * - status_surat
     * - status_verif
     * - nowa
     */
    private function validateSurat(
        Request $request,
        bool $isAdmin
    ): array {
        $jumlahBerwenang = (int) $request->input('berwenang_jumlah', 0);

        $rules = [
            'kepada_nama_instansi' => [
                'required',
                'string',
                'max:255',
            ],
            'kepada_alamat' => [
                'required',
                'string',
                'max:1000',
            ],

            'ybt_nama' => [
                'required',
                'string',
                'max:255',
            ],
            'ybt_jabatan' => [
                'required',
                'string',
                'max:255',
            ],
            'ybt_alamat' => [
                'required',
                'string',
                'max:1000',
            ],

            'rekening_atas_nama' => [
                'required',
                'string',
                'max:255',
            ],
            'rekening_alamat' => [
                'required',
                'string',
                'max:1000',
            ],

            'berwenang_jumlah' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
            'berwenang_nama' => [
                'required',
                'array',
            ],
            'berwenang_nama.*' => [
                'required',
                'string',
                'max:255',
            ],
            'berwenang_jabatan' => [
                'required',
                'array',
            ],
            'berwenang_jabatan.*' => [
                'required',
                'string',
                'max:255',
            ],

            'nowa' => [
                'required',
                'string',
                'max:20',
                'regex:/^(?:\+62|62|0)8[1-9][0-9]{6,11}$/',
            ],
        ];

        if ($isAdmin) {
            $rules['status_surat'] = [
                'required',
                Rule::in([
                    'Pending',
                    'Di cek',
                    'Di terima',
                    'Selesai',
                    'Ditolak',
                ]),
            ];

            $rules['status_verif'] = [
                'required',
                Rule::in([
                    'Belum Verifikasi',
                    'Terverifikasi',
                    'Ditolak',
                ]),
            ];
        }

        $validator = Validator::make(
            $request->all(),
            $rules,
            [
                'berwenang_jumlah.required' =>
                'Jumlah pihak yang berwenang wajib diisi.',
                'berwenang_jumlah.min' =>
                'Minimal harus ada 1 pihak yang berwenang.',
                'berwenang_jumlah.max' =>
                'Maksimal 20 pihak yang berwenang.',
                'berwenang_nama.required' =>
                'Nama pihak yang berwenang wajib diisi.',
                'berwenang_nama.*.required' =>
                'Setiap nama pihak yang berwenang wajib diisi.',
                'berwenang_jabatan.required' =>
                'Jabatan pihak yang berwenang wajib diisi.',
                'berwenang_jabatan.*.required' =>
                'Setiap jabatan pihak yang berwenang wajib diisi.',
                'nowa.regex' =>
                'Nomor WhatsApp tidak valid. Gunakan format 08..., 62..., atau +62....',
            ]
        );

        /**
         * Pastikan jumlah elemen array sesuai dengan berwenang_jumlah.
         */
        $validator->after(function ($validator) use (
            $request,
            $jumlahBerwenang
        ) {
            $daftarNama = array_values(
                array_filter(
                    (array) $request->input('berwenang_nama', []),
                    static fn($value) => trim((string) $value) !== ''
                )
            );

            $daftarJabatan = array_values(
                array_filter(
                    (array) $request->input('berwenang_jabatan', []),
                    static fn($value) => trim((string) $value) !== ''
                )
            );

            if (
                $jumlahBerwenang > 0 &&
                count($daftarNama) !== $jumlahBerwenang
            ) {
                $validator->errors()->add(
                    'berwenang_nama',
                    'Jumlah nama pihak yang berwenang harus sesuai dengan jumlah yang dipilih.'
                );
            }

            if (
                $jumlahBerwenang > 0 &&
                count($daftarJabatan) !== $jumlahBerwenang
            ) {
                $validator->errors()->add(
                    'berwenang_jabatan',
                    'Jumlah jabatan pihak yang berwenang harus sesuai dengan jumlah yang dipilih.'
                );
            }

            if (count($daftarNama) !== count($daftarJabatan)) {
                $validator->errors()->add(
                    'berwenang_jabatan',
                    'Setiap nama pihak yang berwenang harus memiliki jabatan.'
                );
            }
        });

        $validated = $validator->validate();

        /**
         * Rapikan dan urutkan ulang array sebelum disimpan ke MongoDB.
         */
        $validated['berwenang_nama'] = array_values(
            array_map(
                static fn($value) => trim((string) $value),
                $validated['berwenang_nama']
            )
        );

        $validated['berwenang_jabatan'] = array_values(
            array_map(
                static fn($value) => trim((string) $value),
                $validated['berwenang_jabatan']
            )
        );

        /**
         * Pastikan jumlah selalu konsisten dengan data array yang disimpan.
         */
        $validated['berwenang_jumlah'] = count(
            $validated['berwenang_nama']
        );

        return $validated;
    }
}
