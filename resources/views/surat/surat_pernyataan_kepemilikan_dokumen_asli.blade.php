@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-heade">
                    <h5 class="mb-0">Form Pembuatan Surat Pernyataan Kepemilikan Dokumen Asli</h5>
                </div>
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

                    <form action="{{ route('surat.pernyataan_kepemilikan_dokumen.store') }}" method="POST">
                        @csrf

                        <!-- Data Utama -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       onkeyup="autofillPernyataanAdmin()" placeholder="Masukkan NIK" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                            </div>
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
                                <label>Pekerjaan <span class="text-danger">*</span></label>
                                <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                    <option value="">-- Pilih pekerjaan --</option>
                                    @php
                                        $jobs = ['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TENTARA NASIONAL INDONESIA (TNI)','KEPOLISIAN RI (POLRI)','DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','BIDAN','DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN','PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI','PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK','MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI','USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN','JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa','TKI','Lainnya'];
                                    @endphp
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>No HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" id="nowa" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                            </div>
                        </div>

                        <!-- Data Dokumen -->
                        <h6 class="mt-4 mb-3">Data Dokumen yang Dimiliki</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Dokumen / Surat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_dokumen" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nomor Dokumen / Surat <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_dokumen" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pemilik Dokumen</label>
                                <input type="text" name="nama_pemilik_dokumen" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir Pemilik</label>
                                <input type="date" name="tanggal_lahir_pemilik" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat yang Tertera di Dokumen</label>
                            <textarea name="alamat_dokumen" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                        </div>

                        <!-- Status (WAJIB) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat <span class="text-danger">*</span></label>
                                <select name="status_surat" class="form-control" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Di cek">Di cek</option>
                                    <option value="Di terima">Di terima</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi <span class="text-danger">*</span></label>
                                <select name="status_verif" class="form-control" required>
                                    <option value="Belum Verifikasi">Belum Verifikasi</option>
                                    <option value="Terverifikasi">Terverifikasi</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillPernyataanAdmin() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('jenis_kelamin').value = d.jenis_kelamin || '';
                    document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                    document.getElementById('tanggal_lahir').value = d.tanggal_lahir || '';
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                    document.getElementById('alamat').value = d.alamat || '';
                }
            })
            .catch(err => console.error('Autofill error:', err));
    }
</script>
@endsection
