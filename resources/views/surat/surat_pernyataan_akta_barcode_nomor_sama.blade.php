@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Form Pernyataan Akta Barcode Nomor Sama</h5>
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

                        <form action="{{ route('surat.aktabarcode.store') }}" method="POST">
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
                                <label class="form-label">Nama Dalam Akta</label>
                                <input type="text" name="nama_dalam_akta" class="form-control"
                                    value="{{ old('nama_dalam_akta') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No. Akta</label>
                                <input type="text" name="no_akta" class="form-control" value="{{ old('no_akta') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor yang Diajukan</label>
                                <input type="text" name="nomor" class="form-control" value="{{ old('nomor') }}"
                                    required>
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

                            <div class="text-end">
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
        function autofillAktaBarcode() {
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
            if (nikInput) nikInput.addEventListener('blur', autofillAktaBarcode);
        });
    </script>
@endsection
