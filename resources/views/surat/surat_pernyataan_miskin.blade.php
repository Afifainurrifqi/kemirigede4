@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm">

                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Form Surat Pernyataan Miskin</h5>

                        {{-- <a href="{{ route('surat.pernyataan_miskin.index') }}"
                            class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a> --}}
                    </div>

                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Data belum dapat disimpan.</strong>

                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.pernyataan_miskin.store') }}"
                            method="POST"
                            id="formPernyataanMiskin">

                            @csrf

                            <h6 class="fw-bold mb-3">Data Pemohon</h6>

                            {{-- NIK --}}
                            <div class="mb-3">
                                <label for="nik" class="form-label">
                                    NIK <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="nik"
                                    id="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik') }}"
                                    maxlength="16"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                                    required>

                                @error('nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <small id="nikMessage" class="form-text text-muted">
                                    Masukkan 16 digit NIK, kemudian tekan Enter.
                                </small>
                            </div>

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    Nama Lengkap <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="nama"
                                    id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama') }}"
                                    placeholder="Masukkan nama lengkap"
                                    required>

                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tempat dan tanggal lahir --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">
                                        Tempat Lahir <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="tempat_lahir"
                                        id="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ old('tempat_lahir') }}"
                                        placeholder="Masukkan tempat lahir"
                                        required>

                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>

                                    <input type="date"
                                        name="tanggal_lahir"
                                        id="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir') }}"
                                        required>

                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $daftarPekerjaan = [
                                    'BELUM/TIDAK BEKERJA',
                                    'PELAJAR/MAHASISWA',
                                    'TIDAK/BELUM SEKOLAH',
                                    'KARYAWAN SWASTA',
                                    'IBU RUMAH TANGGA',
                                    'WIRASWASTA',
                                    'TENTARA NASIONAL INDONESIA (TNI)',
                                    'KEPOLISIAN RI (POLRI)',
                                    'DOSEN',
                                    'GURU',
                                    'Guru agama',
                                    'KEPALA DESA',
                                    'PERANGKAT DESA',
                                    'Pegawai Kantor Desa',
                                    'BIDAN',
                                    'DOKTER',
                                    'PERAWAT',
                                    'PETANI/PEKEBUN PEMILIK LAHAN',
                                    'PETANI/PEKEBUN',
                                    'BURUH TANI/PERKEBUNAN',
                                    'PEDAGANG',
                                    'PEGAWAI NEGERI SIPIL (PNS)',
                                    'BURUH HARIAN LEPAS',
                                    'SOPIR',
                                    'KARYAWAN BUMN',
                                    'PENSIUNAN',
                                    'PEMBANTU RUMAH TANGGA',
                                    'BURUH PETERNAKAN',
                                    'KONSTRUKSI',
                                    'PELAUT',
                                    'NELAYAN/PERIKANAN',
                                    'KARYAWAN HONORER',
                                    'PETERNAK',
                                    'MEKANIK',
                                    'PENATA RIAS',
                                    'TUKANG LAS/PANDAI BESI',
                                    'INDUSTRI',
                                    'USTADZ/MUBALIGH',
                                    'TABIB',
                                    'BURUH NELAYAN/PERIKANAN',
                                    'JURU MASAK',
                                    'SENIMAN',
                                    'AKUNTAN',
                                    'Petani/Pekebun penyewa',
                                    'TKI',
                                    'Lainnya',
                                ];
                            @endphp

                            {{-- Pekerjaan --}}
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">
                                    Pekerjaan <span class="text-danger">*</span>
                                </label>

                                <select name="pekerjaan"
                                    id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    required>

                                    <option value="">-- Pilih Pekerjaan --</option>

                                    @foreach ($daftarPekerjaan as $pekerjaan)
                                        <option value="{{ $pekerjaan }}"
                                            {{ old('pekerjaan') === $pekerjaan ? 'selected' : '' }}>
                                            {{ $pekerjaan }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    Alamat <span class="text-danger">*</span>
                                </label>

                                <textarea name="alamat"
                                    id="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    rows="3"
                                    placeholder="Masukkan alamat lengkap"
                                    required>{{ old('alamat') }}</textarea>

                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Nomor WhatsApp --}}
                            <div class="mb-3">
                                <label for="nowa" class="form-label">
                                    No. WhatsApp <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="nowa"
                                    id="nowa"
                                    class="form-control @error('nowa') is-invalid @enderror"
                                    value="{{ old('nowa') }}"
                                    maxlength="15"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    placeholder="Contoh: 081234567890"
                                    required>

                                @error('nowa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Status Pengajuan</h6>

                            <div class="row">
                                {{-- Status surat --}}
                                <div class="col-md-6 mb-3">
                                    <label for="status_surat" class="form-label">
                                        Status Surat <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_surat"
                                        id="status_surat"
                                        class="form-control @error('status_surat') is-invalid @enderror"
                                        required>

                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status_surat', 'Pending') === $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Status verifikasi --}}
                                <div class="col-md-6 mb-3">
                                    <label for="status_verif" class="form-label">
                                        Status Verifikasi <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_verif"
                                        id="status_verif"
                                        class="form-control @error('status_verif') is-invalid @enderror"
                                        required>

                                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verifikasi)
                                            <option value="{{ $verifikasi }}"
                                                {{ old('status_verif', 'Belum Verifikasi') === $verifikasi ? 'selected' : '' }}>
                                                {{ $verifikasi }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status_verif')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="text-end">
                                <a href="{{ route('surat.pernyataan_miskin.index') }}"
                                    class="btn btn-danger">
                                    Batal
                                </a>

                                <button type="submit"
                                    class="btn btn-primary"
                                    id="btnSubmit">
                                    <i class="bi bi-save"></i>
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const nikMessage = document.getElementById('nikMessage');
            const namaInput = document.getElementById('nama');
            const tempatLahirInput = document.getElementById('tempat_lahir');
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const pekerjaanSelect = document.getElementById('pekerjaan');
            const alamatInput = document.getElementById('alamat');
            const nowaInput = document.getElementById('nowa');
            const form = document.getElementById('formPernyataanMiskin');
            const btnSubmit = document.getElementById('btnSubmit');

            let sedangMencari = false;

            function setNikMessage(message, type = 'muted') {
                if (!nikMessage) {
                    return;
                }

                nikMessage.textContent = message;
                nikMessage.className = 'form-text text-' + type;
            }

            /**
             * Menyamakan huruf, spasi, dan penulisan garis miring.
             */
            function normalisasiPekerjaan(value) {
                return String(value ?? '')
                    .trim()
                    .toUpperCase()
                    .replace(/\s*\/\s*/g, '/')
                    .replace(/\s+/g, ' ');
            }

            /**
             * Menyamakan singkatan pekerjaan dengan nama lengkap.
             */
            function aliasPekerjaan(value) {
                const nilai = normalisasiPekerjaan(value);

                const aliases = {
                    'TNI': 'TENTARA NASIONAL INDONESIA (TNI)',
                    'POLRI': 'KEPOLISIAN RI (POLRI)',
                    'PNS': 'PEGAWAI NEGERI SIPIL (PNS)',
                    'BELUM/TIDAK BEKERJA': 'BELUM/TIDAK BEKERJA'
                };

                return aliases[nilai]
                    ? normalisasiPekerjaan(aliases[nilai])
                    : nilai;
            }

            /**
             * Memilih pekerjaan dari hasil lookup.
             */
            function setPekerjaan(value) {
                if (!pekerjaanSelect) {
                    console.error('Elemen pekerjaan tidak ditemukan.');
                    return;
                }

                const pekerjaanDatabase = String(value ?? '').trim();

                /*
                 * BELUM/TIDAK BEKERJA tetap dianggap sebagai nilai valid.
                 */
                if (pekerjaanDatabase.length === 0) {
                    pekerjaanSelect.value = '';
                    return;
                }

                const nilaiDatabase = aliasPekerjaan(pekerjaanDatabase);
                let optionDitemukan = null;

                for (const option of pekerjaanSelect.options) {
                    const nilaiOption = aliasPekerjaan(option.value);

                    if (nilaiOption !== '' && nilaiOption === nilaiDatabase) {
                        optionDitemukan = option;
                        break;
                    }
                }

                if (optionDitemukan) {
                    pekerjaanSelect.value = optionDitemukan.value;
                    optionDitemukan.selected = true;
                } else {
                    /*
                     * Jika pekerjaan belum tersedia pada daftar,
                     * tambahkan sebagai option baru dan langsung pilih.
                     */
                    const optionBaru = document.createElement('option');

                    optionBaru.value = pekerjaanDatabase;
                    optionBaru.textContent = pekerjaanDatabase;
                    optionBaru.selected = true;

                    pekerjaanSelect.appendChild(optionBaru);
                    pekerjaanSelect.value = pekerjaanDatabase;
                }

                pekerjaanSelect.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

                console.log('Pekerjaan dari API:', pekerjaanDatabase);
                console.log('Pekerjaan terpilih:', pekerjaanSelect.value);
            }

            function kosongkanDataPenduduk() {
                if (namaInput) {
                    namaInput.value = '';
                }

                if (tempatLahirInput) {
                    tempatLahirInput.value = '';
                }

                if (tanggalLahirInput) {
                    tanggalLahirInput.value = '';
                }

                if (pekerjaanSelect) {
                    pekerjaanSelect.value = '';
                }

                if (alamatInput) {
                    alamatInput.value = '';
                }
            }

            function isiDataPenduduk(data) {
                if (namaInput) {
                    namaInput.value = data.nama || '';
                }

                if (tempatLahirInput) {
                    tempatLahirInput.value = data.tempat_lahir || '';
                }

                if (tanggalLahirInput) {
                    tanggalLahirInput.value = data.tanggal_lahir
                        ? String(data.tanggal_lahir).substring(0, 10)
                        : '';
                }

                if (alamatInput) {
                    alamatInput.value = data.alamat || '';
                }

                setPekerjaan(data.pekerjaan);
            }

            /**
             * Lookup hanya dipanggil ketika Enter ditekan.
             */
            async function cariPenduduk() {
                if (sedangMencari) {
                    return;
                }

                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .trim();

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setNikMessage(
                        'NIK harus terdiri dari 16 digit.',
                        'danger'
                    );

                    nikInput.focus();
                    return;
                }

                sedangMencari = true;
                nikInput.readOnly = true;

                setNikMessage(
                    'Sedang mencari data penduduk...',
                    'primary'
                );

                try {
                    const response = await fetch(
                        `{{ url('/datapenduduk/lookup') }}/${encodeURIComponent(nik)}`,
                        {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    let result;

                    try {
                        result = await response.json();
                    } catch (errorJson) {
                        throw new Error(
                            'Respons dari server tidak valid.'
                        );
                    }

                    if (
                        !response.ok ||
                        !result.success ||
                        !result.data
                    ) {
                        kosongkanDataPenduduk();

                        throw new Error(
                            result.message ||
                            'Data penduduk tidak ditemukan.'
                        );
                    }

                    isiDataPenduduk(result.data);

                    setNikMessage(
                        'Data penduduk berhasil ditemukan.',
                        'success'
                    );

                    if (namaInput) {
                        namaInput.focus();
                    }
                } catch (error) {
                    setNikMessage(
                        error.message ||
                        'Terjadi kesalahan saat mencari data penduduk.',
                        'danger'
                    );

                    console.error('Autofill error:', error);
                } finally {
                    sedangMencari = false;
                    nikInput.readOnly = false;
                }
            }

            /**
             * Saat mengetik hanya membatasi angka dan 16 digit.
             * Tidak ada pencarian otomatis.
             */
            nikInput.addEventListener('input', function() {
                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                setNikMessage(
                    'Masukkan 16 digit NIK, kemudian tekan Enter.',
                    'muted'
                );
            });

            /**
             * Autofill hanya setelah tombol Enter ditekan.
             */
            nikInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    cariPenduduk();
                }
            });

            if (nowaInput) {
                nowaInput.addEventListener('input', function() {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 15);
                });
            }

            if (form && btnSubmit) {
                form.addEventListener('submit', function() {
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                });
            }
        });
    </script>
@endsection
