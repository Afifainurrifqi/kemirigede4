@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Form Surat Keterangan Desa Miskin</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat.miskindesa.store') }}" method="POST">
                @csrf

                <h5 class="mb-3">Data Pemohon</h5>

                <div class="mb-3">
                    <label for="nik" class="form-label">Nomor NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric"
                        value="{{ old('nik') }}" placeholder="16 digit">
                    <small class="text-muted">Isi NIK lalu klik/tab keluar agar data otomatis terisi.</small>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required
                        value="{{ old('nama') }}">
                </div>

                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                        value="{{ old('tempat_lahir') }}">
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                        value="{{ old('tanggal_lahir') }}">
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach (['Laki-laki', 'Perempuan'] as $jk)
                            <option value="{{ $jk }}" {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>
                                {{ $jk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                    <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach (['WNI', 'WNA'] as $kw)
                            <option value="{{ $kw }}" {{ old('kewarganegaraan') == $kw ? 'selected' : '' }}>
                                {{ $kw }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Tempat Tinggal / Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Informasi Surat</h5>

                <div class="mb-3">
                    <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control" required
                        value="{{ old('keperluan') }}"
                        placeholder="Contoh: Berobat ke Rumah Sakit Ngudi Waluyo Wlingi">
                </div>

                <div class="mb-3">
                    <label for="status_surat" class="form-label">Status Surat <span class="text-danger">*</span></label>
                    <select name="status_surat" id="status_surat" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                            <option value="{{ $status }}" {{ old('status_surat', 'Pending') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status_verif" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                    <select name="status_verif" id="status_verif" class="form-control" required>
                        <option value="">-- Pilih Verifikasi --</option>
                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                            <option value="{{ $verif }}" {{ old('status_verif', 'Belum Verifikasi') == $verif ? 'selected' : '' }}>
                                {{ $verif }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required
                        value="{{ old('nowa') }}" placeholder="+62812xxxx">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setValueIfExists(id, value) {
        const el = document.getElementById(id);
        if (el && value !== undefined && value !== null && value !== '') {
            el.value = value;
        }
    }

    function setSelectIfExists(id, value) {
        const el = document.getElementById(id);
        if (!el || value === undefined || value === null || value === '') return;

        const normalized = String(value).trim().toLowerCase();

        const matched = Array.from(el.options).find(option => {
            return option.value.trim().toLowerCase() === normalized ||
                option.text.trim().toLowerCase() === normalized;
        });

        if (matched) {
            el.value = matched.value;
        }
    }

    function formatTanggal(value) {
        if (!value) return '';

        const str = String(value);

        if (/^\d{4}-\d{2}-\d{2}/.test(str)) {
            return str.substring(0, 10);
        }

        if (/^\d{2}-\d{2}-\d{4}/.test(str)) {
            const parts = str.split('-');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        }

        return str.substring(0, 10);
    }

    function normalizeJenisKelamin(value) {
        if (!value) return '';

        const v = String(value).trim().toLowerCase();

        if (v === '1' || v.includes('laki')) {
            return 'Laki-laki';
        }

        if (v === '0' || v.includes('perempuan')) {
            return 'Perempuan';
        }

        return value;
    }

    function normalizeKewarganegaraan(value) {
        if (!value) return '';

        const v = String(value).trim().toLowerCase();

        if (v.includes('indonesia') || v.includes('wni')) {
            return 'WNI';
        }

        if (v.includes('asing') || v.includes('wna')) {
            return 'WNA';
        }

        return value;
    }

    function autofillMiskinDesa() {
        const nikInput = document.getElementById('nik');
        if (!nikInput) return;

        const nik = nikInput.value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(response => response.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;

                    setValueIfExists('nama', d.nama);
                    setValueIfExists('tempat_lahir', d.tempat_lahir);
                    setValueIfExists('tanggal_lahir', formatTanggal(d.tanggal_lahir));
                    setValueIfExists('alamat', d.alamat);

                    setSelectIfExists('jenis_kelamin', normalizeJenisKelamin(d.jenis_kelamin));
                    setSelectIfExists('kewarganegaraan', normalizeKewarganegaraan(d.kewarganegaraan));
                }
            })
            .catch(error => console.log('Autofill miskin desa error:', error));
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik');

        if (nikInput) {
            nikInput.addEventListener('blur', autofillMiskinDesa);
            nikInput.addEventListener('change', autofillMiskinDesa);
        }
    });
</script>
@endsection
