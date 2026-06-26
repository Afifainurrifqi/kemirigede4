@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Kematian Desa</h4>

            <form action="{{ route('surat.kematian.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Almarhum</h5>

                <div class="mb-3">
                    <label for="nik" class="form-label">NIK Almarhum</label>
                    <input type="text" name="nik" id="nik" class="form-control"
                           value="{{ old('nik', $surat->nik) }}">
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required
                           value="{{ old('nama_lengkap', $surat->nama_lengkap) }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" required
                               value="{{ old('kewarganegaraan', $surat->kewarganegaraan ?? 'Indonesia') }}">
                    </div>
                </div>

                <!-- STATUS PERKAWINAN (Dropdown Master) -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Pilih Status Perkawinan --</option>
                        @foreach ($status as $item)
                            @php $statusId = (string) ($item->_id ?? $item->id); @endphp
                            <option value="{{ $statusId }}"
                                {{ old('status', $surat->status) == $statusId ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PEKERJAAN (Dropdown Master) -->
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach ($pekerjaan as $item)
                            @php $jobId = (string) ($item->_id ?? $item->id); @endphp
                            <option value="{{ $jobId }}"
                                {{ old('pekerjaan', $surat->pekerjaan) == $jobId ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                </div>

                <h5 class="mb-3">Keterangan Meninggal</h5>

                <div class="mb-3">
                    <label for="hari" class="form-label">Hari <span class="text-danger">*</span></label>
                    <input type="text" name="hari" id="hari" class="form-control" required
                           value="{{ old('hari', $surat->hari) }}">
                </div>

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Meninggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required
                           value="{{ old('tanggal', $surat->tanggal ? \Carbon\Carbon::parse($surat->tanggal)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label for="penyebab" class="form-label">Disebabkan Karena <span class="text-danger">*</span></label>
                    <input type="text" name="penyebab" id="penyebab" class="form-control" required
                           value="{{ old('penyebab', $surat->penyebab) }}">
                </div>

                <div class="mb-3">
                    <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required
                           value="{{ old('nowa', $surat->nowa) }}">
                </div>

                <!-- Status Surat & Verifikasi -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat <span class="text-danger">*</span></label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
