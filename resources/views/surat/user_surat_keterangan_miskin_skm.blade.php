<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Surat Keterangan Miskin (SKM)</title>
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
                <h6 class="mb-0">Surat Keterangan Miskin (SKM)</h6>
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

                <form action="{{ route('surat.userskm.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric" value="{{ old('nik') }}">
                        <small class="text-muted">Isi NIK lalu klik/tab keluar agar data otomatis terisi.</small>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" required value="{{ old('nama') }}">
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
                        <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                        @php
                            $jobs = [
                                'BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA',
                                'WIRASWASTA','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN',
                                'PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','BURUH HARIAN LEPAS',
                                'SOPIR','KARYAWAN BUMN','PENSIUNAN','KARYAWAN HONORER','TUKANG BATU','Lainnya'
                            ];
                        @endphp
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                    </div>

                    <input type="hidden" name="status_surat" value="Pending">
                    <input type="hidden" name="status_verif" value="Belum Verifikasi">

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required value="{{ old('nowa') }}">
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
    const el = document.getElementById(id);
    if (el && value !== undefined && value !== null && value !== '') el.value = value;
}

function setSelectIfExists(id, value) {
    const el = document.getElementById(id);
    if (!el || !value) return;

    const normalized = String(value).trim().toLowerCase();
    const matched = Array.from(el.options).find(option =>
        option.value.trim().toLowerCase() === normalized ||
        option.text.trim().toLowerCase() === normalized
    );

    if (matched) el.value = matched.value;
}

function formatTanggal(value) {
    if (!value) return '';
    const str = String(value);

    if (/^\d{4}-\d{2}-\d{2}/.test(str)) return str.substring(0, 10);

    if (/^\d{2}-\d{2}-\d{4}/.test(str)) {
        const p = str.split('-');
        return `${p[2]}-${p[1]}-${p[0]}`;
    }

    return str.substring(0, 10);
}

function autofillSkm() {
    const nikInput = document.getElementById('nik');
    if (!nikInput) return;

    const nik = nikInput.value.trim();
    if (nik.length < 10) return;

    fetch(`/datapenduduk/lookup/${nik}`)
        .then(res => res.json())
        .then(result => {
            if (result.success && result.data) {
                const d = result.data;

                setValueIfExists('nama', d.nama);
                setValueIfExists('tempat_lahir', d.tempat_lahir);
                setValueIfExists('tanggal_lahir', formatTanggal(d.tanggal_lahir));
                setValueIfExists('alamat', d.alamat);
                setSelectIfExists('pekerjaan', d.pekerjaan);
            }
        })
        .catch(err => console.log('Autofill SKM error:', err));
}

document.addEventListener('DOMContentLoaded', function () {
    const nikInput = document.getElementById('nik');
    if (nikInput) {
        nikInput.addEventListener('blur', autofillSkm);
        nikInput.addEventListener('change', autofillSkm);
    }
});
</script>
</body>
</html>
