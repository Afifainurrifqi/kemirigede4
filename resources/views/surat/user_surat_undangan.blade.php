<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Undangan</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>
<body>
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Surat Undangan</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('surat.user.undangan') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Kepada Yth <span class="text-danger">*</span></label>
                    <input type="text" name="kepada_yth" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Perihal <span class="text-danger">*</span></label>
                    <input type="text" name="perihal" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-4 mb-3">
                        <label>Hari <span class="text-danger">*</span></label>
                        <input type="text" name="hari" class="form-control" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_acara" class="form-control" required>
                    </div>
                    <div class="col-4 mb-3">
                        <label>Jam <span class="text-danger">*</span></label>
                        <input type="text" name="jam" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Tempat <span class="text-danger">*</span></label>
                    <input type="text" name="tempat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Acara <span class="text-danger">*</span></label>
                    <textarea name="acara" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-3">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</body>
</html>
