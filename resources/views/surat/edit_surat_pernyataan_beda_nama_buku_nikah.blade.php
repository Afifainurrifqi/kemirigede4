@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-lg-12 mx-auto">

                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Pernyataan Beda Nama Buku Nikah</h5>
                        <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Kembali</a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('surat.bedanama.update', $surat->_id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nama --}}
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ old('nama', $surat->nama) }}" required>
                            </div>

                            {{-- NIK --}}
                            <div class="mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control"
                                    value="{{ old('nik', $surat->nik) }}" required>
                            </div>

                            {{-- TTL --}}
                            <div class="mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="ttl_tempat" class="form-control"
                                    value="{{ old('ttl_tempat', $surat->ttl_tempat) }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="ttl_tanggal" class="form-control"
                                    value="{{ old('ttl_tanggal', optional($surat->ttl_tanggal)->format('Y-m-d')) }}"
                                    required>
                            </div>

                            {{-- Pekerjaan --}}
                            {{-- Pekerjaan --}}
                            <div class="mb-3">
                                <label class="form-label">Pekerjaan</label>

                                @php
                                    $pekerjaanValue = old('pekerjaan', $surat->pekerjaan ?? '');

                                    $jobs = [
                                        'BELUM/TIDAK BEKERJA',
                                        'MENGURUS RUMAH TANGGA',
                                        'PELAJAR/MAHASISWA',
                                        'PENSIUNAN',
                                        'PEGAWAI NEGERI SIPIL (PNS)',
                                        'TENTARA NASIONAL INDONESIA (TNI)',
                                        'KEPOLISIAN RI (POLRI)',
                                        'PERDAGANGAN',
                                        'PETANI/PEKEBUN',
                                        'PETERNAK',
                                        'NELAYAN/PERIKANAN',
                                        'INDUSTRI',
                                        'KONSTRUKSI',
                                        'TRANSPORTASI',
                                        'KARYAWAN SWASTA',
                                        'KARYAWAN BUMN',
                                        'KARYAWAN BUMD',
                                        'KARYAWAN HONORER',
                                        'BURUH HARIAN LEPAS',
                                        'BURUH TANI/PERKEBUNAN',
                                        'BURUH NELAYAN/PERIKANAN',
                                        'BURUH PETERNAKAN',
                                        'PEMBANTU RUMAH TANGGA',
                                        'DOSEN',
                                        'GURU',
                                        'DOKTER',
                                        'BIDAN',
                                        'PERAWAT',
                                        'SOPIR',
                                        'PEDAGANG',
                                        'PERANGKAT DESA',
                                        'KEPALA DESA',
                                        'WIRASWASTA',
                                        'LAINNYA',
                                    ];

                                    if ($pekerjaanValue && !in_array($pekerjaanValue, $jobs)) {
                                        $jobs[] = $pekerjaanValue;
                                    }
                                @endphp

                                <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                    <option value="">-- Pilih pekerjaan --</option>

                                    @foreach ($jobs as $job)
                                        <option value="{{ $job }}" {{ $pekerjaanValue == $job ? 'selected' : '' }}>
                                            {{ $job }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Alamat --}}
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                            </div>

                            {{-- Nama Sesuai --}}
                            <div class="mb-3">
                                <label class="form-label">Nama Yang Sesuai</label>
                                <input type="text" name="nama_sesuai" class="form-control"
                                    value="{{ old('nama_sesuai', $surat->nama_sesuai) }}" required>
                            </div>

                            {{-- Sumber Data --}}
                            <div class="mb-3">
                                <label class="form-label">Sumber data Nama</label>
                                <input type="text" name="sumber_data_nama" class="form-control"
                                    placeholder="Buku Nikah/KTP/KK"
                                    value="{{ old('sumber_data_nama', $surat->sumber_data_nama) }}" required>
                            </div>

                            {{-- Status Surat --}}
                            <div class="mb-3">
                                <label class="form-label">Status Surat</label>
                                <select name="status_surat" class="form-control">
                                    @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $st)
                                        <option value="{{ $st }}"
                                            {{ old('status_surat', $surat->status_surat ?? 'Pending') === $st ? 'selected' : '' }}>
                                            {{ $st }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Status Verifikasi --}}
                            <div class="mb-3">
                                <label class="form-label">Status Verifikasi</label>
                                <select name="status_verif" class="form-control">
                                    @foreach (['Belum Verifikasi', 'Terverifikasi'] as $sv)
                                        <option value="{{ $sv }}"
                                            {{ old('status_verif', $surat->status_verif ?? 'Belum Verifikasi') === $sv ? 'selected' : '' }}>
                                            {{ $sv }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- No WA --}}
                            <div class="mb-3">
                                <label class="form-label">No WhatsApp</label>
                                <input type="text" name="nowa" class="form-control"
                                    value="{{ old('nowa', $surat->nowa) }}" required>
                            </div>

                            <div class="text-end">
                                <button class="btn btn-primary">Update</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
