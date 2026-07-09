@extends('layout.main2')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edit Surat Permohonan Pengantar Keabsahan Akta Kelahiran (Untuk Anak)
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            use Carbon\Carbon;

                            $formatTanggalInput = function ($value) {
                                if (empty($value)) {
                                    return '';
                                }

                                try {
                                    if ($value instanceof \MongoDB\BSON\UTCDateTime) {
                                        return Carbon::instance($value->toDateTime())->format('Y-m-d');
                                    }

                                    if ($value instanceof \DateTimeInterface) {
                                        return Carbon::instance($value)->format('Y-m-d');
                                    }

                                    return Carbon::parse($value)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    return '';
                                }
                            };
                        @endphp

                        <form action="{{ route('surat.pengantar_keabsahan_anak.update', $surat->_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK Pemohon <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control"
                                        value="{{ old('nik', $surat->nik) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Pemohon <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" class="form-control"
                                        value="{{ old('nama', $surat->nama) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="ttl_tempat" class="form-control"
                                        value="{{ old('ttl_tempat', $surat->ttl_tempat) }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="ttl_tanggal" class="form-control"
                                        value="{{ old('ttl_tanggal', $formatTanggalInput($surat->ttl_tanggal)) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Nama Anak <span class="text-danger">*</span></label>
                                <input type="text" name="nama_anak" class="form-control"
                                    value="{{ old('nama_anak', $surat->nama_anak) }}" required>
                            </div>

                            <div class="mb-3">
                                <label>No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" class="form-control"
                                    value="{{ old('nowa', $surat->nowa) }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat</label>
                                    <select name="status_surat" class="form-control">
                                        <option value="Pending"
                                            {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Di cek"
                                            {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>
                                            Di cek</option>
                                        <option value="Di terima"
                                            {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>
                                            Di terima</option>
                                        <option value="Ditolak"
                                            {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi</label>
                                    <select name="status_verif" class="form-control">
                                        <option value="Belum Verifikasi"
                                            {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>
                                            Belum Verifikasi</option>
                                        <option value="Terverifikasi"
                                            {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>
                                            Terverifikasi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Surat</button>
                                <a href="{{ route('surat.keluar') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
