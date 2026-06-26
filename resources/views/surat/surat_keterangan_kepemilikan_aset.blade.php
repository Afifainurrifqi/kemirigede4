@extends('layout.main2')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pembuatan Surat Keterangan Kepemilikan Aset</h5>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('surat.kepemilikan_aset.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       onkeyup="autofillKepemilikanAdmin()" placeholder="Masukkan NIK" required>
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
                                        <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                            {{ $job }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>No WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="nowa" id="nowa" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="2" required></textarea>
                        </div>

                        <!-- Survey Aset -->
                        <h6 class="mt-4 mb-3">Data Survey Kepemilikan Aset</h6>

                        <div class="mb-3">
                            <label>Pendapatan Keluarga / Bulan <span class="text-danger">*</span></label>
                            <input type="text" name="pendapatan_bulanan" class="form-control" placeholder="Rp 1.000.000" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Pekarangan (M²)</label>
                                <input type="text" name="pekarangan" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Sawah (M²)</label>
                                <input type="text" name="sawah" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Perkebunan (M²)</label>
                                <input type="text" name="perkebunan" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Mobil</label>
                                <input type="text" name="mobil" class="form-control" placeholder="Jumlah / Merk">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Sepeda Motor</label>
                                <input type="text" name="sepeda_motor" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Perhiasan Emas (gram)</label>
                                <input type="text" name="perhiasan_emas" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Lainnya</label>
                            <input type="text" name="lainnya" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Kepemilikan Rumah <span class="text-danger">*</span></label>
                            <textarea name="kepemilikan_rumah" class="form-control" rows="2" required placeholder="layak huni / numpang di orang tua / dll"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Nomor Surat (opsional)</label>
                            <input type="text" name="nomor_surat" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function autofillKepemilikanAdmin() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success && result.data) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    if (d.pekerjaan) document.getElementById('pekerjaan').value = d.pekerjaan;
                    if (d.alamat) document.getElementById('alamat').value = d.alamat;
                }
            })
            .catch(err => console.error('Autofill error:', err));
    }
</script>
@endsection
