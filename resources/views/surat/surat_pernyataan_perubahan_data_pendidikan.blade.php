@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Form Surat Pernyataan Perubahan Data Pendidikan</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('surat.perubahdatapendidikan.store') }}" method="POST">
                            @csrf

                            <h6 class="fw-bold mb-2">Data Pemohon</h6>

                            <div class="mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                    value="{{ old('nik') }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ old('nama') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control"
                                        value="{{ old('ttl_tempat') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control"
                                        value="{{ old('ttl_tanggal') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Pekerjaan</label>
                                <select name="pekerjaan" class="form-control">
                                    <option value="">-- Pilih Pekerjaan --</option>
                                    @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'PETANI/PEKEBUN', 'BURUH TANI', 'PEDAGANG', 'PEGAWAI NEGERI SIPIL (PNS)', 'KARYAWAN HONORER', 'Lainnya'] as $job)
                                        <option value="{{ $job }}"
                                            {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                            </div>

                            <hr>
                            <h6 class="fw-bold mb-2">Data Perubahan Pendidikan</h6>

                            <div class="mb-3">
                                <label>Nama Subjek (Orang yang Datanya Diubah) <span class="text-danger">*</span></label>
                                <input type="text" name="nama_subjek" class="form-control"
                                    value="{{ old('nama_subjek') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Pendidikan Lama <span class="text-danger">*</span></label>
                                    <select name="pendidikan_lama" class="form-control" required>
                                        <option value="">-- Pilih Pendidikan Lama --</option>
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->nama }}"
                                                {{ old('pendidikan_lama') == $item->nama ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Pendidikan Baru <span class="text-danger">*</span></label>
                                    <select name="pendidikan_baru" class="form-control" required>
                                        <option value="">-- Pilih Pendidikan Baru --</option>
                                        @foreach ($pendidikan as $item)
                                            <option value="{{ $item->nama }}"
                                                {{ old('pendidikan_baru') == $item->nama ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Alasan Perubahan <span class="text-danger">*</span></label>
                                <textarea name="alasan_perubahan" class="form-control" rows="3" required>{{ old('alasan_perubahan') }}</textarea>
                            </div>

                            <hr>
                            <h6 class="fw-bold mb-2">Data Pendukung (Opsional)</h6>

                            <div class="mb-3">
                                <label>Jenis Data Pendukung</label>
                                <input type="text" name="jenis_data_pendukung" class="form-control"
                                    value="{{ old('jenis_data_pendukung') }}"
                                    placeholder="Contoh: Ijazah / Surat Keterangan Pengganti Ijazah">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Nomor Dokumen</label>
                                    <input type="text" name="nomor_dokumen_pendukung" class="form-control"
                                        value="{{ old('nomor_dokumen_pendukung') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Tanggal Diterbitkan</label>
                                    <input type="date" name="tanggal_diterbitkan" class="form-control"
                                        value="{{ old('tanggal_diterbitkan') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Instansi Penerbit</label>
                                <input type="text" name="instansi_penerbit" class="form-control"
                                    value="{{ old('instansi_penerbit') }}">
                            </div>

                            <div class="mb-3">
                                <label>No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}"
                                    required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Status Surat</label>
                                    <select name="status_surat" class="form-control" required>
                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('status_surat', 'Pending') == $st ? 'selected' : '' }}>
                                                {{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status Verifikasi</label>
                                    <select name="status_verif" class="form-control" required>
                                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $sv)
                                            <option value="{{ $sv }}"
                                                {{ old('status_verif', 'Belum Verifikasi') == $sv ? 'selected' : '' }}>
                                                {{ $sv }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function autofillPerubahanPendidikan() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
                        document.getElementById('ttl_tanggal').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0,
                            10) : '';
                        document.getElementById('alamat').value = d.alamat || '';
                        document.getElementById('pekerjaan').value = d.pekerjaan || '';
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');
            if (nikInput) nikInput.addEventListener('blur', autofillPerubahanPendidikan);
        });
    </script>
@endsection
