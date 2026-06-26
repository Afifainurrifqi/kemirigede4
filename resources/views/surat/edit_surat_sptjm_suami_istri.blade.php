@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit SPTJM Suami Istri (F-2.04)</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('surat.sptjm_suami_istri.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h6><strong>Data Deklaran (Yang Menyatakan)</strong></h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_deklaran" class="form-control" value="{{ $surat->nama_deklaran }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik_deklaran" class="form-control" value="{{ $surat->nik_deklaran }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat / Tanggal Lahir</label>
                        <input type="text" name="ttl_deklaran" class="form-control" value="{{ $surat->ttl_deklaran }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan_deklaran" class="form-control" value="{{ $surat->pekerjaan_deklaran }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat_deklaran" class="form-control" rows="2" required>{{ $surat->alamat_deklaran }}</textarea>
                </div>

                <hr>
                <h6><strong>Data Pasangan</strong></h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap Pasangan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pasangan" class="form-control" value="{{ $surat->nama_pasangan }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK Pasangan <span class="text-danger">*</span></label>
                        <input type="text" name="nik_pasangan" class="form-control" value="{{ $surat->nik_pasangan }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat / Tanggal Lahir Pasangan</label>
                        <input type="text" name="ttl_pasangan" class="form-control" value="{{ $surat->ttl_pasangan }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat Pasangan <span class="text-danger">*</span></label>
                        <textarea name="alamat_pasangan" class="form-control" rows="2" required>{{ $surat->alamat_pasangan }}</textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Nomor Kartu Keluarga (KK)</label>
                    <input type="text" name="nomor_kk" class="form-control" value="{{ $surat->nomor_kk }}">
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" value="{{ $surat->nowa }}" required>
                </div>

                <!-- ==================== STATUS SURAT ==================== -->
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control">
                            <option value="Pending" {{ $surat->status_surat == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ $surat->status_surat == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ $surat->status_surat == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ $surat->status_surat == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control">
                            <option value="Belum Verifikasi" {{ $surat->status_verif == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ $surat->status_verif == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>
                <!-- ==================================================== -->

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('surat.keluar') }}" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
