@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Form Surat Pernyataan Kesanggupan</h5>

                        {{-- <a href="{{ route('surat.pernyataan_kesanggupan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a> --}}
                    </div>

                    <div class="card-body">
                        {{-- Error validasi --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Data belum dapat disimpan.</strong>

                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.pernyataan_kesanggupan.store') }}" method="POST"
                            id="formKesanggupan">
                            @csrf

                            {{-- Data Pemohon --}}
                            <h6 class="fw-bold mb-3">Data Pemohon</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">
                                        NIK <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <input type="text" name="nik" id="nik" class="form-control"
                                            onkeyup="autofillKesanggupanUser()" required>

                                        {{-- <button type="button"
                                            class="btn btn-primary"
                                            id="btnCariNik">
                                            <span id="iconCariNik">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            Cari
                                        </button> --}}

                                        @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <small id="nikMessage" class="form-text"></small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}"
                                        placeholder="Nama lengkap pemohon" required>

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tempat_lahir" class="form-label">
                                        Tempat Lahir <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="tempat_lahir" id="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir" required>

                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="tanggal_lahir" class="form-label">
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir') }}" required>

                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">
                                    Alamat <span class="text-danger">*</span>
                                </label>

                                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                    placeholder="Alamat lengkap pemohon" required>{{ old('alamat') }}</textarea>

                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nowa" class="form-label">
                                    No. HP/WhatsApp <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="nowa" id="nowa"
                                    class="form-control @error('nowa') is-invalid @enderror" value="{{ old('nowa') }}"
                                    maxlength="15" inputmode="numeric" placeholder="Contoh: 081234567890" required>

                                @error('nowa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <hr>

                            {{-- Data Kegiatan --}}
                            <h6 class="fw-bold mb-3">Data Kegiatan</h6>

                            <div class="mb-3">
                                <label for="kegiatan" class="form-label">
                                    Nama Kegiatan <span class="text-danger">*</span>
                                </label>

                                <input type="text" name="kegiatan" id="kegiatan"
                                    class="form-control @error('kegiatan') is-invalid @enderror"
                                    value="{{ old('kegiatan') }}" placeholder="Masukkan nama kegiatan" required>

                                @error('kegiatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="hari" class="form-label">
                                        Hari <span class="text-danger">*</span>
                                    </label>

                                    <select name="hari" id="hari"
                                        class="form-control @error('hari') is-invalid @enderror" required>
                                        <option value="">-- Pilih Hari --</option>

                                        @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                            <option value="{{ $hari }}"
                                                {{ old('hari') == $hari ? 'selected' : '' }}>
                                                {{ $hari }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('hari')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="tanggal_kegiatan" class="form-label">
                                        Tanggal Kegiatan <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan"
                                        class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                        value="{{ old('tanggal_kegiatan') }}" required>

                                    @error('tanggal_kegiatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="waktu" class="form-label">
                                        Waktu <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="waktu" id="waktu"
                                        class="form-control @error('waktu') is-invalid @enderror"
                                        value="{{ old('waktu') }}" placeholder="Contoh: 08.00 WIB sampai selesai"
                                        required>

                                    @error('waktu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tempat_kegiatan" class="form-label">
                                    Tempat Kegiatan <span class="text-danger">*</span>
                                </label>

                                <textarea name="tempat_kegiatan" id="tempat_kegiatan"
                                    class="form-control @error('tempat_kegiatan') is-invalid @enderror" rows="3"
                                    placeholder="Masukkan tempat kegiatan" required>{{ old('tempat_kegiatan') }}</textarea>

                                @error('tempat_kegiatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keterangan_tambahan" class="form-label">
                                    Keterangan Tambahan
                                </label>

                                <textarea name="keterangan_tambahan" id="keterangan_tambahan"
                                    class="form-control @error('keterangan_tambahan') is-invalid @enderror" rows="3"
                                    placeholder="Keterangan tambahan apabila diperlukan">{{ old('keterangan_tambahan') }}</textarea>

                                @error('keterangan_tambahan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <hr>

                            {{-- Status Surat --}}
                            <h6 class="fw-bold mb-3">Status Pengajuan</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status_surat" class="form-label">
                                        Status Surat <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_surat" id="status_surat"
                                        class="form-control @error('status_surat') is-invalid @enderror" required>
                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status_surat', 'Pending') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="status_verif" class="form-label">
                                        Status Verifikasi <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_verif" id="status_verif"
                                        class="form-control @error('status_verif') is-invalid @enderror" required>
                                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verifikasi)
                                            <option value="{{ $verifikasi }}"
                                                {{ old('status_verif', 'Belum Verifikasi') == $verifikasi ? 'selected' : '' }}>
                                                {{ $verifikasi }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status_verif')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('surat.pernyataan_kesanggupan.index') }}" class="btn btn-danger">
                                    Batal
                                </a>

                                <button type="submit" class="btn btn-primary" id="btnSimpan">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function autofillKesanggupanUser() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                        document.getElementById('tanggal_lahir').value = d.tanggal_lahir || '';
                        document.getElementById('alamat').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }
    </script>
@endsection
