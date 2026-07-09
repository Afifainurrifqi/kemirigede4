@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit SPTJM Kematian</h5>
                        <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Periksa kembali input:</strong>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.sptjm.update', $surat->_id ?? $surat->id) }}" method="POST"
                            novalidate>
                            @csrf
                            @method('PUT')

                            <h6 class="fw-bold mb-2">Data Pelapor</h6>

                            <div class="mb-3">
                                <label class="form-label">NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    value="{{ old('nik', $surat->nik) }}" required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    value="{{ old('nama', $surat->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="ttl_tempat" id="ttl_tempat"
                                        class="form-control @error('ttl_tempat') is-invalid @enderror"
                                        value="{{ old('ttl_tempat', $surat->ttl_tempat) }}" required>
                                    @error('ttl_tempat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="ttl_tanggal" id="ttl_tanggal"
                                        class="form-control @error('ttl_tanggal') is-invalid @enderror"
                                        value="{{ old('ttl_tanggal', optional($surat->ttl_tanggal)->format('Y-m-d')) }}"
                                        required>
                                    @error('ttl_tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $pekerjaanValue = old('pekerjaan', $surat->pekerjaan ?? '');

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

                                if ($pekerjaanValue && !in_array($pekerjaanValue, $jobs)) {
                                    $jobs[] = $pekerjaanValue;
                                }
                            @endphp

                            <div class="mb-3">
                                <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                <select name="pekerjaan" id="pekerjaan"
                                    class="form-control @error('pekerjaan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}"
                                            {{ $pekerjaanValue == $job ? 'selected' : '' }}>
                                            {{ $job }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror"
                                    required>{{ old('alamat', $surat->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-2">Data Jenazah</h6>

                            <div class="mb-3">
                                <label class="form-label">NIK Jenazah <span class="text-danger">*</span></label>
                                <input type="text" name="nik_jenazah" id="nik_jenazah"
                                    class="form-control @error('nik_jenazah') is-invalid @enderror"
                                    value="{{ old('nik_jenazah', $surat->nik_jenazah) }}" required>
                                @error('nik_jenazah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Jenazah <span class="text-danger">*</span></label>
                                <input type="text" name="nama_jenazah" id="nama_jenazah"
                                    class="form-control @error('nama_jenazah') is-invalid @enderror"
                                    value="{{ old('nama_jenazah', $surat->nama_jenazah) }}" required>
                                @error('nama_jenazah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tempat Lahir Jenazah</label>
                                    <input type="text" name="ttl_tempat_jenazah" id="ttl_tempat_jenazah"
                                        class="form-control @error('ttl_tempat_jenazah') is-invalid @enderror"
                                        value="{{ old('ttl_tempat_jenazah', $surat->ttl_tempat_jenazah) }}" required>
                                    @error('ttl_tempat_jenazah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Lahir Jenazah</label>
                                    <input type="date" name="ttl_tanggal_jenazah" id="ttl_tanggal_jenazah"
                                        class="form-control @error('ttl_tanggal_jenazah') is-invalid @enderror"
                                        value="{{ old('ttl_tanggal_jenazah', optional($surat->ttl_tanggal_jenazah)->format('Y-m-d')) }}"
                                        required>
                                    @error('ttl_tanggal_jenazah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki"
                                        {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Anak Ke <span class="text-danger">*</span></label>
                                <input type="number" name="anak_ke"
                                    class="form-control @error('anak_ke') is-invalid @enderror"
                                    value="{{ old('anak_ke', $surat->anak_ke) }}" min="1" required>
                                @error('anak_ke')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Ayah Kandung <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ayah_kandung"
                                    class="form-control @error('nama_ayah_kandung') is-invalid @enderror"
                                    value="{{ old('nama_ayah_kandung', $surat->nama_ayah_kandung) }}" required>
                                @error('nama_ayah_kandung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Ibu Kandung <span class="text-danger">*</span></label>
                                <input type="text" name="nama_ibu_kandung"
                                    class="form-control @error('nama_ibu_kandung') is-invalid @enderror"
                                    value="{{ old('nama_ibu_kandung', $surat->nama_ibu_kandung) }}" required>
                                @error('nama_ibu_kandung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Meninggal</label>
                                    <input type="date" name="tanggal_kematian" class="form-control"
                                        value="{{ old('tanggal_kematian', optional($surat->tanggal_kematian)->format('Y-m-d')) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Surat Kematian Dari</label>
                                    <input type="text" name="surat_kematian_dari" class="form-control"
                                        value="{{ old('surat_kematian_dari', $surat->surat_kematian_dari) }}">
                                </div>
                            </div>

                            <hr>

                            <h6 class="fw-bold mb-2">Data Saksi</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Saksi I</label>
                                    <input type="text" name="nama_saksi_1" class="form-control"
                                        value="{{ old('nama_saksi_1', $surat->nama_saksi_1) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Saksi I</label>
                                    <input type="text" name="nik_saksi_1" class="form-control"
                                        value="{{ old('nik_saksi_1', $surat->nik_saksi_1) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Saksi II</label>
                                    <input type="text" name="nama_saksi_2" class="form-control"
                                        value="{{ old('nama_saksi_2', $surat->nama_saksi_2) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIK Saksi II</label>
                                    <input type="text" name="nik_saksi_2" class="form-control"
                                        value="{{ old('nik_saksi_2', $surat->nik_saksi_2) }}">
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa"
                                    class="form-control @error('nowa') is-invalid @enderror"
                                    value="{{ old('nowa', $surat->nowa) }}" required>
                                @error('nowa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Surat</label>
                                    <select name="status_surat" class="form-control">
                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('status_surat', $surat->status_surat ?? 'Pending') == $st ? 'selected' : '' }}>
                                                {{ $st }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Verifikasi</label>
                                    <select name="status_verif" class="form-control">
                                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $sv)
                                            <option value="{{ $sv }}"
                                                {{ old('status_verif', $surat->status_verif ?? 'Belum Verifikasi') == $sv ? 'selected' : '' }}>
                                                {{ $sv }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function setSelectValue(selectId, value) {
                const select = document.getElementById(selectId);
                if (!select) return;

                const dbValue = (value || '').trim();
                const normalizedDb = dbValue.toUpperCase();

                let found = false;

                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value.trim().toUpperCase() === normalizedDb) {
                        select.selectedIndex = i;
                        found = true;
                        break;
                    }
                }

                if (!found && dbValue !== '') {
                    select.add(new Option(dbValue, dbValue, true, true));
                }
            }

            function lookupPenduduk(nik, callback) {
                if (!nik || nik.length < 10) return;

                fetch(`/datapenduduk/lookup/${nik}`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success && result.data) {
                            callback(result.data);
                        }
                    })
                    .catch(err => console.log(err));
            }

            function autofillPelapor() {
                const nik = document.getElementById('nik').value.trim();

                lookupPenduduk(nik, function(d) {
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
                    document.getElementById('ttl_tanggal').value = d.tanggal_lahir ?
                        d.tanggal_lahir.substring(0, 10) :
                        '';
                    document.getElementById('alamat').value = d.alamat || '';

                    setSelectValue('pekerjaan', d.pekerjaan);
                });
            }

            function autofillJenazah() {
                const nik = document.getElementById('nik_jenazah').value.trim();

                lookupPenduduk(nik, function(d) {
                    document.getElementById('nama_jenazah').value = d.nama || '';
                    document.getElementById('ttl_tempat_jenazah').value = d.tempat_lahir || '';
                    document.getElementById('ttl_tanggal_jenazah').value = d.tanggal_lahir ?
                        d.tanggal_lahir.substring(0, 10) :
                        '';

                    setSelectValue('jenis_kelamin', d.jenis_kelamin);
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const nikPelapor = document.getElementById('nik');
                const nikJenazah = document.getElementById('nik_jenazah');

                if (nikPelapor) {
                    nikPelapor.addEventListener('blur', autofillPelapor);
                    nikPelapor.addEventListener('change', autofillPelapor);
                }

                if (nikJenazah) {
                    nikJenazah.addEventListener('blur', autofillJenazah);
                    nikJenazah.addEventListener('change', autofillJenazah);
                }
            });
        </script>
    @endsection
