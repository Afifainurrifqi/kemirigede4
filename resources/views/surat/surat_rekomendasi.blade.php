@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Rekomendasi</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.rekomendasi.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="16"
                            inputmode="numeric" value="{{ old('nik') }}">
                        <small class="text-muted">Isi NIK lalu klik/tab keluar untuk autofill.</small>
                    </div>

                    <div class="mb-3">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" required
                            value="{{ old('nama') }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>

                    <!-- Sisanya sama seperti sebelumnya -->
                    <div class="mb-3">
                        <label>Perihal <span class="text-danger">*</span></label>
                        <input type="text" name="perihal" class="form-control" required value="{{ old('perihal') }}">
                    </div>
                    <div class="mb-3">
                        <label>Kegiatan / Acara <span class="text-danger">*</span></label>
                        <input type="text" name="kegiatan" class="form-control" required value="{{ old('kegiatan') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required
                                value="{{ old('tanggal_mulai') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" required
                                value="{{ old('tanggal_selesai') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Waktu</label>
                            <input type="text" name="waktu" class="form-control" required value="{{ old('waktu') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control" required value="{{ old('tempat') }}">
                    </div>

                    <div class="mb-3">
                        <label>Keperluan</label>
                        <textarea name="keperluan" class="form-control" rows="3" required>{{ old('keperluan') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                    </div>

                    <!-- Status fields for admin -->
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
        function autofillRekomendasi() {
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

        document.getElementById('nik').addEventListener('blur', autofillRekomendasi);
        document.getElementById('nik').addEventListener('change', autofillRekomendasi);
    </script>
@endsection
