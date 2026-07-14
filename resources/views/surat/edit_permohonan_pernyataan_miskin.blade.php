@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Permohonan Pernyataan Miskin</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.permohonan_pernyataan_miskin.update', $surat) }}" method="POST">
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
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                            value="{{ old('nama_lengkap', $surat->nama_lengkap) }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $surat->alamat) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>No. HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" class="form-control" required
                                value="{{ old('no_hp', $surat->no_hp) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor WA <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required
                                value="{{ old('nowa', $surat->nowa) }}">
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Data Pasien / Yang Dirawat</h5>

                    <div class="mb-3">
                        <label>Nama Pasien <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pasien" class="form-control" required
                            value="{{ old('nama_pasien', $surat->nama_pasien) }}">
                    </div>

                    <div class="mb-3">
                        <label>Alamat Pasien <span class="text-danger">*</span></label>
                        <textarea name="alamat_pasien" class="form-control" rows="2" required>{{ old('alamat_pasien', $surat->alamat_pasien) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Diagnosa Medis <span class="text-danger">*</span></label>
                        <textarea name="diagnosa" class="form-control" rows="3" required>{{ old('diagnosa', $surat->diagnosa) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Rumah Sakit Tujuan <span class="text-danger">*</span></label>
                        <input type="text" name="rumah_sakit_tujuan" class="form-control" required
                            value="{{ old('rumah_sakit_tujuan', $surat->rumah_sakit_tujuan) }}">
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
                                    {{ old('status_surat', $surat->status_surat) == 'Di Terima' ? 'selected' : '' }}>Di Terima
                                </option>
                                <option value="Di Tolak"
                                    {{ old('status_surat', $surat->status_surat) == 'Di Tolak' ? 'selected' : '' }}>Di Tolak
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

    {{-- Autofill Script (opsional, tetap bisa digunakan saat edit) --}}
    <script>
        function autofillPermohonanMiskin() {
            const nik = document.getElementById('nik').value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success && result.data) {
                        const d = result.data;
                        document.getElementById('nama_lengkap').value = d.nama || '';
                        document.getElementById('alamat').value = d.alamat || '';
                    }
                })
                .catch(err => console.error('Autofill error:', err));
        }

        document.getElementById('nik').addEventListener('blur', autofillPermohonanMiskin);
    </script>
@endsection
