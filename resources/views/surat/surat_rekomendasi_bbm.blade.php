@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Rekomendasi Pembelian BBM Jenis Tertentu</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.rekomendasi_bbm.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="20"
                            inputmode="numeric" value="{{ old('nik') }}" placeholder="Contoh: 3501234567890123">
                        <small class="text-muted">Isi NIK lalu tekan TAB atau klik di luar untuk autofill</small>
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                            value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap sesuai KTP">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>No. HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" id="no_hp" class="form-control" required
                                value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No. WhatsApp (untuk notifikasi) <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}"
                                placeholder="Contoh: 081234567890">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Alamat Usaha <span class="text-danger">*</span></label>
                        <textarea name="alamat_usaha" id="alamat_usaha" class="form-control" rows="2" required
                            placeholder="Contoh: Jl. Merdeka No. 45 RT 02 RW 03, Desa Wates">{{ old('alamat_usaha') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Sektor Konsumen Pengguna <span class="text-danger">*</span></label>
                        <input type="text" name="sektor_konsumen" class="form-control" required
                            value="{{ old('sektor_konsumen') }}" placeholder="Contoh: Pertanian, Perikanan, Transportasi">
                    </div>

                    <div class="mb-3">
                        <label>Jenis Usaha / Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_usaha_kegiatan" class="form-control" required
                            value="{{ old('jenis_usaha_kegiatan') }}"
                            placeholder="Contoh: Pengolahan Pupuk Organik, Penggilingan Padi">
                    </div>

                    <h5 class="mb-3 mt-4">Data Kebutuhan Alat & BBM</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jenis Alat <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_alat" class="form-control" required
                                value="{{ old('jenis_alat') }}" placeholder="Contoh: Traktor Mini, Pompa Air">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jumlah Alat <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_alat" class="form-control" required
                                value="{{ old('jumlah_alat') }}" placeholder="Contoh: 2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fungsi Alat <span class="text-danger">*</span></label>
                            <input type="text" name="fungsi_alat" class="form-control" required
                                value="{{ old('fungsi_alat') }}" placeholder="Contoh: Membajak sawah">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Daya Alat / Mesin <span class="text-danger">*</span></label>
                            <input type="text" name="daya_alat" class="form-control" required
                                value="{{ old('daya_alat') }}" placeholder="Contoh: 15 PK">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kebutuhan BBM <span class="text-danger">*</span></label>
                            <input type="text" name="kebutuhan_bbm" class="form-control" required
                                value="{{ old('kebutuhan_bbm') }}" placeholder="Contoh: Pertalite">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jam Operasi / Hari <span class="text-danger">*</span></label>
                            <input type="text" name="jam_operasi" class="form-control" required
                                value="{{ old('jam_operasi') }}" placeholder="Contoh: 8 jam per hari">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Konsumsi BBM per (Jam/Hari/Minggu/Bulan) <span class="text-danger">*</span></label>
                        <input type="text" name="konsumsi_bbm" class="form-control" required
                            value="{{ old('konsumsi_bbm') }}" placeholder="Contoh: 15 liter per hari">
                    </div>

                    <h5 class="mb-3 mt-4">Alokasi & Penyaluran</h5>

                    <div class="mb-3">
                        <label>Alokasi Volume Pertalite <span class="text-danger">*</span></label>
                        <input type="text" name="alokasi_pertalite" class="form-control" required
                            value="{{ old('alokasi_pertalite') }}" placeholder="Contoh: 450 liter per bulan">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tempat Pengambilan <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_pengambilan" class="form-control" required
                                value="{{ old('tempat_pengambilan') }}" placeholder="Contoh: SPBU Wates">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor Lembaga Penyalur <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_lembaga_penyalur" class="form-control" required
                                value="{{ old('nomor_lembaga_penyalur') }}" placeholder="Contoh: SPBU 34.12345">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Lokasi Penyalur <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi_penyalur" class="form-control" required
                            value="{{ old('lokasi_penyalur') }}" placeholder="Contoh: Desa Wates, Kec. Wates">
                    </div>

                    <div class="mb-3">
                        <label>Jangka Waktu Berlaku (sampai) <span class="text-danger">*</span></label>
                        <input type="date" name="jangka_waktu" class="form-control" required
                            value="{{ old('jangka_waktu') }}">
                        <small class="text-muted">Masukkan tanggal akhir berlaku surat rekomendasi</small>
                    </div>

                    <!-- Status Admin -->
                    <div class="row mt-4">
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

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Simpan Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Autofill Script --}}
    <script>
        function autofillRekomendasiBbm() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_lengkap').value = d.nama || '';
                        document.getElementById('alamat_usaha').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }

        document.getElementById('nik').addEventListener('blur', autofillRekomendasiBbm);
        document.getElementById('nik').addEventListener('change', autofillRekomendasiBbm);
    </script>
@endsection
