@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Surat Pernyataan Batal Pindah Penduduk</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('surat.batal_pindah.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik', $surat->nik) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $surat->nama) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="ttl_tempat" class="form-control" value="{{ old('ttl_tempat', $surat->ttl_tempat) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="ttl_tanggal" class="form-control" value="{{ old('ttl_tanggal', $surat->ttl_tanggal) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', $surat->agama) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Perkawinan</label>
                        <input type="text" name="status" class="form-control" value="{{ old('status', $surat->status) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Ke Alamat (Tujuan Pindah yang Dibatalkan) <span class="text-danger">*</span></label>
                    <textarea name="ke_alamat" class="form-control" rows="2" required>{{ old('ke_alamat', $surat->ke_alamat) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Dikarenakan (Alasan Batal Pindah) <span class="text-danger">*</span></label>
                    <textarea name="alasan_batal" class="form-control" rows="2" required>{{ old('alasan_batal', $surat->alasan_batal) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Dan Akan Menetap Sesuai Alamat Asal di <span class="text-danger">*</span></label>
                    <textarea name="alamat_asal" class="form-control" rows="2" required>{{ old('alamat_asal', $surat->alamat_asal) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" value="{{ old('nowa', $surat->nowa) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control">
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control">
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Surat</button>
                <a href="{{ route('surat.keluar') }}" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
