<?php

namespace App\Http\Controllers;

use App\Models\SuratPerintahTugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SuratPerintahTugasController extends Controller
{
    /**
     * Form admin.
     */
    public function index(): View
    {
        return view('surat.surat_perintah_tugas');
    }

    /**
     * Form user.
     */
    public function userForm(): View
    {
        return view('surat.user_surat_perintah_tugas');
    }

    /**
     * Simpan pengajuan dari user.
     */
    public function userstore(Request $request): RedirectResponse
    {
        $validated = $this->validateSurat($request, false);

        $validated['status_surat'] = 'Pending';
        $validated['status_verif'] = 'Belum Verifikasi';

        SuratPerintahTugas::create($validated);

        return redirect()
            ->route('surat.suratberhasil')
            ->with(
                'success',
                'Pengajuan Surat Perintah Tugas berhasil dikirim.'
            );
    }

    /**
     * Simpan surat dari admin.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSurat($request, true);

        SuratPerintahTugas::create($validated);

        return redirect()
            ->route('surat.keluar')->with(
                'success',
                'Surat Perintah Tugas berhasil dibuat.'
            );
    }

    /**
     * Halaman edit.
     *
     * Menggunakan ID eksplisit agar aman untuk MongoDB ObjectId.
     */
    public function edit(string $surat): View
    {
        $surat = SuratPerintahTugas::findOrFail($surat);

        return view('surat.edit_surat_perintah_tugas',compact('surat'));
    }

    /**
     * Perbarui surat.
     */
    public function update(
        Request $request,
        string $surat
    ): RedirectResponse {
        $surat = SuratPerintahTugas::findOrFail($surat);

        $validated = $this->validateSurat($request, true);

        $surat->update($validated);

        return redirect()
            ->route('surat.keluar')
            ->with(
                'success',
                'Surat Perintah Tugas berhasil diperbarui.'
            );
    }

    /**
     * Validasi data Surat Perintah Tugas.
     *
     * Struktur yang diterima:
     *
     * dasar[] = teks dasar surat
     *
     * penerima_tugas[0][nama]
     * penerima_tugas[0][kedudukan]
     *
     * penerima_tugas[1][nama]
     * penerima_tugas[1][kedudukan]
     *
     * untuk = uraian lengkap bagian "Untuk"
     */
    private function validateSurat(
        Request $request,
        bool $isAdmin
    ): array {
        $rules = [
            'dasar' => [
                'nullable',
                'array',
                'max:20',
            ],
            'dasar.*' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'penerima_tugas' => [
                'required',
                'array',
                'min:1',
                'max:50',
            ],
            'penerima_tugas.*.nama' => [
                'required',
                'string',
                'max:255',
            ],
            'penerima_tugas.*.kedudukan' => [
                'required',
                'string',
                'max:255',
            ],

            'untuk' => [
                'required',
                'string',
                'max:5000',
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
                'dasar.array' =>
                'Dasar surat harus berbentuk daftar.',
                'dasar.max' =>
                'Maksimal 20 dasar surat.',
                'dasar.*.string' =>
                'Setiap dasar surat harus berupa teks.',

                'penerima_tugas.required' =>
                'Minimal satu penerima tugas wajib diisi.',
                'penerima_tugas.array' =>
                'Data penerima tugas tidak valid.',
                'penerima_tugas.min' =>
                'Minimal satu penerima tugas wajib diisi.',
                'penerima_tugas.max' =>
                'Maksimal 50 penerima tugas.',
                'penerima_tugas.*.nama.required' =>
                'Nama setiap penerima tugas wajib diisi.',
                'penerima_tugas.*.kedudukan.required' =>
                'Kedudukan setiap penerima tugas wajib diisi.',

                'untuk.required' =>
                'Uraian bagian Untuk wajib diisi.',
                'untuk.max' =>
                'Uraian bagian Untuk terlalu panjang.',

                'nowa.required' =>
                'Nomor WhatsApp wajib diisi.',
                'nowa.regex' =>
                'Nomor WhatsApp tidak valid. Gunakan format 08..., 62..., atau +62....',
            ]
        );

        /**
         * Pemeriksaan tambahan untuk memastikan tidak ada pasangan
         * nama/kedudukan yang kosong atau tidak lengkap.
         */
        $validator->after(function ($validator) use ($request) {
            $penerima = (array) $request->input(
                'penerima_tugas',
                []
            );

            foreach ($penerima as $index => $item) {
                $nama = trim((string) ($item['nama'] ?? ''));
                $kedudukan = trim(
                    (string) ($item['kedudukan'] ?? '')
                );

                if ($nama === '' && $kedudukan === '') {
                    $validator->errors()->add(
                        "penerima_tugas.$index.nama",
                        'Data penerima tugas tidak boleh kosong.'
                    );
                }

                if ($nama !== '' && $kedudukan === '') {
                    $validator->errors()->add(
                        "penerima_tugas.$index.kedudukan",
                        'Kedudukan penerima tugas wajib diisi.'
                    );
                }

                if ($nama === '' && $kedudukan !== '') {
                    $validator->errors()->add(
                        "penerima_tugas.$index.nama",
                        'Nama penerima tugas wajib diisi.'
                    );
                }
            }
        });

        $validated = $validator->validate();

        /**
         * Bersihkan dasar yang kosong.
         */
        $validated['dasar'] = array_values(
            array_filter(
                array_map(
                    static fn($value) =>
                    trim((string) $value),
                    (array) ($validated['dasar'] ?? [])
                ),
                static fn($value) => $value !== ''
            )
        );

        /**
         * Rapikan data penerima tugas sebelum disimpan ke MongoDB.
         */
        $validated['penerima_tugas'] = array_values(
            array_map(
                static function (array $item): array {
                    return [
                        'nama' => trim(
                            (string) ($item['nama'] ?? '')
                        ),
                        'kedudukan' => trim(
                            (string) ($item['kedudukan'] ?? '')
                        ),
                    ];
                },
                $validated['penerima_tugas']
            )
        );

        /**
         * Rapikan teks bagian Untuk.
         */
        $validated['untuk'] = trim($validated['untuk']);

        return $validated;
    }
}
