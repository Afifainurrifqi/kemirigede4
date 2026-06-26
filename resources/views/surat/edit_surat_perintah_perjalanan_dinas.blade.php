@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Perintah Perjalanan Dinas (SPPD)</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.perintah_perjalanan_dinas.update', $surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Pegawai yang Diperintah</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Pegawai <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pegawai" class="form-control"
                                value="{{ old('nama_pegawai', $surat->nama_pegawai) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Pangkat / Golongan</label>
                            <input type="text" name="pangkat_golongan" class="form-control"
                                value="{{ old('pangkat_golongan', $surat->pangkat_golongan) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control"
                                value="{{ old('jabatan', $surat->jabatan) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Instansi</label>
                            <input type="text" name="instansi" class="form-control"
                                value="{{ old('instansi', $surat->instansi) }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="mb-3">Detail Perjalanan Dinas</h5>
                    <div class="mb-3">
                        <label>Maksud Perjalanan Dinas <span class="text-danger">*</span></label>
                        <textarea name="maksud_perjalanan" class="form-control" rows="3" required>
                            {{ old('maksud_perjalanan', $surat->maksud_perjalanan) }}
                        </textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Alat Angkutan Yang Digunakan</label>
                            <input type="text" name="alat_angkutan" class="form-control"
                                value="{{ old('alat_angkutan', $surat->alat_angkutan) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Lama Perjalanan (Hari) <span class="text-danger">*</span></label>
                            <input type="text" name="lama_perjalanan" class="form-control"
                                value="{{ old('lama_perjalanan', $surat->lama_perjalanan) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Tempat Berangkat</label>
                            <input type="text" name="tempat_berangkat" class="form-control"
                                value="{{ old('tempat_berangkat', $surat->tempat_berangkat) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tempat Tujuan <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_tujuan" class="form-control"
                                value="{{ old('tempat_tujuan', $surat->tempat_tujuan) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Sumber Anggaran</label>
                            <input type="text" name="sumber_anggaran" class="form-control"
                                value="{{ old('sumber_anggaran', $surat->sumber_anggaran) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Berangkat <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berangkat" class="form-control"
                                value="{{ old('tanggal_berangkat', $surat->tanggal_berangkat?->format('Y-m-d')) }}"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Harus Kembali <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_kembali" class="form-control"
                                value="{{ old('tanggal_kembali', $surat->tanggal_kembali?->format('Y-m-d')) }}" required>
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
                                @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status_surat', $surat->status_surat) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi</label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi"
                                    {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>
                                    Belum Verifikasi
                                </option>
                                <option value="Terverifikasi"
                                    {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>
                                    Terverifikasi
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-5">Update Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
