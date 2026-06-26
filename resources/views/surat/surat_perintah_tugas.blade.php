@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Perintah Tugas</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.perintah_tugas.store') }}" method="POST">
                    @csrf

                    <h5 class="mb-3">Data Penerima Tugas</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penerima" id="nama_penerima" class="form-control" required
                                value="{{ old('nama_penerima') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jabatan_penerima" class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan_penerima" id="jabatan_penerima" class="form-control" required
                                value="{{ old('jabatan_penerima') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nik_penerima" class="form-label">NIK (Opsional)</label>
                        <input type="text" name="nik_penerima" id="nik_penerima" class="form-control" maxlength="16"
                            value="{{ old('nik_penerima') }}">
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Detail Tugas / Kegiatan</h5>

                    <div class="mb-3">
                        <label for="untuk_mengikuti" class="form-label">Untuk Mengikuti / Melaksanakan <span class="text-danger">*</span></label>
                        <textarea name="untuk_mengikuti" id="untuk_mengikuti" class="form-control" rows="3" required>{{ old('untuk_mengikuti') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                            <input type="text" name="hari" id="hari" class="form-control" required value="{{ old('hari') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kegiatan" id="tanggal_kegiatan" class="form-control" required
                                value="{{ old('tanggal_kegiatan') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control" required
                                value="{{ old('waktu_mulai') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tempat_kegiatan" class="form-label">Tempat Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_kegiatan" id="tempat_kegiatan" class="form-control" required
                            value="{{ old('tempat_kegiatan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_tugas" class="form-label">Keterangan Tambahan</label>
                        <textarea name="keterangan_tugas" id="keterangan_tugas" class="form-control" rows="2">{{ old('keterangan_tugas') }}</textarea>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Dasar Surat (bisa ditambah)</h5>
                    <div id="dasarContainer">
                        <input type="text" name="dasar[]" class="form-control mb-2" placeholder="Dasar 1" value="{{ old('dasar.0') }}">
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addDasar()">+ Tambah Dasar</button>

                    <hr class="my-4">

                    <h5 class="mb-3">Informasi Surat</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" id="nowa" class="form-control" required value="{{ old('nowa') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status_surat" class="form-label">Status Surat</label>
                            <select name="status_surat" id="status_surat" class="form-control" required>
                                @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                    <option value="{{ $status }}" {{ old('status_surat', 'Pending') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status_verif" class="form-label">Status Verifikasi</label>
                        <select name="status_verif" id="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', 'Belum Verifikasi') == 'Belum Verifikasi' ? 'selected' : '' }}>
                                Belum Verifikasi
                            </option>
                            <option value="Terverifikasi" {{ old('status_verif') == 'Terverifikasi' ? 'selected' : '' }}>
                                Terverifikasi
                            </option>
                        </select>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">Simpan Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addDasar() {
            const container = document.getElementById('dasarContainer');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'dasar[]';
            input.className = 'form-control mb-2';
            input.placeholder = 'Dasar baru';
            container.appendChild(input);
        }
    </script>
@endsection
