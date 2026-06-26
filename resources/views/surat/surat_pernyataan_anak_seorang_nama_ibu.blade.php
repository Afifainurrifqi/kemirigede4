@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Form Pernyataan Anak Seorang Nama Ibu</h5>
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

                        <form action="{{ route('surat.anakseorangibu.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                    value="{{ old('nik') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ old('nama') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">Nama Anak Kandung</label>
                                <input type="text" name="nama_anak" class="form-control" value="{{ old('nama_anak') }}"
                                    required>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir Anak</label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir Anak</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                        value="{{ old('tanggal_lahir') }}" required>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Surat</label>
                                    <select name="status_surat" class="form-control" required>
                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('status_surat', 'Pending') === $st ? 'selected' : '' }}>{{ $st }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Verifikasi</label>
                                    <select name="status_verif" class="form-control" required>
                                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $sv)
                                            <option value="{{ $sv }}"
                                                {{ old('status_verif', 'Belum Verifikasi') === $sv ? 'selected' : '' }}>
                                                {{ $sv }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No WhatsApp</label>
                                <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}"
                                    required>
                            </div>

                            <div class="text-end mt-3">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Autofill NIK --}}
    <script>
        function autofillAnakSeorangIbu() {
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
                })
                .catch(err => console.log(err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            if (nikInput) nikInput.addEventListener('blur', autofillAnakSeorangIbu);
        });
    </script>
@endsection
