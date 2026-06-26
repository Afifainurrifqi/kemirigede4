@extends('layout.main2')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Pembuatan Surat Kuasa</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.kuasa.store') }}" method="POST">
                            @csrf

                            <!-- Pihak I -->
                            <h5 class="mt-3">Pihak I - Pemberi Kuasa</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik_pihak1" id="nik_pihak1" class="form-control"
                                        onkeyup="autofillPihak1()" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pihak1" id="nama_pihak1" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin_pihak1" id="jenis_kelamin_pihak1" class="form-control"
                                        required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Agama</label>
                                    <select name="agama_pihak1" id="agama_pihak1" class="form-control" required>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status_pihak1" id="status_pihak1" class="form-control" required>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_pihak1" id="tempat_lahir_pihak1"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_pihak1" id="tanggal_lahir_pihak1"
                                        class="form-control" required>
                                </div>
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
                            <h5>Pihak II - Penerima Kuasa</h5>
                            <div class="mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik_pihak2" id="nik_pihak2" class="form-control"
                                    onkeyup="autofillPihak2()" placeholder="Masukkan NIK" required>
                            </div>
                            <div class="mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pihak2" id="nama_pihak2" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin_pihak2" id="jenis_kelamin_pihak2" class="form-control"
                                        required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Agama</label>
                                    <select name="agama_pihak2" id="agama_pihak2" class="form-control" required>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen">Kristen</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status_pihak2" id="status_pihak2" class="form-control" required>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_pihak2" id="tempat_lahir_pihak2"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_pihak2" id="tanggal_lahir_pihak2"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Pekerjaan</label>
                                <select name="pekerjaan_pihak2" id="pekerjaan_pihak2" class="form-control" required>
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat_pihak2" id="alamat_pihak2" class="form-control" rows="2" required></textarea>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label>Keterangan / Maksud Kuasa <span class="text-danger">*</span></label>
                                <textarea name="keterangan_kuasa" class="form-control" rows="4"
                                    placeholder="Contoh: pengambilan BPKB Motor dengan nomor register AG6089PAZ atas nama Katimah..." required></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>No WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="nowa" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat</label>
                                    <select name="status_surat" class="form-control" required>
                                        <option value="Pending"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Di cek"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Di cek' ? 'selected' : '' }}>
                                            Di cek</option>
                                        <option value="Di terima"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Di terima' ? 'selected' : '' }}>
                                            Di terima</option>
                                        <option value="Selesai"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="Ditolak"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi</label>
                                    <select name="status_verif" class="form-control" required>
                                        <option value="Belum Verifikasi"
                                            {{ old('status_verif', $surat->status_verif ?? '') == 'Belum Verifikasi' ? 'selected' : '' }}>
                                            Belum Verifikasi</option>
                                        <option value="Terverifikasi"
                                            {{ old('status_verif', $surat->status_verif ?? '') == 'Terverifikasi' ? 'selected' : '' }}>
                                            Terverifikasi</option>
                                        <option value="Ditolak"
                                            {{ old('status_verif', $surat->status_verif ?? '') == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Surat Kuasa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Autofill Pihak 1
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

        // Autofill Pihak 2
        function autofillPihak2() {
            const nik = document.getElementById('nik_pihak2').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_pihak2').value = d.nama || '';
                        if (d.jenis_kelamin) document.getElementById('jenis_kelamin_pihak2').value = d.jenis_kelamin;
                        if (d.tempat_lahir) document.getElementById('tempat_lahir_pihak2').value = d.tempat_lahir;
                        if (d.tanggal_lahir) document.getElementById('tanggal_lahir_pihak2').value = d.tanggal_lahir;
                        if (d.agama) document.getElementById('agama_pihak2').value = d.agama;
                        if (d.pekerjaan) document.getElementById('pekerjaan_pihak2').value = d.pekerjaan;
                        if (d.status) document.getElementById('status_pihak2').value = d.status;
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }
    </script>
@endsection
