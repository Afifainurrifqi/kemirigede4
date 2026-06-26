<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Permohonan Tebang Pohon</title>
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
                    <h6 class="mb-0">Permohonan Tebang Pohon</h6>
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

                    <form action="{{ route('surat.user_permohonan_tebang_pohon.store') }}" method="POST">
                        @csrf

                        <h5 class="mb-3">Data Pemohon</h5>

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" required
                                maxlength="20" inputmode="numeric" value="{{ old('nik') }}"
                                placeholder="Contoh: 3501234567890123">
                            <small class="text-muted">Isi NIK lalu tekan TAB atau klik di luar untuk autofill</small>
                        </div>

                        <div class="mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" required
                                value="{{ old('nama') }}">
                        </div>

                        <div class="mb-3">
                            <label>Jabatan / Posisi <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" required
                                value="{{ old('jabatan') }}" placeholder="Contoh: Ketua RT 01 / Warga">
                        </div>

                        <div class="mb-3">
                            <label>Alamat Lengkap <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>No. HP <span class="text-danger">*</span></label>
                                <input type="text" name="no_hp" class="form-control" required
                                    value="{{ old('no_hp') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" class="form-control" required
                                    value="{{ old('nowa') }}">
                            </div>
                        </div>

                        <h5 class="mb-3 mt-4">Alasan Permohonan Tebang Pohon</h5>

                        <div class="mb-3">
                            <label>Alasan Tebang Pohon <span class="text-danger">*</span></label>
                            <textarea name="alasan_tebang" class="form-control" rows="5" required
                                placeholder="Jelaskan secara detail alasan penebangan pohon (misalnya: rawan tumbang, jamuran, menghalangi jalan, dll)">{{ old('alasan_tebang') }}</textarea>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">Kirim Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Autofill Script -->
    <script>
        function autofillTebangPohonUser() {
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

        document.getElementById('nik').addEventListener('blur', autofillTebangPohonUser);
        document.getElementById('nik').addEventListener('change', autofillTebangPohonUser);
    </script>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>
</body>

</html>
