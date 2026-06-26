<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Keterangan Domisili Warga</title>
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
                    <h6 class="mb-0">Surat Keterangan Domisili Warga</h6>
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

            <form action="{{ route('surat.user_domisili_warga.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control"
                           onkeyup="autofillDomisiliUser()" placeholder="Masukkan NIK" required>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama') === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                <option value="{{ $st }}" {{ old('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                            <option value="">-- Pilih pekerjaan --</option>
                            @php
                                $jobs = [
                                    'BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH',
                                    'KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA',
                                    'TENTARA NASIONAL INDONESIA (TNI)','KEPOLISIAN RI (POLRI)',
                                    'DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','BIDAN',
                                    'DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN',
                                    'BURUH TANI/PERKEBUNAN','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)',
                                    'BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN',
                                    'PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI',
                                    'PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK',
                                    'MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI',
                                    'USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN',
                                    'JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa',
                                    'TKI','Lainnya',
                                ];
                            @endphp
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                    {{ $job }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat Asal (Luar Desa) <span class="text-danger">*</span></label>
                    <textarea name="alamat_asal" id="alamat_asal" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Alamat Domisili di Desa Wates <span class="text-danger">*</span></label>
                    <textarea name="alamat_domisili" id="alamat_domisili" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan</button>
            </form>
        </div>
    </div>

    <script>
        function autofillDomisiliUser() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_lengkap').value = d.nama || '';
                        if (d.jenis_kelamin) document.getElementById('jenis_kelamin').value = d.jenis_kelamin;
                        if (d.tempat_lahir) document.getElementById('tempat_lahir').value = d.tempat_lahir;
                        if (d.tanggal_lahir) document.getElementById('tanggal_lahir').value = d.tanggal_lahir;
                        if (d.agama) document.getElementById('agama').value = d.agama;
                        if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                        if (d.status) document.getElementById('status').value = d.status;
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }
    </script>
</body>
</html>
