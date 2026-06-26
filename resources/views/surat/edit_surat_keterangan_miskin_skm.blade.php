@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Miskin (SKM)</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat.skm.update', $surat->_id ?? $surat->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Pemohon</h5>

                <div class="mb-3">
                    <label for="nik" class="form-label">NIK</label>
                    <input type="text" name="nik" id="nik" class="form-control" required maxlength="16" inputmode="numeric"
                        value="{{ old('nik', $surat->nik ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required
                        value="{{ old('nama', $surat->nama ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required
                        value="{{ old('tempat_lahir', $surat->tempat_lahir ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required
                        value="{{ old('tanggal_lahir', !empty($surat->tanggal_lahir) ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d') : '') }}">
                </div>

                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    @php
                        $pk = old('pekerjaan', $surat->pekerjaan ?? '');
                        $jobs = [
                            'BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA',
                            'WIRASWASTA','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN',
                            'PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','BURUH HARIAN LEPAS',
                            'SOPIR','KARYAWAN BUMN','PENSIUNAN','KARYAWAN HONORER','TUKANG BATU','Lainnya'
                        ];
                    @endphp
                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach ($jobs as $job)
                            <option value="{{ $job }}" {{ $pk == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $surat->alamat ?? '') }}</textarea>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label for="status_surat" class="form-label">Status Surat</label>
                    @php $ss = old('status_surat', $surat->status_surat ?? 'Pending'); @endphp
                    <select name="status_surat" id="status_surat" class="form-control" required>
                        @foreach (['Pending','Di cek','Di terima','Ditolak'] as $opt)
                            <option value="{{ $opt }}" {{ $ss == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status_verif" class="form-label">Status Verifikasi</label>
                    @php $sv = old('status_verif', $surat->status_verif ?? 'Belum Verifikasi'); @endphp
                    <select name="status_verif" id="status_verif" class="form-control" required>
                        @foreach (['Belum Verifikasi','Terverifikasi'] as $opt)
                            <option value="{{ $opt }}" {{ $sv == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nowa" class="form-label">No WhatsApp</label>
                    <input type="text" name="nowa" id="nowa" class="form-control" required
                        value="{{ old('nowa', $surat->nowa ?? '') }}">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                    <a href="{{ route('surat.skm.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
