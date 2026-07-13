@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Form Pembuatan Surat Kuasa</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.kuasa.store') }}" method="POST">
                            @csrf

                            <!-- Pihak I -->
                            <h5 class="mt-3">Pihak I - Pemberi Kuasa</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        name="nik_pihak1"
                                        id="nik_pihak1"
                                        class="form-control"
                                        inputmode="numeric"
                                        maxlength="16"
                                        autocomplete="off"
                                        value="{{ old('nik_pihak1') }}"
                                        placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                                        required
                                    >
                                    <div id="status_nik_pihak1" class="form-text">
                                        Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pihak1" id="nama_pihak1" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin_pihak1" id="jenis_kelamin_pihak1" class="form-control"
                                        required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
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
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status_pihak1" id="status_pihak1" class="form-control" required>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_pihak1" id="tempat_lahir_pihak1"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_pihak1" id="tanggal_lahir_pihak1"
                                        class="form-control" required>
                                </div>
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
                            <h5>Pihak II - Penerima Kuasa</h5>
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
                                    value="{{ old('nik_pihak2') }}"
                                    placeholder="Masukkan 16 digit NIK, lalu tekan Enter"
                                    required
                                >
                                <div id="status_nik_pihak2" class="form-text">
                                    Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pihak2" id="nama_pihak2" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin_pihak2" id="jenis_kelamin_pihak2" class="form-control"
                                        required>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
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
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status_pihak2" id="status_pihak2" class="form-control" required>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_pihak2" id="tempat_lahir_pihak2"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_pihak2" id="tanggal_lahir_pihak2"
                                        class="form-control" required>
                                </div>
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

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>No WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="nowa" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat</label>
                                    <select name="status_surat" class="form-control" required>
                                        <option value="Pending"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Di cek"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Di cek' ? 'selected' : '' }}>
                                            Di cek</option>
                                        <option value="Di terima"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Di terima' ? 'selected' : '' }}>
                                            Di terima</option>
                                        <option value="Selesai"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                        <option value="Ditolak"
                                            {{ old('status_surat', $surat->status_surat ?? '') == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi</label>
                                    <select name="status_verif" class="form-control" required>
                                        <option value="Belum Verifikasi"
                                            {{ old('status_verif', $surat->status_verif ?? '') == 'Belum Verifikasi' ? 'selected' : '' }}>
                                            Belum Verifikasi</option>
                                        <option value="Terverifikasi"
                                            {{ old('status_verif', $surat->status_verif ?? '') == 'Terverifikasi' ? 'selected' : '' }}>
                                            Terverifikasi</option>
                                        <option value="Ditolak"
                                            {{ old('status_verif', $surat->status_verif ?? '') == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Surat Kuasa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setupNikAutofill('pihak1');
            setupNikAutofill('pihak2');

            /**
             * Menyiapkan autofill berdasarkan NIK untuk Pihak I/Pihak II.
             *
             * Lookup hanya dijalankan setelah:
             * - NIK tepat 16 digit; dan
             * - pengguna menekan tombol Enter.
             */
            function setupNikAutofill(prefix) {
                const nikInput = document.getElementById(`nik_${prefix}`);
                const statusElement = document.getElementById(`status_nik_${prefix}`);

                if (!nikInput) {
                    return;
                }

                nikInput.addEventListener('input', function () {
                    this.value = this.value.replace(/\D/g, '').slice(0, 16);

                    setLookupStatus(
                        statusElement,
                        'Ketik 16 digit NIK, kemudian tekan Enter untuk mengambil data penduduk.',
                        'normal'
                    );
                });

                nikInput.addEventListener('keydown', function (event) {
                    if (event.key !== 'Enter') {
                        return;
                    }

                    // Mencegah Enter mengirim form admin.
                    event.preventDefault();

                    lookupPenduduk(prefix, nikInput, statusElement);
                });
            }

            async function lookupPenduduk(prefix, nikInput, statusElement) {
                const nik = nikInput.value.trim();

                if (!/^\d{16}$/.test(nik)) {
                    setLookupStatus(
                        statusElement,
                        'NIK harus terdiri dari tepat 16 digit.',
                        'error'
                    );

                    nikInput.focus();
                    return;
                }

                setLookupStatus(
                    statusElement,
                    'Sedang mengambil data penduduk...',
                    'loading'
                );

                nikInput.readOnly = true;
                nikInput.setAttribute('aria-busy', 'true');

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

                    let result;

                    try {
                        result = await response.json();
                    } catch (error) {
                        throw new Error('Respons server tidak valid.');
                    }

                    if (!response.ok || !result.success || !result.data) {
                        throw new Error(
                            result.message || 'Data penduduk tidak ditemukan.'
                        );
                    }

                    isiDataPenduduk(prefix, result.data);

                    setLookupStatus(
                        statusElement,
                        'Data penduduk berhasil ditemukan dan diisi.',
                        'success'
                    );
                } catch (error) {
                    kosongkanDataPenduduk(prefix);

                    setLookupStatus(
                        statusElement,
                        error.message ||
                            'Terjadi kesalahan saat mengambil data penduduk.',
                        'error'
                    );
                } finally {
                    nikInput.readOnly = false;
                    nikInput.removeAttribute('aria-busy');
                    nikInput.focus();
                }
            }

            function isiDataPenduduk(prefix, data) {
                setInputValue(`nama_${prefix}`, data.nama);
                setInputValue(`jenis_kelamin_${prefix}`, data.jenis_kelamin);
                setInputValue(`tempat_lahir_${prefix}`, data.tempat_lahir);
                setInputValue(`tanggal_lahir_${prefix}`, data.tanggal_lahir);
                setInputValue(`alamat_${prefix}`, data.alamat);

                setSelectValue(
                    `agama_${prefix}`,
                    data.agama,
                    { addIfMissing: true }
                );

                setSelectValue(
                    `pekerjaan_${prefix}`,
                    data.pekerjaan,
                    { addIfMissing: true }
                );

                setSelectValue(
                    `status_${prefix}`,
                    data.status_perkawinan || data.status,
                    { addIfMissing: false }
                );
            }

            function setInputValue(id, value) {
                const element = document.getElementById(id);

                if (
                    !element ||
                    value === null ||
                    value === undefined
                ) {
                    return false;
                }

                element.value = value;
                element.dispatchEvent(
                    new Event('change', { bubbles: true })
                );

                return true;
            }

            /**
             * Normalisasi teks untuk mencocokkan nilai database dengan option.
             */
            function normalizeText(value) {
                return String(value || '')
                    .trim()
                    .toLocaleLowerCase('id-ID')
                    .replace(/&/g, ' dan ')
                    .replace(/[.,()_-]/g, ' ')
                    .replace(/\s+/g, ' ')
                    .trim();
            }

            /**
             * Mengisi select secara toleran terhadap perbedaan kapitalisasi,
             * spasi, tanda baca, serta variasi penulisan.
             */
            function setSelectValue(id, value, options = {}) {
                const element = document.getElementById(id);
                const addIfMissing = options.addIfMissing === true;

                if (
                    !element ||
                    value === null ||
                    value === undefined ||
                    String(value).trim() === ''
                ) {
                    return false;
                }

                const rawValue = String(value).trim();
                const normalizedValue = normalizeText(rawValue);
                const allOptions = Array.from(element.options);

                let matchedOption = allOptions.find(function (option) {
                    return (
                        normalizeText(option.value) === normalizedValue ||
                        normalizeText(option.textContent) === normalizedValue
                    );
                });

                if (!matchedOption) {
                    matchedOption = allOptions.find(function (option) {
                        const normalizedOptionValue = normalizeText(option.value);
                        const normalizedOptionText = normalizeText(option.textContent);

                        if (!normalizedOptionValue && !normalizedOptionText) {
                            return false;
                        }

                        return (
                            normalizedOptionValue.includes(normalizedValue) ||
                            normalizedValue.includes(normalizedOptionValue) ||
                            normalizedOptionText.includes(normalizedValue) ||
                            normalizedValue.includes(normalizedOptionText)
                        );
                    });
                }

                if (!matchedOption) {
                    const fieldType = id.startsWith('agama_')
                        ? 'agama'
                        : id.startsWith('pekerjaan_')
                            ? 'pekerjaan'
                            : 'status';

                    const aliasMap = {
                        agama: {
                            'kristen protestan': 'Kristen',
                            'protestan': 'Kristen',
                            'katholik': 'Katolik',
                            'budha': 'Buddha',
                            'kong hu cu': 'Konghucu',
                        },
                        pekerjaan: {
                            'belum bekerja': 'BELUM/TIDAK BEKERJA',
                            'tidak bekerja': 'BELUM/TIDAK BEKERJA',
                            'pelajar': 'PELAJAR/MAHASISWA',
                            'mahasiswa': 'PELAJAR/MAHASISWA',
                            'mengurus rumah tangga': 'IBU RUMAH TANGGA',
                            'ibu rumah tangga': 'IBU RUMAH TANGGA',
                            'pegawai negeri sipil': 'PNS',
                            'petani': 'PETANI/PEKEBUN PEMILIK LAHAN',
                            'pekebun': 'PETANI/PEKEBUN PEMILIK LAHAN',
                            'buruh tani perkebunan': 'BURUH TANI',
                        },
                        status: {
                            'belum menikah': 'Belum Kawin',
                            'menikah': 'Kawin',
                            'kawin tercatat': 'Kawin',
                            'kawin belum tercatat': 'Kawin',
                            'cerai mati': 'Cerai Mati',
                            'cerai hidup': 'Cerai Hidup',
                        },
                    };

                    const aliasValue = aliasMap[fieldType]?.[normalizedValue];

                    if (aliasValue) {
                        matchedOption = allOptions.find(function (option) {
                            return normalizeText(option.value) ===
                                normalizeText(aliasValue);
                        });
                    }
                }

                if (matchedOption) {
                    element.value = matchedOption.value;
                    element.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );

                    return true;
                }

                /**
                 * Bila data agama/pekerjaan belum tersedia dalam daftar,
                 * tambahkan option baru agar nilai tetap terlihat dan tersimpan.
                 */
                if (addIfMissing) {
                    const option = document.createElement('option');
                    option.value = rawValue;
                    option.textContent = rawValue;
                    option.dataset.autofill = 'true';

                    element.appendChild(option);
                    element.value = rawValue;
                    element.dispatchEvent(
                        new Event('change', { bubbles: true })
                    );

                    return true;
                }

                return false;
            }

            function kosongkanDataPenduduk(prefix) {
                [
                    `nama_${prefix}`,
                    `tempat_lahir_${prefix}`,
                    `tanggal_lahir_${prefix}`,
                    `alamat_${prefix}`,
                ].forEach(function (id) {
                    const element = document.getElementById(id);

                    if (element) {
                        element.value = '';
                    }
                });
            }

            function setLookupStatus(element, message, type) {
                if (!element) {
                    return;
                }

                element.textContent = message;
                element.classList.remove(
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

                element.classList.add(classMap[type] || 'text-muted');
            }
        });
    </script>
@endsection
