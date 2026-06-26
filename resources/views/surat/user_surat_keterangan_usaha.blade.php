<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Surat Keterangan Usaha</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
<div class="header-area" id="headerArea">
    <div class="container">
        <div class="header-content position-relative d-flex align-items-center justify-content-between">
            <div class="back-button">
                <a href="{{ route('surat.keterangan') }}">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
            </div>
            <div class="page-heading">
                <h6 class="mb-0">Form Surat Keterangan Usaha</h6>
            </div>
            <div class="setting-wrapper"></div>
        </div>
    </div>
</div>

<div class="page-content-wrapper py-3">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.userusaha.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label for="nik" class="form-label">Nomor NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric" value="{{ old('nik') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nama_usaha" class="form-label">Nama/Bidang Usaha <span class="text-danger">*</span></label>
                        <input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required value="{{ old('nama_usaha') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Laki-laki', 'Perempuan'] as $jk)
                                <option value="{{ $jk }}" {{ old('jenis_kelamin') == $jk ? 'selected' : '' }}>{{ $jk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['WNI', 'WNA'] as $kw)
                                <option value="{{ $kw }}" {{ old('kewarganegaraan') == $kw ? 'selected' : '' }}>{{ $kw }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Informasi Surat</h5>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" id="keperluan" class="form-control" required value="{{ old('keperluan') }}">
                    </div>

                    <input type="hidden" name="status_surat" value="Pending">
                    <input type="hidden" name="status_verif" value="Belum Verifikasi">

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required value="{{ old('nowa') }}" placeholder="+62812xxxx">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Kirim</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets4/dist/js/active.js') }}"></script>
<script>
    function setValueIfExists(id, value) {
        const element = document.getElementById(id);

        if (element && value !== undefined && value !== null && value !== '') {
            element.value = value;
        }
    }

    function setSelectIfExists(id, value) {
        const element = document.getElementById(id);

        if (!element || value === undefined || value === null || value === '') {
            return;
        }

        const normalizedValue = String(value).trim().toLowerCase();

        const matched = Array.from(element.options).find(option => {
            return option.value.trim().toLowerCase() === normalizedValue ||
                option.text.trim().toLowerCase() === normalizedValue;
        });

        if (matched) {
            element.value = matched.value;
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

    function autofillUsaha() {
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
            .catch(error => {
                console.log('Autofill Surat Keterangan Usaha error:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik');

        if (nikInput) {
            nikInput.addEventListener('blur', autofillUsaha);
            nikInput.addEventListener('change', autofillUsaha);
        }
    });
</script>
</body>
</html>
