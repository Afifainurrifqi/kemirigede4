@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Ghoib</h4>
            <form action="{{ route('surat.ghoib.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Pemohon</h5>
                <div class="mb-3">
                    <label>NIK Pemohon <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required value="{{ old('nik', $surat->nik) }}">
                </div>
                <div class="mb-3">
                    <label>Nama Pemohon <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" required value="{{ old('nama_pemohon', $surat->nama_pemohon) }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required value="{{ old('tempat_lahir', $surat->tempat_lahir) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required value="{{ old('tanggal_lahir', $surat->tanggal_lahir ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d') : '') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required value="{{ old('kewarganegaraan', $surat->kewarganegaraan) }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('agama', $surat->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $surat->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $surat->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $surat->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $surat->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('agama', $surat->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Belum Kawin" {{ old('status', $surat->status) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status', $surat->status) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status', $surat->status) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status', $surat->status) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Pekerjaan <span class="text-danger">*</span></label>
                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TNI','POLRI','DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','Pegawai Kantor Desa','BIDAN','DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN','PEDAGANG','PNS','BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN','PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI','PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK','MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI','USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN','JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa','TKI','Lainnya'] as $job)
                            <option value="{{ $job }}" {{ old('pekerjaan', $surat->pekerjaan) == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                </div>

                <h5 class="mb-3 mt-4">Data yang Hilang</h5>
                <div class="mb-3">
                    <label>Nama Suami/Istri yang Hilang <span class="text-danger">*</span></label>
                    <input type="text" name="nama_suami_istri" class="form-control" required value="{{ old('nama_suami_istri', $surat->nama_suami_istri) }}">
                </div>
                <div class="mb-3">
                    <label>Tanggal Hilang <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_hilang" class="form-control" required value="{{ old('tanggal_hilang', $surat->tanggal_hilang ? \Carbon\Carbon::parse($surat->tanggal_hilang)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label>Tanggal Surat Pernyataan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_pernyataan" class="form-control" required value="{{ old('tanggal_pernyataan', $surat->tanggal_pernyataan ? \Carbon\Carbon::parse($surat->tanggal_pernyataan)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label>Keperluan / Tujuan Surat <span class="text-danger">*</span></label>
                    <input type="text" name="keperluan" class="form-control" required value="{{ old('keperluan', $surat->keperluan) }}" placeholder="contoh: Pengajuan Perceraian">
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="3">{{ old('keterangan_tambahan', $surat->keterangan_tambahan) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required value="{{ old('nowa', $surat->nowa) }}">
                </div>

                <!-- Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
