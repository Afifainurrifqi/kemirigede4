@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Perintah Tugas</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.perintah_tugas.update', $surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Penerima Tugas</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Penerima <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penerima" class="form-control"
                                   value="{{ old('nama_penerima', $surat->nama_penerima) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan_penerima" class="form-control"
                                   value="{{ old('jabatan_penerima', $surat->jabatan_penerima) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>NIK (Opsional)</label>
                        <input type="text" name="nik_penerima" class="form-control" maxlength="16"
                               value="{{ old('nik_penerima', $surat->nik_penerima) }}">
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Detail Kegiatan</h5>

                    <div class="mb-3">
                        <label>Untuk Mengikuti / Melaksanakan <span class="text-danger">*</span></label>
                        <textarea name="untuk_mengikuti" class="form-control" rows="3" required>
                            {{ old('untuk_mengikuti', $surat->untuk_mengikuti) }}
                        </textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Hari <span class="text-danger">*</span></label>
                            <input type="text" name="hari" class="form-control"
                                   value="{{ old('hari', $surat->hari) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Kegiatan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kegiatan" class="form-control"
                                   value="{{ old('tanggal_kegiatan', $surat->tanggal_kegiatan?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="time" name="waktu_mulai" class="form-control"
                                   value="{{ old('waktu_mulai', $surat->waktu_mulai) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Tempat Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_kegiatan" class="form-control"
                               value="{{ old('tempat_kegiatan', $surat->tempat_kegiatan) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan Tambahan</label>
                        <textarea name="keterangan_tugas" class="form-control" rows="2">
                            {{ old('keterangan_tugas', $surat->keterangan_tugas) }}
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label>Dasar Surat</label>
                        <div id="dasarContainer">
                            @if ($surat->dasar && count($surat->dasar) > 0)
                                @foreach ($surat->dasar as $item)
                                    <input type="text" name="dasar[]" class="form-control mb-2"
                                           value="{{ $item }}">
                                @endforeach
                            @else
                                <input type="text" name="dasar[]" class="form-control mb-2" placeholder="Dasar 1">
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addDasar()">+ Tambah Dasar</button>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Informasi Surat</h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control"
                                   value="{{ old('nowa', $surat->nowa) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control" required>
                                @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status_surat', $surat->status_surat) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>
                                Belum Verifikasi
                            </option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>
                                Terverifikasi
                            </option>
                        </select>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">Update Surat</button>
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
