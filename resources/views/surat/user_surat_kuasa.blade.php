<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitakro - Aplikasi Pertanian">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <title>Surat Kuasa</title>
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
                    <h6 class="mb-0">Surat Kuasa</h6>
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

            <form action="{{ route('surat.user_kuasa.store') }}" method="POST">
                @csrf

                <!-- Pihak I (Pemberi Kuasa) -->
                <h5 class="mb-3">Pihak I - Pemberi Kuasa</h5>
                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik_pihak1" id="nik_pihak1" class="form-control"
                        onkeyup="autofillPihak1()" placeholder="Masukkan NIK" required>
                </div>
                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pihak1" id="nama_pihak1" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_pihak1" id="jenis_kelamin_pihak1" class="form-control" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Agama</label>
                        <select name="agama_pihak1" id="agama_pihak1" class="form-control" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_pihak1" id="tempat_lahir_pihak1" class="form-control"
                            required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_pihak1" id="tanggal_lahir_pihak1" class="form-control"
                            required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status_pihak1" id="status_pihak1" class="form-control" required>
                        <option value="Kawin">Kawin</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan_pihak1" id="pekerjaan_pihak1" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat_pihak1" id="alamat_pihak1" class="form-control" rows="2" required></textarea>
                </div>

                <hr>

                <!-- Pihak II -->
                <h5 class="mb-3">Pihak II - Penerima Kuasa</h5>
                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pihak2" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_pihak2" class="form-control" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Agama</label>
                        <select name="agama_pihak2" class="form-control" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_pihak2" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_pihak2" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status_pihak2" class="form-control" required>
                        <option value="Kawin">Kawin</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan_pihak2" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat_pihak2" class="form-control" rows="2" required></textarea>
                </div>

                <hr>

                <div class="mb-3">
                    <label>Keterangan / Maksud Kuasa <span class="text-danger">*</span></label>
                    <textarea name="keterangan_kuasa" class="form-control" rows="4"
                        placeholder="Contoh: pengambilan BPKB Motor dengan nomor register AG6089PAZ atas nama Katimah..." required></textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan Surat Kuasa</button>
            </form>
        </div>
    </div>

    <script>
        function autofillPihak1() {
            const nik = document.getElementById('nik_pihak1').value.trim();
            if (nik.length < 10) return;
            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_pihak1').value = d.nama || '';
                        if (d.jenis_kelamin) document.getElementById('jenis_kelamin_pihak1').value = d.jenis_kelamin;
                        if (d.tempat_lahir) document.getElementById('tempat_lahir_pihak1').value = d.tempat_lahir;
                        if (d.tanggal_lahir) document.getElementById('tanggal_lahir_pihak1').value = d.tanggal_lahir;
                        if (d.agama) document.getElementById('agama_pihak1').value = d.agama;
                        if (d.pekerjaan) document.getElementById('pekerjaan_pihak1').value = d.pekerjaan;
                        if (d.status) document.getElementById('status_pihak1').value = d.status;
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }
    </script>
</body>

</html>
