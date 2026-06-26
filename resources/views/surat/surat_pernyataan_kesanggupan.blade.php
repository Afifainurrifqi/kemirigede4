<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pernyataan Kesanggupan</title>
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
                    <h6 class="mb-0">Surat Pernyataan Kesanggupan</h6>
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

            <form action="{{ route('surat.pernyataan_kesanggupan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control"
                           onkeyup="autofillKesanggupanUser()" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="kegiatan" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Hari <span class="text-danger">*</span></label>
                        <input type="text" name="hari" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kegiatan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Waktu <span class="text-danger">*</span></label>
                    <input type="text" name="waktu" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tempat Kegiatan <span class="text-danger">*</span></label>
                    <textarea name="tempat_kegiatan" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label>No HP / WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <!-- STATUS (WAJIB) -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat <span class="text-danger">*</span></label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" selected>Pending</option>
                            <option value="Di cek">Di cek</option>
                            <option value="Di terima">Di terima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" selected>Belum Verifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <script>
        function autofillKesanggupanUser() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                        document.getElementById('tanggal_lahir').value = d.tanggal_lahir || '';
                        document.getElementById('alamat').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }
    </script>
</body>
</html>
