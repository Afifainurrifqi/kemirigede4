<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pernyataan Pembetulan Data</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>
<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button"><a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a></div>
                <div class="page-heading">
                    <h6 class="mb-0">Pernyataan Pembetulan Data</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ route('surat.userpembetulandata.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-2">Data Pemohon</h6>

                        <div class="mb-3"><label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>
                        <div class="mb-3"><label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>
                        <div class="mb-3"><label>Alamat <span class="text-danger">*</span></label>
                           <textarea
        name="alamat"
        id="alamat"
        class="form-control"
        rows="2"
        required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Uraian Pembetulan</h6>
                        <div class="mb-3">
                            <label>Uraian Data yang Diperbaiki <span class="text-danger">*</span></label>
                            <textarea name="uraian_pembetulan" class="form-control" rows="3" required>{{ old('uraian_pembetulan') }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Pendukung (opsional)</h6>
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="mb-2">
                                <label>Data Pendukung {{ $i }}</label>
                                <input type="text" name="data_pendukung_{{ $i }}" class="form-control" value="{{ old('data_pendukung_'.$i) }}">
                            </div>
                        @endfor

                        <div class="mb-3"><label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required>
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
                    <li class="active"><a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-house"></i><span>Beranda</span></a></li>
                </ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        function autofillPembetulanData() {
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
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            if (nikInput) nikInput.addEventListener('blur', autofillPembetulanData);
        });
    </script>
</body>
</html>
