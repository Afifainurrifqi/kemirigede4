@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Keterangan Ghoib (Admin)</h4>
                <form action="{{ route('surat.ghoib.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>
                    <div class="mb-3">
                        <label>NIK Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required
                            value="{{ old('nik') }}" onblur="autofillGhoibAdmin()">
                    </div>
                    <div class="mb-3">
                        <label>Nama Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" required
                            value="{{ old('nama_pemohon') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                                value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                                value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kewarganegaraan <span class="text-danger">*</span></label>
                            <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required
                                value="{{ old('kewarganegaraan', 'Indonesia') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Agama <span class="text-danger">*</span></label>
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Belum Kawin" {{ old('status') == 'Belum Kawin' ? 'selected' : '' }}>Belum
                                    Kawin</option>
                                <option value="Kawin" {{ old('status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai
                                    Hidup</option>
                                <option value="Cerai Mati" {{ old('status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'Pegawai Kantor Desa', 'BIDAN', 'DOKTER', 'PERAWAT', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI/PERKEBUNAN', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'PENSIUNAN', 'PEMBANTU RUMAH TANGGA', 'BURUH PETERNAKAN', 'KONSTRUKSI', 'PELAUT', 'NELAYAN/PERIKANAN', 'KARYAWAN HONORER', 'PETERNAK', 'MEKANIK', 'PENATA RIAS', 'TUKANG LAS/PANDAI BESI', 'INDUSTRI', 'USTADZ/MUBALIGH', 'TABIB', 'BURUH NELAYAN/PERIKANAN', 'JURU MASAK', 'SENIMAN', 'AKUNTAN', 'Petani/Pekebun penyewa', 'TKI', 'Lainnya'] as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                    {{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">Data yang Hilang</h6>
                    <div class="mb-3">
                        <label>Nama Suami/Istri yang Hilang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_suami_istri" class="form-control" required
                            value="{{ old('nama_suami_istri') }}">
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Hilang <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_hilang" class="form-control" required
                            value="{{ old('tanggal_hilang') }}">
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Surat Pernyataan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_pernyataan" class="form-control" required
                            value="{{ old('tanggal_pernyataan') }}">
                    </div>
                    <div class="mb-3">
                        <label>Keperluan / Tujuan Surat <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" class="form-control" required
                            value="{{ old('keperluan') }}" placeholder="contoh: Pengajuan Perceraian">
                    </div>
                    <div class="mb-3">
                        <label>Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" class="form-control" rows="3">{{ old('keterangan_tambahan') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                    </div>

                    <!-- Status Admin -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control" required>
                                <option value="Pending" {{ old('status_surat') == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Di cek" {{ old('status_surat') == 'Di cek' ? 'selected' : '' }}>Di cek
                                </option>
                                <option value="Di terima" {{ old('status_surat') == 'Di terima' ? 'selected' : '' }}>Di
                                    terima</option>
                                <option value="Ditolak" {{ old('status_surat') == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi</label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi"
                                    {{ old('status_verif') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi
                                </option>
                                <option value="Terverifikasi"
                                    {{ old('status_verif') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    function ambilNilai(value, keys = []) {
        if (value === undefined || value === null) {
            return '';
        }

        if (typeof value !== 'object') {
            return String(value).trim();
        }

        const possibleKeys = [
            ...keys,
            'nama',
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

    function normalisasiTeks(value) {
        return String(value ?? '')
            .trim()
            .toUpperCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^A-Z0-9]/g, '');
    }

    function setInputValue(id, value) {
        const element = document.getElementById(id);

        if (!element || value === undefined || value === null) {
            return false;
        }

        element.value = String(value).trim();

        element.dispatchEvent(
            new Event('change', {
                bubbles: true
            })
        );

        return true;
    }

    function setSelectValue(id, value, tambahJikaTidakAda = false) {
        const select = document.getElementById(id);
        const originalValue = String(value ?? '').trim();

        if (!select || originalValue === '') {
            return false;
        }

        const normalizedValue = normalisasiTeks(originalValue);

        let optionTerpilih = Array.from(select.options).find(option => {
            return normalisasiTeks(option.value) === normalizedValue ||
                normalisasiTeks(option.textContent) === normalizedValue;
        });

        if (!optionTerpilih) {
            optionTerpilih = Array.from(select.options).find(option => {
                if (!option.value) {
                    return false;
                }

                const normalizedOption = normalisasiTeks(option.value);

                return normalizedOption.includes(normalizedValue) ||
                    normalizedValue.includes(normalizedOption);
            });
        }

        if (!optionTerpilih && tambahJikaTidakAda) {
            optionTerpilih = new Option(
                originalValue,
                originalValue,
                true,
                true
            );

            select.add(optionTerpilih);
        }

        if (!optionTerpilih) {
            console.warn(
                `Option ${id} tidak ditemukan:`,
                originalValue
            );

            return false;
        }

        select.value = optionTerpilih.value;
        optionTerpilih.selected = true;

        select.dispatchEvent(
            new Event('change', {
                bubbles: true
            })
        );

        if (window.jQuery) {
            window.jQuery(select)
                .val(optionTerpilih.value)
                .trigger('change');
        }

        return true;
    }

    function normalisasiAgama(value) {
        const rawValue = ambilNilai(value, [
            'agama',
            'nama_agama'
        ]);

        const normalized = normalisasiTeks(rawValue);

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

    function normalisasiStatus(value) {
        const rawValue = ambilNilai(value, [
            'status',
            'nama_status',
            'status_perkawinan'
        ]);

        const normalized = normalisasiTeks(rawValue);

        const aliases = {
            BELUMKAWIN: 'Belum Kawin',
            BELUMMENIKAH: 'Belum Kawin',
            TIDAKKAWIN: 'Belum Kawin',

            KAWIN: 'Kawin',
            MENIKAH: 'Kawin',

            CERAIHIDUP: 'Cerai Hidup',
            CERAIMATI: 'Cerai Mati'
        };

        return aliases[normalized] ?? rawValue;
    }

    function normalisasiPekerjaan(value) {
        const rawValue = ambilNilai(value, [
            'pekerjaan',
            'nama_pekerjaan',
            'jenis_pekerjaan'
        ]);

        const normalized = normalisasiTeks(rawValue);

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

            TNI:
                'TNI',

            TENTARANASIONALINDONESIA:
                'TNI',

            TENTARANASIONALINDONESIATNI:
                'TNI',

            POLRI:
                'POLRI',

            KEPOLISIANRI:
                'POLRI',

            KEPOLISIANREPUBLIKINDONESIA:
                'POLRI',

            KEPOLISIANRIPOLRI:
                'POLRI',

            PNS:
                'PNS',

            PEGAWAINEGERISIPIL:
                'PNS',

            PEGAWAINEGERISIPILPNS:
                'PNS',

            PETANI:
                'PETANI/PEKEBUN PEMILIK LAHAN',

            PEKEBUN:
                'PETANI/PEKEBUN PEMILIK LAHAN',

            PETANIPEKEBUN:
                'PETANI/PEKEBUN PEMILIK LAHAN',

            PETANIPEKEBUNPEMILIKLAHAN:
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

            PETANIPEKEBUNPENYEWA:
                'Petani/Pekebun penyewa',

            LAINLAIN:
                'Lainnya',

            LAINNYA:
                'Lainnya'
        };

        return aliases[normalized] ?? rawValue;
    }

    function formatTanggal(value) {
        if (!value) {
            return '';
        }

        const tanggal = String(value).trim();

        const iso = tanggal.match(
            /^(\d{4})-(\d{2})-(\d{2})/
        );

        if (iso) {
            return `${iso[1]}-${iso[2]}-${iso[3]}`;
        }

        const formatIndonesia = tanggal.match(
            /^(\d{2})[/-](\d{2})[/-](\d{4})$/
        );

        if (formatIndonesia) {
            return `${formatIndonesia[3]}-${formatIndonesia[2]}-${formatIndonesia[1]}`;
        }

        return '';
    }

    function autofillGhoibAdmin() {
        const nikInput = document.getElementById('nik');

        if (!nikInput) {
            return;
        }

        const nik = nikInput.value
            .replace(/\D/g, '')
            .slice(0, 16);

        nikInput.value = nik;

        if (nik.length !== 16) {
            return;
        }

        fetch(`/datapenduduk/lookup/${encodeURIComponent(nik)}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },

            cache: 'no-store'
        })
            .then(async response => {
                const result = await response.json();

                if (!response.ok) {
                    throw new Error(
                        result.message ||
                        'Data penduduk gagal diambil.'
                    );
                }

                return result;
            })
            .then(result => {
                if (!result.success || !result.data) {
                    throw new Error(
                        result.message ||
                        'Data penduduk tidak ditemukan.'
                    );
                }

                const d = result.data;

                setInputValue(
                    'nama_pemohon',
                    d.nama
                );

                setInputValue(
                    'tempat_lahir',
                    d.tempat_lahir
                );

                setInputValue(
                    'tanggal_lahir',
                    formatTanggal(d.tanggal_lahir)
                );

                setInputValue(
                    'kewarganegaraan',
                    d.kewarganegaraan || 'Indonesia'
                );

                setInputValue(
                    'alamat',
                    d.alamat
                );

                setSelectValue(
                    'jenis_kelamin',
                    d.jenis_kelamin
                );

                /*
                 * Perbaikan Agama
                 */
                setSelectValue(
                    'agama',
                    normalisasiAgama(d.agama)
                );

                /*
                 * Perbaikan Status:
                 * utamakan status_perkawinan.
                 */
                setSelectValue(
                    'status',
                    normalisasiStatus(
                        d.status_perkawinan ??
                        d.status
                    )
                );

                /*
                 * Perbaikan Pekerjaan,
                 * termasuk BELUM/TIDAK BEKERJA.
                 */
                setSelectValue(
                    'pekerjaan',
                    normalisasiPekerjaan(d.pekerjaan),
                    true
                );

                console.log('Data Surat Ghoib:', {
                    agama_asli: d.agama,
                    agama_hasil: normalisasiAgama(d.agama),

                    status_asli:
                        d.status_perkawinan ?? d.status,

                    status_hasil: normalisasiStatus(
                        d.status_perkawinan ??
                        d.status
                    ),

                    pekerjaan_asli: d.pekerjaan,
                    pekerjaan_hasil:
                        normalisasiPekerjaan(d.pekerjaan)
                });
            })
            .catch(error => {
                console.error(
                    'Autofill Surat Ghoib:',
                    error
                );
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const nikInput = document.getElementById('nik');

        if (!nikInput) {
            return;
        }

        nikInput.addEventListener('input', function () {
            this.value = this.value
                .replace(/\D/g, '')
                .slice(0, 16);
        });

        nikInput.addEventListener('blur', function () {
            if (this.value.length === 16) {
                autofillGhoibAdmin();
            }
        });

        nikInput.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();

                autofillGhoibAdmin();
            }
        });
    });
</script>


@endsection
