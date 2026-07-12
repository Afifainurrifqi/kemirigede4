<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitakro - Aplikasi Pertanian">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="icon" href="{{ asset('assets4/img/core-img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets4/img/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets4/img/icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets4/img/icons/icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets4/img/icons/icon-180x180.png') }}">
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
    <link rel="manifest" href="/assets4/dist/manifest.json">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content position-relative d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Form Surat Keterangan Waris</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="element-heading">
                <h6>Buat Pengajuan Surat Keterangan Waris</h6>
            </div>
        </div>

        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('surat.userahliwaris.store') }}" method="POST">
                        @csrf

                        {{-- YANG BERTANDA TANGAN --}}
                        <h5 class="mb-3">Yang Bertanda Tangan</h5>
                        <div class="mb-3">
                            <label class="form-label" for="no_ktp">NIK</label>
                            <input type="text" id="no_ktp" name="no_ktp" class="form-control" required
                                value="{{ old('no_ktp') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required
                                value="{{ old('nama_lengkap') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required
                                value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required
                                value="{{ old('tanggal_lahir') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="agama">Agama</label>
                            <select id="agama" name="agama" class="form-control" required>
                                <option value="">-- Pilih Agama --</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $a)
                                    <option value="{{ $a }}" {{ old('agama') === $a ? 'selected' : '' }}>
                                        {{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pekerjaan">Pekerjaan</label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih pekerjaan --</option>
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
                                        'Guru agama_penumpang_kk',
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
                                        {{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $s)
                                    <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>
                                        {{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr class="my-4">

                        {{-- KETERANGAN ISTRI --}}
                        <h5 class="mb-3">Keterangan Istri</h5>
                        <div class="mb-3">
                            <label class="form-label" for="no_ktp_istri">NIK Istri</label>
                            <input type="text" id="no_ktp_istri" name="no_ktp_istri" class="form-control"
                                required value="{{ old('no_ktp_istri') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama_istri">Nama Lengkap</label>
                            <input type="text" id="nama_istri" name="nama_istri" class="form-control" required
                                value="{{ old('nama_istri') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tempat_lahir_istri">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir_istri" name="tempat_lahir_istri"
                                class="form-control" required value="{{ old('tempat_lahir_istri') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal_lahir_istri">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir_istri" name="tanggal_lahir_istri"
                                class="form-control" required value="{{ old('tanggal_lahir_istri') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="agama_istri">Agama</label>
                            <select id="agama_istri" name="agama_istri" class="form-control" required>
                                <option value="">-- Pilih Agama --</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $ai)
                                    <option value="{{ $ai }}"
                                        {{ old('agama_istri') === $ai ? 'selected' : '' }}>
                                        {{ $ai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pekerjaan_istri">Pekerjaan</label>
                            <select name="pekerjaan_istri" id="pekerjaan_istri" class="form-control" required>
                                <option value="">-- Pilih pekerjaan_istri --</option>
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
                                        'Guru agama_penumpang_kk',
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
                                        {{ old('pekerjaan_istri') == $job ? 'selected' : '' }}>
                                        {{ $job }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status_istri">Status</label>
                            <select id="status_istri" name="status_istri" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $si)
                                    <option value="{{ $si }}"
                                        {{ old('status_istri') === $si ? 'selected' : '' }}>
                                        {{ $si }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="alamat_istri">Alamat</label>
                            <textarea id="alamat_istri" name="alamat_istri" class="form-control" rows="2" required>{{ old('alamat_istri') }}</textarea>
                        </div>

                        <hr class="my-4">

                        {{-- ANAK DINAMIS --}}
                        <h5 class="mb-2">Anak</h5>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label" for="jumlah_anak">Jumlah Anak</label>
                                <input type="number" min="0" id="jumlah_anak" name="jumlah_anak"
                                    class="form-control" required value="{{ old('jumlah_anak', 0) }}">
                            </div>
                        </div>
                        <div id="anak-wrapper" class="mt-3"></div>

                        <div class="mb-3 mt-3">
                            <label class="form-label" for="hubungan_dengan_ahli_waris">Hubungan dengan Ahli
                                Waris</label>
                            <input type="text" id="hubungan_dengan_ahli_waris" name="hubungan_dengan_ahli_waris"
                                class="form-control" required value="{{ old('hubungan_dengan_ahli_waris') }}">
                        </div>

                        <hr class="my-4">

                        {{-- SAKSI DINAMIS --}}
                        <h5 class="mb-2">Saksi</h5>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label" for="jumlah_saksi">Jumlah Saksi</label>
                                <input type="number" min="0" id="jumlah_saksi" name="jumlah_saksi"
                                    class="form-control" required value="{{ old('jumlah_saksi', 0) }}">
                            </div>
                        </div>
                        <div id="saksi-wrapper" class="mt-3"></div>

                        {{-- Hidden default status untuk USER --}}
                        <input type="hidden" name="status_surat" value="Pending">
                        <input type="hidden" name="status_verif" value="Belum Verifikasi">

                        <div class="mb-3 mt-3">
                            <label class="form-label" for="nowa">No WhatsApp</label>
                            <input type="text" id="nowa" name="nowa" class="form-control" required
                                value="{{ old('nowa') }}">
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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

    <!-- JavaScript Files -->
    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>
</body>

</html>

<script>
    (function() {
        const anakWrapper = document.getElementById('anak-wrapper');
        const saksiWrapper = document.getElementById('saksi-wrapper');
        const jumlahAnak = document.getElementById('jumlah_anak');
        const jumlahSaksi = document.getElementById('jumlah_saksi');

        const oldAnak = @json(old('nama_anak', []));
        const oldSaksi = @json(old('nama_saksi', []));

        function renderInputs(wrapper, count, name, placeholder, oldVals) {
            wrapper.innerHTML = '';
            const n = parseInt(count || 0, 10);
            for (let i = 0; i < n; i++) {
                const div = document.createElement('div');
                div.className = 'mb-2';
                div.innerHTML = `
                <label class="form-label">${placeholder} ${i+1}</label>
                <input type="text" name="${name}[]" class="form-control" value="${oldVals[i] ? String(oldVals[i]).replace(/"/g,'&quot;') : ''}">
            `;
                wrapper.appendChild(div);
            }
        }

        renderInputs(anakWrapper, jumlahAnak.value, 'nama_anak', 'Nama Anak', oldAnak);
        renderInputs(saksiWrapper, jumlahSaksi.value, 'nama_saksi', 'Nama Saksi', oldSaksi);

        jumlahAnak.addEventListener('input', () => renderInputs(anakWrapper, jumlahAnak.value, 'nama_anak',
            'Nama Anak', []));
        jumlahSaksi.addEventListener('input', () => renderInputs(saksiWrapper, jumlahSaksi.value, 'nama_saksi',
            'Nama Saksi', []));
    })();
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nikUtamaInput = document.getElementById('no_ktp');
        const nikIstriInput = document.getElementById('no_ktp_istri');

        const lookupUrlTemplate = @json(
            route('datapenduduk.lookup', [
                'nik' => '__NIK__'
            ])
        );

        let requestUtama = null;
        let requestIstri = null;

        /**
         * Mengambil nilai dari string atau object relasi API.
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
                'nama_pekerjaan',
                'nama_status',
                'nama_agama',

                'pekerjaan',
                'jenis_pekerjaan',
                'status',
                'status_perkawinan',
                'agama',

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
         * Menyamakan huruf, spasi, slash, tanda kurung,
         * underscore, dan tanda baca.
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
         * Mengisi input biasa atau textarea.
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
         * Memilih nilai select dengan pencocokan fleksibel.
         */
        function setSelectValue(
            id,
            value,
            addWhenMissing = true
        ) {
            const select = document.getElementById(id);
            const originalValue = extractValue(value);

            if (
                !select ||
                originalValue === ''
            ) {
                console.warn(
                    `Nilai ${id} kosong:`,
                    value
                );

                return false;
            }

            const normalizedValue =
                normalizeText(originalValue);

            /*
             * Pencocokan sama persis setelah dinormalisasi.
             */
            let matchedOption = Array.from(
                select.options
            ).find(function (option) {
                return (
                    normalizeText(option.value) ===
                        normalizedValue ||
                    normalizeText(option.textContent) ===
                        normalizedValue
                );
            });

            /*
             * Pencocokan sebagian.
             */
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
                        normalizedOption.includes(
                            normalizedValue
                        ) ||
                        normalizedValue.includes(
                            normalizedOption
                        )
                    );
                });
            }

            /*
             * Apabila pekerjaan database belum tersedia
             * dalam daftar, tambahkan sebagai option.
             */
            if (
                !matchedOption &&
                addWhenMissing
            ) {
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
         * Format tanggal untuk input type="date".
         */
        function formatTanggal(value) {
            const rawValue = extractValue(value);

            if (!rawValue) {
                return '';
            }

            /*
             * Format YYYY-MM-DD atau timestamp ISO.
             */
            const isoMatch = rawValue.match(
                /^(\d{4})-(\d{2})-(\d{2})/
            );

            if (isoMatch) {
                return `${isoMatch[1]}-${isoMatch[2]}-${isoMatch[3]}`;
            }

            /*
             * Format DD-MM-YYYY atau DD/MM/YYYY.
             */
            const indonesiaMatch = rawValue.match(
                /^(\d{2})[\/-](\d{2})[\/-](\d{4})$/
            );

            if (indonesiaMatch) {
                return `${indonesiaMatch[3]}-${indonesiaMatch[2]}-${indonesiaMatch[1]}`;
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
                KHONGHUCU: 'Khonghucu'
            };

            return aliases[normalized] ||
                rawValue;
        }

        /**
         * Normalisasi status perkawinan.
         */
        function normalizeStatus(value) {
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
                BELUMKAWIN:
                    'Belum Kawin',

                BELUMMENIKAH:
                    'Belum Kawin',

                TIDAKKAWIN:
                    'Belum Kawin',

                SINGLE:
                    'Belum Kawin',

                KAWIN:
                    'Kawin',

                MENIKAH:
                    'Kawin',

                SUDAHMENIKAH:
                    'Kawin',

                MARRIED:
                    'Kawin',

                CERAIHIDUP:
                    'Cerai Hidup',

                CERAI:
                    'Cerai Hidup',

                CERAIMATI:
                    'Cerai Mati'
            };

            return aliases[normalized] ||
                rawValue;
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
                    'Petani/Pekebun penyewa',

                PETANIPEKEBUNPENYEWA:
                    'Petani/Pekebun penyewa',

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

                BURUHNELAYANPERIKANAN:
                    'BURUH NELAYAN/PERIKANAN',

                HONORER:
                    'KARYAWAN HONORER',

                PEGAWAIHONORER:
                    'KARYAWAN HONORER',

                KARYAWANHONORER:
                    'KARYAWAN HONORER',

                PEGAWAIKANTORDESA:
                    'Pegawai Kantor Desa',

                GURUAGAMA:
                    'Guru agama_penumpang_kk',

                LAINLAIN:
                    'Lainnya',

                LAINNYA:
                    'Lainnya'
            };

            return aliases[normalized] ||
                rawValue;
        }

        /**
         * Mengambil data penduduk dari endpoint.
         */
        async function lookupPenduduk(
            nik,
            abortController
        ) {
            const url = lookupUrlTemplate.replace(
                '__NIK__',
                encodeURIComponent(nik)
            );

            const response = await fetch(url, {
                method: 'GET',

                headers: {
                    'Accept':
                        'application/json',

                    'X-Requested-With':
                        'XMLHttpRequest'
                },

                cache: 'no-store',
                signal: abortController.signal
            });

            let result;

            try {
                result = await response.json();
            } catch (error) {
                throw new Error(
                    'Respons server tidak valid.'
                );
            }

            console.log(
                'Respons lookup ahli waris:',
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

            return result;
        }

        /**
         * Autofill pihak utama.
         */
        async function autofillAhliWarisUtama() {
            const nik = nikUtamaInput.value
                .replace(/\D/g, '')
                .slice(0, 16);

            nikUtamaInput.value = nik;

            if (nik.length !== 16) {
                alert(
                    'NIK utama harus terdiri dari 16 digit.'
                );

                return;
            }

            if (requestUtama) {
                requestUtama.abort();
            }

            requestUtama =
                new AbortController();

            try {
                const result = await lookupPenduduk(
                    nik,
                    requestUtama
                );

                const data = result.data;

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
                        data.tgl_lahir
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
                    data.alamat_lengkap
                );

                const agamaValue =
                    normalizeAgama(
                        data.agama ??
                        data.nama_agama
                    );

                const pekerjaanValue =
                    normalizePekerjaan(
                        data.pekerjaan ??
                        data.nama_pekerjaan ??
                        data.pekerjaan_nama ??
                        data.jenis_pekerjaan
                    );

                const statusValue =
                    normalizeStatus(
                        data.status_perkawinan ??
                        data.status ??
                        data.nama_status
                    );

                setSelectValue(
                    'agama',
                    agamaValue,
                    true
                );

                setSelectValue(
                    'pekerjaan',
                    pekerjaanValue,
                    true
                );

                setSelectValue(
                    'status',
                    statusValue,
                    true
                );

                /*
                 * Set ulang untuk plugin select.
                 */
                setTimeout(function () {
                    setSelectValue(
                        'agama',
                        agamaValue,
                        true
                    );

                    setSelectValue(
                        'pekerjaan',
                        pekerjaanValue,
                        true
                    );

                    setSelectValue(
                        'status',
                        statusValue,
                        true
                    );
                }, 150);

                console.log(
                    'Autofill utama:',
                    {
                        pekerjaan_asli:
                            data.pekerjaan,

                        pekerjaan_hasil:
                            pekerjaanValue,

                        status_asli:
                            data.status_perkawinan ??
                            data.status,

                        status_hasil:
                            statusValue
                    }
                );
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                console.error(
                    'Autofill ahli waris utama:',
                    error
                );

                alert(error.message);
            }
        }

        /**
         * Autofill istri.
         */
        async function autofillAhliWarisIstri() {
            const nik = nikIstriInput.value
                .replace(/\D/g, '')
                .slice(0, 16);

            nikIstriInput.value = nik;

            if (nik.length !== 16) {
                alert(
                    'NIK istri harus terdiri dari 16 digit.'
                );

                return;
            }

            if (requestIstri) {
                requestIstri.abort();
            }

            requestIstri =
                new AbortController();

            try {
                const result = await lookupPenduduk(
                    nik,
                    requestIstri
                );

                const data = result.data;

                setInputValue(
                    'nama_istri',
                    data.nama ??
                    data.nama_lengkap
                );

                setInputValue(
                    'tempat_lahir_istri',
                    data.tempat_lahir
                );

                const tanggalLahir =
                    formatTanggal(
                        data.tanggal_lahir ??
                        data.tgl_lahir
                    );

                if (tanggalLahir) {
                    setInputValue(
                        'tanggal_lahir_istri',
                        tanggalLahir
                    );
                }

                setInputValue(
                    'alamat_istri',
                    data.alamat ??
                    data.alamat_lengkap
                );

                const agamaValue =
                    normalizeAgama(
                        data.agama ??
                        data.nama_agama
                    );

                const pekerjaanValue =
                    normalizePekerjaan(
                        data.pekerjaan ??
                        data.nama_pekerjaan ??
                        data.pekerjaan_nama ??
                        data.jenis_pekerjaan
                    );

                const statusValue =
                    normalizeStatus(
                        data.status_perkawinan ??
                        data.status ??
                        data.nama_status
                    );

                setSelectValue(
                    'agama_istri',
                    agamaValue,
                    true
                );

                setSelectValue(
                    'pekerjaan_istri',
                    pekerjaanValue,
                    true
                );

                setSelectValue(
                    'status_istri',
                    statusValue,
                    true
                );

                setTimeout(function () {
                    setSelectValue(
                        'agama_istri',
                        agamaValue,
                        true
                    );

                    setSelectValue(
                        'pekerjaan_istri',
                        pekerjaanValue,
                        true
                    );

                    setSelectValue(
                        'status_istri',
                        statusValue,
                        true
                    );
                }, 150);

                console.log(
                    'Autofill istri:',
                    {
                        pekerjaan_asli:
                            data.pekerjaan,

                        pekerjaan_hasil:
                            pekerjaanValue,

                        status_asli:
                            data.status_perkawinan ??
                            data.status,

                        status_hasil:
                            statusValue
                    }
                );
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                console.error(
                    'Autofill ahli waris istri:',
                    error
                );

                alert(error.message);
            }
        }

        /**
         * Input NIK utama:
         * hanya lookup setelah menekan Enter.
         */
        if (nikUtamaInput) {
            nikUtamaInput.setAttribute(
                'maxlength',
                '16'
            );

            nikUtamaInput.setAttribute(
                'inputmode',
                'numeric'
            );

            nikUtamaInput.addEventListener(
                'input',
                function () {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 16);
                }
            );

            nikUtamaInput.addEventListener(
                'keydown',
                function (event) {
                    if (
                        event.key === 'Enter' ||
                        event.keyCode === 13
                    ) {
                        event.preventDefault();
                        event.stopPropagation();

                        autofillAhliWarisUtama();
                    }
                }
            );
        }

        /**
         * Input NIK istri:
         * hanya lookup setelah menekan Enter.
         */
        if (nikIstriInput) {
            nikIstriInput.setAttribute(
                'maxlength',
                '16'
            );

            nikIstriInput.setAttribute(
                'inputmode',
                'numeric'
            );

            nikIstriInput.addEventListener(
                'input',
                function () {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 16);
                }
            );

            nikIstriInput.addEventListener(
                'keydown',
                function (event) {
                    if (
                        event.key === 'Enter' ||
                        event.keyCode === 13
                    ) {
                        event.preventDefault();
                        event.stopPropagation();

                        autofillAhliWarisIstri();
                    }
                }
            );
        }
    });
</script>
