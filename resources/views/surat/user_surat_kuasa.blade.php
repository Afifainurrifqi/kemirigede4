<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitakro - Aplikasi Pertanian">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <title>Surat Kuasa</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Surat Kuasa</h6>
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

            <form action="{{ route('surat.user_kuasa.store') }}" method="POST">
                @csrf

                <!-- Pihak I (Pemberi Kuasa) -->
                <h5 class="mb-3">Pihak I - Pemberi Kuasa</h5>
                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nik_pihak1"
                        id="nik_pihak1"
                        class="form-control"
                        inputmode="numeric"
                        maxlength="16"
                        autocomplete="off"
                        placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                        required
                    >
                    <div id="status_nik_pihak1" class="form-text">
                        Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.
                    </div>
                </div>
                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pihak1" id="nama_pihak1" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_pihak1" id="jenis_kelamin_pihak1" class="form-control" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Agama</label>
                        <select name="agama_pihak1" id="agama_pihak1" class="form-control" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_pihak1" id="tempat_lahir_pihak1" class="form-control"
                            required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_pihak1" id="tanggal_lahir_pihak1" class="form-control"
                            required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status_pihak1" id="status_pihak1" class="form-control" required>
                        <option value="Kawin">Kawin</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan_pihak1" id="pekerjaan_pihak1" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat_pihak1" id="alamat_pihak1" class="form-control" rows="2" required></textarea>
                </div>

                <hr>

                <!-- Pihak II -->
                <h5 class="mb-3">Pihak II - Penerima Kuasa</h5>

                <div class="mb-3">
                    <label>NIK <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nik_pihak2"
                        id="nik_pihak2"
                        class="form-control"
                        inputmode="numeric"
                        maxlength="16"
                        autocomplete="off"
                        placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                        required
                    >
                    <div id="status_nik_pihak2" class="form-text">
                        Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.
                    </div>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="nama_pihak2"
                        id="nama_pihak2"
                        class="form-control"
                        required
                    >
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_pihak2" id="jenis_kelamin_pihak2" class="form-control" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Agama</label>
                        <select name="agama_pihak2" id="agama_pihak2" class="form-control" required>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_pihak2" id="tempat_lahir_pihak2" class="form-control" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_pihak2" id="tanggal_lahir_pihak2" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status_pihak2" id="status_pihak2" class="form-control" required>
                        <option value="Kawin">Kawin</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Pekerjaan</label>
                    <select name="pekerjaan_pihak2" id="pekerjaan_pihak2" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat_pihak2" id="alamat_pihak2" class="form-control" rows="2" required></textarea>
                </div>

                <hr>

                <div class="mb-3">
                    <label>Keterangan / Maksud Kuasa <span class="text-danger">*</span></label>
                    <textarea name="keterangan_kuasa" class="form-control" rows="4"
                        placeholder="Contoh: pengambilan BPKB Motor dengan nomor register AG6089PAZ atas nama Katimah..." required></textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Kirim Pengajuan Surat Kuasa</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const nikInput = document.getElementById('nik_pihak1');
            const statusNik = document.getElementById('status_nik_pihak1');

            if (!nikInput) {
                return;
            }

            /*
             * Batasi input hanya angka dan maksimal 16 digit.
             * Lookup tidak dijalankan saat mengetik.
             */
            nikInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 16);

                setStatusNik(
                    'Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.',
                    'normal'
                );
            });

            /*
             * Autofill hanya berjalan setelah pengguna menekan Enter.
             */
            nikInput.addEventListener('keydown', function (event) {
                if (event.key !== 'Enter') {
                    return;
                }

                // Mencegah Enter mengirim seluruh form.
                event.preventDefault();

                autofillPihak1();
            });

            async function autofillPihak1() {
                const nik = nikInput.value.trim();

                if (!/^\d{16}$/.test(nik)) {
                    setStatusNik('NIK harus terdiri dari tepat 16 digit.', 'error');
                    nikInput.focus();
                    return;
                }

                setStatusNik('Sedang mengambil data penduduk...', 'loading');
                nikInput.disabled = true;

                try {
                    const response = await fetch(
                        `/datapenduduk/lookup/${encodeURIComponent(nik)}`,
                        {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        }
                    );

                    const result = await response.json();

                    if (!response.ok || !result.success || !result.data) {
                        throw new Error(
                            result.message || 'Data penduduk tidak ditemukan.'
                        );
                    }

                    const data = result.data;

                    setValue('nama_pihak1', data.nama);
                    setValue('jenis_kelamin_pihak1', data.jenis_kelamin);
                    setValue('tempat_lahir_pihak1', data.tempat_lahir);
                    setValue('tanggal_lahir_pihak1', data.tanggal_lahir);
                    setSelectValue(
                        'agama_pihak1',
                        data.agama,
                        { addIfMissing: true }
                    );

                    setSelectValue(
                        'pekerjaan_pihak1',
                        data.pekerjaan,
                        { addIfMissing: true }
                    );

                    setSelectValue(
                        'status_pihak1',
                        data.status_perkawinan || data.status,
                        { addIfMissing: false }
                    );
                    setValue('alamat_pihak1', data.alamat);

                    setStatusNik('Data penduduk berhasil ditemukan dan diisi.', 'success');
                } catch (error) {
                    clearAutofillPihak1();

                    setStatusNik(
                        error.message || 'Terjadi kesalahan saat mengambil data penduduk.',
                        'error'
                    );
                } finally {
                    nikInput.disabled = false;
                    nikInput.focus();
                }
            }

            function setValue(id, value) {
                const element = document.getElementById(id);

                if (!element || value === null || value === undefined) {
                    return;
                }

                element.value = value;
            }

            /*
             * Normalisasi teks agar nilai database dapat cocok dengan option,
             * walaupun kapitalisasi, spasi, tanda baca, atau penulisannya berbeda.
             */
            function normalizeSelectText(value) {
                return String(value || '')
                    .trim()
                    .toLocaleLowerCase('id-ID')
                    .replace(/&/g, ' dan ')
                    .replace(/[.,()_-]/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim();
            }

            /*
             * Mengisi elemen select secara toleran.
             *
             * Tahap pencocokan:
             * 1. Sama persis setelah normalisasi.
             * 2. Salah satu teks mengandung teks lainnya.
             * 3. Gunakan alias umum.
             * 4. Tambahkan option baru jika diizinkan.
             */
            function setSelectValue(id, value, options = {}) {
                const element = document.getElementById(id);
                const addIfMissing = options.addIfMissing === true;

                if (!element || value === null || value === undefined) {
                    return false;
                }

                const rawValue = String(value).trim();

                if (rawValue === '') {
                    return false;
                }

                const normalizedValue = normalizeSelectText(rawValue);
                const allOptions = Array.from(element.options);

                let matchingOption = allOptions.find(function (option) {
                    return normalizeSelectText(option.value) === normalizedValue ||
                        normalizeSelectText(option.textContent) === normalizedValue;
                });

                if (!matchingOption) {
                    matchingOption = allOptions.find(function (option) {
                        const normalizedOptionValue = normalizeSelectText(option.value);
                        const normalizedOptionText = normalizeSelectText(option.textContent);

                        return (
                            normalizedOptionValue !== '' &&
                            (
                                normalizedOptionValue.includes(normalizedValue) ||
                                normalizedValue.includes(normalizedOptionValue) ||
                                normalizedOptionText.includes(normalizedValue) ||
                                normalizedValue.includes(normalizedOptionText)
                            )
                        );
                    });
                }

                /*
                 * Alias untuk data yang umum ditemukan pada database penduduk.
                 */
                if (!matchingOption) {
                    const aliasMap = {
                        agama_pihak1: {
                            kristen_protestan: 'Kristen',
                            protestan: 'Kristen',
                            katholik: 'Katolik',
                            budha: 'Buddha',
                            kong_hu_cu: 'Konghucu',
                            konghucu: 'Konghucu',
                        },
                        pekerjaan_pihak1: {
                            belum_bekerja: 'BELUM/TIDAK BEKERJA',
                            tidak_bekerja: 'BELUM/TIDAK BEKERJA',
                            pelajar: 'PELAJAR/MAHASISWA',
                            mahasiswa: 'PELAJAR/MAHASISWA',
                            ibu_rumah_tangga: 'IBU RUMAH TANGGA',
                            mengurus_rumah_tangga: 'IBU RUMAH TANGGA',
                            wiraswasta: 'WIRASWASTA',
                            perangkat_desa: 'PERANGKAT DESA',
                            kepala_desa: 'KEPALA DESA',
                            pegawai_negeri_sipil: 'PNS',
                            petani: 'PETANI/PEKEBUN PEMILIK LAHAN',
                            pekebun: 'PETANI/PEKEBUN PEMILIK LAHAN',
                            buruh_tani: 'BURUH TANI',
                        },
                    };

                    const aliasKey = normalizedValue.replace(/\s+/g, '_');
                    const aliasValue = aliasMap[id]?.[aliasKey];

                    if (aliasValue) {
                        matchingOption = allOptions.find(function (option) {
                            return normalizeSelectText(option.value) ===
                                normalizeSelectText(aliasValue);
                        });
                    }
                }

                if (matchingOption) {
                    element.value = matchingOption.value;
                    element.dispatchEvent(new Event('change', { bubbles: true }));
                    return true;
                }

                /*
                 * Bila nilai dari database belum ada dalam daftar, tambahkan
                 * sebagai option agar nilai tetap terlihat dan tersimpan.
                 */
                if (addIfMissing) {
                    const newOption = document.createElement('option');
                    newOption.value = rawValue;
                    newOption.textContent = rawValue;
                    newOption.dataset.autofill = 'true';

                    element.appendChild(newOption);
                    element.value = rawValue;
                    element.dispatchEvent(new Event('change', { bubbles: true }));
                    return true;
                }

                return false;
            }

            function clearAutofillPihak1() {
                [
                    'nama_pihak1',
                    'tempat_lahir_pihak1',
                    'tanggal_lahir_pihak1',
                    'alamat_pihak1',
                ].forEach(function (id) {
                    const element = document.getElementById(id);

                    if (element) {
                        element.value = '';
                    }
                });
            }

            function setStatusNik(message, type) {
                if (!statusNik) {
                    return;
                }

                statusNik.textContent = message;
                statusNik.classList.remove(
                    'text-muted',
                    'text-primary',
                    'text-success',
                    'text-danger'
                );

                const classMap = {
                    normal: 'text-muted',
                    loading: 'text-primary',
                    success: 'text-success',
                    error: 'text-danger',
                };

                statusNik.classList.add(classMap[type] || 'text-muted');
            }

            /*
             * AUTOFILL PIHAK II
             */
            const nikInputPihak2 = document.getElementById('nik_pihak2');
            const statusNikPihak2 = document.getElementById('status_nik_pihak2');

            if (nikInputPihak2) {
                nikInputPihak2.addEventListener('input', function () {
                    this.value = this.value.replace(/\D/g, '').slice(0, 16);

                    setStatusNikPihak2(
                        'Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.',
                        'normal'
                    );
                });

                nikInputPihak2.addEventListener('keydown', function (event) {
                    if (event.key !== 'Enter') {
                        return;
                    }

                    event.preventDefault();
                    autofillPihak2();
                });
            }

            async function autofillPihak2() {
                const nik = nikInputPihak2.value.trim();

                if (!/^\d{16}$/.test(nik)) {
                    setStatusNikPihak2(
                        'NIK harus terdiri dari tepat 16 digit.',
                        'error'
                    );
                    nikInputPihak2.focus();
                    return;
                }

                setStatusNikPihak2(
                    'Sedang mengambil data penduduk...',
                    'loading'
                );

                nikInputPihak2.disabled = true;

                try {
                    const response = await fetch(
                        `/datapenduduk/lookup/${encodeURIComponent(nik)}`,
                        {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        }
                    );

                    const result = await response.json();

                    if (!response.ok || !result.success || !result.data) {
                        throw new Error(
                            result.message || 'Data penduduk tidak ditemukan.'
                        );
                    }

                    const data = result.data;

                    setValue('nama_pihak2', data.nama);
                    setValue('jenis_kelamin_pihak2', data.jenis_kelamin);
                    setValue('tempat_lahir_pihak2', data.tempat_lahir);
                    setValue('tanggal_lahir_pihak2', data.tanggal_lahir);
                    setValue('alamat_pihak2', data.alamat);

                    setSelectValue(
                        'agama_pihak2',
                        data.agama,
                        { addIfMissing: true }
                    );

                    setSelectValue(
                        'pekerjaan_pihak2',
                        data.pekerjaan,
                        { addIfMissing: true }
                    );

                    setSelectValue(
                        'status_pihak2',
                        data.status_perkawinan || data.status,
                        { addIfMissing: false }
                    );

                    setStatusNikPihak2(
                        'Data penduduk berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    clearAutofillPihak2();

                    setStatusNikPihak2(
                        error.message ||
                            'Terjadi kesalahan saat mengambil data penduduk.',
                        'error'
                    );
                } finally {
                    nikInputPihak2.disabled = false;
                    nikInputPihak2.focus();
                }
            }

            function clearAutofillPihak2() {
                [
                    'nama_pihak2',
                    'tempat_lahir_pihak2',
                    'tanggal_lahir_pihak2',
                    'alamat_pihak2',
                ].forEach(function (id) {
                    const element = document.getElementById(id);

                    if (element) {
                        element.value = '';
                    }
                });
            }

            function setStatusNikPihak2(message, type) {
                if (!statusNikPihak2) {
                    return;
                }

                statusNikPihak2.textContent = message;
                statusNikPihak2.classList.remove(
                    'text-muted',
                    'text-primary',
                    'text-success',
                    'text-danger'
                );

                const classMap = {
                    normal: 'text-muted',
                    loading: 'text-primary',
                    success: 'text-success',
                    error: 'text-danger',
                };

                statusNikPihak2.classList.add(
                    classMap[type] || 'text-muted'
                );
            }
        });
    </script>
</body>

</html>
