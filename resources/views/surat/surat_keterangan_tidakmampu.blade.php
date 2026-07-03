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
                <h4 class="mb-4">Form Surat Keterangan Tidak Mampu (Admin)</h4>
                @php
                    $bansosMap = [
                        'pkh' => 'PKH',
                        'kip' => 'KIP',
                        'kis' => 'KIS',
                        'bpnt' => 'BPNT',
                        'dtks' => 'ID. DTKS',
                        'blt_dd' => 'BLT DD',
                        'bansos' => 'BANSOS',
                    ];

                    $oldBantuan = old('bantuan', []);
                    $oldIds = old('bantuan_id', []);
                @endphp

                <form action="{{ route('surat.tidakmampu.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required
                            value="{{ old('nik') }}">
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                            value="{{ old('nama_lengkap') }}">
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

                    <!-- KEWARGANEGARAAN -->
                    <div class="mb-3">
                        <label>Kewarganegaraan <span class="text-danger">*</span></label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                            <option value="">-- Pilih Kewarganegaraan --</option>
                            <option value="Warga Negara Indonesia (WNI)"
                                {{ old('kewarganegaraan') == 'Warga Negara Indonesia (WNI)' ? 'selected' : '' }}>Warga
                                Negara Indonesia (WNI)</option>
                            <option value="Warga Negara Asing (WNA)"
                                {{ old('kewarganegaraan') == 'Warga Negara Asing (WNA)' ? 'selected' : '' }}>Warga Negara
                                Asing (WNA)</option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label>Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                    {{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="status_perkawinan" id="status_perkawinan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>
                                Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin
                            </option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>
                                Cerai Hidup</option>
                            <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
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
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                    {{ $job }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Alamat Rumah <span class="text-danger">*</span></label>
                        <textarea name="alamat_rumah" id="alamat_rumah" class="form-control" rows="3" required>{{ old('alamat_rumah') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Peruntukan SKTM <span class="text-danger">*</span></label>
                        <select name="peruntukan_sktm" class="form-control" required>
                            <option value="">-- Pilih Peruntukan --</option>
                            <option value="Biaya Pendidikan"
                                {{ old('peruntukan_sktm') == 'Biaya Pendidikan' ? 'selected' : '' }}>Biaya Pendidikan
                            </option>
                            <option value="Bantuan Sosial"
                                {{ old('peruntukan_sktm') == 'Bantuan Sosial' ? 'selected' : '' }}>Bantuan Sosial</option>
                            <option value="Biaya Kesehatan"
                                {{ old('peruntukan_sktm') == 'Biaya Kesehatan' ? 'selected' : '' }}>Biaya Kesehatan
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan Fungsi Surat <span class="text-danger">*</span></label>
                        <textarea name="keterangan_fungsi_surat" class="form-control" rows="3" required>{{ old('keterangan_fungsi_surat') }}</textarea>
                    </div>

                    {{-- Bantuan Sosial + Input ID Dinamis --}}
                    <div class="mb-3">
                        <label class="form-label">Apakah anda memiliki bantuan sosial?</label>

                        <div class="d-flex flex-column gap-2">
                            @foreach ($bansosMap as $key => $label)
                                @php
                                    $isChecked = in_array($key, (array) $oldBantuan);
                                    $cbId = "bantuan_$key";
                                    $wrapId = "wrap_$key";
                                @endphp

                                <div class="border rounded p-2">
                                    <div class="form-check">
                                        <input class="form-check-input bantuan-checkbox" type="checkbox" name="bantuan[]"
                                            id="{{ $cbId }}" value="{{ $key }}"
                                            data-target="#{{ $wrapId }}" {{ $isChecked ? 'checked' : '' }}
                                            onchange="toggleBansosWrap(this)">

                                        <label class="form-check-label" for="{{ $cbId }}">
                                            {{ $label }}
                                        </label>
                                    </div>

                                    <div id="{{ $wrapId }}" class="mt-2"
                                        style="{{ $isChecked ? '' : 'display:none' }}">

                                        <label for="bantuan_id_{{ $key }}" class="form-label mb-1">
                                            ID {{ $label }} <span class="text-danger">*</span>
                                        </label>

                                        <input type="text" class="form-control"
                                            name="bantuan_id[{{ $key }}]" id="bantuan_id_{{ $key }}"
                                            value="{{ $oldIds[$key] ?? '' }}" {{ $isChecked ? 'required' : '' }}
                                            placeholder="Masukkan ID {{ $label }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
                    </div>

                    <!-- Status Admin -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat <span class="text-danger">*</span></label>
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
                            <label>Status Verifikasi <span class="text-danger">*</span></label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi"
                                    {{ old('status_verif') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi
                                </option>
                                <option value="Terverifikasi"
                                    {{ old('status_verif') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- ==================== AUTOFILL SCRIPT (SUDAH DIPERBAIKI) ==================== -->
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
        // otomatis tambahkan supaya tetap tampil.
        if (!found) {
            const newOption = new Option(rawValue, rawValue, true, true);
            select.add(newOption);
            select.value = rawValue;
        }
    }

    function autofillTidakMampu() {
        const nikField = document.getElementById('nik');
        if (!nikField) return;

        const nik = nikField.value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                console.log('HASIL LOOKUP:', result);

                if (!result.success || !result.data) {
                    alert(result.message || 'NIK tidak ditemukan');
                    return;
                }

                const d = result.data;

                setInputValue('nama_lengkap', d.nama);
                setInputValue('tempat_lahir', d.tempat_lahir);
                setInputValue('tanggal_lahir', d.tanggal_lahir ? d.tanggal_lahir.substring(0, 10) : '');

                // ALAMAT
                setInputValue('alamat_rumah', d.alamat);

                // SELECT
                setSelectValue('agama', d.agama);
                setSelectValue('pekerjaan', d.pekerjaan);
                setSelectValue('status_perkawinan', d.status_perkawinan || d.status);

                // KEWARGANEGARAAN
                setSelectValue('kewarganegaraan', d.kewarganegaraan || 'Warga Negara Indonesia (WNI)');
            })
            .catch(err => {
                console.log(err);
                alert('Gagal mengambil data penduduk');
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nikInput = document.getElementById('nik');

        if (nikInput) {
            nikInput.addEventListener('blur', autofillTidakMampu);
        }
    });

    function toggleBansosWrap(cb) {
        const target = cb.getAttribute('data-target');
        const wrap = document.querySelector(target);

        if (!wrap) return;

        const input = wrap.querySelector('input');

        if (cb.checked) {
            wrap.style.display = '';
            if (input) {
                input.setAttribute('required', 'required');
            }
        } else {
            wrap.style.display = 'none';
            if (input) {
                input.removeAttribute('required');
                input.value = '';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.bantuan-checkbox').forEach(function(cb) {
            toggleBansosWrap(cb);
        });
    });
</script>
