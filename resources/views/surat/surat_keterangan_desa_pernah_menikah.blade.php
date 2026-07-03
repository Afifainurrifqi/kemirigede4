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
                <h4 class="mb-4">Form Surat Keterangan Desa Pernah Menikah (Admin)</h4>

                <form action="{{ route('surat.pernahmenikah.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <!-- NIK diletakkan di atas untuk kemudahan autofill -->
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required
                            value="{{ old('nik') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                            value="{{ old('nama_lengkap') }}">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span
                                class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama</label>
                        <select name="agama" id="agama" class="form-control">
                            <option value="">-- Pilih --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama)
                                <option value="{{ $agama }}">{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control"
                            value="{{ old('kewarganegaraan', 'Indonesia') }}">
                    </div>

                    <div class="mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan</label>
                        <select name="pekerjaan" id="pekerjaan" class="form-control">
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
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}">{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rt" class="form-label">RT</label>
                            <input type="text" name="rt" id="rt" class="form-control"
                                value="{{ old('rt') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" name="rw" id="rw" class="form-control"
                                value="{{ old('rw') }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status_surat" class="form-label">Status Surat</label>
                            <select name="status_surat" id="status_surat" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status_surat') == $status ? 'selected' : '' }}>{{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_verif" class="form-label">Status Verifikasi</label>
                            <select name="status_verif" id="status_verif" class="form-control" required>
                                <option value="">-- Pilih Verifikasi --</option>
                                @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                                    <option value="{{ $verif }}"
                                        {{ old('status_verif') == $verif ? 'selected' : '' }}>{{ $verif }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp</label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- ==================== AUTOFILL SCRIPT ==================== -->
    <script>
        function setInputValue(id, value) {
            const el = document.getElementById(id);
            if (el) {
                el.value = value || '';
            }
        }

        function setSelectValue(id, value) {
            const select = document.getElementById(id);
            if (!select) return;

            const rawValue = (value || '').toString().trim();

            if (!rawValue) {
                select.value = '';
                return;
            }

            const cleanValue = rawValue.toUpperCase();
            let found = false;

            Array.from(select.options).forEach(option => {
                const optionValue = option.value.toString().trim().toUpperCase();

                if (optionValue === cleanValue) {
                    select.value = option.value;
                    found = true;
                }
            });

            // Kalau value dari database tidak ada di option,
            // tambahkan otomatis supaya tetap tampil.
            if (!found) {
                const newOption = new Option(rawValue, rawValue, true, true);
                select.add(newOption);
                select.value = rawValue;
            }
        }

        function autofillAdminPernahMenikah() {
            const nikField = document.getElementById('nik');
            if (!nikField) return;

            const nik = nikField.value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    console.log('HASIL LOOKUP:', result);

                    if (result.success && result.data) {
                        const d = result.data;

                        setInputValue('nama_lengkap', d.nama);
                        setInputValue('tempat_lahir', d.tempat_lahir);
                        setInputValue('tanggal_lahir', d.tanggal_lahir ? d.tanggal_lahir.substring(0, 10) : '');
                        setInputValue('alamat', d.alamat);

                        setInputValue('rt', d.rt || d.RT);
                        setInputValue('rw', d.rw || d.RW);

                        setSelectValue('jenis_kelamin', d.jenis_kelamin);
                        setSelectValue('agama', d.agama);
                        setSelectValue('status_perkawinan', d.status_perkawinan || d.status);

                        // INI YANG DIPERBAIKI
                        setSelectValue('pekerjaan', d.pekerjaan);
                    }
                })
                .catch(err => {
                    console.log(err);
                    alert('Gagal mengambil data penduduk');
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const nikField = document.getElementById('nik');

            if (nikField) {
                nikField.addEventListener('blur', autofillAdminPernahMenikah);
            }
        });
    </script>

