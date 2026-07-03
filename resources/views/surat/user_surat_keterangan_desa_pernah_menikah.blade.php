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
                    <h6 class="mb-0">Form Surat Keterangan Desa Pernah Menikah</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="element-heading">
                <h6>Buat Pengajuan Surat Keterangan Desa Pernah Menikah</h6>
            </div>
        </div>

        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.userpernahmenikah.store') }}" method="POST">
                        @csrf

                        <h5 class="mb-3">Data Pemohon</h5>

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" required
                                value="{{ old('nik') }}">
                        </div>

                        <div class="mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                                value="{{ old('nama_lengkap') }}">
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                    value="{{ old('tempat_lahir') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                    value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Agama</label>
                            <select name="agama" id="agama" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama)
                                    <option value="{{ $agama }}">{{ $agama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control"
                                value="{{ old('kewarganegaraan', 'Indonesia') }}">
                        </div>

                        <div class="mb-3">
                            <label>Status Perkawinan</label>
                            <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                <option value="">-- Pilih --</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control">
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
                                        'Guru agama',
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
                                    <option value="{{ $job }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>RT</label>
                                <input type="text" name="rt" id="rt" class="form-control"
                                    value="{{ old('rt') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>RW</label>
                                <input type="text" name="rw" id="rw" class="form-control"
                                    value="{{ old('rw') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" id="nowa" class="form-control" required
                                value="{{ old('nowa') }}">
                        </div>

                        <!-- Status otomatis di-set di Controller -->
                        <input type="hidden" name="status_surat" value="Pending">
                        <input type="hidden" name="status_verif" value="Belum Verifikasi">

                        <button type="submit" class="btn btn-primary mt-3">Kirim Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Nav -->
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

    <!-- Autofill Script -->
    <script>
        function setInputValue(id, value) {
            const el = document.getElementById(id);
            if (el) {
                el.value = value || '';
            }
        }

        function setSelectValue(id, value) {
            const select = document.getElementById(id);
            if (!select) return;

            const rawValue = (value || '').toString().trim();
            const cleanValue = rawValue.toUpperCase();

            if (!rawValue) {
                select.value = '';
                return;
            }

            let found = false;

            Array.from(select.options).forEach(option => {
                const optionValue = option.value.toString().trim().toUpperCase();

                if (optionValue === cleanValue) {
                    select.value = option.value;
                    found = true;
                }
            });

            // Kalau pekerjaan dari database tidak ada di daftar option,
            // otomatis tambahkan option baru agar tetap terisi.
            if (!found) {
                const newOption = new Option(rawValue, rawValue, true, true);
                select.add(newOption);
                select.value = rawValue;

                console.warn(`Value "${rawValue}" tidak ada di select #${id}, jadi ditambahkan otomatis.`);
            }
        }

        function autofillPernahMenikah() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    console.log('HASIL LOOKUP:', result);

                    if (result.success && result.data) {
                        const d = result.data;

                        setInputValue('nama_lengkap', d.nama);
                        setInputValue('tempat_lahir', d.tempat_lahir);
                        setInputValue('tanggal_lahir', d.tanggal_lahir ? d.tanggal_lahir.substring(0, 10) : '');
                        setInputValue('alamat', d.alamat);
                        setInputValue('rt', d.rt || d.RT);
                        setInputValue('rw', d.rw || d.RW);

                        setSelectValue('jenis_kelamin', d.jenis_kelamin);
                        setSelectValue('agama', d.agama);
                        setSelectValue('pekerjaan', d.pekerjaan);
                        setSelectValue('status_perkawinan', d.status_perkawinan || d.status);
                    }
                })
                .catch(err => console.log(err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('blur', autofillPernahMenikah);
            }
        });
    </script>
</body>

</html>
