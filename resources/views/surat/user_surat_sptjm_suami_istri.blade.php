<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPTJM Suami Istri (F-2.04)</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>
<body>
    <div id="preloader"><div class="spinner-grow text-primary" role="status"></div></div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">SPTJM Suami Istri (F-2.04)</h6>
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

                    <form action="{{ route('surat.user_sptjm_suami_istri.store') }}" method="POST">
                        @csrf

                        <h6><strong>Saya yang menyatakan (Deklaran)</strong></h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_deklaran" id="nama_deklaran" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik_deklaran" id="nik_deklaran" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat / Tanggal Lahir</label>
                                <input type="text" name="ttl_deklaran" id="ttl_deklaran" class="form-control" placeholder="Contoh: Blitar / 12-05-1990">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pekerjaan</label>
                                <input type="text" name="pekerjaan_deklaran" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat_deklaran" id="alamat_deklaran" class="form-control" rows="2" required></textarea>
                        </div>

                        <hr>
                        <h6><strong>Menyatakan bahwa (Pasangan)</strong></h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap Pasangan <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pasangan" id="nama_pasangan" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>NIK Pasangan <span class="text-danger">*</span></label>
                                <input type="text" name="nik_pasangan" id="nik_pasangan" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat / Tanggal Lahir Pasangan</label>
                                <input type="text" name="ttl_pasangan" id="ttl_pasangan" class="form-control" placeholder="Contoh: Malang / 15-08-1992">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Alamat Pasangan <span class="text-danger">*</span></label>
                                <textarea name="alamat_pasangan" id="alamat_pasangan" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Nomor Kartu Keluarga (KK)</label>
                            <input type="text" name="nomor_kk" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        // Autofill untuk Deklaran
        function autofillDeklaran() {
            const nik = document.getElementById('nik_deklaran').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_deklaran').value = d.nama || '';
                        document.getElementById('ttl_deklaran').value = d.tempat_lahir || '';
                        if (d.tanggal_lahir) {
                            document.getElementById('ttl_deklaran').value = (d.tempat_lahir || '') + ' / ' + d.tanggal_lahir.substring(0,10);
                        }
                        document.getElementById('alamat_deklaran').value = d.alamat || '';
                    }
                });
        }

        // Autofill untuk Pasangan
        function autofillPasangan() {
            const nik = document.getElementById('nik_pasangan').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_pasangan').value = d.nama || '';
                        document.getElementById('ttl_pasangan').value = d.tempat_lahir || '';
                        if (d.tanggal_lahir) {
                            document.getElementById('ttl_pasangan').value = (d.tempat_lahir || '') + ' / ' + d.tanggal_lahir.substring(0,10);
                        }
                        document.getElementById('alamat_pasangan').value = d.alamat || '';
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('nik_deklaran').addEventListener('blur', autofillDeklaran);
            document.getElementById('nik_pasangan').addEventListener('blur', autofillPasangan);
        });
    </script>
</body>
</html>
