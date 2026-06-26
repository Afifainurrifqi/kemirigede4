@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header text-dark">
                    <h5 class="mb-0">Edit Surat Keterangan Domisili Warga</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('surat.domisili_warga.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK</label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       value="{{ $surat->nik ?? old('nik') }}" onkeyup="autofillDomisiliEdit()">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap"
                                       class="form-control" value="{{ $surat->nama_lengkap ?? old('nama_lengkap') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="Laki-Laki" {{ ($surat->jenis_kelamin ?? old('jenis_kelamin')) == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ ($surat->jenis_kelamin ?? old('jenis_kelamin')) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                       class="form-control" value="{{ $surat->tempat_lahir ?? old('tempat_lahir') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                       class="form-control" value="{{ $surat->tanggal_lahir ?? old('tanggal_lahir') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Agama <span class="text-danger">*</span></label>
                                <select name="agama" id="agama" class="form-control" required>
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $ag)
                                        <option value="{{ $ag }}" {{ ($surat->agama ?? old('agama')) === $ag ? 'selected' : '' }}>{{ $ag }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">-- Pilih Status --</option>
                                    @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                        <option value="{{ $st }}" {{ ($surat->status ?? old('status')) === $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Pekerjaan <span class="text-danger">*</span></label>
                                <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                    <option value="">-- Pilih pekerjaan --</option>
                                    @php
                                        $jobs = [
                                            'BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH',
                                            'KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA',
                                            'TENTARA NASIONAL INDONESIA (TNI)','KEPOLISIAN RI (POLRI)',
                                            'DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','BIDAN',
                                            'DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN',
                                            'BURUH TANI/PERKEBUNAN','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)',
                                            'BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN',
                                            'PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI',
                                            'PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK',
                                            'MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI',
                                            'USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN',
                                            'JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa',
                                            'TKI','Lainnya',
                                        ];
                                    @endphp
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}" {{ ($surat->pekerjaan ?? old('pekerjaan')) == $job ? 'selected' : '' }}>
                                            {{ $job }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" id="nowa"
                                       class="form-control" value="{{ $surat->nowa ?? old('nowa') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Asal (Luar Desa) <span class="text-danger">*</span></label>
                            <textarea name="alamat_asal" id="alamat_asal" class="form-control" rows="2" required>{{ $surat->alamat_asal ?? old('alamat_asal') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Domisili di Desa KEMIRIGEDE <span class="text-danger">*</span></label>
                            <textarea name="alamat_domisili" id="alamat_domisili" class="form-control" rows="2" required>{{ $surat->alamat_domisili ?? old('alamat_domisili') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ $surat->keterangan_tambahan ?? old('keterangan_tambahan') }}</textarea>
                        </div>

                        <div class="row">
                            {{-- <div class="col-md-6 mb-3">
                                <label>Nomor Surat</label>
                                <input type="text" name="nomor_surat" class="form-control"
                                       value="{{ $surat->nomor_surat ?? old('nomor_surat') }}">
                            </div> --}}
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control">
                                    <option value="Pending" {{ $surat->status_surat == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Di cek" {{ $surat->status_surat == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                                    <option value="Di terima" {{ $surat->status_surat == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                                    <option value="Ditolak" {{ $surat->status_surat == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Status Verifikasi</label>
                            <select name="status_verif" class="form-control">
                                <option value="Belum Verifikasi" {{ $surat->status_verif == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                                <option value="Terverifikasi" {{ $surat->status_verif == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillDomisiliEdit() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama_lengkap').value = d.nama || '';
                    if (d.jenis_kelamin) document.getElementById('jenis_kelamin').value = d.jenis_kelamin;
                    if (d.tempat_lahir) document.getElementById('tempat_lahir').value = d.tempat_lahir;
                    if (d.tanggal_lahir) document.getElementById('tanggal_lahir').value = d.tanggal_lahir;
                    if (d.agama) document.getElementById('agama').value = d.agama;
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                    if (d.status) document.getElementById('status').value = d.status;
                }
            });
    }
</script>
@endsection
