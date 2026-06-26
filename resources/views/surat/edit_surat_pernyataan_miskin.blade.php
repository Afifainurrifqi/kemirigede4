@extends('layout.main2')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Edit Surat Pernyataan Miskin</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('surat.pernyataan_miskin.update', $surat->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" id="nik" class="form-control"
                                        value="{{ old('nik', $surat->nik) }}" onkeyup="autofillMiskinEdit()" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama" id="nama" class="form-control"
                                        value="{{ old('nama', $surat->nama) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir', $surat->tempat_lahir) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                                        value="{{ old('tanggal_lahir', $surat->tanggal_lahir) }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Pekerjaan <span class="text-danger">*</span></label>
                                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                        <option value="">-- Pilih Pekerjaan --</option>
                                        @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TNI', 'POLRI', 'DOSEN', 'GURU', 'KEPALA DESA', 'PERANGKAT DESA', 'Pegawai Kantor Desa', 'BIDAN', 'DOKTER', 'PERAWAT', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI/PERKEBUNAN', 'PEDAGANG', 'PNS', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'PENSIUNAN', 'PEMBANTU RUMAH TANGGA', 'BURUH PETERNAKAN', 'KONSTRUKSI', 'PELAUT', 'NELAYAN/PERIKANAN', 'KARYAWAN HONORER', 'PETERNAK', 'MEKANIK', 'PENATA RIAS', 'TUKANG LAS/PANDAI BESI', 'INDUSTRI', 'USTADZ/MUBALIGH', 'TABIB', 'BURUH NELAYAN/PERIKANAN', 'JURU MASAK', 'SENIMAN', 'AKUNTAN', 'Petani/Pekebun penyewa', 'TKI', 'Lainnya'] as $p)
                                            <option value="{{ $p }}"
                                                {{ old('pekerjaan', $surat->pekerjaan) == $p ? 'selected' : '' }}>
                                                {{ $p }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>No WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" name="nowa" class="form-control"
                                        value="{{ old('nowa', $surat->nowa) }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $surat->alamat) }}</textarea>
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

                            <button type="submit" class="btn btn-warning">Update Surat</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function autofillMiskinEdit() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                        document.getElementById('tanggal_lahir').value = d.tanggal_lahir || '';
                        if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                        document.getElementById('alamat').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }
    </script>
@endsection
