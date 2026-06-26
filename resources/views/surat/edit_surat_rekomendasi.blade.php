@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Rekomendasi</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.rekomendasi.update', $surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control"
                            value="{{ old('nik', $surat->nik) }}" required maxlength="16" inputmode="numeric">
                        <small class="text-muted">Ubah NIK lalu tab/keluar untuk autofill.</small>
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ old('nama', $surat->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required>
                            {{ old('alamat', $surat->alamat) }}
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label>Perihal <span class="text-danger">*</span></label>
                        <input type="text" name="perihal" class="form-control"
                            value="{{ old('perihal', $surat->perihal) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Kegiatan / Acara <span class="text-danger">*</span></label>
                        <input type="text" name="kegiatan" class="form-control"
                            value="{{ old('kegiatan', $surat->kegiatan) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ old('tanggal_mulai', $surat->tanggal_mulai?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ old('tanggal_selesai', $surat->tanggal_selesai?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Waktu</label>
                            <input type="text" name="waktu" class="form-control"
                                value="{{ old('waktu', $surat->waktu) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Tempat</label>
                        <input type="text" name="tempat" class="form-control"
                            value="{{ old('tempat', $surat->tempat) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Keperluan</label>
                        <textarea name="keperluan" class="form-control" rows="3" required>
                            {{ old('keperluan', $surat->keperluan) }}
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp</label>
                        <input type="text" name="nowa" class="form-control" value="{{ old('nowa', $surat->nowa) }}"
                            required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
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

                    <button type="submit" class="btn btn-primary btn-lg w-100">Update Surat</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function autofillRekomendasiEdit() {
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

        document.getElementById('nik').addEventListener('blur', autofillRekomendasiEdit);
        document.getElementById('nik').addEventListener('change', autofillRekomendasiEdit);
    </script>
@endsection
