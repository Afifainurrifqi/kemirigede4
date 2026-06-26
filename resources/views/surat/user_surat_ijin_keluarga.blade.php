<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Ijin Keluarga</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>
<body>
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Surat Ijin Keluarga</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat.ijin_keluarga.userstore') }}" method="POST">
                @csrf

                <!-- Data Suami -->
                <h6 class="mt-3">Data Suami</h6>
                <div class="mb-3">
                    <label>Nama Lengkap Suami <span class="text-danger">*</span></label>
                    <input type="text" name="nama_suami" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_suami" class="form-control">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_suami" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan Suami</label>
                    <select name="pekerjaan_suami" class="form-control">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TNI','POLRI','DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','BIDAN','DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN','PEDAGANG','PNS','BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN','PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI','PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK','MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI','USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN','JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa','TKI','Lainnya'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat Suami</label>
                    <textarea name="alamat_suami" class="form-control" rows="3"></textarea>
                </div>

                <!-- Data Istri -->
                <h6 class="mt-4">Data Istri</h6>
                <div class="mb-3">
                    <label>Nama Lengkap Istri <span class="text-danger">*</span></label>
                    <input type="text" name="nama_istri" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_istri" class="form-control">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_istri" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan Istri</label>
                    <select name="pekerjaan_istri" class="form-control">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TNI','POLRI','DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','BIDAN','DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN','PEDAGANG','PNS','BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN','PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI','PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK','MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI','USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN','JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa','TKI','Lainnya'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat Istri</label>
                    <textarea name="alamat_istri" class="form-control" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Negara Keberangkatan</label>
                        <input type="text" name="negara_tujuan" class="form-control" value="Taiwan" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Sebagai</label>
                        <input type="text" name="sebagai" class="form-control" value="TKW" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
