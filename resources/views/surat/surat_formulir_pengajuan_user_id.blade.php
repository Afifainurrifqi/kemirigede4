@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Buat Formulir Pengajuan User ID (F-3.01)</h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            <form action="{{ route('surat.formulir_pengajuan_user_id.store') }}" method="POST">
                @csrf

                <h6>Data Pemohon</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama Instansi / Desa <span class="text-danger">*</span></label>
                        <input type="text" name="instansi_pemohon" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Alamat Instansi</label>
                        <input type="text" name="alamat_instansi" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Nama Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemohon" id="nama_pemohon" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>NIK Pemohon <span class="text-danger">*</span></label>
                        <input type="text" name="nik_pemohon" id="nik_pemohon" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Jabatan Pemohon</label>
                        <input type="text" name="jabatan_pemohon" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <hr>
                <h6>Daftar Personil (Maksimal 4 orang)</h6>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat / Tanggal Lahir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 1; $i <= 4; $i++)
                            <tr>
                                <td>{{ $i }}</td>
                                <td><input type="text" name="personil[{{ $i }}][nik]" class="form-control form-control-sm"></td>
                                <td><input type="text" name="personil[{{ $i }}][nama]" class="form-control form-control-sm"></td>
                                <td>
                                    <select name="personil[{{ $i }}][jenis_kelamin]" class="form-control form-control-sm">
                                        <option value="">--</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </td>
                                <td><input type="text" name="personil[{{ $i }}][ttl]" class="form-control form-control-sm"></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <!-- ==================== STATUS SURAT ==================== -->
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
                <!-- ==================================================== -->

                <button type="submit" class="btn btn-primary mt-3">Simpan Formulir</button>
                <a href="{{ route('surat.keluar') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>

<script>
    function autofillPemohon() {
        const nik = document.getElementById('nik_pemohon').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama_pemohon').value = d.nama || '';
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nik_pemohon').addEventListener('blur', autofillPemohon);
    });
</script>
@endsection
