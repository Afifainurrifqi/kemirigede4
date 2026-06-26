<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulir Pengajuan User ID (F-3.01)</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>
<body>
    <div id="preloader"><div class="spinner-grow text-primary" role="status"></div></div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Formulir Pengajuan User ID (F-3.01)</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                    @endif

                    <form action="{{ route('surat.user_formulir_pengajuan_user_id.store') }}" method="POST">
                        @csrf

                        <h6 class="mb-3"><strong>Data Pemohon</strong></h6>

                        <div class="mb-3">
                            <label>Nama Instansi / Desa <span class="text-danger">*</span></label>
                            <input type="text" name="instansi_pemohon" class="form-control" value="{{ old('instansi_pemohon') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Alamat Instansi</label>
                            <textarea name="alamat_instansi" class="form-control" rows="2">{{ old('alamat_instansi') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nama Lengkap Pemohon <span class="text-danger">*</span></label>
                                <input type="text" name="nama_pemohon" class="form-control" value="{{ old('nama_pemohon') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>NIK Pemohon <span class="text-danger">*</span></label>
                                <input type="text" name="nik_pemohon" class="form-control" value="{{ old('nik_pemohon') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Jabatan Pemohon</label>
                            <input type="text" name="jabatan_pemohon" class="form-control" value="{{ old('jabatan_pemohon') }}">
                        </div>

                        <div class="mb-3">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required>
                        </div>

                        <hr>

                        <h6 class="mb-3"><strong>Daftar Personil yang Diajukan</strong></h6>

                        <div class="table-responsive">
                            <table class="table table-bordered">
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
                                        <td><input type="text" name="personil[{{ $i }}][ttl]" class="form-control form-control-sm" placeholder="Tempat / DD-MM-YYYY"></td>
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Pengajuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>
</body>
</html>
