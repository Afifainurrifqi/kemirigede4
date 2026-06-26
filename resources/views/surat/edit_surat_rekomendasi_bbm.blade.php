@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Rekomendasi Pembelian BBM Jenis Tertentu</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.rekomendasi_bbm.update', $surat->_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="20"
                            value="{{ old('nik', $surat->nik) }}">
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                            value="{{ old('nama_lengkap', $surat->nama_lengkap) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>No. HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" required
                                value="{{ old('no_hp', $surat->no_hp) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>No. WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required
                                value="{{ old('nowa', $surat->nowa) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Alamat Usaha <span class="text-danger">*</span></label>
                        <textarea name="alamat_usaha" class="form-control" rows="2" required>{{ old('alamat_usaha', $surat->alamat_usaha) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Sektor Konsumen Pengguna <span class="text-danger">*</span></label>
                        <input type="text" name="sektor_konsumen" class="form-control" required
                            value="{{ old('sektor_konsumen', $surat->sektor_konsumen) }}">
                    </div>

                    <div class="mb-3">
                        <label>Jenis Usaha / Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_usaha_kegiatan" class="form-control" required
                            value="{{ old('jenis_usaha_kegiatan', $surat->jenis_usaha_kegiatan) }}">
                    </div>

                    <h5 class="mb-3 mt-4">Data Kebutuhan Alat & BBM</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jenis Alat <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_alat" class="form-control" required
                                value="{{ old('jenis_alat', $surat->jenis_alat) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jumlah Alat <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_alat" class="form-control" required
                                value="{{ old('jumlah_alat', $surat->jumlah_alat) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Fungsi Alat <span class="text-danger">*</span></label>
                            <input type="text" name="fungsi_alat" class="form-control" required
                                value="{{ old('fungsi_alat', $surat->fungsi_alat) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Daya Alat / Mesin <span class="text-danger">*</span></label>
                            <input type="text" name="daya_alat" class="form-control" required
                                value="{{ old('daya_alat', $surat->daya_alat) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Kebutuhan BBM <span class="text-danger">*</span></label>
                            <input type="text" name="kebutuhan_bbm" class="form-control" required
                                value="{{ old('kebutuhan_bbm', $surat->kebutuhan_bbm) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jam Operasi / Hari <span class="text-danger">*</span></label>
                            <input type="text" name="jam_operasi" class="form-control" required
                                value="{{ old('jam_operasi', $surat->jam_operasi) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Konsumsi BBM per (Jam/Hari/Minggu/Bulan) <span class="text-danger">*</span></label>
                        <input type="text" name="konsumsi_bbm" class="form-control" required
                            value="{{ old('konsumsi_bbm', $surat->konsumsi_bbm) }}">
                    </div>

                    <h5 class="mb-3 mt-4">Alokasi & Penyaluran</h5>

                    <div class="mb-3">
                        <label>Alokasi Volume Pertalite <span class="text-danger">*</span></label>
                        <input type="text" name="alokasi_pertalite" class="form-control" required
                            value="{{ old('alokasi_pertalite', $surat->alokasi_pertalite) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tempat Pengambilan <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_pengambilan" class="form-control" required
                                value="{{ old('tempat_pengambilan', $surat->tempat_pengambilan) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor Lembaga Penyalur <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_lembaga_penyalur" class="form-control" required
                                value="{{ old('nomor_lembaga_penyalur', $surat->nomor_lembaga_penyalur) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Lokasi Penyalur <span class="text-danger">*</span></label>
                        <input type="text" name="lokasi_penyalur" class="form-control" required
                            value="{{ old('lokasi_penyalur', $surat->lokasi_penyalur) }}">
                    </div>

                    <div class="mb-3">
                        <label>Jangka Waktu Berlaku (sampai) <span class="text-danger">*</span></label>
                        <input type="date" name="jangka_waktu" class="form-control" required
                            value="{{ old('jangka_waktu', $surat->jangka_waktu ? \Carbon\Carbon::parse($surat->jangka_waktu)->format('Y-m-d') : '') }}">
                    </div>

                    <!-- Status -->
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat <span class="text-danger">*</span></label>
                            <select name="status_surat" class="form-control" required>
                                <option value="Pending"
                                    {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Di cek"
                                    {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek
                                </option>
                                <option value="Di terima"
                                    {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di
                                    terima</option>
                                <option value="Ditolak"
                                    {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi <span class="text-danger">*</span></label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi"
                                    {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>
                                    Belum Verifikasi</option>
                                <option value="Terverifikasi"
                                    {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>
                                    Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">Update Data Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
