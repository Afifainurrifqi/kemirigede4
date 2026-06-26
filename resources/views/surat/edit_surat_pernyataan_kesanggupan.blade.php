@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Edit Surat Pernyataan Kesanggupan</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('surat.pernyataan_kesanggupan.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control"
                                       value="{{ $surat->nama ?? old('nama') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       value="{{ $surat->nik ?? old('nik') }}" onkeyup="autofillKesanggupanEdit()">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                       value="{{ $surat->tempat_lahir ?? old('tempat_lahir') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                       value="{{ $surat->tanggal_lahir ?? old('tanggal_lahir') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="2" required>{{ $surat->alamat ?? old('alamat') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Kegiatan <span class="text-danger">*</span></label>
                                <input type="text" name="kegiatan" class="form-control"
                                       value="{{ $surat->kegiatan ?? old('kegiatan') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Hari <span class="text-danger">*</span></label>
                                <input type="text" name="hari" class="form-control"
                                       value="{{ $surat->hari ?? old('hari') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Kegiatan <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_kegiatan" class="form-control"
                                       value="{{ $surat->tanggal_kegiatan ?? old('tanggal_kegiatan') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Waktu <span class="text-danger">*</span></label>
                                <input type="text" name="waktu" class="form-control"
                                       value="{{ $surat->waktu ?? old('waktu') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Tempat Kegiatan <span class="text-danger">*</span></label>
                            <textarea name="tempat_kegiatan" class="form-control" rows="2" required>{{ $surat->tempat_kegiatan ?? old('tempat_kegiatan') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ $surat->keterangan_tambahan ?? old('keterangan_tambahan') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>No HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control"
                                   value="{{ $surat->nowa ?? old('nowa') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status Surat</label>
                                <select name="status_surat" class="form-control">
                                    <option value="Pending" {{ $surat->status_surat == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Di cek" {{ $surat->status_surat == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                                    <option value="Di terima" {{ $surat->status_surat == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                                    <option value="Ditolak" {{ $surat->status_surat == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Status Verifikasi</label>
                                <select name="status_verif" class="form-control">
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
    function autofillKesanggupanEdit() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('tempat_lahir').value = d.tempat_lahir || '';
                    document.getElementById('tanggal_lahir').value = d.tanggal_lahir || '';
                    document.getElementById('alamat').value = d.alamat || '';
                }
            })
            .catch(err => console.error('Autofill error:', err));
    }
</script>
@endsection
