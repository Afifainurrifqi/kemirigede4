<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pengajuan Surat Keterangan Penghasilan</title>

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>

    {{-- Preloader --}}
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    {{-- Header --}}
    <div class="header-area" id="headerArea">
        <div class="container h-100 d-flex align-items-center justify-content-between">
            <div class="back-button">
                <a href="{{ route('surat.pengajuan_surat') }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>

            <div class="page-heading">
                <h6 class="mb-0">
                    Surat Keterangan Penghasilan
                </h6>
            </div>

            <div></div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">

            {{-- Error validasi --}}
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

                    <form action="{{ route('surat.userpenghasilan.store') }}" method="POST">
                        @csrf

                        {{-- =====================================================
                             DATA ORANG TUA / WALI
                        ====================================================== --}}
                        <h6 class="fw-bold text-primary mb-3">
                            Data Orang Tua / Wali
                        </h6>

                        {{-- NIK orang tua --}}
                        <div class="mb-3">
                            <label for="nik" class="form-label">
                                NIK Orang Tua
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nik" id="nik"
                                class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                                maxlength="16" inputmode="numeric" autocomplete="off"
                                placeholder="Masukkan 16 digit NIK, lalu tekan Enter" required>

                            <small id="nik-feedback" class="d-block mt-1 text-muted">
                                Masukkan 16 digit NIK, lalu tekan Enter.
                            </small>

                            @error('nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama orang tua --}}
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">
                                Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap') }}" required>

                            @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tempat dan tanggal lahir orang tua --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Tempat dan Tanggal Lahir
                                <span class="text-danger">*</span>
                            </label>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir" required>

                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir') }}" required>

                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Jenis kelamin orang tua --}}
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin
                                <span class="text-danger">*</span>
                            </label>

                            <select name="jenis_kelamin" id="jenis_kelamin"
                                class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>

                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>

                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Agama, kewarganegaraan, status --}}
                        <div class="row">

                            {{-- Agama --}}
                            <div class="col-md-4 mb-3">
                                <label for="agama" class="form-label">
                                    Agama
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="agama" id="agama"
                                    class="form-control @error('agama') is-invalid @enderror" required>
                                    <option value="">
                                        -- Pilih Agama --
                                    </option>

                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agamaItem)
                                        <option value="{{ $agamaItem }}"
                                            {{ old('agama') === $agamaItem ? 'selected' : '' }}>
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
                            <div class="col-md-4 mb-3">
                                <label for="kewarganegaraan" class="form-label">
                                    Kewarganegaraan
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="kewarganegaraan" id="kewarganegaraan"
                                    class="form-control @error('kewarganegaraan') is-invalid @enderror" required>
                                    <option value="">
                                        -- Pilih --
                                    </option>

                                    <option value="WNI" {{ old('kewarganegaraan') === 'WNI' ? 'selected' : '' }}>
                                        WNI
                                    </option>

                                    <option value="WNA" {{ old('kewarganegaraan') === 'WNA' ? 'selected' : '' }}>
                                        WNA
                                    </option>
                                </select>

                                @error('kewarganegaraan')
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

                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">
                                        -- Pilih Status --
                                    </option>

                                    @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $statusItem)
                                        <option value="{{ $statusItem }}"
                                            {{ old('status') === $statusItem ? 'selected' : '' }}>
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

                        {{-- Pekerjaan orang tua --}}
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">
                                Pekerjaan Orang Tua
                                <span class="text-danger">*</span>
                            </label>

                            <select name="pekerjaan" id="pekerjaan"
                                class="form-control @error('pekerjaan') is-invalid @enderror" required>
                                <option value="">
                                    -- Pilih Pekerjaan --
                                </option>

                                @foreach ($pekerjaan as $p)
                                    @php
                                        $namaPekerjaan = $p->nama ?? ($p->nama_pekerjaan ?? ($p->pekerjaan ?? ''));
                                    @endphp

                                    @if ($namaPekerjaan !== '')
                                        <option value="{{ $namaPekerjaan }}"
                                            {{ old('pekerjaan') === $namaPekerjaan ? 'selected' : '' }}>
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

                        {{-- Alamat orang tua --}}
                        <div class="mb-3">
                            <label for="alamat" class="form-label">
                                Alamat Rumah
                                <span class="text-danger">*</span>
                            </label>

                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                required>{{ old('alamat') }}</textarea>

                            @error('alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nominal penghasilan --}}
                        <div class="mb-3">
                            <label for="nominal_penghasilan" class="form-label">
                                Rata-rata Penghasilan Bulanan
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nominal_penghasilan" id="nominal_penghasilan"
                                class="form-control @error('nominal_penghasilan') is-invalid @enderror"
                                value="{{ old('nominal_penghasilan') }}" placeholder="Contoh: Rp 1.200.000" required>

                            @error('nominal_penghasilan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Keperluan --}}
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">
                                Keperluan Penggunaan Surat
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="keperluan" id="keperluan"
                                class="form-control @error('keperluan') is-invalid @enderror"
                                value="{{ old('keperluan') }}" placeholder="Contoh: Daftar Beasiswa Universitas"
                                required>

                            @error('keperluan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- =====================================================
                             DATA ANAK / MAHASISWA
                        ====================================================== --}}
                        <h6 class="fw-bold text-success mt-4 mb-3">
                            Data Anak / Mahasiswa
                        </h6>

                        {{-- NIK anak --}}
                        <div class="mb-3">
                            <label for="nik_anak" class="form-label">
                                NIK Anak
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nik_anak" id="nik_anak"
                                class="form-control @error('nik_anak') is-invalid @enderror"
                                value="{{ old('nik_anak') }}" maxlength="16" inputmode="numeric" autocomplete="off"
                                placeholder="Masukkan 16 digit NIK anak, lalu tekan Enter" required>

                            <small id="nik-anak-feedback" class="d-block mt-1 text-muted">
                                Masukkan 16 digit NIK anak, lalu tekan Enter.
                            </small>

                            @error('nik_anak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nama anak --}}
                        <div class="mb-3">
                            <label for="nama_anak" class="form-label">
                                Nama Lengkap Anak
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nama_anak" id="nama_anak"
                                class="form-control @error('nama_anak') is-invalid @enderror"
                                value="{{ old('nama_anak') }}" required>

                            @error('nama_anak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tempat dan tanggal lahir anak --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tempat_lahir_anak" class="form-label">
                                    Tempat Lahir Anak
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="tempat_lahir_anak" id="tempat_lahir_anak"
                                    class="form-control @error('tempat_lahir_anak') is-invalid @enderror"
                                    value="{{ old('tempat_lahir_anak') }}" required>

                                @error('tempat_lahir_anak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir_anak" class="form-label">
                                    Tanggal Lahir Anak
                                    <span class="text-danger">*</span>
                                </label>

                                <input type="date" name="tanggal_lahir_anak" id="tanggal_lahir_anak"
                                    class="form-control @error('tanggal_lahir_anak') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir_anak') }}" required>

                                @error('tanggal_lahir_anak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Jenis kelamin anak --}}
                        <div class="mb-3">
                            <label for="jenis_kelamin_anak" class="form-label">
                                Jenis Kelamin Anak
                                <span class="text-danger">*</span>
                            </label>

                            <select name="jenis_kelamin_anak" id="jenis_kelamin_anak"
                                class="form-control @error('jenis_kelamin_anak') is-invalid @enderror" required>
                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin_anak') === 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>

                                <option value="Perempuan"
                                    {{ old('jenis_kelamin_anak') === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>

                            @error('jenis_kelamin_anak')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Sekolah/kampus --}}
                        <div class="mb-3">
                            <label for="sekolah_universitas" class="form-label">
                                Sekolah / Kampus Anak
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="sekolah_universitas" id="sekolah_universitas"
                                class="form-control @error('sekolah_universitas') is-invalid @enderror"
                                value="{{ old('sekolah_universitas') }}" placeholder="Contoh: Universitas Brawijaya"
                                required>

                            @error('sekolah_universitas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- WhatsApp --}}
                        <div class="mb-3">
                            <label for="nowa" class="form-label">
                                No WhatsApp Aktif
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nowa" id="nowa"
                                class="form-control @error('nowa') is-invalid @enderror" value="{{ old('nowa') }}"
                                inputmode="numeric" placeholder="08xxxxxxxxxx" required>

                            @error('nowa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Kirim Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript --}}
    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const nikAnakInput = document.getElementById('nik_anak');

            const nikFeedback = document.getElementById('nik-feedback');
            const nikAnakFeedback = document.getElementById(
                'nik-anak-feedback'
            );

            const lookupUrlTemplate = @json(route('datapenduduk.lookup', ['nik' => '__NIK__']));

            let parentRequestController = null;
            let childRequestController = null;

            /**
             * Menutup preloader sebagai pengaman.
             */
            function tutupPreloader() {
                const preloader = document.getElementById('preloader');

                if (!preloader) {
                    return;
                }

                preloader.style.opacity = '0';
                preloader.style.pointerEvents = 'none';

                setTimeout(function() {
                    preloader.remove();
                }, 250);
            }

            window.addEventListener('load', tutupPreloader);
            setTimeout(tutupPreloader, 1500);

            /**
             * Menampilkan pesan pencarian NIK.
             */
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

            /**
             * Mengambil nilai apabila API mengirim object relasi.
             */
            function extractValue(value) {
                if (
                    value === undefined ||
                    value === null
                ) {
                    return '';
                }

                if (typeof value !== 'object') {
                    return String(value).trim();
                }

                const possibleKeys = [
                    'nama',
                    'nama_pekerjaan',
                    'nama_agama',
                    'nama_status',
                    'pekerjaan',
                    'agama',
                    'status',
                    'label',
                    'value',
                    'keterangan',
                    'jenis_kelamin',
                    'jenisKelamin',
                    'jk',
                    'kelamin',
                    'gender'
                ];

                for (const key of possibleKeys) {
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
             * Normalisasi teks.
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
             * Mengisi input/textarea.
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
             * Memilih option select.
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
                ).find(function(option) {
                    return normalizeText(option.value) ===
                        normalizedValue ||
                        normalizeText(option.textContent) ===
                        normalizedValue;
                });

                if (!matchedOption) {
                    matchedOption = Array.from(
                        select.options
                    ).find(function(option) {
                        if (!option.value) {
                            return false;
                        }

                        const normalizedOption =
                            normalizeText(option.value);

                        return normalizedOption.includes(
                                normalizedValue
                            ) ||
                            normalizedValue.includes(
                                normalizedOption
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
             * Mengambil jenis kelamin dari respons API.
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

                return aliases[normalized] ??
                    extractValue(value);
            }

            /**
             * Normalisasi status perkawinan.
             */
            function normalizeStatus(value) {
                const normalized = normalizeText(value);

                const aliases = {
                    BELUMKAWIN: 'Belum Kawin',
                    BELUMMENIKAH: 'Belum Kawin',
                    TIDAKKAWIN: 'Belum Kawin',

                    KAWIN: 'Kawin',
                    MENIKAH: 'Kawin',

                    CERAIHIDUP: 'Cerai Hidup',
                    CERAIMATI: 'Cerai Mati'
                };

                return aliases[normalized] ??
                    extractValue(value);
            }

            /**
             * Normalisasi kewarganegaraan.
             */
            function normalizeKewarganegaraan(value) {
                const normalized = normalizeText(value);

                if (
                    normalized === 'WNI' ||
                    normalized.includes('INDONESIA')
                ) {
                    return 'WNI';
                }

                if (
                    normalized === 'WNA' ||
                    normalized.includes('ASING')
                ) {
                    return 'WNA';
                }

                return 'WNI';
            }

            /**
             * Normalisasi pekerjaan.
             */
            function normalizePekerjaan(value) {
                const originalValue = extractValue(value);
                const normalized = normalizeText(originalValue);

                const aliases = {
                    BELUMBEKERJA: 'BELUM/TIDAK BEKERJA',

                    TIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    BELUMTIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    PELAJAR: 'PELAJAR/MAHASISWA',

                    MAHASISWA: 'PELAJAR/MAHASISWA',

                    PELAJARMAHASISWA: 'PELAJAR/MAHASISWA',

                    IRT: 'IBU RUMAH TANGGA',

                    PNS: 'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPIL: 'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPILPNS: 'PEGAWAI NEGERI SIPIL (PNS)',

                    TNI: 'TENTARA NASIONAL INDONESIA (TNI)',

                    TENTARANASIONALINDONESIA: 'TENTARA NASIONAL INDONESIA (TNI)',

                    POLRI: 'KEPOLISIAN RI (POLRI)',

                    KEPOLISIANREPUBLIKINDONESIA: 'KEPOLISIAN RI (POLRI)',

                    PETANI: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    PEKEBUN: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    BURUHTANI: 'BURUH TANI/PERKEBUNAN',

                    NELAYAN: 'NELAYAN/PERIKANAN',

                    BURUHNELAYAN: 'BURUH NELAYAN/PERIKANAN',

                    HONORER: 'KARYAWAN HONORER',

                    PEGAWAIHONORER: 'KARYAWAN HONORER',

                    LAINLAIN: 'LAINNYA'
                };

                return aliases[normalized] ??
                    originalValue;
            }

            /**
             * Mengambil data penduduk dari endpoint.
             */
            async function lookupPenduduk(
                nik,
                feedbackElement,
                requestController
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
                    signal: requestController.signal
                });

                const result = await response.json();

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

            /**
             * Autofill orang tua.
             */
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

                parentRequestController =
                    new AbortController();

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
                        resolveJenisKelamin(
                            data,
                            result
                        )
                    );

                    setSelectValue(
                        'agama',
                        normalizeAgama(data.agama),
                        true
                    );

                    setSelectValue(
                        'kewarganegaraan',
                        normalizeKewarganegaraan(
                            data.kewarganegaraan
                        )
                    );

                    setSelectValue(
                        'status',
                        normalizeStatus(
                            data.status_perkawinan ??
                            data.status
                        )
                    );

                    setSelectValue(
                        'pekerjaan',
                        normalizePekerjaan(
                            data.pekerjaan
                        ),
                        true
                    );

                    setInputValue(
                        'alamat',
                        data.alamat
                    );

                    setFeedback(
                        nikFeedback,
                        'Data orang tua berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    setFeedback(
                        nikFeedback,
                        error.message ||
                        'Gagal mengambil data orang tua.',
                        'error'
                    );

                    console.error(
                        'Autofill orang tua:',
                        error
                    );
                }
            }

            /**
             * Autofill anak.
             */
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

                childRequestController =
                    new AbortController();

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
                        formatTanggal(
                            data.tanggal_lahir
                        );

                    if (tanggalLahirAnak) {
                        setInputValue(
                            'tanggal_lahir_anak',
                            tanggalLahirAnak
                        );
                    }

                    setSelectValue(
                        'jenis_kelamin_anak',
                        resolveJenisKelamin(
                            data,
                            result
                        )
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

            /**
             * Event NIK orang tua.
             */
            if (nikInput) {
                nikInput.addEventListener(
                    'input',
                    function() {
                        this.value = this.value
                            .replace(/\D/g, '')
                            .slice(0, 16);

                        setFeedback(
                            nikFeedback,
                            `${this.value.length}/16 digit. Tekan Enter untuk mencari.`
                        );
                    }
                );

                nikInput.addEventListener(
                    'keydown',
                    function(event) {
                        if (
                            event.key === 'Enter' ||
                            event.keyCode === 13
                        ) {
                            event.preventDefault();
                            event.stopPropagation();

                            autofillOrangTua();
                        }
                    }
                );
            }

            /**
             * Event NIK anak.
             */
            if (nikAnakInput) {
                nikAnakInput.addEventListener(
                    'input',
                    function() {
                        this.value = this.value
                            .replace(/\D/g, '')
                            .slice(0, 16);

                        setFeedback(
                            nikAnakFeedback,
                            `${this.value.length}/16 digit. Tekan Enter untuk mencari.`
                        );
                    }
                );

                nikAnakInput.addEventListener(
                    'keydown',
                    function(event) {
                        if (
                            event.key === 'Enter' ||
                            event.keyCode === 13
                        ) {
                            event.preventDefault();
                            event.stopPropagation();

                            autofillAnak();
                        }
                    }
                );
            }
        });
    </script>
</body>

</html>
