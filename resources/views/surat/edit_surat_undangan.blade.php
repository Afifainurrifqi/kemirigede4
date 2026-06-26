@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Edit Surat Undangan</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.undangan.update', $surat) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="mb-3">Data Undangan</h5>

                    <div class="mb-3">
                        <label>Kepada Yth <span class="text-danger">*</span></label>
                        <input type="text" name="kepada_yth" class="form-control"
                            value="{{ old('kepada_yth', $surat->kepada_yth) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Perihal <span class="text-danger">*</span></label>
                        <input type="text" name="perihal" class="form-control"
                            value="{{ old('perihal', $surat->perihal) }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Hari <span class="text-danger">*</span></label>
                            <input type="text" name="hari" class="form-control"
                                value="{{ old('hari', $surat->hari) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Acara <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_acara" class="form-control"
                                value="{{ old('tanggal_acara', $surat->tanggal_acara?->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Jam <span class="text-danger">*</span></label>
                            <input type="text" name="jam" class="form-control" value="{{ old('jam', $surat->jam) }}"
                                required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Tempat <span class="text-danger">*</span></label>
                        <input type="text" name="tempat" class="form-control"
                            value="{{ old('tempat', $surat->tempat) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Acara <span class="text-danger">*</span></label>
                        <textarea name="acara" class="form-control" rows="3" required>
                            {{ old('acara', $surat->acara) }}
                        </textarea>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" class="form-control" rows="2">
                            {{ old('keterangan_tambahan', $surat->keterangan_tambahan) }}
                        </textarea>
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
