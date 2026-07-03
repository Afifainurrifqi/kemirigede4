<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Permohonan Pembukaan Rekening</title>
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
                    <h6 class="mb-0">Permohonan Pembukaan Rekening</h6>
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

                    <form action="{{ route('surat.user.permohonan_rekening.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-3">Data Pemohon (Kepala Desa)</h6>

                        <div class="mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kepala_desa" id="nama_kepala_desa" class="form-control"
                                value="{{ old('nama_kepala_desa') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control"
                                value="{{ old('jabatan', 'KEPALA DESA KEMIRIGEDE') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat_kepala_desa" id="alamat_kepala_desa" class="form-control" rows="3" required>{{ old('alamat_kepala_desa') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">Data Rekening</h6>

                        <div class="mb-3">
                            <label>Atas Nama Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="atas_nama_rekening" id="atas_nama_rekening" class="form-control"
                                value="{{ old('atas_nama_rekening') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Rekening <span class="text-danger">*</span></label>
                            <textarea name="alamat_rekening" id="alamat_rekening" class="form-control" rows="3" required>{{ old('alamat_rekening') }}</textarea>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3">Pejabat yang Berwenang</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pejabat 1 <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pejabat1" id="nama_pejabat1" class="form-control"
                                    value="{{ old('nama_pejabat1') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jabatan 1 <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan1" id="jabatan1" class="form-control"
                                    value="{{ old('jabatan1') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pejabat 2 <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pejabat2" id="nama_pejabat2" class="form-control"
                                    value="{{ old('nama_pejabat2') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jabatan 2 <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan2" id="jabatan2" class="form-control"
                                    value="{{ old('jabatan2') }}" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" id="nowa" class="form-control"
                                value="{{ old('nowa') }}" required>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                <i class="bi bi-send"></i> Kirim Pengajuan
                            </button>
                        </div>
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

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>
</body>

</html>
