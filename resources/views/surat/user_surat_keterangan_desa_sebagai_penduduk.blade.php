<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Surat Keterangan Desa Sebagai Penduduk</title>

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    {{-- Header --}}
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <div class="page-heading">
                    <h6 class="mb-0">
                        Surat Keterangan Desa Sebagai Penduduk
                    </h6>
                </div>

                <div></div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">

            {{-- Pesan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pesan berhasil --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">

                    <form
                        action="{{ route('surat.user_desa_penduduk.store') }}"
                        method="POST"
                    >
                        @csrf

                        <h6 class="fw-bold text-primary mb-3">
                            Data Penduduk
                        </h6>

                        {{-- NIK --}}
                        <div class="mb-3">
                            <label for="nik" class="form-label">
                                NIK
                                <span class="text-danger">*</span>
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
                                placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                                required
                            >

                            <small
                                id="nik-feedback"
                                class="d-block mt-1 text-muted"
                            >
                                Masukkan 16 digit NIK, lalu tekan Enter untuk mencari data.
                            </small>

                            @error('nik')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama lengkap --}}
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">
                                Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="nama_lengkap"
                                id="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap') }}"
                                required
                            >

                            @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Jenis kelamin --}}
                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label">
                                    Jenis Kelamin
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="jenis_kelamin"
                                    id="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Jenis Kelamin --
                                    </option>

                                    <option
                                        value="Laki-laki"
                                        {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}
                                    >
                                        Laki-laki
                                    </option>

                                    <option
                                        value="Perempuan"
                                        {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}
                                    >
                                        Perempuan
                                    </option>
                                </select>

                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Kewarganegaraan --}}
                            <div class="col-md-6 mb-3">
                                <label for="kewarganegaraan" class="form-label">
                                    Kewarganegaraan
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="kewarganegaraan"
                                    id="kewarganegaraan"
                                    class="form-control @error('kewarganegaraan') is-invalid @enderror"
                                    value="{{ old('kewarganegaraan', 'Indonesia') }}"
                                    required
                                >

                                @error('kewarganegaraan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Tempat lahir --}}
                            <div class="col-md-6 mb-3">
                                <label for="tempat_lahir" class="form-label">
                                    Tempat Lahir
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="tempat_lahir"
                                    id="tempat_lahir"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    value="{{ old('tempat_lahir') }}"
                                    required
                                >

                                @error('tempat_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Tanggal lahir --}}
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">
                                    Tanggal Lahir
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="tanggal_lahir"
                                    id="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir') }}"
                                    required
                                >

                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Agama, status perkawinan, pekerjaan --}}
                        <div class="row">
                            {{-- Agama --}}
                            <div class="col-md-4 mb-3">
                                <label for="agama" class="form-label">
                                    Agama
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="agama"
                                    id="agama"
                                    class="form-control @error('agama') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Agama --
                                    </option>

                                    @foreach ([
                                        'Islam',
                                        'Kristen',
                                        'Katolik',
                                        'Hindu',
                                        'Buddha',
                                        'Khonghucu',
                                        'Lainnya'
                                    ] as $agamaItem)
                                        <option
                                            value="{{ $agamaItem }}"
                                            {{ old('agama') === $agamaItem ? 'selected' : '' }}
                                        >
                                            {{ $agamaItem }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('agama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Status perkawinan --}}
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">
                                    Status Perkawinan
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Status Perkawinan --
                                    </option>

                                    @foreach ([
                                        'Belum Kawin',
                                        'Kawin',
                                        'Cerai Hidup',
                                        'Cerai Mati'
                                    ] as $statusItem)
                                        <option
                                            value="{{ $statusItem }}"
                                            {{ old('status') === $statusItem ? 'selected' : '' }}
                                        >
                                            {{ $statusItem }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Pekerjaan --}}
                            <div class="col-md-4 mb-3">
                                <label for="pekerjaan" class="form-label">
                                    Pekerjaan
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="pekerjaan"
                                    id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Pekerjaan --
                                    </option>

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
                                            'KEPALA DESA',
                                            'PERANGKAT DESA',
                                            'PEGAWAI KANTOR DESA',
                                            'BIDAN',
                                            'DOKTER',
                                            'PERAWAT',
                                            'PETANI/PEKEBUN PEMILIK LAHAN',
                                            'PETANI/PEKEBUN PENYEWA',
                                            'BURUH TANI/PERKEBUNAN',
                                            'PEDAGANG',
                                            'PEGAWAI NEGERI SIPIL (PNS)',
                                            'BURUH HARIAN LEPAS',
                                            'SOPIR',
                                            'KARYAWAN BUMN',
                                            'KARYAWAN HONORER',
                                            'PENSIUNAN',
                                            'PEMBANTU RUMAH TANGGA',
                                            'BURUH PETERNAKAN',
                                            'KONSTRUKSI',
                                            'PELAUT',
                                            'NELAYAN/PERIKANAN',
                                            'BURUH NELAYAN/PERIKANAN',
                                            'PETERNAK',
                                            'MEKANIK',
                                            'PENATA RIAS',
                                            'TUKANG LAS/PANDAI BESI',
                                            'INDUSTRI',
                                            'USTADZ/MUBALIGH',
                                            'TABIB',
                                            'JURU MASAK',
                                            'SENIMAN',
                                            'AKUNTAN',
                                            'TKI',
                                            'LAINNYA',
                                        ];
                                    @endphp

                                    @foreach ($daftarPekerjaan as $pekerjaanItem)
                                        <option
                                            value="{{ $pekerjaanItem }}"
                                            {{ old('pekerjaan') === $pekerjaanItem ? 'selected' : '' }}
                                        >
                                            {{ $pekerjaanItem }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('pekerjaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">
                                Alamat
                                <span class="text-danger">*</span>
                            </label>

                            <textarea
                                name="alamat"
                                id="alamat"
                                class="form-control @error('alamat') is-invalid @enderror"
                                rows="3"
                                required
                            >{{ old('alamat') }}</textarea>

                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Keterangan tambahan --}}
                        <div class="mb-3">
                            <label for="keterangan_tambahan" class="form-label">
                                Keterangan Tambahan
                                <span class="text-danger">*</span>
                            </label>

                            <textarea
                                name="keterangan_tambahan"
                                id="keterangan_tambahan"
                                class="form-control @error('keterangan_tambahan') is-invalid @enderror"
                                rows="3"
                                placeholder="Contoh: istrinya bernama ... sedang bekerja di Hongkong"
                                required
                            >{{ old('keterangan_tambahan') }}</textarea>

                            @error('keterangan_tambahan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nomor WhatsApp --}}
                        <div class="mb-3">
                            <label for="nowa" class="form-label">
                                No. WhatsApp
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="nowa"
                                id="nowa"
                                class="form-control @error('nowa') is-invalid @enderror"
                                value="{{ old('nowa') }}"
                                inputmode="numeric"
                                placeholder="08xxxxxxxxxx"
                                required
                            >

                            @error('nowa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="text-end mt-4">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const nikFeedback = document.getElementById('nik-feedback');

            const lookupUrlTemplate = @json(
                route('datapenduduk.lookup', [
                    'nik' => '__NIK__'
                ])
            );

            let requestController = null;

            /**
             * Menampilkan pesan di bawah input NIK.
             */
            function setFeedback(message, type = '') {
                if (!nikFeedback) {
                    return;
                }

                nikFeedback.textContent = message;

                nikFeedback.classList.remove(
                    'text-muted',
                    'text-primary',
                    'text-success',
                    'text-danger'
                );

                if (type === 'loading') {
                    nikFeedback.classList.add('text-primary');
                } else if (type === 'success') {
                    nikFeedback.classList.add('text-success');
                } else if (type === 'error') {
                    nikFeedback.classList.add('text-danger');
                } else {
                    nikFeedback.classList.add('text-muted');
                }
            }

            /**
             * Mengambil nilai dari string atau object relasi.
             */
            function extractValue(value, additionalKeys = []) {
                if (
                    value === undefined ||
                    value === null
                ) {
                    return '';
                }

                if (typeof value !== 'object') {
                    return String(value).trim();
                }

                const keys = [
                    ...additionalKeys,

                    'nama',
                    'nama_agama',
                    'nama_status',
                    'nama_pekerjaan',

                    'agama',
                    'status',
                    'status_perkawinan',
                    'pekerjaan',
                    'jenis_pekerjaan',

                    'alamat',
                    'alamat_lengkap',

                    'jenis_kelamin',
                    'jenisKelamin',
                    'jk',
                    'kelamin',
                    'gender',

                    'label',
                    'value',
                    'keterangan'
                ];

                for (const key of keys) {
                    if (
                        value[key] !== undefined &&
                        value[key] !== null &&
                        String(value[key]).trim() !== ''
                    ) {
                        return String(value[key]).trim();
                    }
                }

                return '';
            }

            /**
             * Normalisasi teks agar pencocokan select lebih mudah.
             */
            function normalizeText(value) {
                return extractValue(value)
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .trim();
            }

            /**
             * Mengisi input atau textarea.
             */
            function setInputValue(id, value) {
                const element = document.getElementById(id);
                const finalValue = extractValue(value);

                if (!element || finalValue === '') {
                    return false;
                }

                element.value = finalValue;

                element.dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

                element.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

                return true;
            }

            /**
             * Memilih nilai pada select.
             */
            function setSelectValue(
                id,
                value,
                addWhenMissing = false
            ) {
                const select = document.getElementById(id);
                const originalValue = extractValue(value);

                if (!select || originalValue === '') {
                    return false;
                }

                const normalizedValue =
                    normalizeText(originalValue);

                let matchedOption = Array.from(
                    select.options
                ).find(function (option) {
                    return (
                        normalizeText(option.value) === normalizedValue ||
                        normalizeText(option.textContent) === normalizedValue
                    );
                });

                if (!matchedOption) {
                    matchedOption = Array.from(
                        select.options
                    ).find(function (option) {
                        if (!option.value) {
                            return false;
                        }

                        const normalizedOption =
                            normalizeText(option.value);

                        return (
                            normalizedOption.includes(normalizedValue) ||
                            normalizedValue.includes(normalizedOption)
                        );
                    });
                }

                if (!matchedOption && addWhenMissing) {
                    matchedOption = new Option(
                        originalValue,
                        originalValue,
                        true,
                        true
                    );

                    select.add(matchedOption);
                }

                if (!matchedOption) {
                    console.warn(
                        `Pilihan ${id} tidak ditemukan:`,
                        originalValue
                    );

                    return false;
                }

                select.value = matchedOption.value;
                matchedOption.selected = true;

                select.dispatchEvent(
                    new Event('input', {
                        bubbles: true
                    })
                );

                select.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

                if (window.jQuery) {
                    window.jQuery(select)
                        .val(matchedOption.value)
                        .trigger('change');
                }

                return true;
            }

            /**
             * Format tanggal menjadi YYYY-MM-DD.
             */
            function formatTanggal(value) {
                const rawValue = extractValue(value);

                if (!rawValue) {
                    return '';
                }

                const isoMatch = rawValue.match(
                    /^(\d{4})-(\d{2})-(\d{2})/
                );

                if (isoMatch) {
                    return `${isoMatch[1]}-${isoMatch[2]}-${isoMatch[3]}`;
                }

                const indonesiaMatch = rawValue.match(
                    /^(\d{2})[\/-](\d{2})[\/-](\d{4})$/
                );

                if (indonesiaMatch) {
                    return `${indonesiaMatch[3]}-${indonesiaMatch[2]}-${indonesiaMatch[1]}`;
                }

                return '';
            }

            /**
             * Normalisasi jenis kelamin.
             */
            function normalizeJenisKelamin(value) {
                const normalized = normalizeText(value);

                const lakiLaki = [
                    '1',
                    'L',
                    'LK',
                    'LAKI',
                    'LAKILAKI',
                    'PRIA',
                    'MALE',
                    'MAN'
                ];

                const perempuan = [
                    '0',
                    '2',
                    'P',
                    'PR',
                    'PEREMPUAN',
                    'WANITA',
                    'FEMALE',
                    'WOMAN'
                ];

                if (lakiLaki.includes(normalized)) {
                    return 'Laki-laki';
                }

                if (perempuan.includes(normalized)) {
                    return 'Perempuan';
                }

                if (
                    normalized.includes('LAKILAKI') ||
                    normalized.includes('PRIA')
                ) {
                    return 'Laki-laki';
                }

                if (
                    normalized.includes('PEREMPUAN') ||
                    normalized.includes('WANITA')
                ) {
                    return 'Perempuan';
                }

                return '';
            }

            /**
             * Mencari jenis kelamin dari kemungkinan field API.
             */
            function resolveJenisKelamin(data, result) {
                const candidates = [
                    data?.jenis_kelamin,
                    data?.jenisKelamin,
                    data?.jk,
                    data?.kelamin,
                    data?.gender,
                    data?.sex,

                    result?.debug?.jenis_kelamin_hasil,
                    result?.debug?.jenis_kelamin_raw,
                    result?.debug?.jenis_kelamin_asli
                ];

                for (const candidate of candidates) {
                    const hasil =
                        normalizeJenisKelamin(candidate);

                    if (hasil !== '') {
                        return hasil;
                    }
                }

                return '';
            }

            /**
             * Normalisasi agama.
             */
            function normalizeAgama(value) {
                const rawValue = extractValue(
                    value,
                    [
                        'agama',
                        'nama_agama',
                        'nama'
                    ]
                );

                const normalized =
                    normalizeText(rawValue);

                const aliases = {
                    ISLAM: 'Islam',

                    KRISTEN: 'Kristen',
                    PROTESTAN: 'Kristen',
                    KRISTENPROTESTAN: 'Kristen',

                    KATOLIK: 'Katolik',
                    KRISTENKATOLIK: 'Katolik',

                    HINDU: 'Hindu',

                    BUDHA: 'Buddha',
                    BUDDHA: 'Buddha',

                    KONGHUCU: 'Khonghucu',
                    KHONGHUCU: 'Khonghucu',

                    LAINLAIN: 'Lainnya',
                    LAINNYA: 'Lainnya'
                };

                return aliases[normalized] || rawValue;
            }

            /**
             * Normalisasi status perkawinan.
             */
            function normalizeStatusPerkawinan(value) {
                const rawValue = extractValue(
                    value,
                    [
                        'status_perkawinan',
                        'nama_status',
                        'status',
                        'nama'
                    ]
                );

                const normalized =
                    normalizeText(rawValue);

                const aliases = {
                    BELUMKAWIN: 'Belum Kawin',
                    BELUMMENIKAH: 'Belum Kawin',
                    TIDAKKAWIN: 'Belum Kawin',
                    SINGLE: 'Belum Kawin',

                    KAWIN: 'Kawin',
                    MENIKAH: 'Kawin',
                    SUDAHMENIKAH: 'Kawin',
                    MARRIED: 'Kawin',

                    CERAIHIDUP: 'Cerai Hidup',
                    CERAI: 'Cerai Hidup',

                    CERAIMATI: 'Cerai Mati'
                };

                return aliases[normalized] || rawValue;
            }

            /**
             * Normalisasi pekerjaan.
             */
            function normalizePekerjaan(value) {
                const rawValue = extractValue(
                    value,
                    [
                        'nama_pekerjaan',
                        'pekerjaan',
                        'jenis_pekerjaan',
                        'nama'
                    ]
                );

                const normalized =
                    normalizeText(rawValue);

                const aliases = {
                    BELUMBEKERJA:
                        'BELUM/TIDAK BEKERJA',

                    TIDAKBEKERJA:
                        'BELUM/TIDAK BEKERJA',

                    BELUMTIDAKBEKERJA:
                        'BELUM/TIDAK BEKERJA',

                    PELAJAR:
                        'PELAJAR/MAHASISWA',

                    MAHASISWA:
                        'PELAJAR/MAHASISWA',

                    PELAJARMAHASISWA:
                        'PELAJAR/MAHASISWA',

                    TIDAKSEKOLAH:
                        'TIDAK/BELUM SEKOLAH',

                    BELUMSEKOLAH:
                        'TIDAK/BELUM SEKOLAH',

                    TIDAKBELUMSEKOLAH:
                        'TIDAK/BELUM SEKOLAH',

                    IRT:
                        'IBU RUMAH TANGGA',

                    PNS:
                        'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPIL:
                        'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPILPNS:
                        'PEGAWAI NEGERI SIPIL (PNS)',

                    TNI:
                        'TENTARA NASIONAL INDONESIA (TNI)',

                    TENTARANASIONALINDONESIA:
                        'TENTARA NASIONAL INDONESIA (TNI)',

                    TENTARANASIONALINDONESIATNI:
                        'TENTARA NASIONAL INDONESIA (TNI)',

                    POLRI:
                        'KEPOLISIAN RI (POLRI)',

                    KEPOLISIANRI:
                        'KEPOLISIAN RI (POLRI)',

                    KEPOLISIANREPUBLIKINDONESIA:
                        'KEPOLISIAN RI (POLRI)',

                    PETANI:
                        'PETANI/PEKEBUN PEMILIK LAHAN',

                    PEKEBUN:
                        'PETANI/PEKEBUN PEMILIK LAHAN',

                    PETANIPEKEBUN:
                        'PETANI/PEKEBUN PEMILIK LAHAN',

                    PETANIPEKEBUNPEMILIKLAHAN:
                        'PETANI/PEKEBUN PEMILIK LAHAN',

                    PETANIPENYEWA:
                        'PETANI/PEKEBUN PENYEWA',

                    PETANIPEKEBUNPENYEWA:
                        'PETANI/PEKEBUN PENYEWA',

                    BURUHTANI:
                        'BURUH TANI/PERKEBUNAN',

                    BURUHTANIPERKEBUNAN:
                        'BURUH TANI/PERKEBUNAN',

                    NELAYAN:
                        'NELAYAN/PERIKANAN',

                    NELAYANPERIKANAN:
                        'NELAYAN/PERIKANAN',

                    BURUHNELAYAN:
                        'BURUH NELAYAN/PERIKANAN',

                    HONORER:
                        'KARYAWAN HONORER',

                    PEGAWAIHONORER:
                        'KARYAWAN HONORER',

                    KARYAWANHONORER:
                        'KARYAWAN HONORER',

                    LAINLAIN:
                        'LAINNYA',

                    LAINNYA:
                        'LAINNYA'
                };

                return aliases[normalized] || rawValue;
            }

            /**
             * Normalisasi kewarganegaraan.
             */
            function normalizeKewarganegaraan(value) {
                const rawValue = extractValue(value);
                const normalized = normalizeText(rawValue);

                if (
                    normalized === 'WNI' ||
                    normalized === 'INDONESIA' ||
                    normalized.includes('WARGANEGARAINDONESIA')
                ) {
                    return 'Indonesia';
                }

                if (
                    normalized === 'WNA' ||
                    normalized.includes('ASING')
                ) {
                    return 'Warga Negara Asing';
                }

                return rawValue || 'Indonesia';
            }

            /**
             * Mengambil data berdasarkan NIK.
             *
             * Fungsi ini hanya dipanggil setelah pengguna
             * menekan Enter pada input NIK.
             */
            async function autofillDesaUser() {
                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setFeedback(
                        'NIK harus terdiri dari 16 digit. Lengkapi NIK lalu tekan Enter.',
                        'error'
                    );

                    nikInput.focus();
                    return;
                }

                if (requestController) {
                    requestController.abort();
                }

                requestController =
                    new AbortController();

                const url = lookupUrlTemplate.replace(
                    '__NIK__',
                    encodeURIComponent(nik)
                );

                setFeedback(
                    'Sedang mencari data penduduk...',
                    'loading'
                );

                try {
                    const response = await fetch(url, {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With':
                                'XMLHttpRequest'
                        },

                        cache: 'no-store',
                        signal: requestController.signal
                    });

                    let result;

                    try {
                        result = await response.json();
                    } catch (jsonError) {
                        throw new Error(
                            'Respons server tidak valid.'
                        );
                    }

                    console.log(
                        'Respons lookup Desa Penduduk:',
                        result
                    );

                    if (
                        !response.ok ||
                        !result.success ||
                        !result.data
                    ) {
                        throw new Error(
                            result.message ||
                            'Data penduduk tidak ditemukan.'
                        );
                    }

                    const data = result.data;

                    /*
                     * Isi field biasa.
                     */
                    setInputValue(
                        'nama_lengkap',
                        data.nama ??
                        data.nama_lengkap
                    );

                    setInputValue(
                        'tempat_lahir',
                        data.tempat_lahir
                    );

                    const tanggalLahir =
                        formatTanggal(
                            data.tanggal_lahir ??
                            data.tgl_lahir ??
                            data.tanggallahir ??
                            data.birth_date
                        );

                    if (tanggalLahir) {
                        setInputValue(
                            'tanggal_lahir',
                            tanggalLahir
                        );
                    }

                    setInputValue(
                        'alamat',
                        data.alamat ??
                        data.alamat_lengkap ??
                        data.alamat_ktp
                    );

                    setInputValue(
                        'kewarganegaraan',
                        normalizeKewarganegaraan(
                            data.kewarganegaraan ??
                            data.warganegara ??
                            data.kewarganegaraan_nama
                        )
                    );

                    /*
                     * Isi jenis kelamin.
                     */
                    const jenisKelamin =
                        resolveJenisKelamin(
                            data,
                            result
                        );

                    setSelectValue(
                        'jenis_kelamin',
                        jenisKelamin
                    );

                    /*
                     * Isi agama.
                     */
                    const agamaValue =
                        normalizeAgama(
                            data.agama ??
                            data.nama_agama ??
                            data.agama_nama
                        );

                    setSelectValue(
                        'agama',
                        agamaValue,
                        true
                    );

                    /*
                     * Isi status perkawinan.
                     */
                    const statusValue =
                        normalizeStatusPerkawinan(
                            data.status_perkawinan ??
                            data.status ??
                            data.nama_status ??
                            data.marital_status
                        );

                    setSelectValue(
                        'status',
                        statusValue,
                        true
                    );

                    /*
                     * Isi pekerjaan.
                     */
                    const pekerjaanValue =
                        normalizePekerjaan(
                            data.pekerjaan ??
                            data.nama_pekerjaan ??
                            data.pekerjaan_nama ??
                            data.jenis_pekerjaan ??
                            data.job
                        );

                    setSelectValue(
                        'pekerjaan',
                        pekerjaanValue,
                        true
                    );

                    /*
                     * Set ulang apabila layout menggunakan
                     * Select2 atau plugin select lainnya.
                     */
                    setTimeout(function () {
                        setSelectValue(
                            'jenis_kelamin',
                            jenisKelamin
                        );

                        setSelectValue(
                            'agama',
                            agamaValue,
                            true
                        );

                        setSelectValue(
                            'status',
                            statusValue,
                            true
                        );

                        setSelectValue(
                            'pekerjaan',
                            pekerjaanValue,
                            true
                        );
                    }, 150);

                    console.log(
                        'Hasil autofill Desa Penduduk:',
                        {
                            jenis_kelamin:
                                jenisKelamin,

                            agama:
                                agamaValue,

                            status_perkawinan:
                                statusValue,

                            pekerjaan:
                                pekerjaanValue
                        }
                    );

                    setFeedback(
                        'Data penduduk berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    setFeedback(
                        error.message ||
                        'Gagal mengambil data penduduk.',
                        'error'
                    );

                    console.error(
                        'Autofill Desa Penduduk:',
                        error
                    );
                }
            }

            /*
             * Saat mengetik NIK:
             * hanya membatasi angka dan maksimal 16 digit.
             * Tidak menjalankan autofill.
             */
            if (nikInput) {
                nikInput.addEventListener(
                    'input',
                    function () {
                        this.value = this.value
                            .replace(/\D/g, '')
                            .slice(0, 16);

                        setFeedback(
                            `${this.value.length}/16 digit. Tekan Enter untuk mencari data.`
                        );
                    }
                );

                /*
                 * Autofill hanya ketika tombol Enter ditekan.
                 */
                nikInput.addEventListener(
                    'keydown',
                    function (event) {
                        if (
                            event.key === 'Enter' ||
                            event.keyCode === 13
                        ) {
                            event.preventDefault();
                            event.stopPropagation();

                            autofillDesaUser();
                        }
                    }
                );
            }
        });
    </script>
</body>

</html>
