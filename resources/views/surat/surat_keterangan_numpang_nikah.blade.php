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
                <h4 class="mb-4">Tambah Surat Keluar - Surat Keterangan Numpang Nikah</h4>

                <form action="{{ route('surat.numpangnikah.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-4">Data Pemohon</h5>

                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required
                            value="{{ old('nik') }}">
                        <small class="text-muted">Isi NIK, lalu klik/tab keluar dari kolom ini agar data otomatis terisi.</small>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" required
                            value="{{ old('nama') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                            value="{{ old('tempat_lahir') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                            value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div class="mb-3">
                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                    {{ $agama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
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
                                    'PETANI/PEKEBUN',
                                    'BURUH TANI',
                                    'PEDAGANG',
                                    'PEGAWAI NEGERI SIPIL (PNS)',
                                    'BURUH HARIAN LEPAS',
                                    'SOPIR',
                                    'KARYAWAN BUMN',
                                    'PENSIUNAN',
                                    'NELAYAN/PERIKANAN',
                                    'KARYAWAN HONORER',
                                    'PETERNAK',
                                    'MEKANIK',
                                    'INDUSTRI',
                                    'USTADZ/MUBALIGH',
                                    'JURU MASAK',
                                    'SENIMAN',
                                    'TKI',
                                    'Lainnya',
                                ];
                            @endphp

                            @foreach ($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                    {{ $job }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="status_perkawinan" id="status_perkawinan" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                <option value="{{ $status }}" {{ old('status_perkawinan') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                    </div>

                    <hr>

                    <h5 class="mb-4">Keterangan Numpang Nikah</h5>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" id="keperluan" class="form-control" required
                            value="{{ old('keperluan', 'Pernikahan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="alamat_tujuan" class="form-label">Alamat yang Dituju <span class="text-danger">*</span></label>
                        <textarea name="alamat_tujuan" id="alamat_tujuan" class="form-control" rows="3" required>{{ old('alamat_tujuan') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="mulai_berangkat" class="form-label">Mulai Berangkat <span class="text-danger">*</span></label>
                        <input type="date" name="mulai_berangkat" id="mulai_berangkat" class="form-control" required
                            value="{{ old('mulai_berangkat') }}">
                    </div>

                    <div class="mb-3">
                        <label for="pembawaan" class="form-label">Pembawaan <span class="text-danger">*</span></label>
                        <input type="text" name="pembawaan" id="pembawaan" class="form-control" required
                            value="{{ old('pembawaan', 'Pakaian secukupnya') }}">
                    </div>

                    <hr>

                    <h5 class="mb-4">Data Pengikut</h5>

                    <div class="mb-3">
                        <label for="jumlah_pengikut" class="form-label">Jumlah Pengikut</label>
                        <input type="number" min="0" name="jumlah_pengikut" id="jumlah_pengikut" class="form-control"
                            value="{{ old('jumlah_pengikut', 0) }}">
                    </div>

                    <div id="pengikut-wrapper" class="mt-3"></div>

                    <hr>

                    <h5 class="mb-4">Kontak dan Status Surat</h5>

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
                    </div>

                    <div class="mb-3">
                        <label for="status_surat" class="form-label">Status Surat <span class="text-danger">*</span></label>
                        <select name="status_surat" id="status_surat" class="form-control" required>
                            @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                <option value="{{ $status }}" {{ old('status_surat', 'Pending') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_verif" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status_verif" id="status_verif" class="form-control" required>
                            @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                                <option value="{{ $verif }}" {{ old('status_verif', 'Belum Verifikasi') == $verif ? 'selected' : '' }}>
                                    {{ $verif }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setValueIfExists(id, value) {
            const element = document.getElementById(id);
            if (element && value !== undefined && value !== null && value !== '') {
                element.value = value;
            }
        }

        function setSelectIfExists(id, value) {
            const element = document.getElementById(id);
            if (!element || value === undefined || value === null || value === '') return;

            const options = Array.from(element.options);
            const matched = options.find(option =>
                option.value.toLowerCase() === String(value).toLowerCase()
            );

            if (matched) {
                element.value = matched.value;
            }
        }

        function formatTanggal(value) {
            if (!value) return '';

            const str = String(value);

            if (/^\d{4}-\d{2}-\d{2}/.test(str)) {
                return str.substring(0, 10);
            }

            if (/^\d{2}-\d{2}-\d{4}/.test(str)) {
                const parts = str.split('-');
                return `${parts[2]}-${parts[1]}-${parts[0]}`;
            }

            return str.substring(0, 10);
        }

        function autofillNumpangNikah() {
            const nikInput = document.getElementById('nik');
            if (!nikInput) return;

            const nik = nikInput.value.trim();

            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;

                        setValueIfExists('nama', d.nama);
                        setValueIfExists('tempat_lahir', d.tempat_lahir);
                        setValueIfExists('tanggal_lahir', formatTanggal(d.tanggal_lahir));
                        setValueIfExists('alamat', d.alamat);

                        setSelectIfExists('agama', d.agama);
                        setSelectIfExists('pekerjaan', d.pekerjaan);
                        setSelectIfExists('status_perkawinan', d.status_perkawinan || d.status);
                    } else {
                        alert(result.message || 'Data penduduk tidak ditemukan.');
                    }
                })
                .catch(() => alert('Gagal mengambil data penduduk.'));
        }

        document.addEventListener('DOMContentLoaded', () => {
            const nikInput = document.getElementById('nik');

            if (nikInput) {
                nikInput.addEventListener('blur', autofillNumpangNikah);
            }

            renderPengikut(document.getElementById('jumlah_pengikut').value, true);

            document.getElementById('jumlah_pengikut').addEventListener('input', function () {
                renderPengikut(this.value, false);
            });
        });

        const oldNamaPengikut = @json(old('nama_pengikut', []));
        const oldUmurPengikut = @json(old('umur_pengikut', []));
        const oldJenisKelaminPengikut = @json(old('jenis_kelamin_pengikut', []));
        const oldHubunganKeluargaPengikut = @json(old('hubungan_keluarga_pengikut', []));
        const oldKeteranganPengikut = @json(old('keterangan_pengikut', []));

        function safe(value) {
            if (value === undefined || value === null) return '';
            return String(value).replace(/"/g, '&quot;');
        }

        function selected(current, option) {
            return String(current || '').toLowerCase() === String(option || '').toLowerCase() ? 'selected' : '';
        }

        function renderPengikut(count, useOld = true) {
            const wrapper = document.getElementById('pengikut-wrapper');
            wrapper.innerHTML = '';

            const jumlah = parseInt(count || 0, 10);

            for (let i = 0; i < jumlah; i++) {
                const nama = useOld ? oldNamaPengikut[i] : '';
                const umur = useOld ? oldUmurPengikut[i] : '';
                const jk = useOld ? oldJenisKelaminPengikut[i] : '';
                const hubungan = useOld ? oldHubunganKeluargaPengikut[i] : '';
                const keterangan = useOld ? oldKeteranganPengikut[i] : '';

                const div = document.createElement('div');
                div.className = 'border rounded p-3 mb-3';

                div.innerHTML = `
                    <h6 class="mb-3">Pengikut ${i + 1}</h6>

                    <div class="mb-3">
                        <label class="form-label">Nama Pengikut</label>
                        <input type="text" name="nama_pengikut[]" class="form-control" value="${safe(nama)}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Umur</label>
                        <input type="text" name="umur_pengikut[]" class="form-control" value="${safe(umur)}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin_pengikut[]" class="form-control">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" ${selected(jk, 'Laki-laki')}>Laki-laki</option>
                            <option value="Perempuan" ${selected(jk, 'Perempuan')}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hubungan Keluarga</label>
                        <input type="text" name="hubungan_keluarga_pengikut[]" class="form-control" value="${safe(hubungan)}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan_pengikut[]" class="form-control" value="${safe(keterangan)}">
                    </div>
                `;

                wrapper.appendChild(div);
            }
        }
    </script>
@endsection
