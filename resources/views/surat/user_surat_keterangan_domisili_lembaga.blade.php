<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keterangan Domisili Lembaga</title>
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
                    <h6 class="mb-0">Surat Keterangan Domisili Lembaga</h6>
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

            <form action="{{ route('surat.user_domisili_lembaga.store') }}" method="POST">
                @csrf
                <h6 class="fw-bold mb-3">Data Lembaga</h6>
                <div class="mb-3">
                    <label>Nama Lembaga <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lembaga" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_kegiatan" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat Lembaga <span class="text-danger">*</span></label>
                    <textarea name="alamat_lembaga" class="form-control" rows="2" required></textarea>
                </div>

                <h6 class="fw-bold mb-3">Data Pengurus (Ketua)</h6>
                <div class="mb-3">
                    <label>NIK Pengurus <span class="text-danger">*</span></label>
                    <input type="text" name="nik_pengurus" id="nik_pengurus" class="form-control" required onblur="autofillPengurusUser()">
                </div>
                <div class="mb-3">
                    <label>Nama Pengurus <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pengurus" id="nama_pengurus" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat Pengurus <span class="text-danger">*</span></label>
                    <textarea name="alamat_pengurus" id="alamat_pengurus" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <script>
    function autofillPengurusUser() {
        const nik = document.getElementById('nik_pengurus').value.trim();
        if (nik.length < 10) return;
        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama_pengurus').value = d.nama || '';
                    document.getElementById('alamat_pengurus').value = d.alamat || '';
                }
            })
            .catch(err => console.log('Autofill Error:', err));
    }
    </script>
</body>
</html>
