<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keterangan Ahli Waris Desa</title>
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
                    <h6 class="mb-0">Surat Keterangan Ahli Waris Desa</h6>
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

                    <form action="{{ route('surat.userahliwarisdesa.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-3">Data Almarhum/Almarhumah</h6>
                        <div class="mb-3">
                            <label>Nama Almarhum/Almarhumah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_almarhum" class="form-control" required value="{{ old('nama_almarhum') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Hari Meninggal <span class="text-danger">*</span></label>
                                <input type="text" name="hari_meninggal" class="form-control" required value="{{ old('hari_meninggal') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Meninggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_meninggal" class="form-control" required value="{{ old('tanggal_meninggal') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Tempat Meninggal <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_meninggal" class="form-control" required value="{{ old('tempat_meninggal') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nomor Surat Kematian <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_surat_kematian" class="form-control" required value="{{ old('nomor_surat_kematian') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Surat Kematian <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_surat_kematian" class="form-control" required value="{{ old('tanggal_surat_kematian') }}">
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3 mt-4">Data Ahli Waris</h6>
                        <div id="ahliWarisContainerUser"></div>
                        <button type="button" class="btn btn-secondary mb-3" onclick="tambahAhliWarisUser()">+ Tambah Ahli Waris</button>

                        <h6 class="fw-bold mb-3 mt-4">Data Simpanan</h6>
                        <div class="mb-3">
                            <label>Nama Simpanan <span class="text-danger">*</span></label>
                            <input type="text" name="simpanan_nama" class="form-control" required value="{{ old('simpanan_nama') }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Jenis Simpanan <span class="text-danger">*</span></label>
                                <input type="text" name="simpanan_jenis" class="form-control" required value="{{ old('simpanan_jenis') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nomor Rekening <span class="text-danger">*</span></label>
                                <input type="text" name="simpanan_rekening" class="form-control" required value="{{ old('simpanan_rekening') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
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
    <script>
    function tambahAhliWarisUser() {
        const container = document.getElementById('ahliWarisContainerUser');
        const index = container.children.length;
        const html = `
            <div class="border p-3 mb-3 bg-light">
                <h6>Ahli Waris ${index + 1}</h6>
                <input type="hidden" name="ahli_waris[${index}][index]" value="${index}">
                <div class="mb-2">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" name="ahli_waris[${index}][nama]" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>No Akta/KK</label>
                    <input type="text" name="ahli_waris[${index}][no_akta]" class="form-control">
                </div>
                <div class="mb-2">
                    <label>Alamat</label>
                    <textarea name="ahli_waris[${index}][alamat]" class="form-control" rows="2"></textarea>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
    </script>
</body>
</html>
