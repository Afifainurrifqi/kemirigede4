@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Pengantar SKCK</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.skck.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    {{-- NIK --}}
                    <div class="mb-3">
                        <label for="nik" class="form-label">
                            Nomor NIK <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nik" id="nik"
                            class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                            maxlength="16" inputmode="numeric" autocomplete="off" placeholder="Masukkan 16 digit NIK"
                            required>

                        <small class="text-muted">
                            Data penduduk akan terisi otomatis setelah NIK lengkap.
                        </small>

                        <div id="nik-feedback" class="small mt-1"></div>

                        @error('nik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="nama" class="form-label">
                            Nama <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nama" id="nama"
                            class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>

                        @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Tempat lahir --}}
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">
                            Tempat Lahir <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            value="{{ old('tempat_lahir') }}" required>

                        @error('tempat_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Tanggal lahir --}}
                    <div class="mb-3">
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

                    {{-- Jenis kelamin --}}
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">
                            Jenis Kelamin <span class="text-danger">*</span>
                        </label>

                        <select name="jenis_kelamin" id="jenis_kelamin"
                            class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>

                            <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>

                        @error('jenis_kelamin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Kewarganegaraan --}}
                    <div class="mb-3">
                        <label for="kewarganegaraan" class="form-label">
                            Kewarganegaraan <span class="text-danger">*</span>
                        </label>

                        <select name="kewarganegaraan" id="kewarganegaraan"
                            class="form-control @error('kewarganegaraan') is-invalid @enderror" required>
                            <option value="">-- Pilih Kewarganegaraan --</option>

                            <option value="WNI" {{ old('kewarganegaraan') === 'WNI' ? 'selected' : '' }}>
                                WNI
                            </option>

                            <option value="WNA" {{ old('kewarganegaraan') === 'WNA' ? 'selected' : '' }}>
                                WNA
                            </option>
                        </select>

                        @error('kewarganegaraan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Status perkawinan --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">
                            Status Perkawinan <span class="text-danger">*</span>
                        </label>

                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Status Perkawinan --</option>

                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                <option value="{{ $st }}" {{ old('status') === $st ? 'selected' : '' }}>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>

                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Agama --}}
                    <div class="mb-3">
                        <label for="agama" class="form-label">
                            Agama <span class="text-danger">*</span>
                        </label>

                        <select name="agama" id="agama" class="form-control @error('agama') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Agama --</option>

                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Khonghucu', 'Lainnya'] as $ag)
                                <option value="{{ $ag }}" {{ old('agama') === $ag ? 'selected' : '' }}>
                                    {{ $ag }}
                                </option>
                            @endforeach
                        </select>

                        @error('agama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Pendidikan --}}
                    <div class="mb-3">
                        <label for="pendidikan" class="form-label">
                            Pendidikan <span class="text-danger">*</span>
                        </label>

                        <select name="pendidikan" id="pendidikan"
                            class="form-control @error('pendidikan') is-invalid @enderror" required>
                            <option value="">-- Pilih Pendidikan --</option>

                            @php
                                $daftarPendidikan = [
                                    'TIDAK/BLM SEKOLAH',
                                    'BELUM TAMAT SD/SEDERAJAT',
                                    'TAMAT SD/SEDERAJAT',
                                    'SLTP/SEDERAJAT',
                                    'SLTA/SEDERAJAT',
                                    'DIPLOMA I/II',
                                    'AKADEMI/DIPLOMA III/SARJANA MUDA',
                                    'DIPLOMA IV/STRATA I',
                                    'STRATA-II',
                                    'STRATA-III',
                                ];
                            @endphp

                            @foreach ($daftarPendidikan as $pd)
                                <option value="{{ $pd }}" {{ old('pendidikan') === $pd ? 'selected' : '' }}>
                                    {{ $pd }}
                                </option>
                            @endforeach
                        </select>

                        @error('pendidikan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Pekerjaan --}}
                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">
                            Pekerjaan <span class="text-danger">*</span>
                        </label>

                        <select name="pekerjaan" id="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror" required>
                            <option value="">-- Pilih Pekerjaan --</option>

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
                                    'KEPALA DESA',
                                    'PERANGKAT DESA',
                                    'PEGAWAI KANTOR DESA',
                                    'BIDAN',
                                    'DOKTER',
                                    'PERAWAT',
                                    'PETANI/PEKEBUN PEMILIK LAHAN',
                                    'PETANI/PEKEBUN PENYEWA',
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
                                    'TKI',
                                    'LAINNYA',
                                ];
                            @endphp

                            @foreach ($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') === $job ? 'selected' : '' }}>
                                    {{ $job }}
                                </option>
                            @endforeach
                        </select>

                        @error('pekerjaan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label for="alamat" class="form-label">
                            Alamat <span class="text-danger">*</span>
                        </label>

                        <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                            required>{{ old('alamat') }}</textarea>

                        @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Informasi Surat</h5>

                    {{-- Keperuntukan --}}
                    <div class="mb-3">
                        <label for="keperuntukan" class="form-label">
                            Keperuntukan Surat <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="keperuntukan" id="keperuntukan"
                            class="form-control @error('keperuntukan') is-invalid @enderror"
                            value="{{ old('keperuntukan') }}" placeholder="Misalnya: Pengajuan SKCK di Polres" required>

                        @error('keperuntukan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Status surat --}}
                    <div class="mb-3">
                        <label for="status_surat" class="form-label">
                            Status Surat <span class="text-danger">*</span>
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

                    {{-- Status verifikasi --}}
                    <div class="mb-3">
                        <label for="status_verif" class="form-label">
                            Status Verifikasi <span class="text-danger">*</span>
                        </label>

                        <select name="status_verif" id="status_verif"
                            class="form-control @error('status_verif') is-invalid @enderror" required>
                            <option value="">-- Pilih Status Verifikasi --</option>

                            @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                                <option value="{{ $verif }}"
                                    {{ old('status_verif', 'Belum Verifikasi') === $verif ? 'selected' : '' }}>
                                    {{ $verif }}
                                </option>
                            @endforeach
                        </select>

                        @error('status_verif')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nomor WhatsApp --}}
                    <div class="mb-3">
                        <label for="nowa" class="form-label">
                            Nomor WhatsApp <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="nowa" id="nowa"
                            class="form-control @error('nowa') is-invalid @enderror" value="{{ old('nowa') }}"
                            placeholder="Contoh: 081234567890" required>

                        @error('nowa')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik');
        const nikFeedback = document.getElementById('nik-feedback');

        const lookupUrlTemplate = @json(
            route('datapenduduk.lookup', ['nik' => '__NIK__'])
        );

        let activeRequest = null;

        /**
         * Menampilkan status pencarian NIK.
         */
        function setNikFeedback(message, type = '') {
            if (!nikFeedback) {
                return;
            }

            nikFeedback.textContent = message;

            nikFeedback.classList.remove(
                'text-muted',
                'text-primary',
                'text-success',
                'text-danger'
            );

            const classes = {
                loading: 'text-primary',
                success: 'text-success',
                error: 'text-danger'
            };

            nikFeedback.classList.add(
                classes[type] ?? 'text-muted'
            );
        }

        /**
         * Mengambil isi apabila nilai berbentuk object.
         */
        function extractValue(value) {
            if (
                value === undefined ||
                value === null
            ) {
                return '';
            }

            if (typeof value !== 'object') {
                return String(value).trim();
            }

            const possibleKeys = [
                'value',
                'nama',
                'label',
                'keterangan',
                'jenis_kelamin',
                'jenisKelamin',
                'jk',
                'kelamin',
                'gender',
                'code',
                'kode',
                'id'
            ];

            for (const key of possibleKeys) {
                if (
                    value[key] !== undefined &&
                    value[key] !== null &&
                    String(value[key]).trim() !== ''
                ) {
                    return String(value[key]).trim();
                }
            }

            return '';
        }

        /**
         * Normalisasi teks untuk membandingkan option.
         */
        function normalizeText(value) {
            return extractValue(value)
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toUpperCase()
                .replace(/[^A-Z0-9]/g, '')
                .trim();
        }

        /**
         * Mengisi input biasa.
         */
        function setInputValue(id, value) {
            const element = document.getElementById(id);
            const finalValue = extractValue(value);

            if (!element || finalValue === '') {
                return false;
            }

            element.value = finalValue;

            element.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            element.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );

            return true;
        }

        /**
         * Memilih option pada select.
         */
        function setSelectValue(
            id,
            value,
            addOptionWhenMissing = false
        ) {
            const element = document.getElementById(id);
            const originalValue = extractValue(value);

            if (!element || originalValue === '') {
                return false;
            }

            const normalizedValue = normalizeText(originalValue);

            let matchedOption = Array.from(element.options).find(option => {
                return normalizeText(option.value) === normalizedValue ||
                    normalizeText(option.textContent) === normalizedValue;
            });

            /*
             * Pencocokan sebagian.
             */
            if (!matchedOption) {
                matchedOption = Array.from(element.options).find(option => {
                    if (!option.value) {
                        return false;
                    }

                    const optionValue = normalizeText(option.value);
                    const optionText = normalizeText(option.textContent);

                    return optionValue.includes(normalizedValue) ||
                        normalizedValue.includes(optionValue) ||
                        optionText.includes(normalizedValue) ||
                        normalizedValue.includes(optionText);
                });
            }

            if (!matchedOption && addOptionWhenMissing) {
                matchedOption = new Option(
                    originalValue,
                    originalValue,
                    true,
                    true
                );

                element.add(matchedOption);
            }

            if (!matchedOption) {
                console.warn(
                    `Option untuk ${id} tidak ditemukan:`,
                    originalValue
                );

                return false;
            }

            element.value = matchedOption.value;
            matchedOption.selected = true;

            element.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            element.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );

            /*
             * Dukungan apabila select memakai jQuery,
             * Select2, atau plugin sejenis.
             */
            if (window.jQuery) {
                window.jQuery(element)
                    .val(matchedOption.value)
                    .trigger('change');
            }

            return true;
        }

        /**
         * Mengubah berbagai format jenis kelamin menjadi
         * Laki-laki atau Perempuan.
         */
        function normalizeJenisKelamin(value) {
            const rawValue = extractValue(value);

            if (rawValue === '') {
                return '';
            }

            const normalized = normalizeText(rawValue);

            const nilaiLakiLaki = [
                '1',
                'L',
                'LK',
                'LKLK',
                'LAKI',
                'LAKILAKI',
                'PRIA',
                'MALE',
                'MAN'
            ];

            const nilaiPerempuan = [
                '0',
                '2',
                'P',
                'PR',
                'PRPR',
                'PEREMPUAN',
                'WANITA',
                'FEMALE',
                'WOMAN'
            ];

            if (nilaiLakiLaki.includes(normalized)) {
                return 'Laki-laki';
            }

            if (nilaiPerempuan.includes(normalized)) {
                return 'Perempuan';
            }

            /*
             * Mendukung teks seperti:
             * Jenis Kelamin: Laki-Laki
             */
            if (
                normalized.includes('LAKILAKI') ||
                normalized.includes('PRIA')
            ) {
                return 'Laki-laki';
            }

            if (
                normalized.includes('PEREMPUAN') ||
                normalized.includes('WANITA')
            ) {
                return 'Perempuan';
            }

            return '';
        }

        /**
         * Mencari jenis kelamin dari semua kemungkinan key JSON.
         */
        function resolveJenisKelamin(data, result) {
            const candidates = [
                data?.jenis_kelamin,
                data?.jenisKelamin,
                data?.jk,
                data?.kelamin,
                data?.gender,
                data?.sex,

                data?.penduduk?.jenis_kelamin,
                data?.penduduk?.jenisKelamin,
                data?.penduduk?.jk,
                data?.penduduk?.kelamin,

                result?.debug?.jenis_kelamin_hasil,
                result?.debug?.jenis_kelamin_asli,
                result?.debug?.jenis_kelamin,
                result?.jenis_kelamin
            ];

            for (const candidate of candidates) {
                const hasil = normalizeJenisKelamin(candidate);

                if (hasil !== '') {
                    return hasil;
                }
            }

            return '';
        }

        /**
         * Mengisi select jenis kelamin secara khusus.
         */
        function setJenisKelamin(data, result) {
            const select = document.getElementById('jenis_kelamin');

            if (!select) {
                return false;
            }

            const jenisKelamin = resolveJenisKelamin(data, result);

            console.log('Jenis kelamin dari API:', {
                jenis_kelamin: data?.jenis_kelamin,
                jenisKelamin: data?.jenisKelamin,
                jk: data?.jk,
                kelamin: data?.kelamin,
                gender: data?.gender,
                debug: result?.debug,
                hasil: jenisKelamin
            });

            if (jenisKelamin === '') {
                select.value = '';

                console.warn(
                    'Jenis kelamin tidak ditemukan dalam respons API.'
                );

                return false;
            }

            const berhasil = setSelectValue(
                'jenis_kelamin',
                jenisKelamin
            );

            /*
             * Set ulang sesaat setelah field lain selesai,
             * untuk mencegah plugin atau script lain mereset select.
             */
            if (berhasil) {
                setTimeout(function () {
                    setSelectValue(
                        'jenis_kelamin',
                        jenisKelamin
                    );
                }, 100);
            }

            return berhasil;
        }

        function formatTanggal(value) {
            const tanggal = extractValue(value);

            if (!tanggal) {
                return '';
            }

            if (/^\d{4}-\d{2}-\d{2}/.test(tanggal)) {
                return tanggal.substring(0, 10);
            }

            if (/^\d{2}-\d{2}-\d{4}/.test(tanggal)) {
                const parts = tanggal.split('-');

                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            if (/^\d{2}\/\d{2}\/\d{4}/.test(tanggal)) {
                const parts = tanggal.split('/');

                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            return tanggal.substring(0, 10);
        }

        function normalizeKewarganegaraan(value) {
            const normalized = normalizeText(value);

            if (
                normalized === 'WNI' ||
                normalized.includes('INDONESIA')
            ) {
                return 'WNI';
            }

            if (
                normalized === 'WNA' ||
                normalized.includes('ASING')
            ) {
                return 'WNA';
            }

            return extractValue(value) || 'WNI';
        }

        function normalizeStatus(value) {
            const normalized = normalizeText(value);

            const aliases = {
                BELUMKAWIN: 'Belum Kawin',
                BELUMMENIKAH: 'Belum Kawin',
                TIDAKKAWIN: 'Belum Kawin',
                KAWIN: 'Kawin',
                MENIKAH: 'Kawin',
                CERAIHIDUP: 'Cerai Hidup',
                CERAIMATI: 'Cerai Mati'
            };

            return aliases[normalized] ?? extractValue(value);
        }

        function normalizeAgama(value) {
            const normalized = normalizeText(value);

            const aliases = {
                ISLAM: 'Islam',
                KRISTEN: 'Kristen',
                KRISTENPROTESTAN: 'Kristen',
                PROTESTAN: 'Kristen',
                KATOLIK: 'Katolik',
                KRISTENKATOLIK: 'Katolik',
                HINDU: 'Hindu',
                BUDHA: 'Buddha',
                BUDDHA: 'Buddha',
                KONGHUCU: 'Konghucu',
                KHONGHUCU: 'Khonghucu',
                LAINNYA: 'Lainnya'
            };

            return aliases[normalized] ?? extractValue(value);
        }

        function normalizePendidikan(value) {
            const normalized = normalizeText(value);

            const aliases = {
                TIDAKBELUMSEKOLAH: 'TIDAK/BLM SEKOLAH',
                TIDAKBLMSEKOLAH: 'TIDAK/BLM SEKOLAH',
                BELUMTAMATSDSEDERAJAT:
                    'BELUM TAMAT SD/SEDERAJAT',
                TAMATSDSEDERAJAT:
                    'TAMAT SD/SEDERAJAT',
                SD: 'TAMAT SD/SEDERAJAT',
                SMP: 'SLTP/SEDERAJAT',
                SLTPSEDERAJAT: 'SLTP/SEDERAJAT',
                SMA: 'SLTA/SEDERAJAT',
                SMK: 'SLTA/SEDERAJAT',
                SLTASEDERAJAT: 'SLTA/SEDERAJAT',
                D1: 'DIPLOMA I/II',
                D2: 'DIPLOMA I/II',
                DIPLOMAIII:
                    'AKADEMI/DIPLOMA III/SARJANA MUDA',
                D3:
                    'AKADEMI/DIPLOMA III/SARJANA MUDA',
                D4:
                    'DIPLOMA IV/STRATA I',
                S1:
                    'DIPLOMA IV/STRATA I',
                STRATAI:
                    'DIPLOMA IV/STRATA I',
                S2: 'STRATA-II',
                STRATAII: 'STRATA-II',
                S3: 'STRATA-III',
                STRATAIII: 'STRATA-III'
            };

            return aliases[normalized] ?? extractValue(value);
        }

        function normalizePekerjaan(value) {
            const normalized = normalizeText(value);

            const aliases = {
                BELUMBEKERJA: 'BELUM/TIDAK BEKERJA',
                TIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',
                PELAJAR: 'PELAJAR/MAHASISWA',
                MAHASISWA: 'PELAJAR/MAHASISWA',
                IRT: 'IBU RUMAH TANGGA',
                PNS: 'PEGAWAI NEGERI SIPIL (PNS)',
                PEGAWAINEGERISIPIL:
                    'PEGAWAI NEGERI SIPIL (PNS)',
                TNI:
                    'TENTARA NASIONAL INDONESIA (TNI)',
                TENTARANASIONALINDONESIA:
                    'TENTARA NASIONAL INDONESIA (TNI)',
                POLRI:
                    'KEPOLISIAN RI (POLRI)',
                KEPOLISIANREPUBLIKINDONESIA:
                    'KEPOLISIAN RI (POLRI)',
                PETANI:
                    'PETANI/PEKEBUN PEMILIK LAHAN',
                PEKEBUN:
                    'PETANI/PEKEBUN PEMILIK LAHAN',
                BURUHTANI:
                    'BURUH TANI/PERKEBUNAN',
                NELAYAN:
                    'NELAYAN/PERIKANAN',
                BURUHNELAYAN:
                    'BURUH NELAYAN/PERIKANAN',
                HONORER:
                    'KARYAWAN HONORER',
                PEGAWAIHONORER:
                    'KARYAWAN HONORER',
                LAINLAIN:
                    'LAINNYA'
            };

            return aliases[normalized] ?? extractValue(value);
        }

        /**
         * Mengosongkan data hasil autofill.
         */
        function clearAutofillFields() {
            [
                'nama',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat'
            ].forEach(id => {
                const element = document.getElementById(id);

                if (element) {
                    element.value = '';
                }
            });

            [
                'jenis_kelamin',
                'kewarganegaraan',
                'status',
                'agama',
                'pendidikan',
                'pekerjaan'
            ].forEach(id => {
                const element = document.getElementById(id);

                if (element) {
                    element.value = '';
                }
            });
        }

        /**
         * Autofill berdasarkan NIK.
         */
        async function autofillSkck() {
            if (!nikInput) {
                return;
            }

            const nik = nikInput.value
                .replace(/\D/g, '')
                .slice(0, 16);

            nikInput.value = nik;

            if (nik.length !== 16) {
                setNikFeedback(
                    `${nik.length}/16 digit NIK`,
                    nik.length > 0 ? 'error' : ''
                );

                return;
            }

            if (activeRequest) {
                activeRequest.abort();
            }

            activeRequest = new AbortController();

            const url = lookupUrlTemplate.replace(
                '__NIK__',
                encodeURIComponent(nik)
            );

            setNikFeedback(
                'Sedang mencari data penduduk...',
                'loading'
            );

            try {
                const response = await fetch(url, {
                    method: 'GET',

                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    cache: 'no-store',
                    signal: activeRequest.signal
                });

                const result = await response.json();

                console.log(
                    'Respons lengkap lookup NIK:',
                    result
                );

                if (!response.ok || !result.success) {
                    throw new Error(
                        result.message ||
                        'Data penduduk tidak ditemukan.'
                    );
                }

                const data = result.data ?? {};

                setInputValue(
                    'nama',
                    data.nama
                );

                setInputValue(
                    'tempat_lahir',
                    data.tempat_lahir
                );

                setInputValue(
                    'tanggal_lahir',
                    formatTanggal(data.tanggal_lahir)
                );

                setInputValue(
                    'alamat',
                    data.alamat
                );

                /*
                 * Jenis kelamin menggunakan fungsi khusus.
                 */
                setJenisKelamin(data, result);

                setSelectValue(
                    'kewarganegaraan',
                    normalizeKewarganegaraan(
                        data.kewarganegaraan
                    )
                );

                setSelectValue(
                    'status',
                    normalizeStatus(
                        data.status_perkawinan ??
                        data.status
                    )
                );

                setSelectValue(
                    'agama',
                    normalizeAgama(data.agama),
                    true
                );

                setSelectValue(
                    'pendidikan',
                    normalizePendidikan(
                        data.pendidikan
                    ),
                    true
                );

                setSelectValue(
                    'pekerjaan',
                    normalizePekerjaan(
                        data.pekerjaan
                    ),
                    true
                );

                setNikFeedback(
                    'Data penduduk berhasil ditemukan dan diisi.',
                    'success'
                );
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                clearAutofillFields();

                setNikFeedback(
                    error.message ||
                    'Gagal mengambil data penduduk.',
                    'error'
                );

                console.error(
                    'Kesalahan autofill NIK:',
                    error
                );
            }
        }

        if (nikInput) {
            nikInput.addEventListener('input', function () {
                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                if (this.value.length === 16) {
                    autofillSkck();
                } else {
                    setNikFeedback(
                        `${this.value.length}/16 digit NIK`
                    );
                }
            });

            nikInput.addEventListener('change', function () {
                if (this.value.length === 16) {
                    autofillSkck();
                }
            });

            nikInput.addEventListener('blur', function () {
                if (this.value.length === 16) {
                    autofillSkck();
                }
            });

            if (
                nikInput.value
                    .replace(/\D/g, '')
                    .length === 16
            ) {
                autofillSkck();
            }
        }
    });
</script>
@endsection
