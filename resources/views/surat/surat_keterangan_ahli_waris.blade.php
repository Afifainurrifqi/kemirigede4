@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Keterangan Ahli Waris</h4>

                <form action="{{ route('surat.ahliwaris.store') }}" method="POST">
                    @csrf

                    {{-- YANG BERTANDA TANGAN --}}
                    <h5 class="mb-3">Yang Bertanda Tangan</h5>
                    <div class="mb-3">
                        <label class="form-label" for="no_ktp">NIK</label>
                        <input type="text" id="no_ktp" name="no_ktp" class="form-control" required
                            value="{{ old('no_ktp') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required
                            value="{{ old('nama_lengkap') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required
                            value="{{ old('tempat_lahir') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required
                            value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="agama">Agama</label>
                        <select id="agama" name="agama" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $a)
                                <option value="{{ $a }}" {{ old('agama') === $a ? 'selected' : '' }}>
                                    {{ $a }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="pekerjaan">Pekerjaan</label>
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                            <option value="">-- Pilih pekerjaan --</option>
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
                                    'Guru agama_penumpang_kk',
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
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                    {{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $s)
                                <option value="{{ $s }}" {{ old('status') === $s ? 'selected' : '' }}>
                                    {{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>

                    <hr class="my-4">

                    {{-- KETERANGAN ISTRI --}}
                    <h5 class="mb-3">Keterangan Istri</h5>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="no_ktp_istri">NIK</label>
                            <input type="text" id="no_ktp_istri" name="no_ktp_istri" class="form-control" required
                                value="{{ old('no_ktp_istri') }}">
                        </div>
                        <label class="form-label" for="nama_istri">Nama Lengkap</label>
                        <input type="text" id="nama_istri" name="nama_istri" class="form-control" required
                            value="{{ old('nama_istri') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tempat_lahir_istri">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir_istri" name="tempat_lahir_istri" class="form-control"
                            required value="{{ old('tempat_lahir_istri') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tanggal_lahir_istri">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir_istri" name="tanggal_lahir_istri" class="form-control"
                            required value="{{ old('tanggal_lahir_istri') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="agama_istri">Agama</label>
                        <select id="agama_istri" name="agama_istri" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $ai)
                                <option value="{{ $ai }}" {{ old('agama_istri') === $ai ? 'selected' : '' }}>
                                    {{ $ai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="pekerjaan_istri">Pekerjaan</label>
                        <select name="pekerjaan_istri" id="pekerjaan_istri" class="form-control" required>
                            <option value="">-- Pilih pekerjaan_istri --</option>
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
                                    'Guru agama_penumpang_kk',
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
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}"
                                    {{ old('pekerjaan_istri') == $job ? 'selected' : '' }}>
                                    {{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status_istri">Status</label>
                        <select id="status_istri" name="status_istri" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $si)
                                <option value="{{ $si }}" {{ old('status_istri') === $si ? 'selected' : '' }}>
                                    {{ $si }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alamat_istri">Alamat</label>
                        <textarea id="alamat_istri" name="alamat_istri" class="form-control" rows="2" required>{{ old('alamat_istri') }}</textarea>
                    </div>

                    <hr class="my-4">

                    {{-- ANAK DINAMIS --}}
                    <h5 class="mb-2">Anak</h5>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label" for="jumlah_anak">Jumlah Anak</label>
                            <input type="number" min="0" id="jumlah_anak" name="jumlah_anak"
                                class="form-control" required value="{{ old('jumlah_anak', 0) }}">
                        </div>
                    </div>
                    <div id="anak-wrapper" class="mt-3"></div>

                    <div class="mb-3 mt-3">
                        <label class="form-label" for="hubungan_dengan_ahli_waris">Hubungan dengan Ahli Waris</label>
                        <input type="text" id="hubungan_dengan_ahli_waris" name="hubungan_dengan_ahli_waris"
                            class="form-control" required value="{{ old('hubungan_dengan_ahli_waris') }}">
                    </div>

                    <hr class="my-4">

                    {{-- SAKSI DINAMIS --}}
                    <h5 class="mb-2">Saksi</h5>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label" for="jumlah_saksi">Jumlah Saksi</label>
                            <input type="number" min="0" id="jumlah_saksi" name="jumlah_saksi"
                                class="form-control" required value="{{ old('jumlah_saksi', 0) }}">
                        </div>
                    </div>
                    <div id="saksi-wrapper" class="mt-3"></div>

                    {{-- Hidden default status untuk USER --}}
                    {{-- STATUS SURAT DAN VERIFIKASI --}}
                    <hr class="my-4">

                    <h5 class="mb-3">Status Surat dan Verifikasi</h5>

                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <div class="row">
                            {{-- Status Surat --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_surat" class="form-label">
                                    Status Surat
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="status_surat" id="status_surat"
                                    class="form-control @error('status_surat') is-invalid @enderror" required>
                                    <option value="">-- Pilih Status Surat --</option>

                                    @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $statusSurat)
                                        <option value="{{ $statusSurat }}"
                                            {{ old('status_surat', 'Pending') === $statusSurat ? 'selected' : '' }}>
                                            {{ $statusSurat }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('status_surat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Status Verifikasi --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_verif" class="form-label">
                                    Status Verifikasi
                                    <span class="text-danger">*</span>
                                </label>

                                <select name="status_verif" id="status_verif"
                                    class="form-control @error('status_verif') is-invalid @enderror" required>
                                    <option value="">-- Pilih Status Verifikasi --</option>

                                    @foreach (['Belum Verifikasi', 'Terverifikasi'] as $statusVerif)
                                        <option value="{{ $statusVerif }}"
                                            {{ old('status_verif', 'Belum Verifikasi') === $statusVerif ? 'selected' : '' }}>
                                            {{ $statusVerif }}
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
                    @else
                        {{-- Pengajuan user selalu memakai status awal --}}
                        <input type="hidden" name="status_surat" value="Pending">

                        <input type="hidden" name="status_verif" value="Belum Verifikasi">
                    @endif

                    <div class="mb-3 mt-3">
                        <label class="form-label" for="nowa">No WhatsApp</label>
                        <input type="text" id="nowa" name="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- JS Dinamis Anak & Saksi --}}
    <script>
        (function() {
            const anakWrapper = document.getElementById('anak-wrapper');
            const saksiWrapper = document.getElementById('saksi-wrapper');
            const jumlahAnak = document.getElementById('jumlah_anak');
            const jumlahSaksi = document.getElementById('jumlah_saksi');

            const oldAnak = @json(old('nama_anak', []));
            const oldSaksi = @json(old('nama_saksi', []));

            function renderInputs(wrapper, count, name, placeholder, oldVals) {
                wrapper.innerHTML = '';
                const n = parseInt(count || 0, 10);
                for (let i = 0; i < n; i++) {
                    const div = document.createElement('div');
                    div.className = 'mb-2';
                    div.innerHTML = `
                <label class="form-label">${placeholder} ${i+1}</label>
                <input type="text" name="${name}[]" class="form-control" value="${oldVals[i] ? String(oldVals[i]).replace(/"/g,'&quot;') : ''}">
            `;
                    wrapper.appendChild(div);
                }
            }

            renderInputs(anakWrapper, jumlahAnak.value, 'nama_anak', 'Nama Anak', oldAnak);
            renderInputs(saksiWrapper, jumlahSaksi.value, 'nama_saksi', 'Nama Saksi', oldSaksi);

            jumlahAnak.addEventListener('input', () => renderInputs(anakWrapper, jumlahAnak.value, 'nama_anak',
                'Nama Anak', []));
            jumlahSaksi.addEventListener('input', () => renderInputs(saksiWrapper, jumlahSaksi.value, 'nama_saksi',
                'Nama Saksi', []));
        })();
    </script>
    <script>
        function setValueIfExists(id, value) {
            const element = document.getElementById(id);
            if (element && value !== undefined && value !== null && value !== '') {
                element.value = value;
            }
        }

        function extractSelectValue(value) {
            if (value === undefined || value === null) {
                return '';
            }

            if (typeof value === 'object') {
                return String(
                    value.nama ??
                    value.nama_pekerjaan ??
                    value.pekerjaan ??
                    value.label ??
                    value.value ??
                    ''
                ).trim();
            }

            return String(value).trim();
        }

        function normalizeSelectValue(value) {
            return extractSelectValue(value)
                .toUpperCase()
                .replace(/\s*\/\s*/g, '/')
                .replace(/\s+/g, ' ')
                .trim();
        }

        function normalizePekerjaan(value) {
            const originalValue = extractSelectValue(value);
            const normalized = normalizeSelectValue(originalValue);

            const aliases = {
                'BELUM BEKERJA': 'BELUM/TIDAK BEKERJA',
                'TIDAK BEKERJA': 'BELUM/TIDAK BEKERJA',
                'BELUM / TIDAK BEKERJA': 'BELUM/TIDAK BEKERJA',
                'BELUM/TIDAK BEKERJA': 'BELUM/TIDAK BEKERJA',
                'BELUM TIDAK BEKERJA': 'BELUM/TIDAK BEKERJA',

                'PELAJAR': 'PELAJAR/MAHASISWA',
                'MAHASISWA': 'PELAJAR/MAHASISWA',

                'PNS': 'PEGAWAI NEGERI SIPIL (PNS)',
                'PEGAWAI NEGERI SIPIL': 'PEGAWAI NEGERI SIPIL (PNS)',

                'TNI': 'TENTARA NASIONAL INDONESIA (TNI)',
                'POLRI': 'KEPOLISIAN RI (POLRI)',

                'IRT': 'IBU RUMAH TANGGA',

                'PETANI': 'PETANI/PEKEBUN PEMILIK LAHAN',
                'PEKEBUN': 'PETANI/PEKEBUN PEMILIK LAHAN',

                'NELAYAN': 'NELAYAN/PERIKANAN',

                'LAIN-LAIN': 'Lainnya',
                'LAINNYA': 'Lainnya'
            };

            return aliases[normalized] ?? originalValue;
        }

        function setSelectIfExists(id, value, addWhenMissing = false) {
            const element = document.getElementById(id);

            if (!element) {
                return false;
            }

            let finalValue = extractSelectValue(value);

            if (id === 'pekerjaan' || id === 'pekerjaan_istri') {
                finalValue = normalizePekerjaan(finalValue);
            }

            if (!finalValue) {
                return false;
            }

            const normalizedValue = normalizeSelectValue(finalValue);

            let matched = Array.from(element.options).find(option => {
                const normalizedOptionValue = normalizeSelectValue(option.value);
                const normalizedOptionText = normalizeSelectValue(option.textContent);

                return normalizedOptionValue === normalizedValue ||
                    normalizedOptionText === normalizedValue;
            });

            if (!matched) {
                matched = Array.from(element.options).find(option => {
                    if (!option.value) {
                        return false;
                    }

                    const normalizedOption = normalizeSelectValue(option.value);

                    return normalizedOption.includes(normalizedValue) ||
                        normalizedValue.includes(normalizedOption);
                });
            }

            if (!matched && addWhenMissing) {
                matched = new Option(
                    finalValue,
                    finalValue,
                    true,
                    true
                );

                element.add(matched);
            }

            if (!matched) {
                console.warn(
                    `Pekerjaan tidak ditemukan pada select ${id}:`,
                    value
                );

                return false;
            }

            element.value = matched.value;
            matched.selected = true;

            element.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );

            if (window.jQuery) {
                window.jQuery(element)
                    .val(matched.value)
                    .trigger('change');
            }

            return true;
        }

        function formatTanggal(value) {
            if (!value) return '';
            return String(value).substring(0, 10);
        }

        function autofillAhliWarisUtama() {
            const nikInput = document.getElementById('no_ktp');
            if (!nikInput) return;

            const nik = nikInput.value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;

                        setValueIfExists('nama_lengkap', d.nama);
                        setValueIfExists('tempat_lahir', d.tempat_lahir);
                        setValueIfExists('tanggal_lahir', formatTanggal(d.tanggal_lahir));
                        setValueIfExists('alamat', d.alamat);

                        setSelectIfExists('agama', d.agama);
                        setSelectIfExists('pekerjaan', d.pekerjaan);
                        setSelectIfExists('status', d.status_perkawinan || d.status);
                    }
                })
                .catch(error => console.log('Autofill ahli waris utama error:', error));
        }

        function autofillAhliWarisIstri() {
            const nikInput = document.getElementById('no_ktp_istri');
            if (!nikInput) return;

            const nik = nikInput.value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(response => response.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;

                        setValueIfExists('nama_istri', d.nama);
                        setValueIfExists('tempat_lahir_istri', d.tempat_lahir);
                        setValueIfExists('tanggal_lahir_istri', formatTanggal(d.tanggal_lahir));
                        setValueIfExists('alamat_istri', d.alamat);

                        setSelectIfExists('agama_istri', d.agama);
                        setSelectIfExists('pekerjaan_istri', d.pekerjaan);
                        setSelectIfExists('status_istri', d.status_perkawinan || d.status);
                    }
                })
                .catch(error => console.log('Autofill ahli waris istri error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const noKtpUtama = document.getElementById('no_ktp');
            const noKtpIstri = document.getElementById('no_ktp_istri');

            if (noKtpUtama) {
                noKtpUtama.addEventListener('blur', autofillAhliWarisUtama);
            }

            if (noKtpIstri) {
                noKtpIstri.addEventListener('blur', autofillAhliWarisIstri);
            }
        });
    </script>
@endsection
