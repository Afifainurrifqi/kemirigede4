<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Surat Keterangan Domisili Warga</title>

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
                        Surat Keterangan Domisili Warga
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form
                action="{{ route('surat.user_domisili_warga.store') }}"
                method="POST"
            >
                @csrf

                {{-- NIK --}}
                <div class="mb-3">
                    <label for="nik" class="form-label">
                        NIK <span class="text-danger">*</span>
                    </label>

                    <div class="input-group">
                        <input
                            type="text"
                            name="nik"
                            id="nik"
                            class="form-control @error('nik') is-invalid @enderror"
                            value="{{ old('nik') }}"
                            maxlength="16"
                            inputmode="numeric"
                            autocomplete="off"
                            placeholder="Masukkan 16 digit NIK"
                            required
                        >

                        {{-- <button
                            type="button"
                            id="btn-cari-nik"
                            class="btn btn-outline-primary"
                        >
                            Cari
                        </button> --}}
                    </div>

                    <small
                        id="nik-feedback"
                        class="d-block mt-1 text-muted"
                    >
                        Masukkan 16 digit NIK, kemudian tekan Enter atau tombol Cari.
                    </small>

                    @error('nik')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">
                        Nama Lengkap <span class="text-danger">*</span>
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
                </div>

                <div class="row">
                    {{-- Tanggal lahir --}}
                    <div class="col-md-4 mb-3">
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
                                'Khonghucu'
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

                    {{-- Status --}}
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
                                -- Pilih Status --
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
                </div>

                <div class="row">
                    {{-- Pekerjaan --}}
                    <div class="col-md-6 mb-3">
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
                                    'KEPALA DESA',
                                    'PERANGKAT DESA',
                                    'BIDAN',
                                    'DOKTER',
                                    'PERAWAT',
                                    'PETANI/PEKEBUN PEMILIK LAHAN',
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
                                    'PETANI/PEKEBUN PENYEWA',
                                    'TKI',
                                    'LAINNYA',
                                ];
                            @endphp

                            @foreach ($jobs as $job)
                                <option
                                    value="{{ $job }}"
                                    {{ old('pekerjaan') === $job ? 'selected' : '' }}
                                >
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

                    {{-- WhatsApp --}}
                    <div class="col-md-6 mb-3">
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
                </div>

                {{-- Alamat asal --}}
                <div class="mb-3">
                    <label for="alamat_asal" class="form-label">
                        Alamat Asal (Luar Desa)
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="alamat_asal"
                        id="alamat_asal"
                        class="form-control @error('alamat_asal') is-invalid @enderror"
                        rows="2"
                        required
                    >{{ old('alamat_asal') }}</textarea>

                    @error('alamat_asal')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Alamat domisili --}}
                <div class="mb-3">
                    <label for="alamat_domisili" class="form-label">
                        Alamat Domisili di Desa Kemirigede
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="alamat_domisili"
                        id="alamat_domisili"
                        class="form-control @error('alamat_domisili') is-invalid @enderror"
                        rows="2"
                        required
                    >{{ old('alamat_domisili') }}</textarea>

                    @error('alamat_domisili')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div class="mb-3">
                    <label for="keterangan_tambahan" class="form-label">
                        Keterangan Tambahan
                    </label>

                    <textarea
                        name="keterangan_tambahan"
                        id="keterangan_tambahan"
                        class="form-control"
                        rows="2"
                    >{{ old('keterangan_tambahan') }}</textarea>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary w-100"
                >
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const btnCariNik = document.getElementById('btn-cari-nik');
            const nikFeedback = document.getElementById('nik-feedback');

            const lookupUrlTemplate = @json(
                route('datapenduduk.lookup', ['nik' => '__NIK__'])
            );

            let requestController = null;

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

            function extractValue(value, additionalKeys = []) {
                if (value === undefined || value === null) {
                    return '';
                }

                if (typeof value !== 'object') {
                    return String(value).trim();
                }

                const keys = [
                    ...additionalKeys,
                    'nama',
                    'nama_pekerjaan',
                    'nama_agama',
                    'nama_status',
                    'pekerjaan',
                    'agama',
                    'status',
                    'status_perkawinan',
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

            function normalizeText(value) {
                return extractValue(value)
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .trim();
            }

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

                const normalizedValue = normalizeText(originalValue);

                let matchedOption = Array.from(
                    select.options
                ).find(function (option) {
                    return normalizeText(option.value) === normalizedValue ||
                        normalizeText(option.textContent) === normalizedValue;
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

                        return normalizedOption.includes(normalizedValue) ||
                            normalizedValue.includes(normalizedOption);
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

            function normalizeJenisKelamin(value) {
                const normalized = normalizeText(value);

                if (
                    [
                        '1',
                        'L',
                        'LK',
                        'LAKI',
                        'LAKILAKI',
                        'PRIA',
                        'MALE'
                    ].includes(normalized)
                ) {
                    return 'Laki-laki';
                }

                if (
                    [
                        '0',
                        '2',
                        'P',
                        'PR',
                        'PEREMPUAN',
                        'WANITA',
                        'FEMALE'
                    ].includes(normalized)
                ) {
                    return 'Perempuan';
                }

                if (normalized.includes('LAKILAKI')) {
                    return 'Laki-laki';
                }

                if (normalized.includes('PEREMPUAN')) {
                    return 'Perempuan';
                }

                return '';
            }

            function resolveJenisKelamin(data, result) {
                const candidates = [
                    data?.jenis_kelamin,
                    data?.jenisKelamin,
                    data?.jk,
                    data?.kelamin,
                    data?.gender,
                    result?.debug?.jenis_kelamin_hasil,
                    result?.debug?.jenis_kelamin_raw,
                    result?.debug?.jenis_kelamin_asli
                ];

                for (const candidate of candidates) {
                    const resultValue =
                        normalizeJenisKelamin(candidate);

                    if (resultValue !== '') {
                        return resultValue;
                    }
                }

                return '';
            }

            function normalizeAgama(value) {
                const rawValue = extractValue(value, [
                    'agama',
                    'nama_agama'
                ]);

                const normalized = normalizeText(rawValue);

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
                    KHONGHUCU: 'Khonghucu'
                };

                return aliases[normalized] ?? rawValue;
            }

            function normalizeStatus(value) {
                const rawValue = extractValue(value, [
                    'status_perkawinan',
                    'nama_status',
                    'status'
                ]);

                const normalized = normalizeText(rawValue);

                const aliases = {
                    BELUMKAWIN: 'Belum Kawin',
                    BELUMMENIKAH: 'Belum Kawin',
                    TIDAKKAWIN: 'Belum Kawin',

                    KAWIN: 'Kawin',
                    MENIKAH: 'Kawin',
                    SUDAHMENIKAH: 'Kawin',

                    CERAIHIDUP: 'Cerai Hidup',
                    CERAIMATI: 'Cerai Mati'
                };

                return aliases[normalized] ?? rawValue;
            }

            function normalizePekerjaan(value) {
                const rawValue = extractValue(value, [
                    'nama_pekerjaan',
                    'pekerjaan',
                    'jenis_pekerjaan'
                ]);

                const normalized = normalizeText(rawValue);

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

                    BURUHTANI:
                        'BURUH TANI/PERKEBUNAN',

                    NELAYAN:
                        'NELAYAN/PERIKANAN',

                    BURUHNELAYAN:
                        'BURUH NELAYAN/PERIKANAN',

                    HONORER:
                        'KARYAWAN HONORER',

                    PEGAWAIHONORER:
                        'KARYAWAN HONORER',

                    PETANIPENYEWA:
                        'PETANI/PEKEBUN PENYEWA',

                    PETANIPEKEBUNPENYEWA:
                        'PETANI/PEKEBUN PENYEWA',

                    LAINLAIN:
                        'LAINNYA',

                    LAINNYA:
                        'LAINNYA'
                };

                return aliases[normalized] ?? rawValue;
            }

            async function autofillDomisiliUser() {
                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setFeedback(
                        'NIK harus terdiri dari 16 digit.',
                        'error'
                    );

                    nikInput.focus();
                    return;
                }

                if (requestController) {
                    requestController.abort();
                }

                requestController = new AbortController();

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
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        cache: 'no-store',
                        signal: requestController.signal
                    });

                    const result = await response.json();

                    console.log(
                        'Respons lookup Domisili Warga:',
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

                    setInputValue(
                        'nama_lengkap',
                        data.nama
                    );

                    setInputValue(
                        'tempat_lahir',
                        data.tempat_lahir
                    );

                    const tanggalLahir = formatTanggal(
                        data.tanggal_lahir
                    );

                    if (tanggalLahir) {
                        setInputValue(
                            'tanggal_lahir',
                            tanggalLahir
                        );
                    }

                    /*
                     * Jenis kelamin
                     */
                    const jenisKelamin =
                        resolveJenisKelamin(data, result);

                    setSelectValue(
                        'jenis_kelamin',
                        jenisKelamin
                    );

                    /*
                     * Agama
                     */
                    const agama = normalizeAgama(
                        data.agama ??
                        data.nama_agama
                    );

                    setSelectValue(
                        'agama',
                        agama,
                        true
                    );

                    /*
                     * Status memakai status_perkawinan
                     * yang dikirim controller.
                     */
                    const statusPerkawinan =
                        normalizeStatus(
                            data.status_perkawinan ??
                            data.status ??
                            data.nama_status
                        );

                    setSelectValue(
                        'status',
                        statusPerkawinan,
                        true
                    );

                    /*
                     * Pekerjaan, termasuk
                     * BELUM/TIDAK BEKERJA.
                     */
                    const pekerjaan =
                        normalizePekerjaan(
                            data.pekerjaan ??
                            data.nama_pekerjaan ??
                            data.pekerjaan_nama ??
                            data.job
                        );

                    setSelectValue(
                        'pekerjaan',
                        pekerjaan,
                        true
                    );

                    /*
                     * Set ulang untuk mencegah plugin lain
                     * mereset pilihan.
                     */
                    setTimeout(function () {
                        setSelectValue(
                            'jenis_kelamin',
                            jenisKelamin
                        );

                        setSelectValue(
                            'agama',
                            agama,
                            true
                        );

                        setSelectValue(
                            'status',
                            statusPerkawinan,
                            true
                        );

                        setSelectValue(
                            'pekerjaan',
                            pekerjaan,
                            true
                        );
                    }, 100);

                    console.log('Hasil autofill Domisili:', {
                        jenis_kelamin_asli:
                            data.jenis_kelamin,

                        jenis_kelamin_hasil:
                            jenisKelamin,

                        agama_asli:
                            data.agama,

                        agama_hasil:
                            agama,

                        status_asli:
                            data.status_perkawinan ??
                            data.status,

                        status_hasil:
                            statusPerkawinan,

                        pekerjaan_asli:
                            data.pekerjaan,

                        pekerjaan_hasil:
                            pekerjaan
                    });

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
                        'Autofill Domisili Warga:',
                        error
                    );
                }
            }

            if (nikInput) {
                nikInput.addEventListener(
                    'input',
                    function () {
                        this.value = this.value
                            .replace(/\D/g, '')
                            .slice(0, 16);

                        setFeedback(
                            `${this.value.length}/16 digit. Tekan Enter atau tombol Cari.`
                        );
                    }
                );

                nikInput.addEventListener(
                    'keydown',
                    function (event) {
                        if (
                            event.key === 'Enter' ||
                            event.keyCode === 13
                        ) {
                            event.preventDefault();
                            event.stopPropagation();

                            autofillDomisiliUser();
                        }
                    }
                );
            }

            if (btnCariNik) {
                btnCariNik.addEventListener(
                    'click',
                    autofillDomisiliUser
                );
            }
        });
    </script>
</body>

</html>
