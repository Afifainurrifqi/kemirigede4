@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Edit Surat Ijin Keluarga</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('surat.ijin_keluarga.update', $surat) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <h6>Data Suami</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Suami <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_suami" class="form-control"
                                        value="{{ old('nama_suami', $surat->nama_suami) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir Suami</label>
                                    <input type="text" name="tempat_lahir_suami" class="form-control"
                                        value="{{ old('tempat_lahir_suami', $surat->tempat_lahir_suami) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir Suami</label>
                                    <input type="date" name="tanggal_lahir_suami" class="form-control"
                                        value="{{ old('tanggal_lahir_suami', $surat->tanggal_lahir_suami) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Pekerjaan Suami</label>
                                    <select name="pekerjaan_suami" class="form-control">
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'BIDAN', 'DOKTER', 'PERAWAT', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI/PERKEBUNAN', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'PENSIUNAN', 'PEMBANTU RUMAH TANGGA', 'BURUH PETERNAKAN', 'KONSTRUKSI', 'PELAUT', 'NELAYAN/PERIKANAN', 'KARYAWAN HONORER', 'PETERNAK', 'MEKANIK', 'PENATA RIAS', 'TUKANG LAS/PANDAI BESI', 'INDUSTRI', 'USTADZ/MUBALIGH', 'TABIB', 'BURUH NELAYAN/PERIKANAN', 'JURU MASAK', 'SENIMAN', 'AKUNTAN', 'Petani/Pekebun penyewa', 'TKI', 'Lainnya'] as $p)
                                            <option value="{{ $p }}"
                                                {{ old('pekerjaan_suami', $surat->pekerjaan_suami) == $p ? 'selected' : '' }}>
                                                {{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Suami</label>
                                <textarea name="alamat_suami" class="form-control" rows="3">{{ old('alamat_suami', $surat->alamat_suami) }}</textarea>
                            </div>

                            <h6 class="mt-4">Data Istri</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nama Istri <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_istri" class="form-control"
                                        value="{{ old('nama_istri', $surat->nama_istri) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir Istri</label>
                                    <input type="text" name="tempat_lahir_istri" class="form-control"
                                        value="{{ old('tempat_lahir_istri', $surat->tempat_lahir_istri) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir Istri</label>
                                    <input type="date" name="tanggal_lahir_istri" class="form-control"
                                        value="{{ old('tanggal_lahir_istri', $surat->tanggal_lahir_istri) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Pekerjaan Istri</label>
                                    <select name="pekerjaan_istri" class="form-control">
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'BIDAN', 'DOKTER', 'PERAWAT', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI/PERKEBUNAN', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'PENSIUNAN', 'PEMBANTU RUMAH TANGGA', 'BURUH PETERNAKAN', 'KONSTRUKSI', 'PELAUT', 'NELAYAN/PERIKANAN', 'KARYAWAN HONORER', 'PETERNAK', 'MEKANIK', 'PENATA RIAS', 'TUKANG LAS/PANDAI BESI', 'INDUSTRI', 'USTADZ/MUBALIGH', 'TABIB', 'BURUH NELAYAN/PERIKANAN', 'JURU MASAK', 'SENIMAN', 'AKUNTAN', 'Petani/Pekebun penyewa', 'TKI', 'Lainnya'] as $p)
                                            <option value="{{ $p }}"
                                                {{ old('pekerjaan_istri', $surat->pekerjaan_istri) == $p ? 'selected' : '' }}>
                                                {{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alamat Istri</label>
                                <textarea name="alamat_istri" class="form-control" rows="3">{{ old('alamat_istri', $surat->alamat_istri) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Negara Tujuan</label>
                                    <input type="text" name="negara_tujuan" class="form-control"
                                        value="{{ old('negara_tujuan', $surat->negara_tujuan) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Sebagai</label>
                                    <input type="text" name="sebagai" class="form-control"
                                        value="{{ old('sebagai', $surat->sebagai) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>No WhatsApp</label>
                                <input type="text" name="nowa" class="form-control"
                                    value="{{ old('nowa', $surat->nowa) }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat</label>
                                    <select name="status_surat" class="form-control">
                                        <option value="Pending" {{ $surat->status_surat == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Di cek" {{ $surat->status_surat == 'Di cek' ? 'selected' : '' }}>Di
                                            cek</option>
                                        <option value="Di terima"
                                            {{ $surat->status_surat == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                                        <option value="Ditolak" {{ $surat->status_surat == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi</label>
                                    <select name="status_verif" class="form-control">
                                        <option value="Belum Verifikasi"
                                            {{ $surat->status_verif == 'Belum Verifikasi' ? 'selected' : '' }}>Belum
                                            Verifikasi</option>
                                        <option value="Terverifikasi"
                                            {{ $surat->status_verif == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Surat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
