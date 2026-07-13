```blade
@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            Form Surat Pernyataan Tidak Memiliki Kartu JAMKESMAS / ASKES / JKN
                        </h5>

                        {{-- <a href="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.index') }}"
                            class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i>
                            Kembali
                        </a> --}}
                    </div>

                    <div class="card-body">

                        {{-- Pesan berhasil --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Pesan kesalahan --}}
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

                        <form
                            action="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.store') }}"
                            method="POST"
                            id="formSuratJkn">

                            @csrf

                            {{-- Data Pemohon --}}
                            <h6 class="fw-bold mb-3">
                                Data Pemohon
                            </h6>

                            {{-- NIK --}}
                            <div class="mb-3">
                                <label for="nik" class="form-label">
                                    NIK <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="nik"
                                    id="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik') }}"
                                    maxlength="16"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    placeholder="Masukkan 16 digit NIK, kemudian tekan Enter"
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

                                <input
                                    type="text"
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

                                    <input
                                        type="text"
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

                                    <input
                                        type="date"
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

                            {{-- Daftar pekerjaan --}}
                            @php
                                $jobs = [
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
                                    'TUKANG BATU',
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

                                <select
                                    name="pekerjaan"
                                    id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    required>

                                    <option value="">
                                        -- Pilih Pekerjaan --
                                    </option>

                                    @foreach ($jobs as $job)
                                        <option
                                            value="{{ $job }}"
                                            {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                            {{ $job }}
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

                                <textarea
                                    name="alamat"
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
                                    No. HP / WhatsApp <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
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

                            {{-- Status Pengajuan --}}
                            <h6 class="fw-bold mb-3">
                                Status Pengajuan
                            </h6>

                            <div class="row">
                                {{-- Status surat --}}
                                <div class="col-md-6 mb-3">
                                    <label for="status_surat" class="form-label">
                                        Status Surat <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        name="status_surat"
                                        id="status_surat"
                                        class="form-control @error('status_surat') is-invalid @enderror"
                                        required>

                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                            <option
                                                value="{{ $status }}"
                                                {{ old('status_surat', 'Pending') == $status ? 'selected' : '' }}>
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

                                    <select
                                        name="status_verif"
                                        id="status_verif"
                                        class="form-control @error('status_verif') is-invalid @enderror"
                                        required>

                                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $statusVerifikasi)
                                            <option
                                                value="{{ $statusVerifikasi }}"
                                                {{ old('status_verif', 'Belum Verifikasi') == $statusVerifikasi ? 'selected' : '' }}>
                                                {{ $statusVerifikasi }}
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
                                <a
                                    href="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.index') }}"
                                    class="btn btn-danger">
                                    Batal
                                </a>

                                <button
                                    type="submit"
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
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const nikMessage = document.getElementById('nikMessage');

            const namaInput = document.getElementById('nama');
            const tempatLahirInput = document.getElementById('tempat_lahir');
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const pekerjaanSelect = document.getElementById('pekerjaan');
            const alamatInput = document.getElementById('alamat');
            const nowaInput = document.getElementById('nowa');

            const formSurat = document.getElementById('formSuratJkn');
            const btnSubmit = document.getElementById('btnSubmit');

            let sedangMencari = false;

            /**
             * Menampilkan pesan di bawah input NIK.
             */
            function setNikMessage(message, type = 'muted') {
                if (!nikMessage) {
                    return;
                }

                nikMessage.textContent = message;
                nikMessage.className = 'form-text text-' + type;
            }

            /**
             * Normalisasi pekerjaan agar perbedaan huruf,
             * spasi, dan garis miring tetap dianggap sama.
             */
            function normalizePekerjaan(value) {
                return String(value || '')
                    .trim()
                    .toUpperCase()
                    .replace(/\s*\/\s*/g, '/')
                    .replace(/\s+/g, ' ');
            }

            /**
             * Memilih pekerjaan dari database.
             *
             * Nilai BELUM/TIDAK BEKERJA tetap dianggap
             * sebagai pekerjaan yang valid, bukan nilai kosong.
             */
            function setPekerjaan(value) {
                if (!pekerjaanSelect) {
                    console.error('Elemen pekerjaan tidak ditemukan.');
                    return;
                }

                const pekerjaanDatabase = String(value ?? '').trim();

                if (pekerjaanDatabase === '') {
                    pekerjaanSelect.value = '';
                    return;
                }

                const nilaiDatabaseNormal =
                    normalizePekerjaan(pekerjaanDatabase);

                let optionDitemukan = null;

                for (const option of pekerjaanSelect.options) {
                    const nilaiOptionNormal =
                        normalizePekerjaan(option.value);

                    if (
                        nilaiOptionNormal !== '' &&
                        nilaiOptionNormal === nilaiDatabaseNormal
                    ) {
                        optionDitemukan = option;
                        break;
                    }
                }

                if (optionDitemukan) {
                    pekerjaanSelect.value = optionDitemukan.value;
                    optionDitemukan.selected = true;
                } else {
                    /*
                     * Tambahkan pekerjaan dari database jika
                     * belum tersedia pada daftar option.
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
            }

            /**
             * Mengosongkan data hasil autofill apabila
             * data penduduk tidak ditemukan.
             */
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

            /**
             * Mengisi form dari hasil lookup penduduk.
             */
            function isiDataPenduduk(data) {
                if (namaInput) {
                    namaInput.value = data.nama || '';
                }

                if (tempatLahirInput) {
                    tempatLahirInput.value =
                        data.tempat_lahir || '';
                }

                if (tanggalLahirInput) {
                    tanggalLahirInput.value =
                        data.tanggal_lahir
                            ? String(data.tanggal_lahir).substring(0, 10)
                            : '';
                }

                if (alamatInput) {
                    alamatInput.value = data.alamat || '';
                }

                setPekerjaan(data.pekerjaan);
            }

            /**
             * Mencari data berdasarkan NIK.
             *
             * Fungsi ini hanya dipanggil saat tombol Enter ditekan.
             */
            async function cariPendudukDenganNik() {
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
                    const url =
                        `{{ url('/datapenduduk/lookup') }}/${encodeURIComponent(nik)}`;

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

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
             * Saat mengetik NIK:
             * - hanya menerima angka;
             * - maksimal 16 digit;
             * - tidak menjalankan autofill.
             */
            nikInput.addEventListener('input', function () {
                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                setNikMessage(
                    'Masukkan 16 digit NIK, kemudian tekan Enter.',
                    'muted'
                );
            });

            /**
             * Autofill hanya berjalan ketika Enter ditekan.
             */
            nikInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();

                    cariPendudukDenganNik();
                }
            });

            /**
             * Nomor WhatsApp hanya menerima angka.
             */
            if (nowaInput) {
                nowaInput.addEventListener('input', function () {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 15);
                });
            }

            /**
             * Mencegah penyimpanan berulang kali.
             */
            if (formSurat && btnSubmit) {
                formSurat.addEventListener('submit', function () {
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                });
            }
        });
    </script>
@endsection
```
