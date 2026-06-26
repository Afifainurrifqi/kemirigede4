@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Permohonan Pengantar Keabsahan Akta Kelahiran</h5>
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.pengantar_keabsahan.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control" value="{{ old('ttl_tempat') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control" value="{{ old('ttl_tanggal') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control" required>
                                    @foreach(['Pending','Di cek','Di terima','Ditolak'] as $st)
                                        <option value="{{ $st }}" {{ old('status_surat', 'Pending') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control" required>
                                    @foreach(['Belum Verifikasi','Terverifikasi'] as $sv)
                                        <option value="{{ $sv }}" {{ old('status_verif', 'Belum Verifikasi') == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillPengantar() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;
        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
                    document.getElementById('ttl_tanggal').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0,10) : '';
                    document.getElementById('alamat').value = d.alamat || '';
                }
            });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const nikInput = document.getElementById('nik');
        if (nikInput) nikInput.addEventListener('blur', autofillPengantar);
    });
</script>
@endsection
