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
        function setValueIfExists(id, value) {
            const element = document.getElementById(id);

            if (element && value !== undefined && value !== null && value !== '') {
                element.value = value;
            }
        }

        function setSelectIfExists(id, value) {
            const element = document.getElementById(id);

            if (!element || value === undefined || value === null || value === '') {
                return;
            }

            const normalizedValue = String(value).trim().toLowerCase();

            const matched = Array.from(element.options).find(option => {
                return option.value.trim().toLowerCase() === normalizedValue ||
                    option.text.trim().toLowerCase() === normalizedValue;
            });

            if (matched) {
                element.value = matched.value;
            }
        }

        function formatTanggal(value) {
            if (!value) return '';

            const str = String(value);

            if (/^\d{4}-\d{2}-\d{2}/.test(str)) {
                return str.substring(0, 10);
            }

            if (/^\d{2}-\d{2}-\d{4}/.test(str)) {
                const parts = str.split('-');
                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            return str.substring(0, 10);
        }

        function normalizeKewarganegaraan(value) {
            if (!value) return '';

            const v = String(value).toLowerCase();

            if (v.includes('indonesia') || v.includes('wni')) {
                return 'WNI';
            }

            if (v.includes('asing') || v.includes('wna')) {
                return 'WNA';
            }

            return value;
        }

        function autofillSkck() {
            const nikInput = document.getElementById('nik');

            if (!nikInput) return;

            const nik = nikInput.value.trim();

            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;

                        setValueIfExists('nama', d.nama);
                        setValueIfExists('tempat_lahir', d.tempat_lahir);
                        setValueIfExists('tanggal_lahir', formatTanggal(d.tanggal_lahir));
                        setValueIfExists('alamat', d.alamat);
                        setValueIfExists('pendidikan', d.pendidikan);

                        setSelectIfExists('jenis_kelamin', d.jenis_kelamin);
                        setSelectIfExists('agama', d.agama);
                        setSelectIfExists('pekerjaan', d.pekerjaan);
                        setSelectIfExists('status', d.status_perkawinan || d.status);
                        setSelectIfExists('kewarganegaraan', normalizeKewarganegaraan(d.kewarganegaraan));
                    } else {
                        alert(result.message || 'Data penduduk tidak ditemukan.');
                    }
                })
                .catch(error => {
                    console.log(error);
                    alert('Gagal mengambil data penduduk.');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');

            if (nikInput) {
                nikInput.addEventListener('blur', autofillSkck);
            }
        });
    </script>
</body>

</html>
