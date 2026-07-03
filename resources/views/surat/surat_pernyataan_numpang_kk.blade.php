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
                <h4 class="mb-4">Surat Pernyataan Numpang KK</h4>

                <form action="{{ route('surat.numpangkk.store') }}" method="POST">
                    @csrf

                    <h5>Pemilik KK</h5>
                    <div class="mb-3">
                        <label for="nik_pemilik_kk" class="form-label">NIK Pemilik KK <span
                                class="text-danger">*</span></label>
                        <input type="text" name="nik_pemilik_kk" id="nik_pemilik_kk" class="form-control" required
                            value="{{ old('nik_pemilik_kk') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nama_pemilik_kk" class="form-label">Nama Pemilik KK</label>
                        <input type="text" name="nama_pemilik_kk" id="nama_pemilik_kk" class="form-control" required
                            value="{{ old('nama_pemilik_kk') }}">
                    </div>

                    <div class="mb-3">
                        <label for="no_kk" class="form-label">No. KK</label>
                        <input type="text" name="no_kk" id="no_kk" class="form-control" required
                            value="{{ old('no_kk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan_pemilik_kk" class="form-label">Pekerjaan</label>
                        <select name="pekerjaan_pemilik_kk" id="pekerjaan_pemilik_kk" class="form-control" required>
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
                                    'Guru Agama',
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
                                    {{ old('pekerjaan_pemilik_kk') == $job ? 'selected' : '' }}>
                                    {{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_pemilik_kk" class="form-label">Alamat</label>
                        <textarea name="alamat_pemilik_kk" id="alamat_pemilik_kk" class="form-control" rows="3" required>{{ old('alamat_pemilik_kk') }}</textarea>
                    </div>

                    <hr>

                    <h5>Penumpang KK</h5>
                    <div class="mb-3">
                        <label for="nama_penumpang_kk" class="form-label">Nama</label>
                        <input type="text" name="nama_penumpang_kk" id="nama_penumpang_kk" class="form-control" required
                            value="{{ old('nama_penumpang_kk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="nik_penumpang_kk" class="form-label">NIK</label>
                        <input type="text" name="nik_penumpang_kk" id="nik_penumpang_kk" class="form-control" required
                            value="{{ old('nik_penumpang_kk') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir_penumpang_kk" class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_penumpang_kk" id="tempat_lahir_penumpang_kk"
                            class="form-control" required value="{{ old('tempat_lahir_penumpang_kk') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir_penumpang_kk" class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_penumpang_kk" id="tanggal_lahir_penumpang_kk"
                            class="form-control" required value="{{ old('tanggal_lahir_penumpang_kk') }}">
                    </div>

                    <div class="mb-3">
                        <label for="agama_penumpang_kk" class="form-label">Agama</label>
                        <select name="agama_penumpang_kk" id="agama_penumpang_kk" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama_penumpang_kk)
                                <option value="{{ $agama_penumpang_kk }}"
                                    {{ old('agama_penumpang_kk') == $agama_penumpang_kk ? 'selected' : '' }}>
                                    {{ $agama_penumpang_kk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pekerjaan_penumpang_kk" class="form-label">Pekerjaan</label>
                        <select name="pekerjaan_penumpang_kk" id="pekerjaan_penumpang_kk" class="form-control" required>
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
                                    'Guru Agama',
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
                                    {{ old('pekerjaan_penumpang_kk') == $job ? 'selected' : '' }}>
                                    {{ $job }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp</label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
                    </div>
                    <div class="row border p-3 rounded mb-3 bg-light">
                        <div class="col-md-6 mb-3">
                            <label for="status_surat" class="form-label">Status Surat <span
                                    class="text-danger">*</span></label>
                            <select name="status_surat" id="status_surat" class="form-control" required>
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
                            <label for="status_verif" class="form-label">Status Verifikasi <span
                                    class="text-danger">*</span></label>
                            <select name="status_verif" id="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi"
                                    {{ old('status_verif') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi
                                </option>
                                <option value="Terverifikasi"
                                    {{ old('status_verif') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Kirim</button>
                </form>
            </div>
        </div>
    </div>

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

            const cleanValue = (value || '').toString().trim().toUpperCase();

            let found = false;

            Array.from(select.options).forEach(option => {
                const optionValue = option.value.toString().trim().toUpperCase();

                if (optionValue === cleanValue) {
                    select.value = option.value;
                    found = true;
                }
            });

            if (!found) {
                select.value = '';
                console.warn(`Value "${value}" tidak ditemukan di select #${id}`);
            }
        }

        function autofillData(nikFieldId, prefix) {
            const nik = document.getElementById(nikFieldId).value.trim();

            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    console.log('HASIL LOOKUP:', result);

                    if (result.success) {
                        const d = result.data;

                        if (prefix === 'pemilik') {
                            setInputValue('nama_pemilik_kk', d.nama);
                            setInputValue('no_kk', d.nokk || d.no_kk);
                            setInputValue('alamat_pemilik_kk', d.alamat);

                            setSelectValue('pekerjaan_pemilik_kk', d.pekerjaan);
                        }

                        if (prefix === 'penumpang') {
                            setInputValue('nama_penumpang_kk', d.nama);
                            setInputValue('tempat_lahir_penumpang_kk', d.tempat_lahir);
                            setInputValue('tanggal_lahir_penumpang_kk', d.tanggal_lahir);

                            setSelectValue('agama_penumpang_kk', d.agama);
                            setSelectValue('pekerjaan_penumpang_kk', d.pekerjaan);
                        }
                    } else {
                        alert(result.message || 'NIK tidak ditemukan');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Gagal mengambil data dari server');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikPemilik = document.getElementById('nik_pemilik_kk');
            if (nikPemilik) {
                nikPemilik.addEventListener('blur', function() {
                    autofillData('nik_pemilik_kk', 'pemilik');
                });
            }

            const nikPenumpang = document.getElementById('nik_penumpang_kk');
            if (nikPenumpang) {
                nikPenumpang.addEventListener('blur', function() {
                    autofillData('nik_penumpang_kk', 'penumpang');
                });
            }
        });
    </script>
@endsection
