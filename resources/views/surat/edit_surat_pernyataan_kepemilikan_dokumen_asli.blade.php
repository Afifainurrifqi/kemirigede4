@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Surat Pernyataan Kepemilikan Dokumen Asli</h5>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.pernyataan_kepemilikan_dokumen.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       value="{{ $surat->nik ?? old('nik') }}" onkeyup="autofillPernyataanEdit()">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama"
                                       class="form-control" value="{{ $surat->nama ?? old('nama') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir"
                                       class="form-control" value="{{ $surat->tempat_lahir ?? old('tempat_lahir') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                       class="form-control" value="{{ $surat->tanggal_lahir ?? old('tanggal_lahir') }}" required>
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
                                <label>Pekerjaan <span class="text-danger">*</span></label>
                                <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                    <option value="">-- Pilih pekerjaan --</option>
                                    @php
                                        $jobs = ['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','TIDAK/BELUM SEKOLAH','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','TENTARA NASIONAL INDONESIA (TNI)','KEPOLISIAN RI (POLRI)','DOSEN','GURU','KEPALA DESA','PERANGKAT DESA','BIDAN','DOKTER','PERAWAT','PETANI/PEKEBUN PEMILIK LAHAN','BURUH TANI/PERKEBUNAN','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','BURUH HARIAN LEPAS','SOPIR','KARYAWAN BUMN','PENSIUNAN','PEMBANTU RUMAH TANGGA','BURUH PETERNAKAN','KONSTRUKSI','PELAUT','NELAYAN/PERIKANAN','KARYAWAN HONORER','PETERNAK','MEKANIK','PENATA RIAS','TUKANG LAS/PANDAI BESI','INDUSTRI','USTADZ/MUBALIGH','TABIB','BURUH NELAYAN/PERIKANAN','JURU MASAK','SENIMAN','AKUNTAN','Petani/Pekebun penyewa','TKI','Lainnya'];
                                    @endphp
                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}" {{ ($surat->pekerjaan ?? old('pekerjaan')) == $job ? 'selected' : '' }}>
                                            {{ $job }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>No HP / WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" id="nowa"
                                       class="form-control" value="{{ $surat->nowa ?? old('nowa') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ $surat->alamat ?? old('alamat') }}</textarea>
                            </div>
                        </div>

                        <h6 class="mt-4 mb-3">Data Dokumen yang Dimiliki</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Dokumen / Surat <span class="text-danger">*</span></label>
                                <input type="text" name="nama_dokumen" class="form-control"
                                       value="{{ $surat->nama_dokumen ?? old('nama_dokumen') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nomor Dokumen / Surat <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_dokumen" class="form-control"
                                       value="{{ $surat->nomor_dokumen ?? old('nomor_dokumen') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Pemilik Dokumen</label>
                                <input type="text" name="nama_pemilik_dokumen" class="form-control"
                                       value="{{ $surat->nama_pemilik_dokumen ?? old('nama_pemilik_dokumen') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir Pemilik</label>
                                <input type="date" name="tanggal_lahir_pemilik" class="form-control"
                                       value="{{ $surat->tanggal_lahir_pemilik ?? old('tanggal_lahir_pemilik') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat yang Tertera di Dokumen</label>
                            <textarea name="alamat_dokumen" class="form-control" rows="2">{{ $surat->alamat_dokumen ?? old('alamat_dokumen') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ $surat->keterangan_tambahan ?? old('keterangan_tambahan') }}</textarea>
                        </div>

                        <!-- Status -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat <span class="text-danger">*</span></label>
                                <select name="status_surat" class="form-control" required>
                                    <option value="Pending" {{ $surat->status_surat == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Di cek" {{ $surat->status_surat == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                                    <option value="Di terima" {{ $surat->status_surat == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                                    <option value="Ditolak" {{ $surat->status_surat == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi <span class="text-danger">*</span></label>
                                <select name="status_verif" class="form-control" required>
                                    <option value="Belum Verifikasi" {{ $surat->status_verif == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                                    <option value="Terverifikasi" {{ $surat->status_verif == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">Update Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillPernyataanEdit() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('jenis_kelamin').value = d.jenis_kelamin || '';
                    document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                    document.getElementById('tanggal_lahir').value = d.tanggal_lahir || '';
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                    document.getElementById('alamat').value = d.alamat || '';
                }
            })
            .catch(err => console.error('Autofill error:', err));
    }
</script>
@endsection
