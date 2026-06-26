<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengajuan Surat Keterangan Penghasilan</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <div class="header-area" id="headerArea">
        <div class="container h-100 d-flex align-items-center justify-content-between">
            <div class="back-button"><a href="{{ route('surat.pengajuan_surat') }}"><i
                        class="bi bi-arrow-left-short"></i></a></div>
            <div class="page-heading">
                <h6 class="mb-0">Surat Keterangan Penghasilan</h6>
            </div>
            <div></div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('surat.userpenghasilan.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold text-primary mb-3">Data Orang Tua / Wali</h6>
                        <div class="mb-3">
                            <label class="form-label">NIK Orang Tua <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tempat & Tanggal Lahir <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-6"><input type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control" placeholder="Tempat" required></div>
                                <div class="col-6"><input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control" required></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan Orang Tua <span class="text-danger">*</span></label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                @foreach ($pekerjaan as $p)
                                    <option value="{{ $p->nama }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rata-rata Penghasilan Bulanan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nominal_penghasilan" class="form-control"
                                placeholder="Contoh: Rp 1.200.000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keperluan Penggunaan Surat <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="keperluan" class="form-control"
                                placeholder="Contoh: Daftar Beasiswa Universitas" required>
                        </div>

                        <h6 class="fw-bold text-success mt-4 mb-3">Data Anak / Mahasiswa</h6>
                        <div class="mb-3">
                            <label class="form-label">NIK Anak <span class="text-danger">*</span></label>
                            <input type="text" name="nik_anak" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap Anak <span class="text-danger">*</span></label>
                            <input type="text" name="nama_anak" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sekolah / Kampus Anak <span class="text-danger">*</span></label>
                            <input type="text" name="sekolah_universitas" class="form-control"
                                placeholder="Contoh: Universitas Brawijaya" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No WhatsApp Aktif <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" placeholder="08xxxxxxxxxx"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>
    <script>
        document.getElementById('nik').addEventListener('blur', function() {
            let nik = this.value.trim();
            if (nik.length < 10) return;
            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(res => {
                    if (res.success && res.data) {
                        document.getElementById('nama_lengkap').value = res.data.nama || '';
                        document.getElementById('tempat_lahir').value = res.data.tempat_lahir || '';
                        document.getElementById('tanggal_lahir').value = res.data.tanggal_lahir || '';
                        document.getElementById('jenis_kelamin').value = res.data.jenis_kelamin || '';
                        document.getElementById('alamat').value = res.data.alamat || '';
                        document.getElementById('status').value = res.data.status || '';
                    }
                });
        });
    </script>
</body>

</html>
