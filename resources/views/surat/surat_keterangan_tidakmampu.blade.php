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

                <form action="{{ route('surat.tidakmampu.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required value="{{ old('nik') }}">
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required value="{{ old('nama_lengkap') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>

                    <!-- KEWARGANEGARAAN -->
                    <div class="mb-3">
                        <label>Kewarganegaraan <span class="text-danger">*</span></label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                            <option value="">-- Pilih Kewarganegaraan --</option>
                            <option value="Warga Negara Indonesia (WNI)" {{ old('kewarganegaraan') == 'Warga Negara Indonesia (WNI)' ? 'selected' : '' }}>Warga Negara Indonesia (WNI)</option>
                            <option value="Warga Negara Asing (WNA)" {{ old('kewarganegaraan') == 'Warga Negara Asing (WNA)' ? 'selected' : '' }}>Warga Negara Asing (WNA)</option>
                        </select>
                    </div>



                    <div class="mb-3">
                        <label>Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="status_perkawinan" id="status_perkawinan" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                            <option value="">-- Pilih Pekerjaan --</option>
                            @php
                                $jobs = ["BELUM/TIDAK BEKERJA","PELAJAR/MAHASISWA","KARYAWAN SWASTA","IBU RUMAH TANGGA","WIRASWASTA","PETANI/PEKEBUN","BURUH TANI","PEDAGANG","PEGAWAI NEGERI SIPIL (PNS)","KARYAWAN HONORER","BURUH HARIAN LEPAS","SOPIR","KARYAWAN BUMN","PENSIUNAN","Lainnya"];
                            @endphp
                            @foreach($jobs as $job)
                                <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
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
                            <option value="Biaya Pendidikan" {{ old('peruntukan_sktm') == 'Biaya Pendidikan' ? 'selected' : '' }}>Biaya Pendidikan</option>
                            <option value="Bantuan Sosial" {{ old('peruntukan_sktm') == 'Bantuan Sosial' ? 'selected' : '' }}>Bantuan Sosial</option>
                            <option value="Biaya Kesehatan" {{ old('peruntukan_sktm') == 'Biaya Kesehatan' ? 'selected' : '' }}>Biaya Kesehatan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan Fungsi Surat <span class="text-danger">*</span></label>
                        <textarea name="keterangan_fungsi_surat" class="form-control" rows="3" required>{{ old('keterangan_fungsi_surat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required value="{{ old('nowa') }}">
                    </div>

                    <!-- Status Admin -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat <span class="text-danger">*</span></label>
                            <select name="status_surat" class="form-control" required>
                                <option value="Pending" {{ old('status_surat') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Di cek" {{ old('status_surat') == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                                <option value="Di terima" {{ old('status_surat') == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                                <option value="Ditolak" {{ old('status_surat') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi <span class="text-danger">*</span></label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi" {{ old('status_verif') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                                <option value="Terverifikasi" {{ old('status_verif') == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
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
    function autofillAdminSKTM() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;

                    // Data utama
                    document.getElementById('nama_lengkap').value = d.nama || '';
                    document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                    document.getElementById('tanggal_lahir').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0,10) : '';
                    document.getElementById('alamat_rumah').value = d.alamat || '';

                    // Dropdown fields
                    if (d.jenis_kelamin) document.getElementById('jenis_kelamin').value = d.jenis_kelamin;
                    if (d.agama) document.getElementById('agama').value = d.agama;
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                    if (d.status_perkawinan || d.status) {
                        document.getElementById('status_perkawinan').value = d.status_perkawinan || d.status;
                    }
                    if (d.kewarganegaraan) {
                        document.getElementById('kewarganegaraan').value = d.kewarganegaraan;
                    }
                }
            })
            .catch(err => console.log('Autofill error:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nikInput = document.getElementById('nik');
        if (nikInput) {
            nikInput.addEventListener('blur', autofillAdminSKTM);
        }
    });
</script>
