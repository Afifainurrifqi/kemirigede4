@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Form Surat Keterangan Domisili Lembaga (Admin)</h4>
            <form action="{{ route('surat.domisili_lembaga.store') }}" method="POST">
                @csrf
                <h5 class="mb-3">Data Lembaga</h5>
                <div class="mb-3">
                    <label>Nama Lembaga <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lembaga" class="form-control" required value="{{ old('nama_lembaga') }}">
                </div>
                <div class="mb-3">
                    <label>Jenis Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_kegiatan" class="form-control" required value="{{ old('jenis_kegiatan') }}">
                </div>
                <div class="mb-3">
                    <label>Alamat Lembaga <span class="text-danger">*</span></label>
                    <textarea name="alamat_lembaga" class="form-control" rows="2" required>{{ old('alamat_lembaga') }}</textarea>
                </div>

                <h5 class="mb-3">Data Pengurus (Ketua)</h5>
                <div class="mb-3">
                    <label>NIK Pengurus <span class="text-danger">*</span></label>
                    <input type="text" name="nik_pengurus" id="nik_pengurus" class="form-control" required value="{{ old('nik_pengurus') }}" onblur="autofillPengurus()">
                </div>
                <div class="mb-3">
                    <label>Nama Pengurus <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pengurus" id="nama_pengurus" class="form-control" required value="{{ old('nama_pengurus') }}">
                </div>
                <div class="mb-3">
                    <label>Alamat Pengurus <span class="text-danger">*</span></label>
                    <textarea name="alamat_pengurus" id="alamat_pengurus" class="form-control" rows="2" required>{{ old('alamat_pengurus') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ old('keterangan_tambahan') }}</textarea>
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
function autofillPengurus() {
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
@endsection
