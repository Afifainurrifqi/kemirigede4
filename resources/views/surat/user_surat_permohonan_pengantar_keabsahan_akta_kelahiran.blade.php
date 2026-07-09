<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permohonan Pengantar Keabsahan Akta Kelahiran</title>
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
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Permohonan Pengantar Keabsahan Akta Kelahiran</h6>
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

                    <form action="{{ route('surat.user_pengantar_keabsahan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control"
                                value="{{ old('nik') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama') }}" required>
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
                            <div class="col-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control"
                                    value="{{ old('ttl_tempat') }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control"
                                    value="{{ old('ttl_tanggal') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan</button>
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

    <!-- Script Theme (WAJIB) -->
    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        function autofillPengantar() {

            const nik = document.getElementById('nik').value.trim();

            if (nik.length < 10) return;


            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {

                    console.log(result);

                    if (result.success && result.data) {

                        const d = result.data;


                        document.getElementById('nama').value = d.nama || '';


                        document.getElementById('ttl_tempat').value =
                            d.tempat_lahir || '';


                        document.getElementById('ttl_tanggal').value =
                            d.tanggal_lahir ?
                            d.tanggal_lahir.substring(0, 10) :
                            '';


                        document.getElementById('alamat').value =
                            d.alamat || '';


                        // Jenis Kelamin
                        let jk = d.jenis_kelamin || '';

                        if (jk.toUpperCase() === 'L' || jk.toUpperCase() === 'LAKI-LAKI') {
                            document.getElementById('jenis_kelamin').value = 'Laki-laki';
                        } else if (jk.toUpperCase() === 'P' || jk.toUpperCase() === 'PEREMPUAN') {
                            document.getElementById('jenis_kelamin').value = 'Perempuan';
                        }

                    }

                })
                .catch(err => console.log(err));

        }


        document.addEventListener('DOMContentLoaded', function() {

            const nikInput = document.getElementById('nik');

            if (nikInput) {

                nikInput.addEventListener('blur', autofillPengantar);

                nikInput.addEventListener('change', autofillPengantar);

            }

        });
    </script>
</body>

</html>
