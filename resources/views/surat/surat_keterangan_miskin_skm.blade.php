@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Keterangan Miskin (SKM)</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.skm.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="16"
                            inputmode="numeric" value="{{ old('nik') }}">
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
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                            value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                        @php
                            $jobs = [
                                'BELUM/TIDAK BEKERJA',
                                'PELAJAR/MAHASISWA',
                                'TIDAK/BELUM SEKOLAH',
                                'KARYAWAN SWASTA',
                                'IBU RUMAH TANGGA',
                                'WIRASWASTA',
                                'TENTARA NASIONAL INDONESIA (TNI)',
                                'KEPOLISIAN RI (POLRI)',
                                'DOSEN',
                                'GURU',
                                'Guru agama',
                                'KEPALA DESA',
                                'PERANGKAT DESA',
                                'Pegawai Kantor Desa',
                                'BIDAN',
                                'DOKTER',
                                'PERAWAT',
                                'PETANI/PEKEBUN PEMILIK LAHAN',
                                'BURUH TANI/PERKEBUNAN',
                                'PEDAGANG',
                                'PEGAWAI NEGERI SIPIL (PNS)',
                                'BURUH HARIAN LEPAS',
                                'SOPIR',
                                'KARYAWAN BUMN',
                                'PENSIUNAN',
                                'PEMBANTU RUMAH TANGGA',
                                'BURUH PETERNAKAN',
                                'KONSTRUKSI',
                                'PELAUT',
                                'NELAYAN/PERIKANAN',
                                'KARYAWAN HONORER',
                                'PETERNAK',
                                'MEKANIK',
                                'PENATA RIAS',
                                'TUKANG LAS/PANDAI BESI',
                                'INDUSTRI',
                                'USTADZ/MUBALIGH',
                                'TABIB',
                                'BURUH NELAYAN/PERIKANAN',
                                'JURU MASAK',
                                'SENIMAN',
                                'AKUNTAN',
                                'Petani/Pekebun penyewa',
                                'TKI',
                                'Lainnya',
                            ];
                        @endphp
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                    {{ $job }}</option>
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
                        <label for="status_surat" class="form-label">Status Surat</label>
                        <select name="status_surat" id="status_surat" class="form-control" required>
                            @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status_surat', 'Pending') == $status ? 'selected' : '' }}>{{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_verif" class="form-label">Status Verifikasi</label>
                        <select name="status_verif" id="status_verif" class="form-control" required>
                            @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                                <option value="{{ $verif }}"
                                    {{ old('status_verif', 'Belum Verifikasi') == $verif ? 'selected' : '' }}>
                                    {{ $verif }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
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
        if (el) {
            el.value = value || '';
        }
    }

    function setSelectIfExists(id, value) {
        const el = document.getElementById(id);
        if (!el) return;

        const rawValue = (value || '').toString().trim();

        if (!rawValue) {
            el.value = '';
            return;
        }

        const normalized = rawValue.toLowerCase();

        const matched = Array.from(el.options).find(option => {
            const optionValue = option.value.toString().trim().toLowerCase();
            const optionText = option.textContent.toString().trim().toLowerCase();

            return optionValue === normalized || optionText === normalized;
        });

        if (matched) {
            el.value = matched.value;
        } else {
            const newOption = new Option(rawValue, rawValue, true, true);
            el.add(newOption);
            el.value = rawValue;

            console.warn(`Value "${rawValue}" tidak ada di select #${id}, jadi ditambahkan otomatis.`);
        }
    }

    function formatTanggal(value) {
        if (!value) return '';

        const str = String(value);

        if (/^\d{4}-\d{2}-\d{2}/.test(str)) {
            return str.substring(0, 10);
        }

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
                console.log('HASIL LOOKUP SKM:', result);

                if (!result.success || !result.data) {
                    alert(result.message || 'NIK tidak ditemukan');
                    return;
                }

                const d = result.data;

                setValueIfExists('nama', d.nama);
                setValueIfExists('tempat_lahir', d.tempat_lahir);
                setValueIfExists('tanggal_lahir', formatTanggal(d.tanggal_lahir));
                setValueIfExists('alamat', d.alamat);

                // INI BAGIAN PEKERJAAN
                setSelectIfExists('pekerjaan', d.pekerjaan);
            })
            .catch(err => {
                console.log('Autofill SKM error:', err);
                alert('Gagal mengambil data penduduk');
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik');

        if (nikInput) {
            nikInput.addEventListener('blur', autofillSkm);
            nikInput.addEventListener('change', autofillSkm);
        }
    });
</script>
@endsection
