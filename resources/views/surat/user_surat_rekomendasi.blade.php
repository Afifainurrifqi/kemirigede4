<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Rekomendasi</title>
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
                    <h6 class="mb-0">Surat Rekomendasi</h6>
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

            <form action="{{ route('surat.user.rekomendasi.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required maxlength="16"
                        inputmode="numeric" placeholder="Masukkan NIK">
                    <small class="text-muted">Isi NIK lalu tekan Tab atau klik di luar untuk autofill data.</small>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Perihal <span class="text-danger">*</span></label>
                    <input type="text" name="perihal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kegiatan / Acara <span class="text-danger">*</span></label>
                    <input type="text" name="kegiatan" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Selesai <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Waktu <span class="text-danger">*</span></label>
                    <input type="text" name="waktu" class="form-control" required
                        placeholder="contoh: 17.00 - Selesai">
                </div>

                <div class="mb-3">
                    <label>Tempat <span class="text-danger">*</span></label>
                    <input type="text" name="tempat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Keperluan <span class="text-danger">*</span></label>
                    <textarea name="keperluan" class="form-control" rows="3" required></textarea>
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
        function autofillRekomendasi() {
            const nikInput = document.getElementById('nik').value.trim();
            if (nikInput.length < 10) return;

            fetch(`/datapenduduk/lookup/${nikInput}`)
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

        // Trigger saat blur atau change
        document.getElementById('nik').addEventListener('blur', autofillRekomendasi);
        document.getElementById('nik').addEventListener('change', autofillRekomendasi);
    </script>
</body>

</html>
