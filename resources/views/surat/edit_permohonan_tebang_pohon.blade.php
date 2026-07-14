@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Permohonan Tebang Pohon</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.permohonan_tebang_pohon.update', $surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Pemohon</h5>

                    <div class="mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" required maxlength="20"
                            inputmode="numeric" value="{{ old('nik', $surat->nik) }}">
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" required
                            value="{{ old('nama', $surat->nama) }}">
                    </div>

                    <div class="mb-3">
                        <label>Jabatan / Posisi <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan" class="form-control" required
                            value="{{ old('jabatan', $surat->jabatan) }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $surat->alamat) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>No. HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" required
                                value="{{ old('no_hp', $surat->no_hp) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required
                                value="{{ old('nowa', $surat->nowa) }}">
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Alasan Permohonan Tebang Pohon</h5>

                    <div class="mb-3">
                        <label>Alasan Tebang Pohon <span class="text-danger">*</span></label>
                        <textarea name="alasan_tebang" class="form-control" rows="5" required>{{ old('alasan_tebang', $surat->alasan_tebang) }}</textarea>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control">
                                <option value="Pending"
                                    {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="Di cek"
                                    {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek
                                </option>
                                <option value="Di Terima"
                                    {{ old('status_surat', $surat->status_surat) == 'Di Terima' ? 'selected' : '' }}>Di
                                    Terima
                                </option>
                                <option value="Di Tolak"
                                    {{ old('status_surat', $surat->status_surat) == 'Di Tolak' ? 'selected' : '' }}>Di
                                    Tolak
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
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

                    <div class="text-end mt-4">
                        <a href="{{ route('surat.keluar') }}" class="btn btn-danger">Kembali</a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">Update Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Autofill Script --}}
    <script>
        function autofillTebangPohon() {
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

        document.getElementById('nik').addEventListener('blur', autofillTebangPohon);
    </script>
@endsection
