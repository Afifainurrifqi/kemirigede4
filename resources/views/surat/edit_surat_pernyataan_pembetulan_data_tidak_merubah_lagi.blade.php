@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Surat Pernyataan Pembetulan Data</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ route('surat.pembetulandata.update', $surat->_id) }}" method="POST">
                        @csrf @method('PUT')

                        <h6 class="fw-bold mb-2">Data Pemohon</h6>
                        <div class="mb-3"><label>NIK</label><input type="text" name="nik" class="form-control" value="{{ old('nik', $surat->nik) }}" required></div>
                        <div class="mb-3"><label>Nama</label><input type="text" name="nama" class="form-control" value="{{ old('nama', $surat->nama) }}" required></div>
                        <div class="mb-3"><label>Alamat</label><textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea></div>

                        <hr>
                        <h6 class="fw-bold mb-2">Uraian Pembetulan</h6>
                        <div class="mb-3">
                            <label>Uraian Data yang Diperbaiki</label>
                            <textarea name="uraian_pembetulan" class="form-control" rows="3" required>{{ old('uraian_pembetulan', $surat->uraian_pembetulan) }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Pendukung</h6>
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="mb-2">
                                <label>Data Pendukung {{ $i }}</label>
                                <input type="text" name="data_pendukung_{{ $i }}" class="form-control" value="{{ old('data_pendukung_'.$i, $surat->{'data_pendukung_'.$i}) }}">
                            </div>
                        @endfor

                        <div class="mb-3"><label>No WhatsApp</label><input type="text" name="nowa" class="form-control" value="{{ old('nowa', $surat->nowa) }}" required></div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control">
                                    @foreach(['Pending','Di cek','Di terima','Ditolak'] as $st)
                                        <option value="{{ $st }}" {{ old('status_surat', $surat->status_surat) == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control">
                                    @foreach(['Belum Verifikasi','Terverifikasi'] as $sv)
                                        <option value="{{ $sv }}" {{ old('status_verif', $surat->status_verif) == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
