@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card">
                        <h5 class="mb-0">Edit Surat Kuasa</h5>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('surat.kuasa.update', $surat->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Pihak I -->
                            <h5>Pihak I - Pemberi Kuasa</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK</label>
                                    <input type="text" name="nik_pihak1"
                                        value="{{ old('nik_pihak1', $surat->nik_pihak1) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_pihak1"
                                        value="{{ old('nama_pihak1', $surat->nama_pihak1) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin_pihak1" class="form-control" required>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin_pihak1', $surat->jenis_kelamin_pihak1) == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin_pihak1', $surat->jenis_kelamin_pihak1) == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Agama</label>
                                    <select name="agama_pihak1" class="form-control" required>
                                        <option value="Islam"
                                            {{ old('agama_pihak1', $surat->agama_pihak1) == 'Islam' ? 'selected' : '' }}>
                                            Islam</option>
                                        <option value="Kristen"
                                            {{ old('agama_pihak1', $surat->agama_pihak1) == 'Kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="Katolik"
                                            {{ old('agama_pihak1', $surat->agama_pihak1) == 'Katolik' ? 'selected' : '' }}>
                                            Katolik</option>
                                        <option value="Hindu"
                                            {{ old('agama_pihak1', $surat->agama_pihak1) == 'Hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                        <option value="Buddha"
                                            {{ old('agama_pihak1', $surat->agama_pihak1) == 'Buddha' ? 'selected' : '' }}>
                                            Buddha</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status_pihak1" class="form-control" required>
                                        <option value="Kawin"
                                            {{ old('status_pihak1', $surat->status_pihak1) == 'Kawin' ? 'selected' : '' }}>
                                            Kawin</option>
                                        <option value="Belum Kawin"
                                            {{ old('status_pihak1', $surat->status_pihak1) == 'Belum Kawin' ? 'selected' : '' }}>
                                            Belum Kawin</option>
                                        <option value="Cerai Hidup"
                                            {{ old('status_pihak1', $surat->status_pihak1) == 'Cerai Hidup' ? 'selected' : '' }}>
                                            Cerai Hidup</option>
                                        <option value="Cerai Mati"
                                            {{ old('status_pihak1', $surat->status_pihak1) == 'Cerai Mati' ? 'selected' : '' }}>
                                            Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_pihak1"
                                        value="{{ old('tempat_lahir_pihak1', $surat->tempat_lahir_pihak1) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_pihak1"
                                        value="{{ old('tanggal_lahir_pihak1', $surat->tanggal_lahir_pihak1) }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Pekerjaan</label>
                                <select name="pekerjaan_pihak1" class="form-control" required>
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('pekerjaan_pihak1', $surat->pekerjaan_pihak1) == $p ? 'selected' : '' }}>
                                            {{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat_pihak1" class="form-control" rows="2" required>{{ old('alamat_pihak1', $surat->alamat_pihak1) }}</textarea>
                            </div>

                            <hr>

                            <!-- Pihak II -->
                            <h5>Pihak II - Penerima Kuasa</h5>
                            <div class="mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama_pihak2"
                                    value="{{ old('nama_pihak2', $surat->nama_pihak2) }}" class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin_pihak2" class="form-control" required>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin_pihak2', $surat->jenis_kelamin_pihak2) == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin_pihak2', $surat->jenis_kelamin_pihak2) == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Agama</label>
                                    <select name="agama_pihak2" class="form-control" required>
                                        <option value="Islam"
                                            {{ old('agama_pihak2', $surat->agama_pihak2) == 'Islam' ? 'selected' : '' }}>
                                            Islam</option>
                                        <option value="Kristen"
                                            {{ old('agama_pihak2', $surat->agama_pihak2) == 'Kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="Katolik"
                                            {{ old('agama_pihak2', $surat->agama_pihak2) == 'Katolik' ? 'selected' : '' }}>
                                            Katolik</option>
                                        <option value="Hindu"
                                            {{ old('agama_pihak2', $surat->agama_pihak2) == 'Hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                        <option value="Buddha"
                                            {{ old('agama_pihak2', $surat->agama_pihak2) == 'Buddha' ? 'selected' : '' }}>
                                            Buddha</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Status</label>
                                    <select name="status_pihak2" class="form-control" required>
                                        <option value="Kawin"
                                            {{ old('status_pihak2', $surat->status_pihak2) == 'Kawin' ? 'selected' : '' }}>
                                            Kawin</option>
                                        <option value="Belum Kawin"
                                            {{ old('status_pihak2', $surat->status_pihak2) == 'Belum Kawin' ? 'selected' : '' }}>
                                            Belum Kawin</option>
                                        <option value="Cerai Hidup"
                                            {{ old('status_pihak2', $surat->status_pihak2) == 'Cerai Hidup' ? 'selected' : '' }}>
                                            Cerai Hidup</option>
                                        <option value="Cerai Mati"
                                            {{ old('status_pihak2', $surat->status_pihak2) == 'Cerai Mati' ? 'selected' : '' }}>
                                            Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir_pihak2"
                                        value="{{ old('tempat_lahir_pihak2', $surat->tempat_lahir_pihak2) }}"
                                        class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir_pihak2"
                                        value="{{ old('tanggal_lahir_pihak2', $surat->tanggal_lahir_pihak2) }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Pekerjaan</label>
                                <select name="pekerjaan_pihak2" class="form-control" required>
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'Lainnya'] as $p)
                                        <option value="{{ $p }}"
                                            {{ old('pekerjaan_pihak2', $surat->pekerjaan_pihak2) == $p ? 'selected' : '' }}>
                                            {{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat_pihak2" class="form-control" rows="2" required>{{ old('alamat_pihak2', $surat->alamat_pihak2) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Keterangan / Maksud Kuasa</label>
                                <textarea name="keterangan_kuasa" class="form-control" rows="4" required>{{ old('keterangan_kuasa', $surat->keterangan_kuasa) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nomor Surat</label>
                                    <input type="text" name="nomor_surat"
                                        value="{{ old('nomor_surat', $surat->nomor_surat) }}" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>No WhatsApp</label>
                                    <input type="text" name="nowa" value="{{ old('nowa', $surat->nowa) }}"
                                        class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat</label>
                                    <select name="status_surat" class="form-control" required>
                                        <option value="Pending"
                                            {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Selesai"
                                            {{ old('status_surat', $surat->status_surat) == 'Selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi</label>
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

                            <button type="submit" class="btn btn-warning btn-lg w-100">Update Surat Kuasa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
