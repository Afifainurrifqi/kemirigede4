@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pembuatan Surat Pernyataan Tidak Memiliki Kartu JAMKESMAS / ASKES / JKN</h5>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       onkeyup="autofillAdmin()" placeholder="Masukkan NIK" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan <span class="text-danger">*</span></label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih Pekerjaan --</option>
                                @php
                                    $jobs = [
                                        'BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'KARYAWAN SWASTA',
                                        'WIRASWASTA', 'IBU RUMAH TANGGA', 'PETANI/PEKEBUN', 'PEDAGANG',
                                        'PEGAWAI NEGERI SIPIL (PNS)', 'TUKANG BATU', 'Lainnya'
                                    ];
                                @endphp
                                @foreach ($jobs as $job)
                                    <option value="{{ $job }}">{{ $job }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label>No HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" required>
                        </div>

                        <!-- Status -->
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

                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillAdmin() {
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
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                }
            })
            .catch(err => console.error('Autofill error:', err));
    }
</script>
@endsection
