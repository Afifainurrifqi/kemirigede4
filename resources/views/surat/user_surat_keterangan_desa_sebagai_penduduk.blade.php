<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keterangan Desa Sebagai Penduduk</title>
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
                    <h6 class="mb-0">Surat Keterangan Desa Sebagai Penduduk</h6>
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

            <form action="{{ route('surat.user_desa_penduduk.store') }}" method="POST">
                @csrf

                <h6 class="fw-bold mb-3">Data Penduduk</h6>

                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required onblur="autofillDesaUser()">
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required value="Indonesia">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Agama</label>
                        <input type="text" name="agama" id="agama" class="form-control" required value="Islam">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status Perkawinan</label>
                    <input type="text" name="status" id="status" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan <span class="text-danger">*</span></label>
                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="3"
                        placeholder="Contoh: istrinya bernama ... sedang bekerja di Hongkong" required></textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function autofillDesaUser() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama_lengkap').value = d.nama || '';
                    document.getElementById('alamat').value = d.alamat || '';
                    if (d.jenis_kelamin) document.getElementById('jenis_kelamin').value = d.jenis_kelamin;
                    if (d.tempat_lahir) document.getElementById('tempat_lahir').value = d.tempat_lahir;
                    if (d.tanggal_lahir) document.getElementById('tanggal_lahir').value = d.tanggal_lahir;
                    if (d.agama) document.getElementById('agama').value = d.agama;
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                    if (d.status) document.getElementById('status').value = d.status;
                }
            })
            .catch(err => console.log('Autofill Error:', err));
    }
    </script>
</body>
</html>
