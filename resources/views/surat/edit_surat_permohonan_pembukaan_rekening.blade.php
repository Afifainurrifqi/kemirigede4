@extends('layout.main2')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Surat Permohonan Pembukaan Rekening Tabungan</h5>
                    </div>
                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.permohonan_rekening.update', $surat->_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h5>Data Pemohon (Kepala Desa)</h5>

                            <div class="mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_kepala_desa" class="form-control"
                                    value="{{ old('nama_kepala_desa', $surat->nama_kepala_desa) }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="jabatan" class="form-control"
                                    value="{{ old('jabatan', $surat->jabatan ?? 'Kepala Desa KEMIRIGEDE') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat_kepala_desa" class="form-control" rows="3" required>
                                {{ old('alamat_kepala_desa', $surat->alamat_kepala_desa) }}
                            </textarea>
                            </div>

                            <hr>

                            <h5>Data Rekening</h5>

                            <div class="mb-3">
                                <label>Atas Nama Rekening <span class="text-danger">*</span></label>
                                <input type="text" name="atas_nama_rekening" class="form-control"
                                    value="{{ old('atas_nama_rekening', $surat->atas_nama_rekening) }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Rekening <span class="text-danger">*</span></label>
                                <textarea name="alamat_rekening" class="form-control" rows="3" required>
                                {{ old('alamat_rekening', $surat->alamat_rekening) }}
                            </textarea>
                            </div>

                            <hr>

                            <h5>Pejabat yang Berwenang</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Pejabat 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pejabat1" class="form-control"
                                        value="{{ old('nama_pejabat1', $surat->nama_pejabat1) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Jabatan 1 <span class="text-danger">*</span></label>
                                    <input type="text" name="jabatan1" class="form-control"
                                        value="{{ old('jabatan1', $surat->jabatan1) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Pejabat 2 <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pejabat2" class="form-control"
                                        value="{{ old('nama_pejabat2', $surat->nama_pejabat2) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Jabatan 2 <span class="text-danger">*</span></label>
                                    <input type="text" name="jabatan2" class="form-control"
                                        value="{{ old('jabatan2', $surat->jabatan2) }}" required>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nomor Surat</label>
                                    <input type="text" name="nomor_surat" class="form-control"
                                        value="{{ old('nomor_surat', $surat->nomor_surat) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>No WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="nowa" class="form-control"
                                        value="{{ old('nowa', $surat->nowa) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat <span class="text-danger">*</span></label>
                                    <select name="status_surat" class="form-control" required>
                                        <option value="Pending"
                                            {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Di cek"
                                            {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>
                                            Di cek</option>
                                        <option value="Di terima"
                                            {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>
                                            Di terima</option>
                                        <option value="Selesai"
                                            {{ old('status_surat', $surat->status_surat) == 'Selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="Ditolak"
                                            {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi <span class="text-danger">*</span></label>
                                    <select name="status_verif" class="form-control" required>
                                        <option value="Belum Verifikasi"
                                            {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>
                                            Belum Verifikasi</option>
                                        <option value="Terverifikasi"
                                            {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>
                                            Terverifikasi</option>
                                        <option value="Ditolak"
                                            {{ old('status_verif', $surat->status_verif) == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('surat.keluar') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary btn-lg px-5">Update Surat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
