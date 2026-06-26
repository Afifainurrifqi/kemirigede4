@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Buat SPTJM Suami Istri (F-2.04)</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('surat.sptjm_suami_istri.store') }}" method="POST">
                @csrf

                <h6><strong>Data Deklaran (Yang Menyatakan)</strong></h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_deklaran" id="nama_deklaran" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik_deklaran" id="nik_deklaran" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat / Tanggal Lahir</label>
                        <input type="text" name="ttl_deklaran" id="ttl_deklaran" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Pekerjaan</label>
                        <input type="text" name="pekerjaan_deklaran" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat_deklaran" id="alamat_deklaran" class="form-control" rows="2" required></textarea>
                </div>

                <hr>
                <h6><strong>Data Pasangan</strong></h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Lengkap Pasangan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pasangan" id="nama_pasangan" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>NIK Pasangan <span class="text-danger">*</span></label>
                        <input type="text" name="nik_pasangan" id="nik_pasangan" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tempat / Tanggal Lahir Pasangan</label>
                        <input type="text" name="ttl_pasangan" id="ttl_pasangan" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat Pasangan <span class="text-danger">*</span></label>
                        <textarea name="alamat_pasangan" id="alamat_pasangan" class="form-control" rows="2" required></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Nomor Kartu Keluarga (KK)</label>
                    <input type="text" name="nomor_kk" class="form-control">
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <!-- Status Surat -->
                <hr>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control">
                            <option value="Pending" selected>Pending</option>
                            <option value="Di cek">Di cek</option>
                            <option value="Di terima">Di terima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control">
                            <option value="Belum Verifikasi" selected>Belum Verifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('surat.keluar') }}" class="btn btn-secondary ms-2">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
    function autofillDeklaran() {
        const nik = document.getElementById('nik_deklaran').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama_deklaran').value = d.nama || '';
                    document.getElementById('ttl_deklaran').value = d.tempat_lahir || '';
                    if (d.tanggal_lahir) {
                        document.getElementById('ttl_deklaran').value = (d.tempat_lahir || '') + ' / ' + d.tanggal_lahir.substring(0,10);
                    }
                    document.getElementById('alamat_deklaran').value = d.alamat || '';
                }
            });
    }

    function autofillPasangan() {
        const nik = document.getElementById('nik_pasangan').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama_pasangan').value = d.nama || '';
                    document.getElementById('ttl_pasangan').value = d.tempat_lahir || '';
                    if (d.tanggal_lahir) {
                        document.getElementById('ttl_pasangan').value = (d.tempat_lahir || '') + ' / ' + d.tanggal_lahir.substring(0,10);
                    }
                    document.getElementById('alamat_pasangan').value = d.alamat || '';
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nik_deklaran').addEventListener('blur', autofillDeklaran);
        document.getElementById('nik_pasangan').addEventListener('blur', autofillPasangan);
    });
</script>
@endsection
