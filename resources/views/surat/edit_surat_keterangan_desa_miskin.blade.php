@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Desa Miskin</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat.miskindesa.update', $surat->_id ?? $surat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Pemohon</h5>

                <div class="mb-3">
                    <label for="nik" class="form-label">Nomor NIK <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric"
                        value="{{ old('nik', $surat->nik) }}">
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama" class="form-control" required
                        value="{{ old('nama', $surat->nama) }}">
                </div>

                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                        value="{{ old('tempat_lahir', $surat->tempat_lahir) }}">
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                        value="{{ old('tanggal_lahir', !empty($surat->tanggal_lahir) ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    @php $jk = old('jenis_kelamin', $surat->jenis_kelamin); @endphp
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach (['Laki-laki', 'Perempuan'] as $opt)
                            <option value="{{ $opt }}" {{ $jk == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                    @php $kw = old('kewarganegaraan', $surat->kewarganegaraan); @endphp
                    <select name="kewarganegaraan" id="kewarganegaraan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach (['WNI', 'WNA'] as $opt)
                            <option value="{{ $opt }}" {{ $kw == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Tempat Tinggal / Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $surat->alamat) }}</textarea>
                </div>

                <hr class="my-4">

                <h5 class="mb-3">Informasi Surat</h5>

                <div class="mb-3">
                    <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                    <input type="text" name="keperluan" id="keperluan" class="form-control" required
                        value="{{ old('keperluan', $surat->keperluan) }}">
                </div>

                <div class="mb-3">
                    <label for="status_surat" class="form-label">Status Surat <span class="text-danger">*</span></label>
                    @php $ss = old('status_surat', $surat->status_surat); @endphp
                    <select name="status_surat" id="status_surat" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $opt)
                            <option value="{{ $opt }}" {{ $ss == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status_verif" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                    @php $sv = old('status_verif', $surat->status_verif); @endphp
                    <select name="status_verif" id="status_verif" class="form-control" required>
                        <option value="">-- Pilih Verifikasi --</option>
                        @foreach (['Belum Verifikasi', 'Terverifikasi'] as $opt)
                            <option value="{{ $opt }}" {{ $sv == $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required
                        value="{{ old('nowa', $surat->nowa) }}">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                    <a href="{{ route('surat.miskindesa.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
