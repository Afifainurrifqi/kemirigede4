<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Surat Pernyataan Tidak Memiliki Kartu JAMKESMAS / ASKES / JKN
    </title>

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>

    {{-- Header --}}
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
                        Surat Pernyataan Tidak Punya Kartu JAMKESMAS
                    </h6>
                </div>

            </div>
        </div>
    </div>

    {{-- Konten halaman --}}
    <div class="page-content-wrapper py-3">
        <div class="container">

            {{-- Pesan berhasil --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pesan error validasi --}}
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

            <form
                action="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.userstore') }}"
                method="POST"
                id="formSuratJkn">

                @csrf

                {{-- NIK --}}
                <div class="mb-3">
                    <label for="nik">
                        NIK <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nik"
                        id="nik"
                        class="form-control @error('nik') is-invalid @enderror"
                        value="{{ old('nik') }}"
                        maxlength="16"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                        required>

                    @error('nik')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small id="nikMessage" class="form-text text-muted">
                        Masukkan 16 digit NIK, kemudian tekan Enter.
                    </small>
                </div>

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nama"
                        id="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        required>

                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tempat dan tanggal lahir --}}
                <div class="row">

                    <div class="col-6 mb-3">
                        <label for="tempat_lahir">
                            Tempat Lahir <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="tempat_lahir"
                            id="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            value="{{ old('tempat_lahir') }}"
                            placeholder="Tempat lahir"
                            required>

                        @error('tempat_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="tanggal_lahir">
                            Tanggal Lahir <span class="text-danger">*</span>
                        </label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            id="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir') }}"
                            required>

                        @error('tanggal_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- Daftar pekerjaan --}}
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
                        'PETANI/PEKEBUN',
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
                        'TUKANG BATU',
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

                {{-- Pekerjaan --}}
                <div class="mb-3">
                    <label for="pekerjaan">
                        Pekerjaan <span class="text-danger">*</span>
                    </label>

                    <select
                        name="pekerjaan"
                        id="pekerjaan"
                        class="form-control @error('pekerjaan') is-invalid @enderror"
                        required>

                        <option value="">-- Pilih Pekerjaan --</option>

                        @foreach ($jobs as $job)
                            <option
                                value="{{ $job }}"
                                {{ old('pekerjaan') == $job ? 'selected' : '' }}>
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
                    <label for="alamat">
                        Alamat <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="alamat"
                        id="alamat"
                        class="form-control @error('alamat') is-invalid @enderror"
                        rows="3"
                        placeholder="Masukkan alamat lengkap"
                        required>{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Nomor WhatsApp --}}
                <div class="mb-3">
                    <label for="nowa">
                        No. HP/WhatsApp <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="nowa"
                        id="nowa"
                        class="form-control @error('nowa') is-invalid @enderror"
                        value="{{ old('nowa') }}"
                        maxlength="15"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder="Contoh: 081234567890"
                        required>

                    @error('nowa')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tombol submit --}}
                <button
                    type="submit"
                    class="btn btn-primary w-100"
                    id="btnSubmit">

                    Kirim Pengajuan
                </button>

            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik');
            const nikMessage = document.getElementById('nikMessage');

            const namaInput = document.getElementById('nama');
            const tempatLahirInput = document.getElementById('tempat_lahir');
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const pekerjaanSelect = document.getElementById('pekerjaan');
            const alamatInput = document.getElementById('alamat');
            const nowaInput = document.getElementById('nowa');
            const formSurat = document.getElementById('formSuratJkn');
            const btnSubmit = document.getElementById('btnSubmit');

            let sedangMencari = false;

            /**
             * Menampilkan pesan di bawah input NIK.
             */
            function setNikMessage(message, type = 'muted') {
                nikMessage.textContent = message;
                nikMessage.className = 'form-text text-' + type;
            }

            /**
             * Mengubah berbagai variasi penulisan pekerjaan
             * agar dapat dibandingkan.
             *
             * Contoh:
             * BELUM/TIDAK BEKERJA
             * BELUM / TIDAK BEKERJA
             * belum/tidak bekerja
             *
             * Semuanya akan dianggap sama.
             */
            function normalizePekerjaan(value) {
                return String(value || '')
                    .trim()
                    .toUpperCase()
                    .replace(/\s*\/\s*/g, '/')
                    .replace(/\s+/g, ' ');
            }

            /**
             * Memilih pekerjaan berdasarkan data dari API.
             *
             * Apabila pekerjaannya belum ada di option,
             * nilai tersebut otomatis ditambahkan dan dipilih.
             */
            function setPekerjaan(value) {
                if (!pekerjaanSelect) {
                    console.error('Elemen pekerjaan tidak ditemukan.');
                    return;
                }

                const pekerjaanDatabase = String(value ?? '').trim();

                /*
                 * Jangan menganggap nilai seperti
                 * BELUM/TIDAK BEKERJA sebagai nilai kosong.
                 */
                if (pekerjaanDatabase.length === 0) {
                    pekerjaanSelect.value = '';
                    return;
                }

                const pekerjaanDatabaseNormal =
                    normalizePekerjaan(pekerjaanDatabase);

                let optionDitemukan = null;

                for (const option of pekerjaanSelect.options) {
                    const optionNormal =
                        normalizePekerjaan(option.value);

                    if (
                        optionNormal !== '' &&
                        optionNormal === pekerjaanDatabaseNormal
                    ) {
                        optionDitemukan = option;
                        break;
                    }
                }

                if (optionDitemukan) {
                    /*
                     * Memilih option yang sudah tersedia.
                     */
                    pekerjaanSelect.value = optionDitemukan.value;
                    optionDitemukan.selected = true;
                } else {
                    /*
                     * Pekerjaan belum tersedia di daftar.
                     * Tambahkan option baru agar tetap terisi.
                     */
                    const optionBaru = document.createElement('option');

                    optionBaru.value = pekerjaanDatabase;
                    optionBaru.textContent = pekerjaanDatabase;
                    optionBaru.selected = true;

                    pekerjaanSelect.appendChild(optionBaru);
                    pekerjaanSelect.value = pekerjaanDatabase;
                }

                /*
                 * Memastikan nilai terpilih setelah browser
                 * memperbarui elemen select.
                 */
                setTimeout(function () {
                    if (optionDitemukan) {
                        pekerjaanSelect.value =
                            optionDitemukan.value;
                    } else {
                        pekerjaanSelect.value =
                            pekerjaanDatabase;
                    }
                }, 0);

                pekerjaanSelect.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

                console.log(
                    'Pekerjaan dari API:',
                    pekerjaanDatabase
                );

                console.log(
                    'Pekerjaan terpilih:',
                    pekerjaanSelect.value
                );
            }

            /**
             * Mengosongkan hasil autofill saat NIK tidak ditemukan.
             */
            function kosongkanDataPenduduk() {
                namaInput.value = '';
                tempatLahirInput.value = '';
                tanggalLahirInput.value = '';
                pekerjaanSelect.value = '';
                alamatInput.value = '';
            }

            /**
             * Mengisi form menggunakan data penduduk.
             */
            function isiDataPenduduk(data) {
                namaInput.value = data.nama || '';

                tempatLahirInput.value =
                    data.tempat_lahir || '';

                tanggalLahirInput.value =
                    data.tanggal_lahir
                        ? String(data.tanggal_lahir).substring(0, 10)
                        : '';

                alamatInput.value = data.alamat || '';

                /*
                 * Pekerjaan menggunakan fungsi khusus
                 * agar BELUM/TIDAK BEKERJA tetap terpilih.
                 */
                setPekerjaan(data.pekerjaan);
            }

            /**
             * Mencari data penduduk berdasarkan NIK.
             *
             * Fungsi ini hanya dipanggil ketika tombol Enter ditekan.
             */
            async function cariPendudukDenganNik() {
                if (sedangMencari) {
                    return;
                }

                const nik = nikInput.value
                    .replace(/\D/g, '')
                    .trim();

                nikInput.value = nik;

                if (nik.length !== 16) {
                    setNikMessage(
                        'NIK harus terdiri dari 16 digit.',
                        'danger'
                    );

                    nikInput.focus();
                    return;
                }

                sedangMencari = true;
                nikInput.disabled = true;

                setNikMessage(
                    'Sedang mencari data penduduk...',
                    'primary'
                );

                try {
                    const url =
                        `{{ url('/datapenduduk/lookup') }}/${encodeURIComponent(nik)}`;

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    let result;

                    try {
                        result = await response.json();
                    } catch (jsonError) {
                        throw new Error(
                            'Respons server tidak valid.'
                        );
                    }

                    if (
                        !response.ok ||
                        !result.success ||
                        !result.data
                    ) {
                        kosongkanDataPenduduk();

                        throw new Error(
                            result.message ||
                            'Data penduduk tidak ditemukan.'
                        );
                    }

                    isiDataPenduduk(result.data);

                    setNikMessage(
                        'Data penduduk berhasil ditemukan.',
                        'success'
                    );
                } catch (error) {
                    setNikMessage(
                        error.message ||
                        'Terjadi kesalahan saat mencari data penduduk.',
                        'danger'
                    );

                    console.error(
                        'Autofill error:',
                        error
                    );
                } finally {
                    sedangMencari = false;
                    nikInput.disabled = false;
                    nikInput.focus();
                }
            }

            /**
             * Saat mengetik:
             * - hanya menerima angka;
             * - maksimal 16 digit;
             * - tidak melakukan pencarian otomatis.
             */
            nikInput.addEventListener('input', function () {
                this.value = this.value
                    .replace(/\D/g, '')
                    .slice(0, 16);

                setNikMessage(
                    'Masukkan 16 digit NIK, kemudian tekan Enter.',
                    'muted'
                );
            });

            /**
             * Autofill hanya dijalankan ketika Enter ditekan.
             */
            nikInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();

                    cariPendudukDenganNik();
                }
            });

            /**
             * Nomor WhatsApp hanya menerima angka.
             */
            if (nowaInput) {
                nowaInput.addEventListener('input', function () {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 15);
                });
            }

            /**
             * Mencegah tombol submit ditekan berulang kali.
             */
            formSurat.addEventListener('submit', function () {
                btnSubmit.disabled = true;
                btnSubmit.textContent = 'Mengirim Pengajuan...';
            });
        });
    </script>

</body>

</html>
