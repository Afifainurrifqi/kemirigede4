<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota Angkutan Hasil Hutan</title>
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
                    <h6 class="mb-0">Nota Angkutan Hasil Hutan Kayu</h6>
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

            <form action="{{ route('surat.user.nota_angkutan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric">
                    <small class="text-muted">Isi NIK lalu tab/keluar untuk autofill</small>
                </div>

                <div class="mb-3">
                    <label>Nama Pengirim <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pengirim" id="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat Pengirim <span class="text-danger">*</span></label>
                    <textarea name="alamat_pengirim" id="alamat" class="form-control" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Bukti Kepemilikan</label>
                        <input type="text" name="bukti_kepemilikan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nomor Bukti Kepemilikan</label>
                        <input type="text" name="nomor_bukti_kepemilikan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Jenis Kayu <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_kayu" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Jumlah</label>
                        <input type="text" name="jumlah" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Volume (m³)</label>
                        <input type="text" name="volume" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Alat Angkut</label>
                        <input type="text" name="alat_angkut" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Tempat Muat</label>
                    <input type="text" name="tempat_muat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Penerima <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penerima" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat Penerima <span class="text-danger">*</span></label>
                    <textarea name="alamat_penerima" class="form-control" rows="2" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Mulai Berlaku</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Selesai Berlaku</label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-4">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <script>
        function autofillNotaAngkutanUser() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('alamat').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }

        document.getElementById('nik').addEventListener('blur', autofillNotaAngkutanUser);
        document.getElementById('nik').addEventListener('change', autofillNotaAngkutanUser);
    </script>
</body>
</html>
