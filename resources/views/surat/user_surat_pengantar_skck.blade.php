{{-- -- view user --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitakro - Aplikasi Pertanian">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <title>Form Surat Pengantar SKCK</title>

    <link rel="icon" href="{{ asset('assets4/img/core-img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets4/img/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets4/img/icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets4/img/icons/icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets4/img/icons/icon-180x180.png') }}">

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
    <link rel="manifest" href="/assets4/dist/manifest.json">
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="internet-connection-status" id="internetStatus"></div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.keterangan') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <div class="page-heading">
                    <h6 class="mb-0">Form Surat Pengantar SKCK</h6>
                </div>

                <div class="setting-wrapper"></div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="element-heading">
                <h6>Buat Pengajuan Surat Pengantar SKCK</h6>
            </div>
        </div>

        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.userskck.store') }}" method="POST">
                        @csrf

                        <h5 class="mb-3">Data Pemohon</h5>

                        <div class="mb-3">
                            <label for="nik" class="form-label">Nomor NIK <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" required
                                value="{{ old('nik') }}" maxlength="16" inputmode="numeric" placeholder="16 digit">
                            <small class="text-muted">Isi NIK lalu klik/tab keluar agar data otomatis terisi.</small>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" required
                                value="{{ old('nama') }}">
                        </div>

                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                                value="{{ old('tempat_lahir') }}">
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                                value="{{ old('tanggal_lahir') }}">
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                    class="text-danger">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Laki-laki', 'Perempuan'] as $jk)
                                    <option value="{{ $jk }}"
                                        {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>
                                        {{ $jk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span
                                    class="text-danger">*</span></label>
                            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['WNI', 'WNA'] as $kw)
                                    <option value="{{ $kw }}"
                                        {{ old('kewarganegaraan') == $kw ? 'selected' : '' }}>
                                        {{ $kw }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                    <option value="{{ $st }}" {{ old('status') == $st ? 'selected' : '' }}>
                                        {{ $st }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Khonghucu', 'Lainnya'] as $ag)
                                    <option value="{{ $ag }}" {{ old('agama') == $ag ? 'selected' : '' }}>
                                        {{ $ag }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="pendidikan" class="form-label">Pendidikan <span
                                    class="text-danger">*</span></label>
                            <select name="pendidikan" id="pendidikan" class="form-control" required>
                                <option value="">-- Pilih Pendidikan --</option>

                                @foreach (['TIDAK/BLM SEKOLAH', 'BELUM TAMAT SD/SEDERAJAT', 'TAMAT SD/SEDERAJAT', 'SLTP/SEDERAJAT', 'SLTA/SEDERAJAT', 'DIPLOMA I/II', 'AKADEMI/DIPLOMA III/SARJANA MUDA', 'DIPLOMA IV/STRATA I', 'STRATA-II', 'STRATA-III'] as $pd)
                                    <option value="{{ $pd }}"
                                        {{ old('pendidikan') == $pd ? 'selected' : '' }}>
                                        {{ $pd }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">Pekerjaan <span
                                    class="text-danger">*</span></label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih Pekerjaan --</option>
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
                                        'Pegawai Kantor Desa',
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
                                        'Petani/Pekebun penyewa',
                                        'TKI',
                                        'Lainnya',
                                    ];
                                @endphp

                                @foreach ($jobs as $job)
                                    <option value="{{ $job }}"
                                        {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                        {{ $job }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span
                                    class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Informasi Surat</h5>

                        <div class="mb-3">
                            <label for="keperuntukan" class="form-label">Keperuntukan Surat <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="keperuntukan" id="keperuntukan" class="form-control"
                                required value="{{ old('keperuntukan') }}"
                                placeholder="Misal: Pengajuan SKCK di Polres ...">
                        </div>

                        <input type="hidden" name="status_surat" value="Pending">
                        <input type="hidden" name="status_verif" value="Belum Verifikasi">

                        <div class="mb-3">
                            <label for="nowa" class="form-label">No WhatsApp <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nowa" id="nowa" class="form-control" required
                                value="{{ old('nowa') }}" placeholder="+62812xxxx">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Kirim</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="active">
                        <a href="{{ route('surat.pengajuan_surat') }}">
                            <i class="bi bi-house"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const nikFeedback = document.getElementById('nik-feedback');

            const lookupUrlTemplate = @json(route('datapenduduk.lookup', ['nik' => '__NIK__']));

            let activeRequest = null;

            /**
             * Menampilkan status pencarian NIK.
             */
            function setNikFeedback(message, type = '') {
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

                const classes = {
                    loading: 'text-primary',
                    success: 'text-success',
                    error: 'text-danger'
                };

                nikFeedback.classList.add(
                    classes[type] ?? 'text-muted'
                );
            }

            /**
             * Mengambil isi apabila nilai berbentuk object.
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
                    'value',
                    'nama',
                    'label',
                    'keterangan',
                    'jenis_kelamin',
                    'jenisKelamin',
                    'jk',
                    'kelamin',
                    'gender',
                    'code',
                    'kode',
                    'id'
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
             * Normalisasi teks untuk membandingkan option.
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
             * Mengisi input biasa.
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
             * Memilih option pada select.
             */
            function setSelectValue(
                id,
                value,
                addOptionWhenMissing = false
            ) {
                const element = document.getElementById(id);
                const originalValue = extractValue(value);

                if (!element || originalValue === '') {
                    return false;
                }

                const normalizedValue = normalizeText(originalValue);

                let matchedOption = Array.from(element.options).find(option => {
                    return normalizeText(option.value) === normalizedValue ||
                        normalizeText(option.textContent) === normalizedValue;
                });

                /*
                 * Pencocokan sebagian.
                 */
                if (!matchedOption) {
                    matchedOption = Array.from(element.options).find(option => {
                        if (!option.value) {
                            return false;
                        }

                        const optionValue = normalizeText(option.value);
                        const optionText = normalizeText(option.textContent);

                        return optionValue.includes(normalizedValue) ||
                            normalizedValue.includes(optionValue) ||
                            optionText.includes(normalizedValue) ||
                            normalizedValue.includes(optionText);
                    });
                }

                if (!matchedOption && addOptionWhenMissing) {
                    matchedOption = new Option(
                        originalValue,
                        originalValue,
                        true,
                        true
                    );

                    element.add(matchedOption);
                }

                if (!matchedOption) {
                    console.warn(
                        `Option untuk ${id} tidak ditemukan:`,
                        originalValue
                    );

                    return false;
                }

                element.value = matchedOption.value;
                matchedOption.selected = true;

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

                /*
                 * Dukungan apabila select memakai jQuery,
                 * Select2, atau plugin sejenis.
                 */
                if (window.jQuery) {
                    window.jQuery(element)
                        .val(matchedOption.value)
                        .trigger('change');
                }

                return true;
            }

            /**
             * Mengubah berbagai format jenis kelamin menjadi
             * Laki-laki atau Perempuan.
             */
            function normalizeJenisKelamin(value) {
                const rawValue = extractValue(value);

                if (rawValue === '') {
                    return '';
                }

                const normalized = normalizeText(rawValue);

                const nilaiLakiLaki = [
                    '1',
                    'L',
                    'LK',
                    'LKLK',
                    'LAKI',
                    'LAKILAKI',
                    'PRIA',
                    'MALE',
                    'MAN'
                ];

                const nilaiPerempuan = [
                    '0',
                    '2',
                    'P',
                    'PR',
                    'PRPR',
                    'PEREMPUAN',
                    'WANITA',
                    'FEMALE',
                    'WOMAN'
                ];

                if (nilaiLakiLaki.includes(normalized)) {
                    return 'Laki-laki';
                }

                if (nilaiPerempuan.includes(normalized)) {
                    return 'Perempuan';
                }

                /*
                 * Mendukung teks seperti:
                 * Jenis Kelamin: Laki-Laki
                 */
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
             * Mencari jenis kelamin dari semua kemungkinan key JSON.
             */
            function resolveJenisKelamin(data, result) {
                const candidates = [
                    data?.jenis_kelamin,
                    data?.jenisKelamin,
                    data?.jk,
                    data?.kelamin,
                    data?.gender,
                    data?.sex,

                    data?.penduduk?.jenis_kelamin,
                    data?.penduduk?.jenisKelamin,
                    data?.penduduk?.jk,
                    data?.penduduk?.kelamin,

                    result?.debug?.jenis_kelamin_hasil,
                    result?.debug?.jenis_kelamin_asli,
                    result?.debug?.jenis_kelamin,
                    result?.jenis_kelamin
                ];

                for (const candidate of candidates) {
                    const hasil = normalizeJenisKelamin(candidate);

                    if (hasil !== '') {
                        return hasil;
                    }
                }

                return '';
            }

            /**
             * Mengisi select jenis kelamin secara khusus.
             */
            function setJenisKelamin(data, result) {
                const select = document.getElementById('jenis_kelamin');

                if (!select) {
                    return false;
                }

                const jenisKelamin = resolveJenisKelamin(data, result);

                console.log('Jenis kelamin dari API:', {
                    jenis_kelamin: data?.jenis_kelamin,
                    jenisKelamin: data?.jenisKelamin,
                    jk: data?.jk,
                    kelamin: data?.kelamin,
                    gender: data?.gender,
                    debug: result?.debug,
                    hasil: jenisKelamin
                });

                if (jenisKelamin === '') {
                    select.value = '';

                    console.warn(
                        'Jenis kelamin tidak ditemukan dalam respons API.'
                    );

                    return false;
                }

                const berhasil = setSelectValue(
                    'jenis_kelamin',
                    jenisKelamin
                );

                /*
                 * Set ulang sesaat setelah field lain selesai,
                 * untuk mencegah plugin atau script lain mereset select.
                 */
                if (berhasil) {
                    setTimeout(function() {
                        setSelectValue(
                            'jenis_kelamin',
                            jenisKelamin
                        );
                    }, 100);
                }

                return berhasil;
            }

            function formatTanggal(value) {
                const tanggal = extractValue(value);

                if (!tanggal) {
                    return '';
                }

                if (/^\d{4}-\d{2}-\d{2}/.test(tanggal)) {
                    return tanggal.substring(0, 10);
                }

                if (/^\d{2}-\d{2}-\d{4}/.test(tanggal)) {
                    const parts = tanggal.split('-');

                    return `${parts[2]}-${parts[1]}-${parts[0]}`;
                }

                if (/^\d{2}\/\d{2}\/\d{4}/.test(tanggal)) {
                    const parts = tanggal.split('/');

                    return `${parts[2]}-${parts[1]}-${parts[0]}`;
                }

                return tanggal.substring(0, 10);
            }

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

                return extractValue(value) || 'WNI';
            }

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

                return aliases[normalized] ?? extractValue(value);
            }

            function normalizeAgama(value) {
                const normalized = normalizeText(value);

                const aliases = {
                    ISLAM: 'Islam',
                    KRISTEN: 'Kristen',
                    KRISTENPROTESTAN: 'Kristen',
                    PROTESTAN: 'Kristen',
                    KATOLIK: 'Katolik',
                    KRISTENKATOLIK: 'Katolik',
                    HINDU: 'Hindu',
                    BUDHA: 'Buddha',
                    BUDDHA: 'Buddha',
                    KONGHUCU: 'Konghucu',
                    KHONGHUCU: 'Khonghucu',
                    LAINNYA: 'Lainnya'
                };

                return aliases[normalized] ?? extractValue(value);
            }

            function normalizePendidikan(value) {
                const normalized = normalizeText(value);

                const aliases = {
                    TIDAKBELUMSEKOLAH: 'TIDAK/BLM SEKOLAH',
                    TIDAKBLMSEKOLAH: 'TIDAK/BLM SEKOLAH',
                    BELUMTAMATSDSEDERAJAT: 'BELUM TAMAT SD/SEDERAJAT',
                    TAMATSDSEDERAJAT: 'TAMAT SD/SEDERAJAT',
                    SD: 'TAMAT SD/SEDERAJAT',
                    SMP: 'SLTP/SEDERAJAT',
                    SLTPSEDERAJAT: 'SLTP/SEDERAJAT',
                    SMA: 'SLTA/SEDERAJAT',
                    SMK: 'SLTA/SEDERAJAT',
                    SLTASEDERAJAT: 'SLTA/SEDERAJAT',
                    D1: 'DIPLOMA I/II',
                    D2: 'DIPLOMA I/II',
                    DIPLOMAIII: 'AKADEMI/DIPLOMA III/SARJANA MUDA',
                    D3: 'AKADEMI/DIPLOMA III/SARJANA MUDA',
                    D4: 'DIPLOMA IV/STRATA I',
                    S1: 'DIPLOMA IV/STRATA I',
                    STRATAI: 'DIPLOMA IV/STRATA I',
                    S2: 'STRATA-II',
                    STRATAII: 'STRATA-II',
                    S3: 'STRATA-III',
                    STRATAIII: 'STRATA-III'
                };

                return aliases[normalized] ?? extractValue(value);
            }

            function normalizePekerjaan(value) {
                const normalized = normalizeText(value);

                const aliases = {
                    BELUMBEKERJA: 'BELUM/TIDAK BEKERJA',
                    TIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',
                    PELAJAR: 'PELAJAR/MAHASISWA',
                    MAHASISWA: 'PELAJAR/MAHASISWA',
                    IRT: 'IBU RUMAH TANGGA',
                    PNS: 'PEGAWAI NEGERI SIPIL (PNS)',
                    PEGAWAINEGERISIPIL: 'PEGAWAI NEGERI SIPIL (PNS)',
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

                return aliases[normalized] ?? extractValue(value);
            }

            /**
             * Mengosongkan data hasil autofill.
             */
            function clearAutofillFields() {
                [
                    'nama',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'alamat'
                ].forEach(id => {
                    const element = document.getElementById(id);

                    if (element) {
                        element.value = '';
                    }
                });

                [
                    'jenis_kelamin',
                    'kewarganegaraan',
                    'status',
                    'agama',
                    'pendidikan',
                    'pekerjaan'
                ].forEach(id => {
                    const element = document.getElementById(id);

                    if (element) {
                        element.value = '';
                    }
                });
            }

            /**
             * Autofill berdasarkan NIK.
             */
            async function autofillSkck() {
                if (!nikInput) {
                    return;
                }

                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setNikFeedback(
                        `${nik.length}/16 digit NIK`,
                        nik.length > 0 ? 'error' : ''
                    );

                    return;
                }

                if (activeRequest) {
                    activeRequest.abort();
                }

                activeRequest = new AbortController();

                const url = lookupUrlTemplate.replace(
                    '__NIK__',
                    encodeURIComponent(nik)
                );

                setNikFeedback(
                    'Sedang mencari data penduduk...',
                    'loading'
                );

                try {
                    const response = await fetch(url, {
                        method: 'GET',

                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        cache: 'no-store',
                        signal: activeRequest.signal
                    });

                    const result = await response.json();

                    console.log(
                        'Respons lengkap lookup NIK:',
                        result
                    );

                    if (!response.ok || !result.success) {
                        throw new Error(
                            result.message ||
                            'Data penduduk tidak ditemukan.'
                        );
                    }

                    const data = result.data ?? {};

                    setInputValue(
                        'nama',
                        data.nama
                    );

                    setInputValue(
                        'tempat_lahir',
                        data.tempat_lahir
                    );

                    setInputValue(
                        'tanggal_lahir',
                        formatTanggal(data.tanggal_lahir)
                    );

                    setInputValue(
                        'alamat',
                        data.alamat
                    );

                    /*
                     * Jenis kelamin menggunakan fungsi khusus.
                     */
                    setJenisKelamin(data, result);

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
                        'agama',
                        normalizeAgama(data.agama),
                        true
                    );

                    setSelectValue(
                        'pendidikan',
                        normalizePendidikan(
                            data.pendidikan
                        ),
                        true
                    );

                    setSelectValue(
                        'pekerjaan',
                        normalizePekerjaan(
                            data.pekerjaan
                        ),
                        true
                    );

                    setNikFeedback(
                        'Data penduduk berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    clearAutofillFields();

                    setNikFeedback(
                        error.message ||
                        'Gagal mengambil data penduduk.',
                        'error'
                    );

                    console.error(
                        'Kesalahan autofill NIK:',
                        error
                    );
                }
            }

            if (nikInput) {
                nikInput.addEventListener('input', function() {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 16);

                    if (this.value.length === 16) {
                        autofillSkck();
                    } else {
                        setNikFeedback(
                            `${this.value.length}/16 digit NIK`
                        );
                    }
                });

                nikInput.addEventListener('change', function() {
                    if (this.value.length === 16) {
                        autofillSkck();
                    }
                });

                nikInput.addEventListener('blur', function() {
                    if (this.value.length === 16) {
                        autofillSkck();
                    }
                });

                if (
                    nikInput.value
                    .replace(/\D/g, '')
                    .length === 16
                ) {
                    autofillSkck();
                }
            }
        });
    </script>
</body>

</html>
