@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-dark">
                    <h5 class="mb-0">Edit Surat Keterangan Kepemilikan Aset</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('surat.kepemilikan_aset.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       value="{{ $surat->nik ?? old('nik') }}" onkeyup="autofillKepemilikanEdit()">
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
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ $surat->alamat ?? old('alamat') }}</textarea>
                        </div>

                        <!-- Survey Aset -->
                        <h6 class="mt-4 mb-3">Data Survey Kepemilikan Aset</h6>

                        <div class="mb-3">
                            <label>Pendapatan Keluarga / Bulan</label>
                            <input type="text" name="pendapatan_bulanan" class="form-control"
                                   value="{{ $surat->pendapatan_bulanan ?? old('pendapatan_bulanan') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Pekarangan (M²)</label>
                                <input type="text" name="pekarangan" class="form-control"
                                       value="{{ $surat->pekarangan ?? old('pekarangan') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Sawah (M²)</label>
                                <input type="text" name="sawah" class="form-control"
                                       value="{{ $surat->sawah ?? old('sawah') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Perkebunan (M²)</label>
                                <input type="text" name="perkebunan" class="form-control"
                                       value="{{ $surat->perkebunan ?? old('perkebunan') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Mobil</label>
                                <input type="text" name="mobil" class="form-control"
                                       value="{{ $surat->mobil ?? old('mobil') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Sepeda Motor</label>
                                <input type="text" name="sepeda_motor" class="form-control"
                                       value="{{ $surat->sepeda_motor ?? old('sepeda_motor') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Perhiasan Emas (gram)</label>
                                <input type="text" name="perhiasan_emas" class="form-control"
                                       value="{{ $surat->perhiasan_emas ?? old('perhiasan_emas') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Lainnya</label>
                            <input type="text" name="lainnya" class="form-control"
                                   value="{{ $surat->lainnya ?? old('lainnya') }}">
                        </div>

                        <div class="mb-3">
                            <label>Kepemilikan Rumah</label>
                            <textarea name="kepemilikan_rumah" class="form-control" rows="2">{{ $surat->kepemilikan_rumah ?? old('kepemilikan_rumah') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Keterangan Tambahan</label>
                            <textarea name="keterangan_tambahan" class="form-control" rows="2">{{ $surat->keterangan_tambahan ?? old('keterangan_tambahan') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
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
    function autofillKepemilikanEdit() {
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
