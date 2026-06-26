<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pernyataan Perubahan Data Pendidikan</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button"><a href="{{ route('surat.pengajuan_surat') }}"><i
                            class="bi bi-arrow-left-short"></i></a></div>
                <div class="page-heading">
                    <h6 class="mb-0">Pernyataan Perubahan Data Pendidikan</h6>
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
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.userperubahdatapendidikan.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-2">Data Pemohon</h6>

                        <div class="mb-3"><label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control"
                                value="{{ old('nik') }}" required>
                        </div>

                        <div class="mb-3"><label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Tempat/Tgl. Lahir</label>
                            <div class="row g-2">
                                <div class="col-6"><input type="text" name="ttl_tempat" id="ttl_tempat"
                                        class="form-control" placeholder="Tempat" value="{{ old('ttl_tempat') }}"
                                        required></div>
                                <div class="col-6"><input type="date" name="ttl_tanggal" id="ttl_tanggal"
                                        class="form-control" value="{{ old('ttl_tanggal') }}" required></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'PETANI/PEKEBUN', 'BURUH TANI', 'PEDAGANG', 'PEGAWAI NEGERI SIPIL (PNS)', 'KARYAWAN HONORER', 'Lainnya'] as $job)
                                    <option value="{{ $job }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3"><label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Perubahan Pendidikan</h6>

                        <div class="mb-3"><label>Nama Subjek <span class="text-danger">*</span></label>
                            <input type="text" name="nama_subjek" class="form-control"
                                value="{{ old('nama_subjek') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Pendidikan Lama <span class="text-danger">*</span></label>
                            <select name="pendidikan_lama" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($pendidikan as $item)
                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Pendidikan Baru <span class="text-danger">*</span></label>
                            <select name="pendidikan_baru" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($pendidikan as $item)
                                    <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3"><label>Alasan Perubahan <span class="text-danger">*</span></label>
                            <textarea name="alasan_perubahan" class="form-control" rows="3" required>{{ old('alasan_perubahan') }}</textarea>
                        </div>

                        <div class="mb-3"><label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}"
                                required>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary px-4">Kirim</button>
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
                    <li class="active"><a href="{{ route('surat.pengajuan_surat') }}"><i
                                class="bi bi-house"></i><span>Beranda</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        function autofillPerubahanPendidikan() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;
            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
                        document.getElementById('ttl_tanggal').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0,
                            10) : '';
                        document.getElementById('alamat').value = d.alamat || '';
                        document.getElementById('pekerjaan').value = d.pekerjaan || '';
                    }
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            if (nikInput) nikInput.addEventListener('blur', autofillPerubahanPendidikan);
        });
    </script>
</body>

</html>
