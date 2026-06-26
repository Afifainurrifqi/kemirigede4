@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Surat Pernyataan Mengizinkan Ikut KK</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.izinkk.update', $surat->_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- DATA PEMOHON (Orang yang Memberi Izin) --}}
                        <h6 class="fw-bold mb-2">Data Pemohon (Orang yang Memberi Izin)</h6>

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control" value="{{ old('nik', $surat->nik) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama', $surat->nama) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="ttl_tempat" class="form-control" value="{{ old('ttl_tempat', $surat->ttl_tempat) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal" class="form-control"
                                    value="{{ old('ttl_tanggal', $surat->ttl_tanggal ? $surat->ttl_tanggal->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan" class="form-control">
                                @foreach(['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','PETANI/PEKEBUN','BURUH TANI','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','KARYAWAN HONORER','Lainnya'] as $job)
                                    <option value="{{ $job }}" {{ old('pekerjaan', $surat->pekerjaan) == $job ? 'selected' : '' }}>{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                        </div>

                        <hr>
                        {{-- DATA ORANG YANG DIIZINKAN --}}
                        <h6 class="fw-bold mb-2">Data Orang yang Diizinkan</h6>

                        <div class="mb-3">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama_izin" class="form-control" value="{{ old('nama_izin', $surat->nama_izin) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik_izin" class="form-control" value="{{ old('nik_izin', $surat->nik_izin) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="ttl_tempat_izin" class="form-control" value="{{ old('ttl_tempat_izin', $surat->ttl_tempat_izin) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal_izin" class="form-control"
                                    value="{{ old('ttl_tanggal_izin', $surat->ttl_tanggal_izin ? $surat->ttl_tanggal_izin->format('Y-m-d') : '') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat_izin" class="form-control" rows="2" required>{{ old('alamat_izin', $surat->alamat_izin) }}</textarea>
                        </div>

                        <hr>
                        {{-- PERNYATAAN IZIN PINDAH --}}
                        <h6 class="fw-bold mb-2">Pernyataan Izin Pindah</h6>

                        <div class="mb-3">
                            <label>Tujuan Pindah <span class="text-danger">*</span></label>
                            <input type="text" name="tujuan_pindah" class="form-control" value="{{ old('tujuan_pindah', $surat->tujuan_pindah) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alasan Pindah <span class="text-danger">*</span></label>
                            <textarea name="alasan_pindah" class="form-control" rows="3" required>{{ old('alasan_pindah', $surat->alasan_pindah) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa', $surat->nowa) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control" required>
                                    @foreach(['Pending','Di cek','Di terima','Ditolak'] as $st)
                                        <option value="{{ $st }}" {{ old('status_surat', $surat->status_surat) == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control" required>
                                    @foreach(['Belum Verifikasi','Terverifikasi'] as $sv)
                                        <option value="{{ $sv }}" {{ old('status_verif', $surat->status_verif) == $sv ? 'selected' : '' }}>{{ $sv }}</option>
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
