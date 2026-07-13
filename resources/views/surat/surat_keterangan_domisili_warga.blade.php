@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-heade">
                        <h5 class="mb-0">Form Pembuatan Surat Keterangan Domisili Warga</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('surat.domisili_warga.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control"
                                        onkeyup="autofillDomisiliAdmin()" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                        required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Agama <span class="text-danger">*</span></label>
                                    <select name="agama" id="agama" class="form-control" required>
                                        <option value="">-- Pilih Agama --</option>
                                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $ag)
                                            <option value="{{ $ag }}"
                                                {{ old('agama') === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('status') === $st ? 'selected' : '' }}>{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Pekerjaan <span class="text-danger">*</span></label>
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
                                                'KEPALA DESA',
                                                'PERANGKAT DESA',
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
                                                {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                                {{ $job }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>No WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="nowa" id="nowa" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Asal (Luar Desa) <span class="text-danger">*</span></label>
                                <textarea name="alamat_asal" id="alamat_asal" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Domisili di Desa KEMIRIGEDE <span class="text-danger">*</span></label>
                                <textarea name="alamat_domisili" id="alamat_domisili" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Keterangan Tambahan</label>
                                <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                            </div>

                            {{-- Verifikasi dan status surat --}}
                            <h5 class="text-secondary mt-4 mb-3">
                                Verifikasi dan Status Surat
                            </h5>

                            <div class="row">
                                {{-- Nomor surat --}}


                                {{-- Status surat --}}
                                <div class="col-md-4 mb-3">
                                    <label for="status_surat" class="form-label">
                                        Status Surat
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_surat" id="status_surat"
                                        class="form-control @error('status_surat') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status Surat --</option>

                                        <option value="Pending"
                                            {{ old('status_surat', 'Pending') === 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        <option value="Di cek" {{ old('status_surat') === 'Di cek' ? 'selected' : '' }}>
                                            Di cek
                                        </option>

                                        <option value="Di terima"
                                            {{ old('status_surat') === 'Di terima' ? 'selected' : '' }}>
                                            Di terima
                                        </option>

                                        <option value="Ditolak" {{ old('status_surat') === 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak
                                        </option>
                                    </select>

                                    @error('status_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Status verifikasi --}}
                                <div class="col-md-4 mb-3">
                                    <label for="status_verif" class="form-label">
                                        Status Verifikasi
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_verif" id="status_verif"
                                        class="form-control @error('status_verif') is-invalid @enderror" required>
                                        <option value="">
                                            -- Pilih Status Verifikasi --
                                        </option>

                                        <option value="Belum Verifikasi"
                                            {{ old('status_verif', 'Belum Verifikasi') === 'Belum Verifikasi' ? 'selected' : '' }}>
                                            Belum Verifikasi
                                        </option>

                                        <option value="Terverifikasi"
                                            {{ old('status_verif') === 'Terverifikasi' ? 'selected' : '' }}>
                                            Terverifikasi
                                        </option>
                                    </select>

                                    @error('status_verif')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary">Simpan Surat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const btnCariNik = document.getElementById('btn-cari-nik');
            const nikFeedback = document.getElementById('nik-feedback');

            const lookupUrlTemplate = @json(route('datapenduduk.lookup', ['nik' => '__NIK__']));

            let requestController = null;

            function setFeedback(message, type = '') {
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

                if (type === 'loading') {
                    nikFeedback.classList.add('text-primary');
                } else if (type === 'success') {
                    nikFeedback.classList.add('text-success');
                } else if (type === 'error') {
                    nikFeedback.classList.add('text-danger');
                } else {
                    nikFeedback.classList.add('text-muted');
                }
            }

            function extractValue(value, additionalKeys = []) {
                if (value === undefined || value === null) {
                    return '';
                }

                if (typeof value !== 'object') {
                    return String(value).trim();
                }

                const keys = [
                    ...additionalKeys,
                    'nama',
                    'nama_pekerjaan',
                    'nama_agama',
                    'nama_status',
                    'pekerjaan',
                    'agama',
                    'status',
                    'status_perkawinan',
                    'label',
                    'value',
                    'keterangan'
                ];

                for (const key of keys) {
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

            function normalizeText(value) {
                return extractValue(value)
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '')
                    .trim();
            }

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

            function setSelectValue(
                id,
                value,
                addWhenMissing = false
            ) {
                const select = document.getElementById(id);
                const originalValue = extractValue(value);

                if (!select || originalValue === '') {
                    return false;
                }

                const normalizedValue = normalizeText(originalValue);

                let matchedOption = Array.from(
                    select.options
                ).find(function(option) {
                    return normalizeText(option.value) === normalizedValue ||
                        normalizeText(option.textContent) === normalizedValue;
                });

                if (!matchedOption) {
                    matchedOption = Array.from(
                        select.options
                    ).find(function(option) {
                        if (!option.value) {
                            return false;
                        }

                        const normalizedOption =
                            normalizeText(option.value);

                        return normalizedOption.includes(normalizedValue) ||
                            normalizedValue.includes(normalizedOption);
                    });
                }

                if (!matchedOption && addWhenMissing) {
                    matchedOption = new Option(
                        originalValue,
                        originalValue,
                        true,
                        true
                    );

                    select.add(matchedOption);
                }

                if (!matchedOption) {
                    console.warn(
                        `Pilihan ${id} tidak ditemukan:`,
                        originalValue
                    );

                    return false;
                }

                select.value = matchedOption.value;
                matchedOption.selected = true;

                select.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

                if (window.jQuery) {
                    window.jQuery(select)
                        .val(matchedOption.value)
                        .trigger('change');
                }

                return true;
            }

            function formatTanggal(value) {
                const rawValue = extractValue(value);

                if (!rawValue) {
                    return '';
                }

                const isoMatch = rawValue.match(
                    /^(\d{4})-(\d{2})-(\d{2})/
                );

                if (isoMatch) {
                    return `${isoMatch[1]}-${isoMatch[2]}-${isoMatch[3]}`;
                }

                const indonesiaMatch = rawValue.match(
                    /^(\d{2})[\/-](\d{2})[\/-](\d{4})$/
                );

                if (indonesiaMatch) {
                    return `${indonesiaMatch[3]}-${indonesiaMatch[2]}-${indonesiaMatch[1]}`;
                }

                return '';
            }

            function normalizeJenisKelamin(value) {
                const normalized = normalizeText(value);

                if (
                    [
                        '1',
                        'L',
                        'LK',
                        'LAKI',
                        'LAKILAKI',
                        'PRIA',
                        'MALE'
                    ].includes(normalized)
                ) {
                    return 'Laki-laki';
                }

                if (
                    [
                        '0',
                        '2',
                        'P',
                        'PR',
                        'PEREMPUAN',
                        'WANITA',
                        'FEMALE'
                    ].includes(normalized)
                ) {
                    return 'Perempuan';
                }

                if (normalized.includes('LAKILAKI')) {
                    return 'Laki-laki';
                }

                if (normalized.includes('PEREMPUAN')) {
                    return 'Perempuan';
                }

                return '';
            }

            function resolveJenisKelamin(data, result) {
                const candidates = [
                    data?.jenis_kelamin,
                    data?.jenisKelamin,
                    data?.jk,
                    data?.kelamin,
                    data?.gender,
                    result?.debug?.jenis_kelamin_hasil,
                    result?.debug?.jenis_kelamin_raw,
                    result?.debug?.jenis_kelamin_asli
                ];

                for (const candidate of candidates) {
                    const resultValue =
                        normalizeJenisKelamin(candidate);

                    if (resultValue !== '') {
                        return resultValue;
                    }
                }

                return '';
            }

            function normalizeAgama(value) {
                const rawValue = extractValue(value, [
                    'agama',
                    'nama_agama'
                ]);

                const normalized = normalizeText(rawValue);

                const aliases = {
                    ISLAM: 'Islam',

                    KRISTEN: 'Kristen',
                    PROTESTAN: 'Kristen',
                    KRISTENPROTESTAN: 'Kristen',

                    KATOLIK: 'Katolik',
                    KRISTENKATOLIK: 'Katolik',

                    HINDU: 'Hindu',

                    BUDHA: 'Buddha',
                    BUDDHA: 'Buddha',

                    KONGHUCU: 'Khonghucu',
                    KHONGHUCU: 'Khonghucu'
                };

                return aliases[normalized] ?? rawValue;
            }

            function normalizeStatus(value) {
                const rawValue = extractValue(value, [
                    'status_perkawinan',
                    'nama_status',
                    'status'
                ]);

                const normalized = normalizeText(rawValue);

                const aliases = {
                    BELUMKAWIN: 'Belum Kawin',
                    BELUMMENIKAH: 'Belum Kawin',
                    TIDAKKAWIN: 'Belum Kawin',

                    KAWIN: 'Kawin',
                    MENIKAH: 'Kawin',
                    SUDAHMENIKAH: 'Kawin',

                    CERAIHIDUP: 'Cerai Hidup',
                    CERAIMATI: 'Cerai Mati'
                };

                return aliases[normalized] ?? rawValue;
            }

            function normalizePekerjaan(value) {
                const rawValue = extractValue(value, [
                    'nama_pekerjaan',
                    'pekerjaan',
                    'jenis_pekerjaan'
                ]);

                const normalized = normalizeText(rawValue);

                const aliases = {
                    BELUMBEKERJA: 'BELUM/TIDAK BEKERJA',

                    TIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    BELUMTIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    PELAJAR: 'PELAJAR/MAHASISWA',

                    MAHASISWA: 'PELAJAR/MAHASISWA',

                    PELAJARMAHASISWA: 'PELAJAR/MAHASISWA',

                    IRT: 'IBU RUMAH TANGGA',

                    PNS: 'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPIL: 'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPILPNS: 'PEGAWAI NEGERI SIPIL (PNS)',

                    TNI: 'TENTARA NASIONAL INDONESIA (TNI)',

                    TENTARANASIONALINDONESIA: 'TENTARA NASIONAL INDONESIA (TNI)',

                    TENTARANASIONALINDONESIATNI: 'TENTARA NASIONAL INDONESIA (TNI)',

                    POLRI: 'KEPOLISIAN RI (POLRI)',

                    KEPOLISIANRI: 'KEPOLISIAN RI (POLRI)',

                    KEPOLISIANREPUBLIKINDONESIA: 'KEPOLISIAN RI (POLRI)',

                    PETANI: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    PEKEBUN: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    PETANIPEKEBUN: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    BURUHTANI: 'BURUH TANI/PERKEBUNAN',

                    NELAYAN: 'NELAYAN/PERIKANAN',

                    BURUHNELAYAN: 'BURUH NELAYAN/PERIKANAN',

                    HONORER: 'KARYAWAN HONORER',

                    PEGAWAIHONORER: 'KARYAWAN HONORER',

                    PETANIPENYEWA: 'PETANI/PEKEBUN PENYEWA',

                    PETANIPEKEBUNPENYEWA: 'PETANI/PEKEBUN PENYEWA',

                    LAINLAIN: 'LAINNYA',

                    LAINNYA: 'LAINNYA'
                };

                return aliases[normalized] ?? rawValue;
            }

            async function autofillDomisiliUser() {
                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setFeedback(
                        'NIK harus terdiri dari 16 digit.',
                        'error'
                    );

                    nikInput.focus();
                    return;
                }

                if (requestController) {
                    requestController.abort();
                }

                requestController = new AbortController();

                const url = lookupUrlTemplate.replace(
                    '__NIK__',
                    encodeURIComponent(nik)
                );

                setFeedback(
                    'Sedang mencari data penduduk...',
                    'loading'
                );

                try {
                    const response = await fetch(url, {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },

                        cache: 'no-store',
                        signal: requestController.signal
                    });

                    const result = await response.json();

                    console.log(
                        'Respons lookup Domisili Warga:',
                        result
                    );

                    if (
                        !response.ok ||
                        !result.success ||
                        !result.data
                    ) {
                        throw new Error(
                            result.message ||
                            'Data penduduk tidak ditemukan.'
                        );
                    }

                    const data = result.data;

                    setInputValue(
                        'nama_lengkap',
                        data.nama
                    );

                    setInputValue(
                        'tempat_lahir',
                        data.tempat_lahir
                    );

                    const tanggalLahir = formatTanggal(
                        data.tanggal_lahir
                    );

                    if (tanggalLahir) {
                        setInputValue(
                            'tanggal_lahir',
                            tanggalLahir
                        );
                    }

                    /*
                     * Jenis kelamin
                     */
                    const jenisKelamin =
                        resolveJenisKelamin(data, result);

                    setSelectValue(
                        'jenis_kelamin',
                        jenisKelamin
                    );

                    /*
                     * Agama
                     */
                    const agama = normalizeAgama(
                        data.agama ??
                        data.nama_agama
                    );

                    setSelectValue(
                        'agama',
                        agama,
                        true
                    );

                    /*
                     * Status memakai status_perkawinan
                     * yang dikirim controller.
                     */
                    const statusPerkawinan =
                        normalizeStatus(
                            data.status_perkawinan ??
                            data.status ??
                            data.nama_status
                        );

                    setSelectValue(
                        'status',
                        statusPerkawinan,
                        true
                    );

                    /*
                     * Pekerjaan, termasuk
                     * BELUM/TIDAK BEKERJA.
                     */
                    const pekerjaan =
                        normalizePekerjaan(
                            data.pekerjaan ??
                            data.nama_pekerjaan ??
                            data.pekerjaan_nama ??
                            data.job
                        );

                    setSelectValue(
                        'pekerjaan',
                        pekerjaan,
                        true
                    );

                    /*
                     * Set ulang untuk mencegah plugin lain
                     * mereset pilihan.
                     */
                    setTimeout(function() {
                        setSelectValue(
                            'jenis_kelamin',
                            jenisKelamin
                        );

                        setSelectValue(
                            'agama',
                            agama,
                            true
                        );

                        setSelectValue(
                            'status',
                            statusPerkawinan,
                            true
                        );

                        setSelectValue(
                            'pekerjaan',
                            pekerjaan,
                            true
                        );
                    }, 100);

                    console.log('Hasil autofill Domisili:', {
                        jenis_kelamin_asli: data.jenis_kelamin,

                        jenis_kelamin_hasil: jenisKelamin,

                        agama_asli: data.agama,

                        agama_hasil: agama,

                        status_asli: data.status_perkawinan ??
                            data.status,

                        status_hasil: statusPerkawinan,

                        pekerjaan_asli: data.pekerjaan,

                        pekerjaan_hasil: pekerjaan
                    });

                    setFeedback(
                        'Data penduduk berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    if (error.name === 'AbortError') {
                        return;
                    }

                    setFeedback(
                        error.message ||
                        'Gagal mengambil data penduduk.',
                        'error'
                    );

                    console.error(
                        'Autofill Domisili Warga:',
                        error
                    );
                }
            }

            if (nikInput) {
                nikInput.addEventListener(
                    'input',
                    function() {
                        this.value = this.value
                            .replace(/\D/g, '')
                            .slice(0, 16);

                        setFeedback(
                            `${this.value.length}/16 digit. Tekan Enter atau tombol Cari.`
                        );
                    }
                );

                nikInput.addEventListener(
                    'keydown',
                    function(event) {
                        if (
                            event.key === 'Enter' ||
                            event.keyCode === 13
                        ) {
                            event.preventDefault();
                            event.stopPropagation();

                            autofillDomisiliUser();
                        }
                    }
                );
            }

            if (btnCariNik) {
                btnCariNik.addEventListener(
                    'click',
                    autofillDomisiliUser
                );
            }
        });
    </script>
@endsection
