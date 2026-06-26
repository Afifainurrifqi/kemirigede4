<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPTJM Kematian</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">SPTJM Kematian</h6>
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
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                      <form action="{{ route('surat.usersptjm.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-2">Data Pelapor</h6>
                        <div class="mb-3"><label>NIK</label><input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required></div>
                        <div class="mb-3"><label>Nama</label><input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required></div>

                        <div class="row">
                            <div class="col-md-6 mb-3"><label>Tempat Lahir</label><input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control" value="{{ old('ttl_tempat') }}" required></div>
                            <div class="col-md-6 mb-3"><label>Tanggal Lahir</label><input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control" value="{{ old('ttl_tanggal') }}" required></div>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach(['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','PETANI/PEKEBUN','BURUH TANI','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','KARYAWAN HONORER','Lainnya'] as $job)
                                    <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea></div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Jenazah</h6>

                        <div class="mb-3"><label>Nama Jenazah</label><input type="text" name="nama_jenazah" class="form-control" value="{{ old('nama_jenazah') }}" required></div>
                        <div class="mb-3"><label>NIK Jenazah</label><input type="text" name="nik_jenazah" class="form-control" value="{{ old('nik_jenazah') }}" required></div>

                        <div class="row">
                            <div class="col-md-6 mb-3"><label>Tempat Lahir Jenazah</label><input type="text" name="ttl_tempat_jenazah" class="form-control" value="{{ old('ttl_tempat_jenazah') }}" required></div>
                            <div class="col-md-6 mb-3"><label>Tanggal Lahir Jenazah</label><input type="date" name="ttl_tanggal_jenazah" class="form-control" value="{{ old('ttl_tanggal_jenazah') }}" required></div>
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3"><label>Anak Ke</label><input type="number" name="anak_ke" class="form-control" value="{{ old('anak_ke') }}" min="1" required></div>
                        <div class="mb-3"><label>Nama Ayah Kandung</label><input type="text" name="nama_ayah_kandung" class="form-control" value="{{ old('nama_ayah_kandung') }}" required></div>
                        <div class="mb-3"><label>Nama Ibu Kandung</label><input type="text" name="nama_ibu_kandung" class="form-control" value="{{ old('nama_ibu_kandung') }}" required></div>

                        <div class="mb-3"><label>Tanggal Meninggal</label><input type="date" name="tanggal_kematian" class="form-control" value="{{ old('tanggal_kematian') }}"></div>
                        <div class="mb-3"><label>Surat Kematian Dari</label><input type="text" name="surat_kematian_dari" class="form-control" value="{{ old('surat_kematian_dari') }}"></div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Saksi</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label>Nama Saksi I</label><input type="text" name="nama_saksi_1" class="form-control" value="{{ old('nama_saksi_1') }}"></div>
                            <div class="col-md-6 mb-3"><label>NIK Saksi I</label><input type="text" name="nik_saksi_1" class="form-control" value="{{ old('nik_saksi_1') }}"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label>Nama Saksi II</label><input type="text" name="nama_saksi_2" class="form-control" value="{{ old('nama_saksi_2') }}"></div>
                            <div class="col-md-6 mb-3"><label>NIK Saksi II</label><input type="text" name="nik_saksi_2" class="form-control" value="{{ old('nik_saksi_2') }}"></div>
                        </div>

                        <div class="mb-3"><label>No WhatsApp</label><input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required></div>

                        {{-- <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control" required>
                                    @foreach(['Pending','Di cek','Di terima','Ditolak'] as $st)
                                        <option value="{{ $st }}" {{ old('status_surat', 'Pending') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control" required>
                                    @foreach(['Belum Verifikasi','Terverifikasi'] as $sv)
                                        <option value="{{ $sv }}" {{ old('status_verif', 'Belum Verifikasi') == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}

                        <div class="text-end">
                            <button class="btn btn-primary">Simpan</button>
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
                            <i class="bi bi-house"></i><span>Beranda</span>
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
        function autofillSptjmKematian() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value       = d.nama || '';
                        document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
                        document.getElementById('ttl_tanggal').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0, 10) : '';
                        document.getElementById('alamat').value     = d.alamat || '';
                        document.getElementById('pekerjaan').value  = d.pekerjaan || '';
                    }
                })
                .catch(err => console.log(err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            if (nikInput) {
                nikInput.addEventListener('blur', autofillSptjmKematian);
            }
        });
    </script>
</body>
</html>
