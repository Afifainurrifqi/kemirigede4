@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Domisili Lembaga</h4>
            <form action="{{ route('surat.domisili_lembaga.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Lembaga</h5>
                <div class="mb-3">
                    <label>Nama Lembaga <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lembaga" class="form-control" required value="{{ old('nama_lembaga', $surat->nama_lembaga) }}">
                </div>
                <div class="mb-3">
                    <label>Jenis Kegiatan <span class="text-danger">*</span></label>
                    <input type="text" name="jenis_kegiatan" class="form-control" required value="{{ old('jenis_kegiatan', $surat->jenis_kegiatan) }}">
                </div>
                <div class="mb-3">
                    <label>Alamat Lembaga <span class="text-danger">*</span></label>
                    <textarea name="alamat_lembaga" class="form-control" rows="2" required>{{ old('alamat_lembaga', $surat->alamat_lembaga) }}</textarea>
                </div>

                <h5 class="mb-3">Data Pengurus (Ketua)</h5>
                <div class="mb-3">
                    <label>Nama Pengurus <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pengurus" class="form-control" required value="{{ old('nama_pengurus', $surat->nama_pengurus) }}">
                </div>
                <div class="mb-3">
                    <label>NIK Pengurus <span class="text-danger">*</span></label>
                    <input type="text" name="nik_pengurus" class="form-control" required value="{{ old('nik_pengurus', $surat->nik_pengurus) }}">
                </div>
                <div class="mb-3">
                    <label>Alamat Pengurus <span class="text-danger">*</span></label>
                    <textarea name="alamat_pengurus" class="form-control" rows="2" required>{{ old('alamat_pengurus', $surat->alamat_pengurus) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ old('keterangan_tambahan', $surat->keterangan_tambahan) }}</textarea>
                </div>
                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required value="{{ old('nowa', $surat->nowa) }}">
                </div>

                <!-- Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
