@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container py-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Penghasilan</h4>

            <form action="{{ route('surat.penghasilan.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-primary mb-3">Data Orang Tua / Wali</h5>
                <div class="mb-3">
                    <label class="form-label">NIK Pemohon</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $surat->nik) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $surat->nama_lengkap) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nominal Penghasilan</label>
                        <input type="text" name="nominal_penghasilan" class="form-control" value="{{ old('nominal_penghasilan', $surat->nominal_penghasilan) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Keperluan</label>
                        <input type="text" name="keperluan" class="form-control" value="{{ old('keperluan', $surat->keperluan) }}" required>
                    </div>
                </div>

                <h5 class="text-success mt-4 mb-3">Data Anak</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Anak</label>
                        <input type="text" name="nama_anak" class="form-control" value="{{ old('nama_anak', $surat->nama_anak) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sekolah / Kampus</label>
                        <input type="text" name="sekolah_universitas" class="form-control" value="{{ old('sekolah_universitas', $surat->sekolah_universitas) }}" required>
                    </div>
                </div>

                {{-- <h5 class="text-secondary mt-4 mb-3">Administrasi Surat</h5>
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" class="form-control" value="{{ old('nomor_surat', $surat->nomor_surat) }}">
                </div> --}}

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">No WhatsApp</label>
                        <input type="text" name="nowa" class="form-control" value="{{ old('nowa', $surat->nowa) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ $surat->status_surat == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ $surat->status_surat == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ $surat->status_surat == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ $surat->status_surat == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ $surat->status_verif == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ $surat->status_verif == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-5">Perbarui Data Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
