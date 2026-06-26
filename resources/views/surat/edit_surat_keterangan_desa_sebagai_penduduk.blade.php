@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Desa Sebagai Penduduk</h4>
            <form action="{{ route('surat.desa_penduduk.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Penduduk</h5>

                <div class="mb-3">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik', $surat->nik) }}">
                </div>
                <div class="mb-3">
                    <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                           value="{{ old('nama_lengkap', $surat->nama_lengkap) }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kewarganegaraan">Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required
                               value="{{ old('kewarganegaraan', $surat->kewarganegaraan ?? 'Indonesia') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                               value="{{ old('tempat_lahir', $surat->tempat_lahir) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                               value="{{ old('tanggal_lahir', $surat->tanggal_lahir ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d') : '') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="agama">Agama</label>
                    <input type="text" name="agama" id="agama" class="form-control" required
                           value="{{ old('agama', $surat->agama) }}">
                </div>
                <div class="mb-3">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required
                           value="{{ old('pekerjaan', $surat->pekerjaan) }}">
                </div>
                <div class="mb-3">
                    <label for="status">Status Perkawinan</label>
                    <input type="text" name="status" id="status" class="form-control" required
                           value="{{ old('status', $surat->status) }}">
                </div>
                <div class="mb-3">
                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="keterangan_tambahan">Keterangan Tambahan <span class="text-danger">*</span></label>
                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="3" required>{{ old('keterangan_tambahan', $surat->keterangan_tambahan) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="nowa">No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required
                           value="{{ old('nowa', $surat->nowa) }}">
                </div>

                <!-- Status Surat & Verifikasi -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat <span class="text-danger">*</span></label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi <span class="text-danger">*</span></label>
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
