@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Buat Surat Permohonan Pengantar Keabsahan Akta Kelahiran (Untuk Anak)</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form action="{{ route('surat.pengantar_keabsahan_anak.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>NIK Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nik" id="nik" class="form-control" value="{{ old('nik') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nama Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                      <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tempat Lahir</label>
                        <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control" value="{{ old('ttl_tempat') }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control" value="{{ old('ttl_tanggal') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Nama Anak <span class="text-danger">*</span></label>
                    <input type="text" name="nama_anak" class="form-control" value="{{ old('nama_anak') }}" required>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control">
                            <option value="Pending">Pending</option>
                            <option value="Di cek">Di cek</option>
                            <option value="Di terima">Di terima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control">
                            <option value="Belum Verifikasi">Belum Verifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Simpan Surat</button>
                    <a href="{{ route('surat.keluar') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function autofill() {

    const nik = document.getElementById('nik').value.trim();

    if (nik.length < 10) return;


    fetch(`/datapenduduk/lookup/${nik}`)
        .then(res => res.json())
        .then(result => {

            console.log(result); // cek data dari API


            if (result.success && result.data) {

                const d = result.data;


                document.getElementById('nama').value = d.nama || '';

                document.getElementById('ttl_tempat').value =
                    d.tempat_lahir || '';

                document.getElementById('ttl_tanggal').value =
                    d.tanggal_lahir
                    ? d.tanggal_lahir.substring(0,10)
                    : '';

                document.getElementById('alamat').value =
                    d.alamat || '';



                // =========================
                // AUTOFILL JENIS KELAMIN
                // =========================

                let jk = d.jenis_kelamin || '';

                if (jk) {

                    jk = jk.toString().toUpperCase();


                    if (
                        jk == 'L' ||
                        jk == 'LAKI-LAKI' ||
                        jk == 'LAKI LAKI' ||
                        jk == 'PRIA'
                    ) {

                        document.getElementById('jenis_kelamin').value = 'Laki-laki';

                    }


                    else if (
                        jk == 'P' ||
                        jk == 'PEREMPUAN' ||
                        jk == 'WANITA'
                    ) {

                        document.getElementById('jenis_kelamin').value = 'Perempuan';

                    }

                }

            }

        })
        .catch(err => console.log(err));

}


document.addEventListener('DOMContentLoaded', function(){

    const nikInput = document.getElementById('nik');

    if(nikInput){

        nikInput.addEventListener('blur', autofill);

        nikInput.addEventListener('change', autofill);

    }

});
</script>
@endsection
