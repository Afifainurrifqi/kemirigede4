@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Surat Pernyataan Perubahan Data Pendidikan</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.perubahdatapendidikan.update', $surat->_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="fw-bold mb-3">Data Pemohon</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control" value="{{ old('nik', $surat->nik) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama <span class="text-danger">*</span></label>
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
                                <input type="date" name="ttl_tanggal" class="form-control" value="{{ old('ttl_tanggal', $surat->ttl_tanggal ? $surat->ttl_tanggal->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $surat->alamat) }}</textarea>
                        </div>

                        <h6 class="fw-bold mb-3 mt-4">Data yang Diubah</h6>

                        <div class="mb-3">
                            <label>Nama Subjek <span class="text-danger">*</span></label>
                            <input type="text" name="nama_subjek" class="form-control" value="{{ old('nama_subjek', $surat->nama_subjek) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Pendidikan Lama</label>
                                <input type="text" name="pendidikan_lama" class="form-control" value="{{ old('pendidikan_lama', $surat->pendidikan_lama) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pendidikan Baru</label>
                                <input type="text" name="pendidikan_baru" class="form-control" value="{{ old('pendidikan_baru', $surat->pendidikan_baru) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alasan Perubahan</label>
                            <textarea name="alasan_perubahan" class="form-control" rows="2">{{ old('alasan_perubahan', $surat->alasan_perubahan) }}</textarea>
                        </div>

                        <h6 class="fw-bold mb-3">Data Pendukung</h6>

                        <div class="mb-3">
                            <label>Jenis Data Pendukung</label>
                            <input type="text" name="jenis_data_pendukung" class="form-control" value="{{ old('jenis_data_pendukung', $surat->jenis_data_pendukung) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nomor Dokumen</label>
                                <input type="text" name="nomor_dokumen_pendukung" class="form-control" value="{{ old('nomor_dokumen_pendukung', $surat->nomor_dokumen_pendukung) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Diterbitkan</label>
                                <input type="date" name="tanggal_diterbitkan" class="form-control" value="{{ old('tanggal_diterbitkan', $surat->tanggal_diterbitkan ? $surat->tanggal_diterbitkan->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Instansi Penerbit</label>
                            <input type="text" name="instansi_penerbit" class="form-control" value="{{ old('instansi_penerbit', $surat->instansi_penerbit) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" class="form-control" value="{{ old('nowa', $surat->nowa) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control">
                                    @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                        <option value="{{ $status }}" {{ old('status_surat', $surat->status_surat) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control">
                                    @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                                        <option value="{{ $verif }}" {{ old('status_verif', $surat->status_verif) == $verif ? 'selected' : '' }}>{{ $verif }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
