@extends(Auth::check() && Auth::user()->role === 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container py-3">
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

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">
                    Form Surat Keterangan Penghasilan (Admin)
                </h4>

                <form
                    action="{{ route('surat.penghasilan.store') }}"
                    method="POST"
                >
                    @csrf

                    <h5 class="text-primary mb-3">
                        Data Orang Tua / Wali (Pemohon)
                    </h5>

                    {{-- NIK Pemohon --}}
                    <div class="mb-3">
                        <label for="nik" class="form-label">
                            NIK Pemohon
                            <span class="text-danger">*</span>
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



                        @error('nik')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nama --}}
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
                        <div class="col-md-4 mb-3">
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
                                <option value="">-- Pilih --</option>

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
                        <div class="col-md-4 mb-3">
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
                    </div>

                    <div class="row">
                        {{-- Agama --}}
                        <div class="col-md-6 mb-3">
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
                                <option value="">-- Pilih Agama --</option>

                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agamaItem)
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

                    {{-- Status perkawinan --}}
                    <div class="mb-3">
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
                            <option value="">-- Pilih Status --</option>

                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $statusItem)
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
                    <div class="mb-3">
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
                            <option value="">-- Pilih Pekerjaan --</option>

                            @foreach ($pekerjaan as $p)
                                @php
                                    $namaPekerjaan = $p->nama
                                        ?? $p->nama_pekerjaan
                                        ?? $p->pekerjaan
                                        ?? '';
                                @endphp

                                @if ($namaPekerjaan !== '')
                                    <option
                                        value="{{ $namaPekerjaan }}"
                                        {{ old('pekerjaan') === $namaPekerjaan ? 'selected' : '' }}
                                    >
                                        {{ $namaPekerjaan }}
                                    </option>
                                @endif
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
                            Alamat Lengkap
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

                    <div class="row">
                        {{-- Penghasilan --}}
                        <div class="col-md-6 mb-3">
                            <label for="nominal_penghasilan" class="form-label">
                                Nominal Penghasilan/Bulan
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="nominal_penghasilan"
                                id="nominal_penghasilan"
                                class="form-control @error('nominal_penghasilan') is-invalid @enderror"
                                value="{{ old('nominal_penghasilan') }}"
                                placeholder="Contoh: Rp 1.000.000"
                                required
                            >

                            @error('nominal_penghasilan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Keperluan --}}
                        <div class="col-md-6 mb-3">
                            <label for="keperluan" class="form-label">
                                Peruntukan/Keperluan Surat
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="keperluan"
                                id="keperluan"
                                class="form-control @error('keperluan') is-invalid @enderror"
                                value="{{ old('keperluan') }}"
                                placeholder="Contoh: Persyaratan Beasiswa"
                                required
                            >

                            @error('keperluan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <h5 class="text-success mt-4 mb-3">
                        Data Anak
                    </h5>

                    <div class="row">
                        {{-- NIK Anak --}}
                        <div class="col-md-6 mb-3">
                            <label for="nik_anak" class="form-label">
                                NIK Anak
                                <span class="text-danger">*</span>
                            </label>

                            <div class="input-group">
                                <input
                                    type="text"
                                    name="nik_anak"
                                    id="nik_anak"
                                    class="form-control @error('nik_anak') is-invalid @enderror"
                                    value="{{ old('nik_anak') }}"
                                    maxlength="16"
                                    inputmode="numeric"
                                    autocomplete="off"
                                    required
                                >
{{--
                                <button
                                    type="button"
                                    id="btn-cari-nik-anak"
                                    class="btn btn-outline-success"
                                >
                                    Cari
                                </button> --}}
                            </div>

                            <small
                                id="nik-anak-feedback"
                                class="d-block mt-1 text-muted"
                            >
                                Masukkan 16 digit NIK anak, lalu tekan Enter atau tombol Cari.
                            </small>

                            @error('nik_anak')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama Anak --}}
                        <div class="col-md-6 mb-3">
                            <label for="nama_anak" class="form-label">
                                Nama Lengkap Anak
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="nama_anak"
                                id="nama_anak"
                                class="form-control @error('nama_anak') is-invalid @enderror"
                                value="{{ old('nama_anak') }}"
                                required
                            >

                            @error('nama_anak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- Jenis kelamin anak --}}
                        <div class="col-md-4 mb-3">
                            <label for="jenis_kelamin_anak" class="form-label">
                                Jenis Kelamin Anak
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="jenis_kelamin_anak"
                                id="jenis_kelamin_anak"
                                class="form-control @error('jenis_kelamin_anak') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih --</option>

                                <option
                                    value="Laki-laki"
                                    {{ old('jenis_kelamin_anak') === 'Laki-laki' ? 'selected' : '' }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="Perempuan"
                                    {{ old('jenis_kelamin_anak') === 'Perempuan' ? 'selected' : '' }}
                                >
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        {{-- Tempat lahir anak --}}
                        <div class="col-md-4 mb-3">
                            <label for="tempat_lahir_anak" class="form-label">
                                Tempat Lahir Anak
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="tempat_lahir_anak"
                                id="tempat_lahir_anak"
                                class="form-control @error('tempat_lahir_anak') is-invalid @enderror"
                                value="{{ old('tempat_lahir_anak') }}"
                                required
                            >
                        </div>

                        {{-- Tanggal lahir anak --}}
                        <div class="col-md-4 mb-3">
                            <label for="tanggal_lahir_anak" class="form-label">
                                Tanggal Lahir Anak
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="tanggal_lahir_anak"
                                id="tanggal_lahir_anak"
                                class="form-control @error('tanggal_lahir_anak') is-invalid @enderror"
                                value="{{ old('tanggal_lahir_anak') }}"
                                required
                            >
                        </div>
                    </div>

                    {{-- Sekolah --}}
                    <div class="mb-3">
                        <label for="sekolah_universitas" class="form-label">
                            Nama Sekolah/Instansi Universitas
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="sekolah_universitas"
                            id="sekolah_universitas"
                            class="form-control @error('sekolah_universitas') is-invalid @enderror"
                            value="{{ old('sekolah_universitas') }}"
                            placeholder="Contoh: Universitas Brawijaya"
                            required
                        >
                    </div>

                    <div class="row">
                        {{-- WhatsApp --}}
                        <div class="col-md-4 mb-3">
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
                                required
                            >
                        </div>

                        {{-- Status surat --}}
                        <div class="col-md-4 mb-3">
                            <label for="status_surat" class="form-label">
                                Status Surat
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status_surat"
                                id="status_surat"
                                class="form-control"
                                required
                            >
                                @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $statusSurat)
                                    <option
                                        value="{{ $statusSurat }}"
                                        {{ old('status_surat', 'Pending') === $statusSurat ? 'selected' : '' }}
                                    >
                                        {{ $statusSurat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status verifikasi --}}
                        <div class="col-md-4 mb-3">
                            <label for="status_verif" class="form-label">
                                Status Verifikasi
                                <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status_verif"
                                id="status_verif"
                                class="form-control"
                                required
                            >
                                @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verifikasi)
                                    <option
                                        value="{{ $verifikasi }}"
                                        {{ old('status_verif', 'Belum Verifikasi') === $verifikasi ? 'selected' : '' }}
                                    >
                                        {{ $verifikasi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button
                            type="submit"
                            class="btn btn-primary px-5"
                        >
                            Simpan Data Surat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const nikAnakInput = document.getElementById('nik_anak');

            const btnCariNik = document.getElementById('btn-cari-nik');
            const btnCariNikAnak = document.getElementById('btn-cari-nik-anak');

            const nikFeedback = document.getElementById('nik-feedback');
            const nikAnakFeedback = document.getElementById('nik-anak-feedback');

            const lookupUrlTemplate = @json(
                route('datapenduduk.lookup', ['nik' => '__NIK__'])
            );

            let parentRequestController = null;
            let childRequestController = null;

            function setFeedback(element, message, type = '') {
                if (!element) {
                    return;
                }

                element.textContent = message;

                element.classList.remove(
                    'text-muted',
                    'text-primary',
                    'text-success',
                    'text-danger'
                );

                if (type === 'loading') {
                    element.classList.add('text-primary');
                } else if (type === 'success') {
                    element.classList.add('text-success');
                } else if (type === 'error') {
                    element.classList.add('text-danger');
                } else {
                    element.classList.add('text-muted');
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
                    'alamat',
                    'alamat_lengkap',
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

            function setSelectValue(id, value, addWhenMissing = false) {
                const select = document.getElementById(id);
                const originalValue = extractValue(value);

                if (!select || originalValue === '') {
                    return false;
                }

                const normalizedValue = normalizeText(originalValue);

                let matchedOption = Array.from(select.options).find(function (option) {
                    return normalizeText(option.value) === normalizedValue ||
                        normalizeText(option.textContent) === normalizedValue;
                });

                if (!matchedOption) {
                    matchedOption = Array.from(select.options).find(function (option) {
                        if (!option.value) {
                            return false;
                        }

                        const normalizedOption = normalizeText(option.value);

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
                        `Option ${id} tidak ditemukan:`,
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

                const iso = rawValue.match(
                    /^(\d{4})-(\d{2})-(\d{2})/
                );

                if (iso) {
                    return `${iso[1]}-${iso[2]}-${iso[3]}`;
                }

                const indonesia = rawValue.match(
                    /^(\d{2})[\/-](\d{2})[\/-](\d{4})$/
                );

                if (indonesia) {
                    return `${indonesia[3]}-${indonesia[2]}-${indonesia[1]}`;
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
                    const resultValue = normalizeJenisKelamin(candidate);

                    if (resultValue !== '') {
                        return resultValue;
                    }
                }

                return '';
            }

            function normalizeAgama(value) {
                const normalized = normalizeText(value);

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

                return aliases[normalized] ?? extractValue(value);
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

            function normalizeKewarganegaraan(value) {
                const normalized = normalizeText(value);

                if (
                    normalized === 'WNI' ||
                    normalized.includes('INDONESIA')
                ) {
                    return 'Indonesia';
                }

                if (
                    normalized === 'WNA' ||
                    normalized.includes('ASING')
                ) {
                    return 'Warga Negara Asing';
                }

                return extractValue(value) || 'Indonesia';
            }

            function normalizePekerjaan(value) {
                const rawValue = extractValue(value, [
                    'nama_pekerjaan',
                    'pekerjaan',
                    'jenis_pekerjaan'
                ]);

                const normalized = normalizeText(rawValue);

                const aliases = {
                    BELUMBEKERJA: 'BELUM/TIDAK BEKERJA',
                    TIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',
                    BELUMTIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    PELAJAR: 'PELAJAR/MAHASISWA',
                    MAHASISWA: 'PELAJAR/MAHASISWA',
                    PELAJARMAHASISWA: 'PELAJAR/MAHASISWA',

                    IRT: 'IBU RUMAH TANGGA',

                    PNS: 'PEGAWAI NEGERI SIPIL (PNS)',
                    PEGAWAINEGERISIPIL:
                        'PEGAWAI NEGERI SIPIL (PNS)',
                    PEGAWAINEGERISIPILPNS:
                        'PEGAWAI NEGERI SIPIL (PNS)',

                    TNI: 'TENTARA NASIONAL INDONESIA (TNI)',
                    TENTARANASIONALINDONESIA:
                        'TENTARA NASIONAL INDONESIA (TNI)',

                    POLRI: 'KEPOLISIAN RI (POLRI)',
                    KEPOLISIANRI:
                        'KEPOLISIAN RI (POLRI)',
                    KEPOLISIANREPUBLIKINDONESIA:
                        'KEPOLISIAN RI (POLRI)',

                    PETANI:
                        'PETANI/PEKEBUN PEMILIK LAHAN',
                    PEKEBUN:
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

                    LAINLAIN: 'LAINNYA'
                };

                return aliases[normalized] ?? rawValue;
            }

            function resolveStatus(data) {
                const candidates = [
                    data?.status_perkawinan,
                    data?.status,
                    data?.nama_status,
                    data?.marital_status,
                    data?.penduduk?.status_perkawinan,
                    data?.penduduk?.status
                ];

                for (const candidate of candidates) {
                    const resultValue = normalizeStatus(candidate);

                    if (resultValue !== '') {
                        return resultValue;
                    }
                }

                return '';
            }

            function resolvePekerjaan(data) {
                const candidates = [
                    data?.pekerjaan,
                    data?.nama_pekerjaan,
                    data?.pekerjaan_nama,
                    data?.jenis_pekerjaan,
                    data?.job,
                    data?.penduduk?.pekerjaan
                ];

                for (const candidate of candidates) {
                    const resultValue = normalizePekerjaan(candidate);

                    if (resultValue !== '') {
                        return resultValue;
                    }
                }

                return '';
            }

            function resolveAlamat(data) {
                const candidates = [
                    data?.alamat,
                    data?.alamat_lengkap,
                    data?.alamat_ktp,
                    data?.alamat_domisili,
                    data?.domisili,
                    data?.penduduk?.alamat
                ];

                for (const candidate of candidates) {
                    const resultValue = extractValue(candidate, [
                        'alamat',
                        'alamat_lengkap'
                    ]);

                    if (resultValue !== '') {
                        return resultValue;
                    }
                }

                const dusun = extractValue(
                    data?.dusun ?? data?.dukuh
                );

                const desa = extractValue(
                    data?.desa ?? data?.kelurahan
                );

                const kecamatan = extractValue(
                    data?.kecamatan
                );

                return [
                    dusun,
                    desa,
                    kecamatan
                ].filter(Boolean).join(', ');
            }

            async function lookupPenduduk(
                nik,
                feedbackElement,
                abortController
            ) {
                const url = lookupUrlTemplate.replace(
                    '__NIK__',
                    encodeURIComponent(nik)
                );

                setFeedback(
                    feedbackElement,
                    'Sedang mencari data penduduk...',
                    'loading'
                );

                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    cache: 'no-store',
                    signal: abortController.signal
                });

                const result = await response.json();

                console.log('Respons lookup NIK:', result);

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

                return result;
            }

            async function autofillOrangTua() {
                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setFeedback(
                        nikFeedback,
                        'NIK harus terdiri dari 16 digit.',
                        'error'
                    );

                    nikInput.focus();
                    return;
                }

                if (parentRequestController) {
                    parentRequestController.abort();
                }

                parentRequestController = new AbortController();

                try {
                    const result = await lookupPenduduk(
                        nik,
                        nikFeedback,
                        parentRequestController
                    );

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

                    setSelectValue(
                        'jenis_kelamin',
                        resolveJenisKelamin(data, result)
                    );

                    setSelectValue(
                        'agama',
                        normalizeAgama(data.agama),
                        true
                    );

                    setInputValue(
                        'kewarganegaraan',
                        normalizeKewarganegaraan(
                            data.kewarganegaraan
                        )
                    );

                    /*
                     * Perbaikan status perkawinan.
                     */
                    const statusPerkawinan =
                        resolveStatus(data);

                    setSelectValue(
                        'status',
                        statusPerkawinan,
                        true
                    );

                    /*
                     * Perbaikan pekerjaan, termasuk
                     * BELUM/TIDAK BEKERJA.
                     */
                    const pekerjaanValue =
                        resolvePekerjaan(data);

                    setSelectValue(
                        'pekerjaan',
                        pekerjaanValue,
                        true
                    );

                    /*
                     * Perbaikan alamat.
                     */
                    const alamatValue =
                        resolveAlamat(data);

                    setInputValue(
                        'alamat',
                        alamatValue
                    );

                    /*
                     * Set ulang select untuk mencegah Select2
                     * atau script lain menghapus pilihan.
                     */
                    setTimeout(function () {
                        setSelectValue(
                            'status',
                            statusPerkawinan,
                            true
                        );

                        setSelectValue(
                            'pekerjaan',
                            pekerjaanValue,
                            true
                        );

                        setInputValue(
                            'alamat',
                            alamatValue
                        );
                    }, 100);

                    console.log('Hasil autofill admin:', {
                        status_asli:
                            data.status_perkawinan ??
                            data.status,

                        status_hasil:
                            statusPerkawinan,

                        pekerjaan_asli:
                            data.pekerjaan,

                        pekerjaan_hasil:
                            pekerjaanValue,

                        alamat_asli:
                            data.alamat,

                        alamat_hasil:
                            alamatValue
                    });

                    setFeedback(
                        nikFeedback,
                        'Data pemohon berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    setFeedback(
                        nikFeedback,
                        error.message ||
                        'Gagal mengambil data pemohon.',
                        'error'
                    );

                    console.error(
                        'Autofill orang tua:',
                        error
                    );
                }
            }

            async function autofillAnak() {
                const nik = nikAnakInput.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                nikAnakInput.value = nik;

                if (nik.length !== 16) {
                    setFeedback(
                        nikAnakFeedback,
                        'NIK anak harus terdiri dari 16 digit.',
                        'error'
                    );

                    nikAnakInput.focus();
                    return;
                }

                if (childRequestController) {
                    childRequestController.abort();
                }

                childRequestController = new AbortController();

                try {
                    const result = await lookupPenduduk(
                        nik,
                        nikAnakFeedback,
                        childRequestController
                    );

                    const data = result.data;

                    setInputValue(
                        'nama_anak',
                        data.nama
                    );

                    setInputValue(
                        'tempat_lahir_anak',
                        data.tempat_lahir
                    );

                    const tanggalLahirAnak =
                        formatTanggal(data.tanggal_lahir);

                    if (tanggalLahirAnak) {
                        setInputValue(
                            'tanggal_lahir_anak',
                            tanggalLahirAnak
                        );
                    }

                    setSelectValue(
                        'jenis_kelamin_anak',
                        resolveJenisKelamin(data, result)
                    );

                    setFeedback(
                        nikAnakFeedback,
                        'Data anak berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    setFeedback(
                        nikAnakFeedback,
                        error.message ||
                        'Gagal mengambil data anak.',
                        'error'
                    );

                    console.error(
                        'Autofill anak:',
                        error
                    );
                }
            }

            if (nikInput) {
                nikInput.addEventListener('input', function () {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 16);

                    setFeedback(
                        nikFeedback,
                        `${this.value.length}/16 digit. Tekan Enter atau tombol Cari.`
                    );
                });

                nikInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        event.stopPropagation();

                        autofillOrangTua();
                    }
                });
            }

            if (btnCariNik) {
                btnCariNik.addEventListener(
                    'click',
                    autofillOrangTua
                );
            }

            if (nikAnakInput) {
                nikAnakInput.addEventListener('input', function () {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 16);

                    setFeedback(
                        nikAnakFeedback,
                        `${this.value.length}/16 digit. Tekan Enter atau tombol Cari.`
                    );
                });

                nikAnakInput.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        event.stopPropagation();

                        autofillAnak();
                    }
                });
            }

            if (btnCariNikAnak) {
                btnCariNikAnak.addEventListener(
                    'click',
                    autofillAnak
                );
            }
        });
    </script>
@endsection
