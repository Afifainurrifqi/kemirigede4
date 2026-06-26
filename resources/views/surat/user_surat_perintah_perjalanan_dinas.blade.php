<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Perintah Perjalanan Dinas</title>
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
                    <h6 class="mb-0">Surat Perintah Perjalanan Dinas</h6>
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

            <form action="{{ route('surat.user.perintah_perjalanan_dinas.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Data Pegawai</h5>
                <div class="mb-3">
                    <label>Nama Pegawai <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pegawai" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Pangkat/Golongan</label>
                        <input type="text" name="pangkat_golongan" class="form-control">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>
                </div>

                <h5 class="mb-3 mt-4">Detail Perjalanan</h5>
                <div class="mb-3">
                    <label>Maksud Perjalanan Dinas <span class="text-danger">*</span></label>
                    <textarea name="maksud_perjalanan" class="form-control" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Alat Angkutan</label>
                        <input type="text" name="alat_angkutan" class="form-control">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Lama Perjalanan (Hari) <span class="text-danger">*</span></label>
                        <input type="text" name="lama_perjalanan" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Berangkat</label>
                        <input type="text" name="tempat_berangkat" class="form-control">
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tempat Tujuan <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_tujuan" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tanggal Berangkat <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_berangkat" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kembali" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Sumber Anggaran</label>
                    <input type="text" name="sumber_anggaran" class="form-control">
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</body>

</html>
