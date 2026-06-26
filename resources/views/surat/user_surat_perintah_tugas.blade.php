<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Perintah Tugas</title>
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
                    <h6 class="mb-0">Surat Perintah Tugas</h6>
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

            <form action="{{ route('surat.user.perintah_tugas.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Data Penerima Tugas</h5>

                <div class="mb-3">
                    <label>Nama Penerima <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan_penerima" id="jabatan_penerima" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>NIK (Opsional)</label>
                    <input type="text" name="nik_penerima" id="nik_penerima" class="form-control" maxlength="16">
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Detail Kegiatan</h5>

                <div class="mb-3">
                    <label>Untuk Mengikuti / Melaksanakan <span class="text-danger">*</span></label>
                    <textarea name="untuk_mengikuti" class="form-control" rows="3" required></textarea>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Hari <span class="text-danger">*</span></label>
                        <input type="text" name="hari" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Kegiatan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kegiatan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Waktu Mulai <span class="text-danger">*</span></label>
                    <input type="time" name="waktu_mulai" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tempat Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_kegiatan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tugas" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <script>
        // Autofill jika ada NIK (opsional, karena tidak wajib)
        function autofillPerintahTugas() {
            const nik = document.getElementById('nik_penerima').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_penerima').value = d.nama || '';
                        document.getElementById('jabatan_penerima').value = d.pekerjaan || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik_penerima');
            if (nikInput) {
                nikInput.addEventListener('blur', autofillPerintahTugas);
            }
        });
    </script>
</body>
</html>
