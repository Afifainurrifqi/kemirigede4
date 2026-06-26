@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Form Surat Pernyataan Pembetulan Data Tidak Merubah Lagi</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.pembetulandata.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-2">Data Pemohon</h6>

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Uraian Pembetulan Data</h6>

                        <div class="mb-3">
                            <label>Uraian Data yang Diperbaiki <span class="text-danger">*</span></label>
                            <textarea name="uraian_pembetulan" class="form-control" rows="3" required>{{ old('uraian_pembetulan') }}</textarea>
                            <small class="text-muted">Contoh: Perubahan nama dari "Ahmad" menjadi "Ahmad Santoso"</small>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Pendukung</h6>

                        <div class="mb-3">
                            <label>Data Pendukung 1</label>
                            <input type="text" name="data_pendukung_1" class="form-control" value="{{ old('data_pendukung_1') }}">
                        </div>
                        <div class="mb-3">
                            <label>Data Pendukung 2</label>
                            <input type="text" name="data_pendukung_2" class="form-control" value="{{ old('data_pendukung_2') }}">
                        </div>
                        <div class="mb-3">
                            <label>Data Pendukung 3</label>
                            <input type="text" name="data_pendukung_3" class="form-control" value="{{ old('data_pendukung_3') }}">
                        </div>
                        <div class="mb-3">
                            <label>Data Pendukung 4</label>
                            <input type="text" name="data_pendukung_4" class="form-control" value="{{ old('data_pendukung_4') }}">
                        </div>
                        <div class="mb-3">
                            <label>Data Pendukung 5</label>
                            <input type="text" name="data_pendukung_5" class="form-control" value="{{ old('data_pendukung_5') }}">
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
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillPembetulanData() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('alamat').value = d.alamat || '';
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nikInput = document.getElementById('nik');
        if (nikInput) nikInput.addEventListener('blur', autofillPembetulanData);
    });
</script>
@endsection
