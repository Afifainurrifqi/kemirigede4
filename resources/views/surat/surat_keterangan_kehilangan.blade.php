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
                <h4 class="mb-4">Form Surat Kehilangan (Admin)</h4>

                <form action="{{ route('suratkehilangan.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pelapor</h5>

                    <div class="mb-3">
                        <label>NIK Pelapor <span class="text-danger">*</span></label>
                        <input type="text" name="nik_pelapor" id="nik_pelapor" class="form-control" required
                            value="{{ old('nik_pelapor') }}">
                    </div>

                    <div class="mb-3">
                        <label>Nama Pelapor <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pelapor" id="nama_pelapor" class="form-control" required
                            value="{{ old('nama_pelapor') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir_pelapor" id="tempat_lahir_pelapor" class="form-control"
                                value="{{ old('tempat_lahir_pelapor') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir_pelapor" id="tanggal_lahir_pelapor"
                                class="form-control" value="{{ old('tanggal_lahir_pelapor') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_pelapor" id="jenis_kelamin_pelapor" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Agama</label>
                        <select name="agama_pelapor" id="agama_pelapor" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agama)
                                <option value="{{ $agama }}">{{ $agama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status Perkawinan</label>
                        <select name="status_pelapor" id="status_pelapor" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @foreach (['Kawin', 'Belum Kawin', 'Cerai Hidup', 'Cerai'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Pekerjaan</label>
                        <select name="pekerjaan_pelapor" id="pekerjaan_pelapor" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            @php
                                $jobs = [
                                    'BELUM/TIDAK BEKERJA',
                                    'PELAJAR/MAHASISWA',
                                    'KARYAWAN SWASTA',
                                    'IBU RUMAH TANGGA',
                                    'WIRASWASTA',
                                    'PETANI/PEKEBUN',
                                    'BURUH TANI/PERKEBUNAN',
                                    'PEDAGANG',
                                    'PEGAWAI NEGERI SIPIL (PNS)',
                                    'KARYAWAN HONORER',
                                    'BURUH HARIAN LEPAS',
                                    'SOPIR',
                                    'KARYAWAN BUMN',
                                    'PENSIUNAN',
                                    'Lainnya',
                                ];
                            @endphp
                            @foreach ($jobs as $job)
                                <option value="{{ $job }}">{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat_pelapor" id="alamat_pelapor" class="form-control" rows="3" required>{{ old('alamat_pelapor') }}</textarea>
                    </div>

                    <hr>

                    <h5 class="mb-3">Data Kehilangan</h5>

                    <div class="mb-3">
                        <label>Jenis Kehilangan</label>
                        <input type="text" name="jenis_kehilangan" class="form-control" required
                            value="{{ old('jenis_kehilangan') }}">
                    </div>

                    <div class="mb-3">
                        <label>Atas Nama</label>
                        <input type="text" name="atas_nama" class="form-control" required
                            value="{{ old('atas_nama') }}">
                    </div>

                    <div class="mb-3">
                        <label>Isi yang Hilang</label>
                        <input type="text" name="berisi" class="form-control" required value="{{ old('berisi') }}">
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Kehilangan</label>
                        <input type="date" name="tanggal_kehilangan" class="form-control" required
                            value="{{ old('tanggal_kehilangan') }}">
                    </div>

                    <div class="mb-3">
                        <label>Kehilangan Saat / Lokasi</label>
                        <input type="text" name="hilang_saat" class="form-control" required
                            value="{{ old('hilang_saat') }}">
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp</label>
                        <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $st)
                                    <option value="{{ $st }}">{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi</label>
                            <select name="status_verif" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Belum Verifikasi', 'Terverifikasi'] as $sv)
                                    <option value="{{ $sv }}">{{ $sv }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!-- ==================== AUTOFILL SCRIPT ==================== -->
<script>
    function autofillAdminKehilangan() {
        const nik = document.getElementById('nik_pelapor').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;

                    // Isi field
                    document.getElementById('nama_pelapor').value = d.nama || '';
                    document.getElementById('tempat_lahir_pelapor').value = d.tempat_lahir || '';
                    document.getElementById('tanggal_lahir_pelapor').value = d.tanggal_lahir ? d.tanggal_lahir
                        .substring(0, 10) : '';
                    document.getElementById('alamat_pelapor').value = d.alamat || '';

                    // Dropdown
                    if (document.getElementById('jenis_kelamin_pelapor')) {
                        document.getElementById('jenis_kelamin_pelapor').value = d.jenis_kelamin || '';
                    }
                    if (document.getElementById('agama_pelapor') && d.agama) {
                        document.getElementById('agama_pelapor').value = d.agama;
                    }
                    if (document.getElementById('status_pelapor') && (d.status_perkawinan || d.status)) {
                        document.getElementById('status_pelapor').value = d.status_perkawinan || d.status;
                    }
                    if (document.getElementById('pekerjaan_pelapor') && d.pekerjaan) {
                        document.getElementById('pekerjaan_pelapor').value = d.pekerjaan;
                    }
                }
            })
            .catch(err => console.log('Autofill error:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const nikField = document.getElementById('nik_pelapor');
        if (nikField) {
            nikField.addEventListener('blur', autofillAdminKehilangan);
        }
    });
</script>
