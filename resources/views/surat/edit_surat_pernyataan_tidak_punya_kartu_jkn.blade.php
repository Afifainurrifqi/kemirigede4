@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card">
                    <h5 class="mb-0">Edit Surat Pernyataan Tidak Memiliki Kartu JAMKESMAS / ASKES / JKN</h5>
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

                    <form action="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.update', $surat) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>NIK <span class="text-danger">*</span></label>
                                <input type="text" name="nik" id="nik" class="form-control"
                                       value="{{ $surat->nik }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                       value="{{ $surat->nama }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control"
                                       value="{{ $surat->tempat_lahir }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control"
                                       value="{{ $surat->tanggal_lahir }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Pekerjaan <span class="text-danger">*</span></label>
                            <select name="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih Pekerjaan --</option>
                               @php
                                $jobs = [
                                    'BELUM/TIDAK BEKERJA',
                                    'PELAJAR/MAHASISWA',
                                    'TIDAK/BELUM SEKOLAH',
                                    'KARYAWAN SWASTA',
                                    'IBU RUMAH TANGGA',
                                    'WIRASWASTA',
                                    'TENTARA NASIONAL INDONESIA (TNI)',
                                    'KEPOLISIAN RI (POLRI)',
                                    'DOSEN',
                                    'GURU',
                                    'Guru agama',
                                    'KEPALA DESA',
                                    'PERANGKAT DESA',
                                    'Pegawai Kantor Desa',
                                    'BIDAN',
                                    'DOKTER',
                                    'PERAWAT',
                                    'PETANI/PEKEBUN PEMILIK LAHAN',
                                    'PETANI/PEKEBUN',
                                    'BURUH TANI/PERKEBUNAN',
                                    'PEDAGANG',
                                    'PEGAWAI NEGERI SIPIL (PNS)',
                                    'BURUH HARIAN LEPAS',
                                    'SOPIR',
                                    'KARYAWAN BUMN',
                                    'PENSIUNAN',
                                    'PEMBANTU RUMAH TANGGA',
                                    'BURUH PETERNAKAN',
                                    'KONSTRUKSI',
                                    'PELAUT',
                                    'NELAYAN/PERIKANAN',
                                    'KARYAWAN HONORER',
                                    'PETERNAK',
                                    'MEKANIK',
                                    'PENATA RIAS',
                                    'TUKANG LAS/PANDAI BESI',
                                    'TUKANG BATU',
                                    'INDUSTRI',
                                    'USTADZ/MUBALIGH',
                                    'TABIB',
                                    'BURUH NELAYAN/PERIKANAN',
                                    'JURU MASAK',
                                    'SENIMAN',
                                    'AKUNTAN',
                                    'Petani/Pekebun penyewa',
                                    'TKI',
                                    'Lainnya',
                                ];
                            @endphp
                                @foreach ($jobs as $job)
                                    <option value="{{ $job }}" {{ $surat->pekerjaan == $job ? 'selected' : '' }}>
                                        {{ $job }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ $surat->alamat }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>No HP / WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ $surat->nowa }}" required>
                        </div>

                        <!-- Status -->
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

                        <button type="submit" class="btn btn-primary">Update Surat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
