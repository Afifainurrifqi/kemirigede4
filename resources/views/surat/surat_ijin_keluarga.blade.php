@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-heade">
                    <h5 class="mb-0">Form Pembuatan Surat Ijin Keluarga</h5>
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

                    <form action="{{ route('surat.ijin_keluarga.store') }}" method="POST">
                        @csrf

                        <h6 class="mt-3 mb-2">Data Suami</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Suami <span class="text-danger">*</span></label>
                                <input type="text" name="nama_suami" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir Suami</label>
                                <input type="text" name="tempat_lahir_suami" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir Suami</label>
                                <input type="date" name="tanggal_lahir_suami" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pekerjaan Suami</label>
                                <select name="pekerjaan_suami" class="form-control">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TNI','POLRI','GURU','PETANI','BURUH TANI','PEDAGANG','PNS','NELAYAN','Lainnya'] as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Suami</label>
                            <textarea name="alamat_suami" class="form-control" rows="2"></textarea>
                        </div>

                        <h6 class="mt-4 mb-2">Data Istri</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Istri <span class="text-danger">*</span></label>
                                <input type="text" name="nama_istri" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir Istri</label>
                                <input type="text" name="tempat_lahir_istri" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir Istri</label>
                                <input type="date" name="tanggal_lahir_istri" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Pekerjaan Istri</label>
                                <select name="pekerjaan_istri" class="form-control">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TNI','POLRI','GURU','PETANI','BURUH TANI','PEDAGANG','PNS','NELAYAN','Lainnya'] as $p)
                                        <option value="{{ $p }}">{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Istri</label>
                            <textarea name="alamat_istri" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Negara Tujuan</label>
                                <input type="text" name="negara_tujuan" class="form-control" value="Taiwan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Sebagai</label>
                                <input type="text" name="sebagai" class="form-control" value="TKW">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control">
                                    <option value="Pending">Pending</option>
                                    <option value="Di cek">Di cek</option>
                                    <option value="Di terima">Di terima</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control">
                                    <option value="Belum Verifikasi">Belum Verifikasi</option>
                                    <option value="Terverifikasi">Terverifikasi</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
