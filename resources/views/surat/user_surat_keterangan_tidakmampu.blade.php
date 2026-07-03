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
                    <h6 class="mb-0">Form Surat Keterangan Tidak Mampu</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="element-heading">
                <h6>Buat Pengajuan Surat Keterangan Tidak Mampu</h6>
                @php
                    $bansosMap = [
                        'pkh' => 'PKH',
                        'kip' => 'KIP',
                        'kis' => 'KIS',
                        'bpnt' => 'BPNT',
                        'dtks' => 'ID. DTKS',
                        'blt_dd' => 'BLT DD',
                        'bansos' => 'BANSOS',
                    ];

                    $oldBantuan = old('bantuan', []);
                    $oldIds = old('bantuan_id', []);
                @endphp
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

                    <form action="{{ route('surat.usertidakmampu.store') }}" method="POST">
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                    required value="{{ old('tempat_lahir') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                    required value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>

                        <!-- KEWARGANEGARAAN -->
                        <div class="mb-3">
                            <label>Kewarganegaraan <span class="text-danger">*</span></label>
                            <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                                <option value="">-- Pilih Kewarganegaraan --</option>
                                <option value="Warga Negara Indonesia (WNI)"
                                    {{ old('kewarganegaraan') == 'Warga Negara Indonesia (WNI)' ? 'selected' : '' }}>
                                    Warga Negara Indonesia (WNI)
                                </option>
                                <option value="Warga Negara Asing (WNA)"
                                    {{ old('kewarganegaraan') == 'Warga Negara Asing (WNA)' ? 'selected' : '' }}>
                                    Warga Negara Asing (WNA)
                                </option>
                            </select>
                        </div>



                        <div class="mb-3">
                            <label>Agama <span class="text-danger">*</span></label>
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama)
                                    <option value="{{ $agama }}"
                                        {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Status Perkawinan <span class="text-danger">*</span></label>
                            <select name="status_perkawinan" id="status_perkawinan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Belum Kawin"
                                    {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                </option>
                                <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>
                                    Kawin</option>
                                <option value="Cerai Hidup"
                                    {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup
                                </option>
                                <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>
                                    Cerai</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan <span class="text-danger">*</span></label>
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
                                    <option value="{{ $job }}"
                                        {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Rumah <span class="text-danger">*</span></label>
                            <textarea name="alamat_rumah" id="alamat_rumah" class="form-control" rows="3" required>{{ old('alamat_rumah') }}</textarea>
                        </div>

                        <!-- PERUNTUKAN SKTM -->
                        <div class="mb-3">
                            <label>Peruntukan untuk SKTM <span class="text-danger">*</span></label>
                            <select name="peruntukan_sktm" id="peruntukan_sktm" class="form-control" required>
                                <option value="">-- Pilih Peruntukan --</option>
                                <option value="Biaya Pendidikan"
                                    {{ old('peruntukan_sktm') == 'Biaya Pendidikan' ? 'selected' : '' }}>Biaya
                                    Pendidikan</option>
                                <option value="Bantuan Sosial"
                                    {{ old('peruntukan_sktm') == 'Bantuan Sosial' ? 'selected' : '' }}>Bantuan Sosial
                                </option>
                                <option value="Biaya Kesehatan"
                                    {{ old('peruntukan_sktm') == 'Biaya Kesehatan' ? 'selected' : '' }}>Biaya Kesehatan
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Fungsi Surat (Kelengkapan) <span class="text-danger">*</span></label>
                            <textarea name="keterangan_fungsi_surat" id="keterangan_fungsi_surat" class="form-control" rows="3" required>{{ old('keterangan_fungsi_surat') }}</textarea>
                        </div>

                        {{-- Bantuan Sosial + Input ID Dinamis --}}
                        <div class="mb-3">
                            <label class="form-label">Apakah anda memiliki bantuan sosial?</label>

                            <div class="d-flex flex-column gap-2">
                                @foreach ($bansosMap as $key => $label)
                                    @php
                                        $isChecked = in_array($key, (array) $oldBantuan);
                                        $cbId = "bantuan_$key";
                                        $wrapId = "wrap_$key";
                                    @endphp

                                    <div class="border rounded p-2">
                                        <div class="form-check">
                                            <input class="form-check-input bantuan-checkbox" type="checkbox"
                                                name="bantuan[]" id="{{ $cbId }}"
                                                value="{{ $key }}" data-target="#{{ $wrapId }}"
                                                {{ $isChecked ? 'checked' : '' }} onchange="toggleBansosWrap(this)">

                                            <label class="form-check-label" for="{{ $cbId }}">
                                                {{ $label }}
                                            </label>
                                        </div>

                                        <div id="{{ $wrapId }}" class="mt-2"
                                            style="{{ $isChecked ? '' : 'display:none' }}">

                                            <label for="bantuan_id_{{ $key }}" class="form-label mb-1">
                                                ID {{ $label }} <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" class="form-control"
                                                name="bantuan_id[{{ $key }}]"
                                                id="bantuan_id_{{ $key }}"
                                                value="{{ $oldIds[$key] ?? '' }}" {{ $isChecked ? 'required' : '' }}
                                                placeholder="Masukkan ID {{ $label }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" id="nowa" class="form-control" required
                                value="{{ old('nowa') }}">
                        </div>

                        <!-- Hidden fields for user submission -->
                        <input type="hidden" name="status_surat" value="Pending">
                        <input type="hidden" name="status_verif" value="Belum Verifikasi">

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </div>
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

            if (!rawValue) {
                select.value = '';
                return;
            }

            const cleanValue = rawValue.toUpperCase();
            let found = false;

            Array.from(select.options).forEach(option => {
                const optionValue = option.value.toString().trim().toUpperCase();

                if (optionValue === cleanValue) {
                    select.value = option.value;
                    found = true;
                }
            });

            // Kalau value dari database tidak ada di option,
            // otomatis tambahkan supaya tetap tampil.
            if (!found) {
                const newOption = new Option(rawValue, rawValue, true, true);
                select.add(newOption);
                select.value = rawValue;
            }
        }

        function autofillTidakMampu() {
            const nikField = document.getElementById('nik');
            if (!nikField) return;

            const nik = nikField.value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    console.log('HASIL LOOKUP:', result);

                    if (!result.success || !result.data) {
                        alert(result.message || 'NIK tidak ditemukan');
                        return;
                    }

                    const d = result.data;

                    setInputValue('nama_lengkap', d.nama);
                    setInputValue('tempat_lahir', d.tempat_lahir);
                    setInputValue('tanggal_lahir', d.tanggal_lahir ? d.tanggal_lahir.substring(0, 10) : '');

                    // ALAMAT
                    setInputValue('alamat_rumah', d.alamat);

                    // SELECT
                    setSelectValue('agama', d.agama);
                    setSelectValue('pekerjaan', d.pekerjaan);
                    setSelectValue('status_perkawinan', d.status_perkawinan || d.status);

                    // KEWARGANEGARAAN
                    setSelectValue('kewarganegaraan', d.kewarganegaraan || 'Warga Negara Indonesia (WNI)');
                })
                .catch(err => {
                    console.log(err);
                    alert('Gagal mengambil data penduduk');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');

            if (nikInput) {
                nikInput.addEventListener('blur', autofillTidakMampu);
            }
        });

        function toggleBansosWrap(cb) {
            const target = cb.getAttribute('data-target');
            const wrap = document.querySelector(target);

            if (!wrap) return;

            const input = wrap.querySelector('input');

            if (cb.checked) {
                wrap.style.display = '';
                if (input) {
                    input.setAttribute('required', 'required');
                }
            } else {
                wrap.style.display = 'none';
                if (input) {
                    input.removeAttribute('required');
                    input.value = '';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.bantuan-checkbox').forEach(function(cb) {
                toggleBansosWrap(cb);
            });
        });
    </script>
</body>

</html>
