@extends('layout.main2')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Pembuatan Surat Keterangan Kepemilikan Aset</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('surat.kepemilikan_aset.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control"
                                        onkeyup="autofillKepemilikanAdmin()" placeholder="Masukkan NIK" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                        required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                        required>
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
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                            </div>

                            <!-- Survey Aset -->
                            <h6 class="mt-4 mb-3">Data Survey Kepemilikan Aset</h6>

                            <div class="mb-3">
                                <label>Pendapatan Keluarga / Bulan <span class="text-danger">*</span></label>
                                <input type="text" name="pendapatan_bulanan" class="form-control"
                                    placeholder="Rp 1.000.000" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Pekarangan (M²)</label>
                                    <input type="text" name="pekarangan" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Sawah (M²)</label>
                                    <input type="text" name="sawah" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Perkebunan (M²)</label>
                                    <input type="text" name="perkebunan" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Mobil</label>
                                    <input type="text" name="mobil" class="form-control" placeholder="Jumlah / Merk">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Sepeda Motor</label>
                                    <input type="text" name="sepeda_motor" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Perhiasan Emas (gram)</label>
                                    <input type="text" name="perhiasan_emas" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Lainnya</label>
                                <input type="text" name="lainnya" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Kepemilikan Rumah <span class="text-danger">*</span></label>
                                <textarea name="kepemilikan_rumah" class="form-control" rows="2" required
                                    placeholder="layak huni / numpang di orang tua / dll"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan_tambahan" class="form-label">
                                    Keterangan Tambahan
                                </label>

                                <textarea name="keterangan_tambahan" id="keterangan_tambahan"
                                    class="form-control @error('keterangan_tambahan') is-invalid @enderror" rows="3">{{ old('keterangan_tambahan') }}</textarea>

                                @error('keterangan_tambahan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-3">Status Pengajuan Surat</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="status_surat" class="form-label">
                                        Status Surat <span class="text-danger">*</span>
                                    </label>

                                    <select name="status_surat" id="status_surat"
                                        class="form-control @error('status_surat') is-invalid @enderror" required>
                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status_surat', 'Pending') === $status ? 'selected' : '' }}>
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
                                                {{ old('status_verif', 'Belum Verifikasi') === $verifikasi ? 'selected' : '' }}>
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
                                <button type="submit" class="btn btn-primary px-4">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            const nikFeedback = document.getElementById('nik-feedback');

            const lookupUrlTemplate = @json(route('datapenduduk.lookup', ['nik' => '__NIK__']));

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
                    BELUMBEKERJA: 'BELUM/TIDAK BEKERJA',

                    TIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    BELUMTIDAKBEKERJA: 'BELUM/TIDAK BEKERJA',

                    PELAJAR: 'PELAJAR/MAHASISWA',

                    MAHASISWA: 'PELAJAR/MAHASISWA',

                    PELAJARMAHASISWA: 'PELAJAR/MAHASISWA',

                    IRT: 'IBU RUMAH TANGGA',

                    PNS: 'PEGAWAI NEGERI SIPIL (PNS)',

                    PEGAWAINEGERISIPIL: 'PEGAWAI NEGERI SIPIL (PNS)',

                    TNI: 'TENTARA NASIONAL INDONESIA (TNI)',

                    TENTARANASIONALINDONESIA: 'TENTARA NASIONAL INDONESIA (TNI)',

                    POLRI: 'KEPOLISIAN RI (POLRI)',

                    KEPOLISIANREPUBLIKINDONESIA: 'KEPOLISIAN RI (POLRI)',

                    PETANI: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    PEKEBUN: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    PETANIPEKEBUN: 'PETANI/PEKEBUN PEMILIK LAHAN',

                    BURUHTANI: 'BURUH TANI/PERKEBUNAN',

                    NELAYAN: 'NELAYAN/PERIKANAN',

                    BURUHNELAYAN: 'BURUH NELAYAN/PERIKANAN',

                    HONORER: 'KARYAWAN HONORER',

                    PEGAWAIHONORER: 'KARYAWAN HONORER',

                    PETANIPENYEWA: 'Petani/Pekebun penyewa',

                    LAINLAIN: 'Lainnya',

                    LAINNYA: 'Lainnya'
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
            nikInput.addEventListener('input', function() {
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
            nikInput.addEventListener('keydown', function(event) {
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
@endsection
