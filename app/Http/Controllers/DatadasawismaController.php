<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\datapenduduk;
use App\Models\User;
use App\Models\datadasawisma;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class DatadasawismaController extends Controller
{
    public function index(Request $request)
    {
        return view('datadasawisma.datadw');
    }

    public function index_admin(Request $request)
    {
        return view('datadasawisma.admindatadw');
    }

    public function add(Request $request)
    {
        // ➜ Tampilan TAMBAH = Code A
        return view('datadasawisma.tambahdw', [
            'isEdit'    => false,
            'nik'       => null,
            'valNIK'    => old('ValNIK', ''),
            'valNama'   => old('nama', ''),
            'valAlamat' => old('alamat', ''),
            'valRT'     => old('rt', ''),
            'valRW'     => old('rw', ''),
            'valEmail'  => old('email', ''),
            'valRole'   => old('role', 'dasawisma'),
        ]);
    }

    public function json(Request $request)
    {
        $allowedDatakValues = ['tetap', 'tidaktetap'];

        if ($request->has('nik')) {
            $nik = $request->input('nik');
            $query = Datapenduduk::with(['kk', 'agama', 'pendidikan', 'pekerjaan', 'goldar', 'status', 'detailkk.kk'])
                ->where('nik', $nik)
                ->whereIn('datak', $allowedDatakValues);
        } else {
            $query = Datapenduduk::whereNull('nik');
        }

        return DataTables::of($query)
            ->addColumn('nokk', fn($row) => optional(optional($row->detailkk)->kk)->nokk)
            ->addColumn('action', function ($row) {
                $editUrl = route('dasawisma.show', ['nik' => $row->nik]);
                // Hanya tombol Edit; tombol Delete DIHILANGKAN untuk semua role
                return '<a href="' . e($editUrl) . '" class="btn mb-1 btn-info btn-sm" title="Edit data"><i class="fas fa-edit"></i></a>';
            })
            ->addColumn('statusdw', fn(Datapenduduk $item) => $item && $item->user_id == null ? 'dasawisma' : 'penduduk')
            ->rawColumns(['action'])
            ->toJson();
    }


    public function jsonadmin(Request $request)
    {
        $allowedDatakValues = ['tetap', 'tidaktetap'];

        $query = Datapenduduk::with(['agama', 'pendidikan', 'pekerjaan', 'goldar', 'status', 'detailkk.kk', 'user'])
            ->whereIn('datak', $allowedDatakValues)
            ->whereHas('user', fn($q) => $q->where('role', 'dasawisma'));

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('nokk', fn($row) => optional(optional($row->detailkk)->kk)->nokk)
            ->addColumn('action', function ($row) {
                $editUrl = route('dasawisma.show', ['nik' => $row->nik]);
                // Hanya tombol Edit; tombol Delete DIHILANGKAN untuk semua role
                return '<a href="' . e($editUrl) . '" class="btn mb-1 btn-info btn-sm" title="Edit data"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    /** Simpan akun dasawisma baru & tautkan ke datapenduduk */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ValNIK'   => ['required', 'digits_between:8,20', 'exists:datapenduduks,nik'],
            'nama'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'ValNIK.required'       => 'NIK wajib diisi.',
            'ValNIK.digits_between' => 'Format NIK tidak valid.',
            'ValNIK.exists'         => 'NIK tidak ditemukan pada data penduduk.',
            'nama.required'         => 'Nama wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($validated) {
            $penduduk = Datapenduduk::where('nik', $validated['ValNIK'])->lockForUpdate()->first();

            if (!$penduduk) {
                throw ValidationException::withMessages(['ValNIK' => 'Data penduduk tidak ditemukan.']);
            }
            if (!is_null($penduduk->user_id)) {
                throw ValidationException::withMessages(['ValNIK' => 'NIK ini sudah terdaftar sebagai pengguna.']);
            }
            if (User::where('nik', $penduduk->nik)->exists()) {
                throw ValidationException::withMessages(['ValNIK' => 'Sudah ada akun dengan NIK ini.']);
            }

            $user = User::create([
                'nik'      => $penduduk->nik,
                'name'     => $validated['nama'],
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'dasawisma',
            ]);

            $penduduk->user_id = $user->id;
            $penduduk->save();
        });

        return redirect()->route('dasawisma.index_admin')
            ->with('msg', 'Berhasil menambahkan akun Dasawisma dan menautkannya ke data penduduk.');
    }

    /** API tombol "Cari" NIK → balikan JSON untuk autofill */
    public function findPendudukByNik(Request $request)
    {
        $validated = $request->validate(
            [
                'nik' => [
                    'required',
                    'digits:16',
                ],

                'current_nik' => [
                    'nullable',
                    'digits:16',
                ],
            ],
            [
                'nik.required' => 'NIK wajib diisi.',
                'nik.digits' => 'NIK harus terdiri dari tepat 16 digit.',
                'current_nik.digits' =>
                'NIK akun saat ini tidak valid.',
            ]
        );

        $nik = trim($validated['nik']);

        $currentNik = isset($validated['current_nik'])
            ? trim($validated['current_nik'])
            : null;

        $penduduk = Datapenduduk::query()
            ->where('nik', $nik)
            ->first();

        if (!$penduduk) {
            return response()->json(
                [
                    'ok' => false,
                    'message' =>
                    'NIK tidak ditemukan pada data penduduk.',
                ],
                404
            );
        }

        /*
     * Cari akun yang saat ini sedang diedit.
     */
        $currentUser = null;

        if ($currentNik) {
            $currentUser = User::query()
                ->where('nik', $currentNik)
                ->first();
        }

        /*
     * Periksa apakah target NIK sudah digunakan akun lain.
     */
        $targetUser = User::query()
            ->where('nik', $nik)
            ->first();

        if (
            $targetUser &&
            (!$currentUser || $targetUser->id !== $currentUser->id)
        ) {
            return response()->json(
                [
                    'ok' => false,
                    'message' =>
                    'NIK ini sudah digunakan oleh akun pengguna lain.',
                ],
                409
            );
        }

        /*
     * Periksa tautan user_id pada penduduk target.
     */
        if (
            !is_null($penduduk->user_id) &&
            (!$currentUser || $penduduk->user_id !== $currentUser->id)
        ) {
            return response()->json(
                [
                    'ok' => false,
                    'message' =>
                    'Penduduk ini sudah terdaftar sebagai anggota pengguna lain.',
                ],
                409
            );
        }

        return response()->json(
            [
                'ok' => true,

                'data' => [
                    'id' => $penduduk->id,
                    'nik' => $penduduk->nik,
                    'nama' => $penduduk->nama ?? '',
                    'alamat' => $penduduk->alamat ?? '',
                    'rt' => $penduduk->rt
                        ?? $penduduk->RT
                        ?? '',
                    'rw' => $penduduk->rw
                        ?? $penduduk->RW
                        ?? '',
                ],
            ],
            200
        );
    }



    public function show($nik)
    {
        $penduduk = Datapenduduk::query()
            ->with('user')
            ->where('nik', $nik)
            ->firstOrFail();

        /*
     * Prioritaskan akun dari relasi user_id.
     * Fallback berdasarkan NIK untuk data lama.
     */
        $user = $penduduk->user;

        if (!$user) {
            $user = User::query()
                ->where('nik', $nik)
                ->first();
        }

        return view('datadasawisma.editdatadw', [
            'nik'       => $nik,
            'penduduk'  => $penduduk,
            'user'      => $user,
            'valNIK'    => $penduduk->nik ?? '',
            'valNama'   => $penduduk->nama ?? '',
            'valAlamat' => $penduduk->alamat ?? '',
            'valRT'     => $penduduk->rt ?? $penduduk->RT ?? '',
            'valRW'     => $penduduk->rw ?? $penduduk->RW ?? '',
            'valEmail'  => $user?->email ?? '',
            'valRole'   => $user?->role ?? 'dasawisma',
        ]);
    }


    public function update(Request $request, $nik)
    {
        $pendudukLama = Datapenduduk::query()
            ->where('nik', $nik)
            ->firstOrFail();

        /*
     * Temukan akun Dasawisma yang sedang diedit.
     */
        $user = null;

        if ($pendudukLama->user_id) {
            $user = User::query()
                ->find($pendudukLama->user_id);
        }

        if (!$user) {
            $user = User::query()
                ->where('nik', $nik)
                ->first();
        }

        if (!$user) {
            throw ValidationException::withMessages([
                'ValNIK' =>
                'Akun Dasawisma tidak ditemukan.',
            ]);
        }

        $validated = $request->validate(
            [
                'ValNIK' => [
                    'required',
                    'digits:16',
                    'exists:datapenduduks,nik',

                    Rule::unique('users', 'nik')
                        ->ignore($user->id),
                ],

                'email' => [
                    'required',
                    'email',
                    'max:255',

                    Rule::unique('users', 'email')
                        ->ignore($user->id),
                ],

                /*
             * Password tidak wajib pada edit.
             */
                'password' => [
                    'nullable',
                    'string',
                    'min:6',
                    'confirmed',
                ],
            ],
            [
                'ValNIK.required' =>
                'NIK wajib diisi.',

                'ValNIK.digits' =>
                'NIK harus terdiri dari tepat 16 digit.',

                'ValNIK.exists' =>
                'NIK tidak ditemukan pada data penduduk.',

                'ValNIK.unique' =>
                'NIK sudah digunakan oleh akun lain.',

                'email.required' =>
                'Email wajib diisi.',

                'email.email' =>
                'Format email tidak valid.',

                'email.unique' =>
                'Email sudah digunakan oleh akun lain.',

                'password.min' =>
                'Password minimal 6 karakter.',

                'password.confirmed' =>
                'Konfirmasi password tidak sama.',
            ]
        );

        DB::transaction(function () use (
            $pendudukLama,
            $user,
            $validated
        ): void {
            $pendudukLama = Datapenduduk::query()
                ->whereKey($pendudukLama->id)
                ->lockForUpdate()
                ->firstOrFail();

            $user = User::query()
                ->whereKey($user->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
         * Penduduk yang dipilih melalui pencarian NIK.
         */
            $pendudukBaru = Datapenduduk::query()
                ->where('nik', $validated['ValNIK'])
                ->lockForUpdate()
                ->firstOrFail();

            /*
         * Pastikan NIK target tidak dimiliki akun lain.
         */
            $akunLain = User::query()
                ->where('nik', $validated['ValNIK'])
                ->where('id', '!=', $user->id)
                ->exists();

            if ($akunLain) {
                throw ValidationException::withMessages([
                    'ValNIK' =>
                    'NIK sudah digunakan oleh akun lain.',
                ]);
            }

            /*
         * Pastikan penduduk target belum tertaut ke user lain.
         */
            if (
                !is_null($pendudukBaru->user_id) &&
                $pendudukBaru->user_id !== $user->id
            ) {
                throw ValidationException::withMessages([
                    'ValNIK' =>
                    'Penduduk tersebut sudah terdaftar sebagai pengguna lain.',
                ]);
            }

            /*
         * Jika NIK berubah, lepaskan akun dari penduduk lama.
         */
            if (
                $pendudukLama->id !== $pendudukBaru->id &&
                $pendudukLama->user_id === $user->id
            ) {
                $pendudukLama->user_id = null;
                $pendudukLama->save();
            }

            /*
         * Data akun mengikuti penduduk hasil autofill.
         */
            $user->nik = $pendudukBaru->nik;
            $user->name = $pendudukBaru->nama;
            $user->email = strtolower(
                trim($validated['email'])
            );

            $user->role = 'dasawisma';

            /*
         * Password hanya diperbarui apabila diisi.
         */
            if (!empty($validated['password'])) {
                $user->password = Hash::make(
                    $validated['password']
                );
            }

            $user->save();

            /*
         * Tautkan penduduk baru ke akun Dasawisma.
         */
            $pendudukBaru->user_id = $user->id;
            $pendudukBaru->save();
        }, 3);

        return redirect()
            ->route('dasawisma.index_admin')
            ->with(
                'msg',
                'Data Dasawisma berhasil diperbarui.'
            );
    }

    public function destroy($nik)
    {
        $penduduk = Datapenduduk::where('nik', $nik)->firstOrFail();
        $user     = User::where('nik', $nik)->first();

        if ($user) $user->delete();

        $penduduk->user_id = null;
        // Hanya set role kalau kolomnya memang ada di tabel Datapenduduk
        if (isset($penduduk->role)) {
            $penduduk->role = 'penduduk';
        }
        $penduduk->save();

        return redirect()->route('dasawisma.index')->with('success', 'Data berhasil dihapus');
    }
}
