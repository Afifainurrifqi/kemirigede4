<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permohonan Pengantar Keabsahan Akta Kelahiran (Untuk Anak)</title>
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
                    <h6 class="mb-0">Permohonan Pengantar Keabsahan Akta Kelahiran (Untuk Anak)</h6>
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

                    <form action="{{ route('surat.user_pengantar_keabsahan_anak.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>NIK Pemohon (Orang Tua) <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control"
                                value="{{ old('nik') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama Pemohon (Orang Tua) <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin<span class="text-danger">*</span></label>

                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>

                        </div>

                        <div class="mb-3">


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
                                <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Nama Anak <span class="text-danger">*</span></label>
                                <input type="text" name="nama_anak" class="form-control"
                                    value="{{ old('nama_anak') }}" required>
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

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        function autofillPengantarAnak() {

            const nikInput = document.getElementById('nik');

            if (!nikInput) return;


            const nik = nikInput.value.trim();


            if (nik.length < 10) return;



            fetch(`/datapenduduk/lookup/${nik}`)

                .then(response => response.json())

                .then(result => {


                    console.log(result);


                    if (result.success && result.data) {


                        const d = result.data;



                        // =====================
                        // NAMA
                        // =====================

                        document.getElementById('nama').value =
                            d.nama || '';




                        // =====================
                        // TEMPAT LAHIR
                        // =====================

                        document.getElementById('ttl_tempat').value =
                            d.tempat_lahir || '';





                        // =====================
                        // TANGGAL LAHIR
                        // =====================

                        document.getElementById('ttl_tanggal').value =
                            d.tanggal_lahir ?
                            d.tanggal_lahir.substring(0, 10) :
                            '';






                        // =====================
                        // ALAMAT
                        // =====================

                        document.getElementById('alamat').value =
                            d.alamat ||
                            d.alamat_lengkap ||
                            d.alamat_domisili ||
                            '';







                        // =====================
                        // JENIS KELAMIN
                        // =====================

                        let jk =
                            d.jenis_kelamin ||
                            d.jk ||
                            '';



                        if (jk) {


                            jk = jk.toString()
                                .toUpperCase()
                                .trim();



                            if (
                                jk === 'L' ||
                                jk === 'LAKI-LAKI' ||
                                jk === 'LAKI LAKI' ||
                                jk === 'PRIA'
                            ) {

                                document.getElementById('jenis_kelamin').value =
                                    'Laki-laki';

                            } else if (
                                jk === 'P' ||
                                jk === 'PEREMPUAN' ||
                                jk === 'WANITA'
                            ) {

                                document.getElementById('jenis_kelamin').value =
                                    'Perempuan';

                            }


                        }



                    }


                })


                .catch(error => {

                    console.log(error);

                });


        }





        document.addEventListener('DOMContentLoaded', function() {


            const nikInput = document.getElementById('nik');



            if (nikInput) {

                nikInput.addEventListener(
                    'blur',
                    autofillPengantarAnak
                );


                nikInput.addEventListener(
                    'change',
                    autofillPengantarAnak
                );


            }



        });
    </script>
</body>

</html>
