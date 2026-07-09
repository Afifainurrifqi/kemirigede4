<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Surat Keterangan Kepemilikan Aset</title>

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <div class="page-heading">
                    <h6 class="mb-0">
                        Surat Keterangan Kepemilikan Aset
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
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

            <form action="{{ route('surat.user_kepemilikan_aset.store') }}" method="POST">
                @csrf

                {{-- NIK --}}
                <div class="mb-3">
                    <label for="nik">
                        NIK <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="nik" id="nik"
                        class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                        maxlength="16" inputmode="numeric" autocomplete="off"
                        placeholder="Masukkan 16 digit NIK, lalu tekan Enter" required>

                    <small id="nik-feedback" class="d-block mt-1 text-muted">
                        Data akan terisi otomatis setelah NIK lengkap.
                    </small>

                    @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>

                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Tempat lahir --}}
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir">
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
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir">
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

                <div class="row">
                    {{-- Pekerjaan --}}
                    <div class="col-md-6 mb-3">
                        <label for="pekerjaan">
                            Pekerjaan <span class="text-danger">*</span>
                        </label>

                        <select name="pekerjaan" id="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror" required>
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
                                    'PEGAWAI KANTOR DESA',
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
                                    'PETANI/PEKEBUN PENYEWA',
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

                    {{-- WhatsApp --}}
                    <div class="col-md-6 mb-3">
                        <label for="nowa">
                            No WhatsApp <span class="text-danger">*</span>
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
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label for="alamat">
                        Alamat <span class="text-danger">*</span>
                    </label>

                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2"
                        required>{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <h6 class="mt-4 mb-3">
                    Data Survey Kepemilikan Aset
                </h6>

                {{-- Pendapatan --}}
                <div class="mb-3">
                    <label for="pendapatan_bulanan">
                        Pendapatan Keluarga/Bulan
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="pendapatan_bulanan" id="pendapatan_bulanan"
                        class="form-control @error('pendapatan_bulanan') is-invalid @enderror"
                        value="{{ old('pendapatan_bulanan') }}" placeholder="Rp 1.000.000" required>

                    @error('pendapatan_bulanan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="pekarangan">Pekarangan (M²)</label>

                        <input type="text" name="pekarangan" id="pekarangan" class="form-control"
                            value="{{ old('pekarangan') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sawah">Sawah (M²)</label>

                        <input type="text" name="sawah" id="sawah" class="form-control"
                            value="{{ old('sawah') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="perkebunan">Perkebunan (M²)</label>

                        <input type="text" name="perkebunan" id="perkebunan" class="form-control"
                            value="{{ old('perkebunan') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="mobil">Mobil</label>

                        <input type="text" name="mobil" id="mobil" class="form-control"
                            value="{{ old('mobil') }}" placeholder="Jumlah/Merk">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="sepeda_motor">Sepeda Motor</label>

                        <input type="text" name="sepeda_motor" id="sepeda_motor" class="form-control"
                            value="{{ old('sepeda_motor') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="perhiasan_emas">
                            Perhiasan Emas (gram)
                        </label>

                        <input type="text" name="perhiasan_emas" id="perhiasan_emas" class="form-control"
                            value="{{ old('perhiasan_emas') }}">
                    </div>
                </div>

                {{-- Lainnya --}}
                <div class="mb-3">
                    <label for="lainnya">Lainnya</label>

                    <input type="text" name="lainnya" id="lainnya" class="form-control"
                        value="{{ old('lainnya') }}">
                </div>

                {{-- Kepemilikan rumah --}}
                <div class="mb-3">
                    <label for="kepemilikan_rumah">
                        Kepemilikan Rumah
                        <span class="text-danger">*</span>
                    </label>

                    <textarea name="kepemilikan_rumah" id="kepemilikan_rumah"
                        class="form-control @error('kepemilikan_rumah') is-invalid @enderror" rows="2"
                        placeholder="Layak huni, menumpang di rumah orang tua, dan sebagainya" required>{{ old('kepemilikan_rumah') }}</textarea>

                    @error('kepemilikan_rumah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Keterangan tambahan --}}
                <div class="mb-3">
                    <label for="keterangan_tambahan">
                        Keterangan Tambahan
                    </label>

                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" class="form-control" rows="2">{{ old('keterangan_tambahan') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Kirim Pengajuan
                </button>
            </form>
        </div>
    </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik');
        const nikFeedback = document.getElementById('nik-feedback');

        const lookupUrlTemplate = @json(
            route('datapenduduk.lookup', ['nik' => '__NIK__'])
        );

        let requestController = null;

        /**
         * Mengatur pesan status pencarian NIK.
         */
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

        /**
         * Mengambil nilai string dari respons API,
         * termasuk apabila data dikirim sebagai object relasi.
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
                'nama',
                'nama_pekerjaan',
                'pekerjaan',
                'label',
                'value',
                'keterangan'
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
         * Mengisi input atau textarea.
         */
        function setFieldValue(id, value) {
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
         * Menormalisasi teks untuk pencocokan select.
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
         * Mengubah tanggal menjadi format YYYY-MM-DD
         * agar diterima input type="date".
         */
        function formatTanggal(value) {
            const rawValue = extractValue(value);

            if (!rawValue) {
                return '';
            }

            /*
             * Format:
             * YYYY-MM-DD
             * YYYY-MM-DDTHH:mm:ss
             */
            const isoMatch = rawValue.match(
                /^(\d{4})-(\d{2})-(\d{2})/
            );

            if (isoMatch) {
                return `${isoMatch[1]}-${isoMatch[2]}-${isoMatch[3]}`;
            }

            /*
             * Format DD-MM-YYYY.
             */
            const dashMatch = rawValue.match(
                /^(\d{2})-(\d{2})-(\d{4})$/
            );

            if (dashMatch) {
                return `${dashMatch[3]}-${dashMatch[2]}-${dashMatch[1]}`;
            }

            /*
             * Format DD/MM/YYYY.
             */
            const slashMatch = rawValue.match(
                /^(\d{2})\/(\d{2})\/(\d{4})$/
            );

            if (slashMatch) {
                return `${slashMatch[3]}-${slashMatch[2]}-${slashMatch[1]}`;
            }

            return '';
        }

        /**
         * Menyamakan nama pekerjaan dari database
         * dengan daftar pilihan pada form.
         */
        function normalizePekerjaan(value) {
            const originalValue = extractValue(value);
            const normalized = normalizeText(originalValue);

            const aliases = {
                BELUMBEKERJA:
                    'BELUM/TIDAK BEKERJA',

                TIDAKBEKERJA:
                    'BELUM/TIDAK BEKERJA',

                BELUMTIDAKBEKERJA:
                    'BELUM/TIDAK BEKERJA',

                PELAJAR:
                    'PELAJAR/MAHASISWA',

                MAHASISWA:
                    'PELAJAR/MAHASISWA',

                PELAJARMAHASISWA:
                    'PELAJAR/MAHASISWA',

                IRT:
                    'IBU RUMAH TANGGA',

                PNS:
                    'PEGAWAI NEGERI SIPIL (PNS)',

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

                PETANIPEKEBUN:
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

                PETANIPENYEWA:
                    'Petani/Pekebun penyewa',

                LAINLAIN:
                    'Lainnya',

                LAINNYA:
                    'Lainnya'
            };

            return aliases[normalized] ?? originalValue;
        }

        /**
         * Memilih pekerjaan pada select.
         */
        function setPekerjaan(value) {
            const select = document.getElementById('pekerjaan');

            if (!select) {
                return false;
            }

            const pekerjaan = normalizePekerjaan(value);

            if (!pekerjaan) {
                console.warn(
                    'Pekerjaan dari API kosong.',
                    value
                );

                return false;
            }

            const normalizedPekerjaan = normalizeText(pekerjaan);

            let matchedOption = Array.from(
                select.options
            ).find(option => {
                return normalizeText(option.value) ===
                    normalizedPekerjaan;
            });

            /*
             * Pencocokan sebagian.
             *
             * Contoh:
             * Database: PEGAWAI NEGERI SIPIL
             * Form: PEGAWAI NEGERI SIPIL (PNS)
             */
            if (!matchedOption) {
                matchedOption = Array.from(
                    select.options
                ).find(option => {
                    if (!option.value) {
                        return false;
                    }

                    const normalizedOption = normalizeText(
                        option.value
                    );

                    return normalizedOption.includes(
                        normalizedPekerjaan
                    ) ||
                    normalizedPekerjaan.includes(
                        normalizedOption
                    );
                });
            }

            /*
             * Apabila belum tersedia dalam daftar,
             * tambahkan option dari database.
             */
            if (!matchedOption) {
                matchedOption = new Option(
                    pekerjaan,
                    pekerjaan,
                    true,
                    true
                );

                select.add(matchedOption);
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

        /**
         * Menjalankan pencarian penduduk.
         * Fungsi ini hanya dipanggil ketika tombol Enter ditekan.
         */
        async function autofillKepemilikanUser() {
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
                    'Respons lookup kepemilikan aset:',
                    result
                );

                if (!response.ok || !result.success) {
                    throw new Error(
                        result.message ||
                        'Data penduduk tidak ditemukan.'
                    );
                }

                const data = result.data ?? {};

                /*
                 * Data hanya diubah setelah respons sukses.
                 */
                setFieldValue(
                    'nama',
                    data.nama
                );

                setFieldValue(
                    'tempat_lahir',
                    data.tempat_lahir
                );

                const tanggalLahir = formatTanggal(
                    data.tanggal_lahir ??
                    data.tgl_lahir ??
                    data.tanggallahir ??
                    data.birth_date
                );

                if (tanggalLahir) {
                    setFieldValue(
                        'tanggal_lahir',
                        tanggalLahir
                    );
                } else {
                    console.warn(
                        'Tanggal lahir kosong atau format tidak valid:',
                        data.tanggal_lahir
                    );
                }

                setPekerjaan(
                    data.pekerjaan ??
                    data.nama_pekerjaan ??
                    data.pekerjaan_nama ??
                    data.job
                );

                setFieldValue(
                    'alamat',
                    data.alamat
                );

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
                    'Kesalahan autofill kepemilikan aset:',
                    error
                );
            }
        }

        /**
         * Saat diketik, hanya membersihkan karakter nonangka.
         * Tidak menjalankan autofill.
         */
        nikInput.addEventListener('input', function () {
            this.value = this.value
                .replace(/\D/g, '')
                .slice(0, 16);

            setFeedback(
                `${this.value.length}/16 digit. Tekan Enter untuk mencari.`
            );
        });

        /**
         * Autofill hanya setelah tombol Enter ditekan.
         */
        nikInput.addEventListener('keydown', function (event) {
            if (
                event.key === 'Enter' ||
                event.keyCode === 13
            ) {
                /*
                 * Mencegah form langsung terkirim.
                 */
                event.preventDefault();
                event.stopPropagation();

                autofillKepemilikanUser();
            }
        });
    });
</script>
</body>

</html>
