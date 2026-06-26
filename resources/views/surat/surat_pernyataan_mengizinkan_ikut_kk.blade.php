@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
    <div class="row">
        <div class="col-lg-12 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Form Surat Pernyataan Mengizinkan Ikut KK</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ route('surat.izinkk.store') }}" method="POST">
                        @csrf

                        <h6 class="fw-bold mb-2">Data Pemohon (Orang yang Memberi Izin)</h6>

                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control" value="{{ old('ttl_tempat') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control" value="{{ old('ttl_tanggal') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan" class="form-control">
                                <option value="">-- Pilih --</option>
                                @foreach(['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','PETANI/PEKEBUN','BURUH TANI','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','KARYAWAN HONORER','Lainnya'] as $job)
                                    <option value="{{ $job }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Data Orang yang Diizinkan</h6>

                        <div class="mb-3">
                            <label>Nama <span class="text-danger">*</span></label>
                            <input type="text" name="nama_izin" class="form-control" value="{{ old('nama_izin') }}" required>
                        </div>
                        <div class="mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik_izin" class="form-control" value="{{ old('nik_izin') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir</label>
                                <input type="text" name="ttl_tempat_izin" class="form-control" value="{{ old('ttl_tempat_izin') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal_izin" class="form-control" value="{{ old('ttl_tanggal_izin') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat_izin" class="form-control" rows="2" required>{{ old('alamat_izin') }}</textarea>
                        </div>

                        <hr>
                        <h6 class="fw-bold mb-2">Pernyataan Izin Pindah</h6>

                        <div class="mb-3">
                            <label>Tujuan Pindah <span class="text-danger">*</span></label>
                            <input type="text" name="tujuan_pindah" class="form-control" value="{{ old('tujuan_pindah') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alasan Pindah <span class="text-danger">*</span></label>
                            <textarea name="alasan_pindah" class="form-control" rows="3" required>{{ old('alasan_pindah') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control" required>
                                    @foreach(['Pending','Di cek','Di terima','Ditolak'] as $st)
                                        <option value="{{ $st }}" {{ old('status_surat', 'Pending') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control" required>
                                    @foreach(['Belum Verifikasi','Terverifikasi'] as $sv)
                                        <option value="{{ $sv }}" {{ old('status_verif', 'Belum Verifikasi') == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillIzinKk() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;
        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
                    document.getElementById('ttl_tanggal').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0,10) : '';
                    document.getElementById('alamat').value = d.alamat || '';
                    document.getElementById('pekerjaan').value = d.pekerjaan || '';
                }
            });
    }
    document.addEventListener('DOMContentLoaded', function() {
        const nikInput = document.getElementById('nik');
        if (nikInput) nikInput.addEventListener('blur', autofillIzinKk);
    });
</script>
@endsection
