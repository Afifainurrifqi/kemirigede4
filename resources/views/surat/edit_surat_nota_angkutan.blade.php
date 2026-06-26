@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Nota Angkutan Hasil Hutan Kayu</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.nota_angkutan.update', $surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Pengirim / Pemilik</h5>

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control"
                            value="{{ old('nik', $surat->nik) }}" required maxlength="16" inputmode="numeric">
                        <small class="text-muted">Ubah NIK lalu tab/keluar untuk autofill data penduduk.</small>
                    </div>

                    <div class="mb-3">
                        <label>Nama Pengirim <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pengirim" id="nama" class="form-control"
                            value="{{ old('nama_pengirim', $surat->nama_pengirim) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Alamat Pengirim <span class="text-danger">*</span></label>
                        <textarea name="alamat_pengirim" id="alamat" class="form-control" rows="3" required>
                            {{ old('alamat_pengirim', $surat->alamat_pengirim) }}
                        </textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Bukti Kepemilikan</label>
                            <input type="text" name="bukti_kepemilikan" class="form-control"
                                value="{{ old('bukti_kepemilikan', $surat->bukti_kepemilikan) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor Bukti Kepemilikan</label>
                            <input type="text" name="nomor_bukti_kepemilikan" class="form-control"
                                value="{{ old('nomor_bukti_kepemilikan', $surat->nomor_bukti_kepemilikan) }}" required>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Data Angkutan</h5>
                    <div class="mb-3">
                        <label>Jenis Kayu <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_kayu" class="form-control"
                            value="{{ old('jenis_kayu', $surat->jenis_kayu) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Jumlah (batang/ikat)</label>
                            <input type="text" name="jumlah" class="form-control"
                                value="{{ old('jumlah', $surat->jumlah) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Volume (m³)</label>
                            <input type="text" name="volume" class="form-control"
                                value="{{ old('volume', $surat->volume) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Alat Angkut</label>
                            <input type="text" name="alat_angkut" class="form-control"
                                value="{{ old('alat_angkut', $surat->alat_angkut) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Tempat Muat</label>
                        <input type="text" name="tempat_muat" class="form-control"
                            value="{{ old('tempat_muat', $surat->tempat_muat) }}" required>
                    </div>

                    <h5 class="mb-3 mt-4">Data Penerima / Tujuan</h5>
                    <div class="mb-3">
                        <label>Nama Penerima <span class="text-danger">*</span></label>
                        <input type="text" name="nama_penerima" class="form-control"
                            value="{{ old('nama_penerima', $surat->nama_penerima) }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat Penerima <span class="text-danger">*</span></label>
                        <textarea name="alamat_penerima" class="form-control" rows="2" required>
                            {{ old('alamat_penerima', $surat->alamat_penerima) }}
                        </textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Mulai Berlaku</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ old('tanggal_mulai', $surat->tanggal_mulai?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Selesai Berlaku</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ old('tanggal_selesai', $surat->tanggal_selesai?->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
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
        function autofillNotaAngkutanEdit() {
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

        document.getElementById('nik').addEventListener('blur', autofillNotaAngkutanEdit);
        document.getElementById('nik').addEventListener('change', autofillNotaAngkutanEdit);
    </script>
@endsection
