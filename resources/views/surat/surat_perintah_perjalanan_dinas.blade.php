@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Form Surat Perintah Perjalanan Dinas (SPPD)</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat.perintah_perjalanan_dinas.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Data Pegawai yang Diperintah</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Pegawai <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pegawai" class="form-control" required value="{{ old('nama_pegawai') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Pangkat / Golongan</label>
                        <input type="text" name="pangkat_golongan" class="form-control" value="{{ old('pangkat_golongan') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" required value="{{ old('jabatan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Instansi</label>
                        <input type="text" name="instansi" class="form-control" value="{{ old('instansi') }}">
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Detail Perjalanan Dinas</h5>
                <div class="mb-3">
                    <label>Maksud Perjalanan Dinas <span class="text-danger">*</span></label>
                    <textarea name="maksud_perjalanan" class="form-control" rows="3" required>{{ old('maksud_perjalanan') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Alat Angkutan</label>
                        <input type="text" name="alat_angkutan" class="form-control" value="{{ old('alat_angkutan') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Lama Perjalanan (Hari)</label>
                        <input type="text" name="lama_perjalanan" class="form-control" required value="{{ old('lama_perjalanan') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Tempat Berangkat</label>
                        <input type="text" name="tempat_berangkat" class="form-control" value="{{ old('tempat_berangkat') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Tempat Tujuan <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_tujuan" class="form-control" required value="{{ old('tempat_tujuan') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Sumber Anggaran</label>
                        <input type="text" name="sumber_anggaran" class="form-control" value="{{ old('sumber_anggaran') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Berangkat <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_berangkat" class="form-control" required value="{{ old('tanggal_berangkat') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Kembali <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kembali" class="form-control" required value="{{ old('tanggal_kembali') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek">Di cek</option>
                            <option value="Di terima">Di terima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', 'Belum Verifikasi') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5">Simpan Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
