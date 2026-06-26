@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Form Surat Keterangan Ghoib (Admin)</h4>
            <form action="{{ route('surat.ghoib.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Data Pemohon</h5>
                <div class="mb-3">
                    <label>NIK Pemohon <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required value="{{ old('nik') }}" onblur="autofillGhoibAdmin()">
                </div>
                <div class="mb-3">
                    <label>Nama Pemohon <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" required value="{{ old('nama_pemohon') }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required value="{{ old('kewarganegaraan', 'Indonesia') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Belum Kawin" {{ old('status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Pekerjaan <span class="text-danger">*</span></label>
                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TNI','POLRI','DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','Pegawai Kantor Desa','BIDAN','DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN','PEDAGANG','PNS','BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN','PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI','PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK','MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI','USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN','JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa','TKI','Lainnya'] as $job)
                            <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                </div>

                <hr>
                <h6 class="fw-bold mb-3">Data yang Hilang</h6>
                <div class="mb-3">
                    <label>Nama Suami/Istri yang Hilang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_suami_istri" class="form-control" required value="{{ old('nama_suami_istri') }}">
                </div>
                <div class="mb-3">
                    <label>Tanggal Hilang <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_hilang" class="form-control" required value="{{ old('tanggal_hilang') }}">
                </div>
                <div class="mb-3">
                    <label>Tanggal Surat Pernyataan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pernyataan" class="form-control" required value="{{ old('tanggal_pernyataan') }}">
                </div>
                <div class="mb-3">
                    <label>Keperluan / Tujuan Surat <span class="text-danger">*</span></label>
                    <input type="text" name="keperluan" class="form-control" required value="{{ old('keperluan') }}" placeholder="contoh: Pengajuan Perceraian">
                </div>
                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="3">{{ old('keterangan_tambahan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                </div>

                <!-- Status Admin -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat') == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat') == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
function autofillGhoibAdmin() {
    const nik = document.getElementById('nik').value.trim();
    if (nik.length < 10) return;

    fetch(`/datapenduduk/lookup/${nik}`)
        .then(res => res.json())
        .then(result => {
            if (result.success && result.data) {
                const d = result.data;
                document.getElementById('nama_pemohon').value = d.nama || '';
                document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                if (d.tanggal_lahir) document.getElementById('tanggal_lahir').value = d.tanggal_lahir.substring(0,10);
                if (d.jenis_kelamin) document.getElementById('jenis_kelamin').value = d.jenis_kelamin;
                if (d.agama) document.getElementById('agama').value = d.agama;
                if (d.status) document.getElementById('status').value = d.status;
                if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                if (d.alamat) document.getElementById('alamat').value = d.alamat;
            }
        })
        .catch(err => console.log('Autofill Error:', err));
}
</script>
