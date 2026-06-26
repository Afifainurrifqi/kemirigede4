@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Permohonan Pembukaan Rekening Tabungan</h5>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.permohonan_rekening.store') }}" method="POST">
                        @csrf

                        <h5>Data Pemohon (Kepala Desa)</h5>
                        <div class="mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kepala_desa" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" value="Kepala Desa KEMIRIGEDE" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="alamat_kepala_desa" class="form-control" rows="2" required></textarea>
                        </div>

                        <hr>

                        <h5>Data Rekening</h5>
                        <div class="mb-3">
                            <label>Atas Nama Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="atas_nama_rekening" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat Rekening</label>
                            <textarea name="alamat_rekening" class="form-control" rows="2" required></textarea>
                        </div>

                        <hr>

                        <h5>Pejabat yang Berwenang</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pejabat 1</label>
                                <input type="text" name="nama_pejabat1" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jabatan 1</label>
                                <input type="text" name="jabatan1" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pejabat 2</label>
                                <input type="text" name="nama_pejabat2" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jabatan 2</label>
                                <input type="text" name="jabatan2" class="form-control" required>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nomor Surat (opsional)</label>
                                <input type="text" name="nomor_surat" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Di cek">Di cek</option>
                                    <option value="Di terima">Di terima</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control" required>
                                    <option value="Belum Verifikasi">Belum Verifikasi</option>
                                    <option value="Terverifikasi">Terverifikasi</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
