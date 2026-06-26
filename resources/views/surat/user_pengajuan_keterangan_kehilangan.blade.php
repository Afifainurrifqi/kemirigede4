<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Surat Keterangan Kehilangan</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>
<body>
    <div id="preloader"><div class="spinner-grow text-primary" role="status"></div></div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Form Surat Keterangan Kehilangan</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.userkehilangan.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-2">Data Pelapor</h6>

                        <div class="mb-3">
                            <label>NIK Pelapor <span class="text-danger">*</span></label>
                            <input type="text" name="nik_pelapor" id="nik_pelapor" class="form-control" value="{{ old('nik_pelapor') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama Pelapor <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pelapor" id="nama_pelapor" class="form-control" value="{{ old('nama_pelapor') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir_pelapor" id="tempat_lahir_pelapor" class="form-control" value="{{ old('tempat_lahir_pelapor') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir_pelapor" id="tanggal_lahir_pelapor" class="form-control" value="{{ old('tanggal_lahir_pelapor') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin_pelapor" id="jenis_kelamin_pelapor" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Agama</label>
                            <select name="agama_pelapor" id="agama_pelapor" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agama)
                                    <option value="{{ $agama }}">{{ $agama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Status Perkawinan</label>
                            <select name="status_pelapor" id="status_pelapor" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['Kawin','Belum Kawin','Cerai Hidup','Cerai'] as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- ==================== PEKERJAAN (SUDAH DIISI) ==================== -->
                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan_pelapor" id="pekerjaan_pelapor" class="form-control" required>
                                <option value="">-- Pilih Pekerjaan --</option>
                                @php
                                    $jobs = [
                                        'BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH',
                                        'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA',
                                        'TENTARA NASIONAL INDONESIA (TNI)', 'KEPOLISIAN RI (POLRI)',
                                        'DOSEN', 'GURU', 'BIDAN', 'DOKTER', 'PERAWAT',
                                        'PETANI/PEKEBUN', 'BURUH TANI/PERKEBUNAN', 'PEDAGANG',
                                        'PEGAWAI NEGERI SIPIL (PNS)', 'KARYAWAN HONORER', 'BURUH HARIAN LEPAS',
                                        'SOPIR', 'KARYAWAN BUMN', 'PENSIUNAN', 'PEMBANTU RUMAH TANGGA',
                                        'KONSTRUKSI', 'PELAUT', 'NELAYAN/PERIKANAN', 'PETERNAK',
                                        'MEKANIK', 'TUKANG LAS/PANDAI BESI', 'Lainnya'
                                    ];
                                @endphp
                                @foreach($jobs as $job)
                                    <option value="{{ $job }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- ============================================================ -->

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat_pelapor" id="alamat_pelapor" class="form-control" rows="2" required>{{ old('alamat_pelapor') }}</textarea>
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-2">Data Kehilangan</h6>

                        <div class="mb-3">
                            <label>Jenis Kehilangan <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_kehilangan" class="form-control" required value="{{ old('jenis_kehilangan') }}">
                        </div>

                        <div class="mb-3">
                            <label>Atas Nama <span class="text-danger">*</span></label>
                            <input type="text" name="atas_nama" class="form-control" required value="{{ old('atas_nama') }}">
                        </div>

                        <div class="mb-3">
                            <label>Isi yang Hilang <span class="text-danger">*</span></label>
                            <input type="text" name="berisi" class="form-control" required value="{{ old('berisi') }}">
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Kehilangan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kehilangan" class="form-control" required value="{{ old('tanggal_kehilangan') }}">
                        </div>

                        <div class="mb-3">
                            <label>Kehilangan Saat / Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="hilang_saat" class="form-control" required value="{{ old('hilang_saat') }}">
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
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

    <!-- Autofill Script -->
    <script>
        function autofillKehilangan() {
            const nik = document.getElementById('nik_pelapor').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;

                        document.getElementById('nama_pelapor').value           = d.nama || '';
                        document.getElementById('tempat_lahir_pelapor').value   = d.tempat_lahir || '';
                        document.getElementById('tanggal_lahir_pelapor').value  = d.tanggal_lahir ? d.tanggal_lahir.substring(0, 10) : '';
                        document.getElementById('jenis_kelamin_pelapor').value  = d.jenis_kelamin || '';
                        document.getElementById('alamat_pelapor').value         = d.alamat || '';

                        // Autofill Pekerjaan
                        if (document.getElementById('pekerjaan_pelapor') && d.pekerjaan) {
                            document.getElementById('pekerjaan_pelapor').value = d.pekerjaan;
                        }

                        // Autofill Agama
                        if (document.getElementById('agama_pelapor') && d.agama) {
                            document.getElementById('agama_pelapor').value = d.agama;
                        }

                        // Autofill Status Perkawinan
                        if (document.getElementById('status_pelapor') && (d.status_perkawinan || d.status)) {
                            document.getElementById('status_pelapor').value = d.status_perkawinan || d.status;
                        }
                    }
                })
                .catch(err => console.log(err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik_pelapor');
            if (nikInput) {
                nikInput.addEventListener('blur', autofillKehilangan);
            }
        });
    </script>
</body>
</html>
