@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Form Surat Keterangan Desa Sebagai Penduduk (Admin)</h4>
            <form action="{{ route('surat.desa_penduduk.store') }}" method="POST">
                @csrf
                <h5 class="mb-3">Data Penduduk</h5>

                <div class="mb-3">
                    <label for="nik">NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required value="{{ old('nik') }}" onblur="autofillDesaAdmin()">
                </div>
                <div class="mb-3">
                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required value="{{ old('nama_lengkap') }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kewarganegaraan">Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required value="{{ old('kewarganegaraan', 'Indonesia') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="agama">Agama</label>
                    <input type="text" name="agama" id="agama" class="form-control" required value="{{ old('agama', 'Islam') }}">
                </div>
                <div class="mb-3">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required value="{{ old('pekerjaan') }}">
                </div>
                <div class="mb-3">
                    <label for="status">Status Perkawinan</label>
                    <input type="text" name="status" id="status" class="form-control" required value="{{ old('status') }}">
                </div>
                <div class="mb-3">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="keterangan_tambahan">Keterangan Tambahan <span class="text-danger">*</span></label>
                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="3" required>{{ old('keterangan_tambahan') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="nowa">No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required value="{{ old('nowa') }}">
                </div>

                <!-- Status Admin -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending">Pending</option>
                            <option value="Di cek">Di cek</option>
                            <option value="Di terima">Di terima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi">Belum Verifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
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

<script>
function autofillDesaAdmin() {
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
@endsection
