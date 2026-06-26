@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Undangan</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.undangan.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Kepada Yth <span class="text-danger">*</span></label>
                        <input type="text" name="kepada_yth" class="form-control" required
                            value="{{ old('kepada_yth') }}">
                    </div>

                    <div class="mb-3">
                        <label>Perihal <span class="text-danger">*</span></label>
                        <input type="text" name="perihal" class="form-control" required value="{{ old('perihal') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Hari <span class="text-danger">*</span></label>
                            <input type="text" name="hari" class="form-control" required value="{{ old('hari') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Tanggal Acara <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_acara" class="form-control" required
                                value="{{ old('tanggal_acara') }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Jam <span class="text-danger">*</span></label>
                            <input type="text" name="jam" class="form-control" required value="{{ old('jam') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Tempat <span class="text-danger">*</span></label>
                        <input type="text" name="tempat" class="form-control" required value="{{ old('tempat') }}">
                    </div>

                    <div class="mb-3">
                        <label>Acara <span class="text-danger">*</span></label>
                        <textarea name="acara" class="form-control" rows="3" required>{{ old('acara') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Keterangan Tambahan</label>
                        <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ old('keterangan_tambahan') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control" required>
                                <option value="Pending"
                                    {{ old('status_surat', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Di cek">Di cek</option>
                                <option value="Di terima">Di terima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi"
                                {{ old('status_verif', 'Belum Verifikasi') == 'Belum Verifikasi' ? 'selected' : '' }}>Belum
                                Verifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                        </select>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-5">Simpan Surat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
