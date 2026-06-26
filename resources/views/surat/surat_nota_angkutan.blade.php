@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Nota Angkutan Hasil Hutan Kayu</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.nota_angkutan.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Pengirim / Pemilik</h5>
                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric" value="{{ old('nik') }}">
                        <small>Isi NIK lalu tab/keluar untuk autofill</small>
                    </div>
                    <div class="mb-3">
                        <label>Nama Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pengirim" id="nama" class="form-control" required value="{{ old('nama_pengirim') }}">
                    </div>
                    <div class="mb-3">
                        <label>Alamat Pengirim <span class="text-danger">*</span></label>
                        <textarea name="alamat_pengirim" id="alamat" class="form-control" rows="2" required>{{ old('alamat_pengirim') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Bukti Kepemilikan</label>
                            <input type="text" name="bukti_kepemilikan" class="form-control" required value="{{ old('bukti_kepemilikan') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor Bukti Kepemilikan</label>
                            <input type="text" name="nomor_bukti_kepemilikan" class="form-control" required value="{{ old('nomor_bukti_kepemilikan') }}">
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Data Angkutan</h5>
                    <div class="mb-3">
                        <label>Jenis Kayu <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_kayu" class="form-control" required value="{{ old('jenis_kayu') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Jumlah (batang/ikat)</label>
                            <input type="text" name="jumlah" class="form-control" required value="{{ old('jumlah') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Volume (m³)</label>
                            <input type="text" name="volume" class="form-control" required value="{{ old('volume') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Alat Angkut</label>
                            <input type="text" name="alat_angkut" class="form-control" required value="{{ old('alat_angkut') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Tempat Muat</label>
                        <input type="text" name="tempat_muat" class="form-control" required value="{{ old('tempat_muat') }}">
                    </div>

                    <h5 class="mb-3 mt-4">Data Penerima / Tujuan</h5>
                    <div class="mb-3">
                        <label>Nama Penerima <span class="text-danger">*</span></label>
                        <input type="text" name="nama_penerima" class="form-control" required value="{{ old('nama_penerima') }}">
                    </div>
                    <div class="mb-3">
                        <label>Alamat Penerima <span class="text-danger">*</span></label>
                        <textarea name="alamat_penerima" class="form-control" rows="2" required>{{ old('alamat_penerima') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Mulai Berlaku</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required value="{{ old('tanggal_mulai') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Selesai Berlaku</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required value="{{ old('tanggal_selesai') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control" required>
                                <option value="Pending">Pending</option>
                                <option value="Di cek">Di cek</option>
                                <option value="Di terima">Di terima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi</label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi">Belum Verifikasi</option>
                                <option value="Terverifikasi">Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Simpan Surat</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function autofillNotaAngkutan() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('alamat').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }

        document.getElementById('nik').addEventListener('blur', autofillNotaAngkutan);
        document.getElementById('nik').addEventListener('change', autofillNotaAngkutan);
    </script>
@endsection
