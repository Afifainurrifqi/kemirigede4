<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Form Permohonan Pembukaan Rekening Tabungan">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">

    <title>Permohonan Pembukaan Rekening</title>

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">

    <style>
        .section-title {
            margin-bottom: 16px;
            color: #1f2937;
            font-size: 16px;
            font-weight: 700;
        }

        .section-description {
            margin-top: -10px;
            margin-bottom: 16px;
            color: #6b7280;
            font-size: 13px;
        }

        .required-mark {
            color: #dc3545;
        }

        .berwenang-item {
            border-radius: 12px;
            overflow: hidden;
        }

        .berwenang-item .card-header {
            background-color: #f8f9fa;
        }

        .submit-button {
            min-height: 48px;
            border-radius: 10px;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            min-height: 45px;
            border-radius: 9px;
        }

        textarea.form-control {
            min-height: auto;
        }

        @media (max-width: 575.98px) {
            .page-content-wrapper {
                padding-bottom: 90px;
            }

            .card-body {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status">
            <span class="visually-hidden">Memuat...</span>
        </div>
    </div>

    {{-- HEADER --}}
    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}">
                        <i class="bi bi-arrow-left-short"></i>
                    </a>
                </div>

                <div class="page-heading">
                    <h6 class="mb-0">
                        Permohonan Pembukaan Rekening
                    </h6>
                </div>

                <div style="width: 32px;"></div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Data belum dapat dikirim.</strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('surat.user.permohonan_rekening.store') }}"
                        method="POST"
                        id="formPermohonanRekeningUser"
                    >
                        @csrf

                        {{-- =====================================================
                             KEPADA
                        ====================================================== --}}
                        <h6 class="section-title">Kepada</h6>

                        <div class="mb-3">
                            <label for="kepada_nama_instansi" class="form-label">
                                Nama Instansi
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                name="kepada_nama_instansi"
                                id="kepada_nama_instansi"
                                class="form-control @error('kepada_nama_instansi') is-invalid @enderror"
                                value="{{ old('kepada_nama_instansi') }}"
                                placeholder="Contoh: PT Bank Rakyat Indonesia (Persero) Tbk."
                                maxlength="255"
                                required
                            >

                            @error('kepada_nama_instansi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kepada_alamat" class="form-label">
                                Alamat Instansi
                                <span class="required-mark">*</span>
                            </label>

                            <textarea
                                name="kepada_alamat"
                                id="kepada_alamat"
                                class="form-control @error('kepada_alamat') is-invalid @enderror"
                                rows="3"
                                maxlength="1000"
                                placeholder="Masukkan alamat lengkap instansi tujuan"
                                required
                            >{{ old('kepada_alamat') }}</textarea>

                            @error('kepada_alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- =====================================================
                             YANG BERTANDA TANGAN
                        ====================================================== --}}
                        <h6 class="section-title">Yang Bertanda Tangan</h6>

                        <div class="mb-3">
                            <label for="ybt_nama" class="form-label">
                                Nama Lengkap
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                name="ybt_nama"
                                id="ybt_nama"
                                class="form-control @error('ybt_nama') is-invalid @enderror"
                                value="{{ old('ybt_nama') }}"
                                maxlength="255"
                                placeholder="Masukkan nama lengkap"
                                required
                            >

                            @error('ybt_nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ybt_jabatan" class="form-label">
                                Jabatan
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                name="ybt_jabatan"
                                id="ybt_jabatan"
                                class="form-control @error('ybt_jabatan') is-invalid @enderror"
                                value="{{ old('ybt_jabatan', 'KEPALA DESA Kemirigede') }}"
                                maxlength="255"
                                required
                            >

                            @error('ybt_jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ybt_alamat" class="form-label">
                                Alamat
                                <span class="required-mark">*</span>
                            </label>

                            <textarea
                                name="ybt_alamat"
                                id="ybt_alamat"
                                class="form-control @error('ybt_alamat') is-invalid @enderror"
                                rows="3"
                                maxlength="1000"
                                placeholder="Masukkan alamat lengkap"
                                required
                            >{{ old('ybt_alamat') }}</textarea>

                            @error('ybt_alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- =====================================================
                             DATA REKENING
                        ====================================================== --}}
                        <h6 class="section-title">Data Rekening</h6>

                        <div class="mb-3">
                            <label for="rekening_atas_nama" class="form-label">
                                Rekening Atas Nama
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                name="rekening_atas_nama"
                                id="rekening_atas_nama"
                                class="form-control @error('rekening_atas_nama') is-invalid @enderror"
                                value="{{ old('rekening_atas_nama') }}"
                                maxlength="255"
                                placeholder="Masukkan nama pemilik rekening"
                                required
                            >

                            @error('rekening_atas_nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rekening_alamat" class="form-label">
                                Alamat Pemilik Rekening
                                <span class="required-mark">*</span>
                            </label>

                            <textarea
                                name="rekening_alamat"
                                id="rekening_alamat"
                                class="form-control @error('rekening_alamat') is-invalid @enderror"
                                rows="3"
                                maxlength="1000"
                                placeholder="Masukkan alamat pemilik rekening"
                                required
                            >{{ old('rekening_alamat') }}</textarea>

                            @error('rekening_alamat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- =====================================================
                             PIHAK YANG BERWENANG
                        ====================================================== --}}
                        <h6 class="section-title">
                            Pihak yang Berwenang
                        </h6>

                        <p class="section-description">
                            Tentukan jumlah pihak yang berwenang, kemudian isi nama dan jabatannya.
                        </p>

                        <div class="mb-3">
                            <label for="berwenang_jumlah" class="form-label">
                                Jumlah Pihak yang Berwenang
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="number"
                                name="berwenang_jumlah"
                                id="berwenang_jumlah"
                                class="form-control @error('berwenang_jumlah') is-invalid @enderror"
                                value="{{ old('berwenang_jumlah', 2) }}"
                                min="1"
                                max="20"
                                required
                            >

                            <div class="form-text">
                                Minimal 1 orang dan maksimal 20 orang.
                            </div>

                            @error('berwenang_jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        @php
                            $oldJumlah = (int) old('berwenang_jumlah', 2);
                            $oldJumlah = max(1, min(20, $oldJumlah));

                            $oldNama = old('berwenang_nama', []);
                            $oldJabatan = old('berwenang_jabatan', []);
                        @endphp

                        <div id="berwenangContainer">
                            @for ($i = 0; $i < $oldJumlah; $i++)
                                <div
                                    class="card border mb-3 berwenang-item"
                                    data-index="{{ $i }}"
                                >
                                    <div class="card-header py-2">
                                        <strong>
                                            Pihak Berwenang
                                            <span class="nomor-berwenang">
                                                {{ $i + 1 }}
                                            </span>
                                        </strong>
                                    </div>

                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label
                                                for="berwenang_nama_{{ $i }}"
                                                class="form-label"
                                            >
                                                Nama Lengkap
                                                <span class="required-mark">*</span>
                                            </label>

                                            <input
                                                type="text"
                                                name="berwenang_nama[]"
                                                id="berwenang_nama_{{ $i }}"
                                                class="form-control @error('berwenang_nama.' . $i) is-invalid @enderror"
                                                value="{{ $oldNama[$i] ?? '' }}"
                                                maxlength="255"
                                                placeholder="Masukkan nama lengkap"
                                                required
                                            >

                                            @error('berwenang_nama.' . $i)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label
                                                for="berwenang_jabatan_{{ $i }}"
                                                class="form-label"
                                            >
                                                Jabatan
                                                <span class="required-mark">*</span>
                                            </label>

                                            <input
                                                type="text"
                                                name="berwenang_jabatan[]"
                                                id="berwenang_jabatan_{{ $i }}"
                                                class="form-control @error('berwenang_jabatan.' . $i) is-invalid @enderror"
                                                value="{{ $oldJabatan[$i] ?? '' }}"
                                                maxlength="255"
                                                placeholder="Masukkan jabatan"
                                                required
                                            >

                                            @error('berwenang_jabatan.' . $i)
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        @error('berwenang_nama')
                            <div class="alert alert-danger py-2">
                                {{ $message }}
                            </div>
                        @enderror

                        @error('berwenang_jabatan')
                            <div class="alert alert-danger py-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <hr class="my-4">

                        {{-- =====================================================
                             DATA PENGAJUAN
                        ====================================================== --}}
                        <h6 class="section-title">Data Pengajuan</h6>

                        <div class="mb-3">
                            <label for="nowa" class="form-label">
                                Nomor WhatsApp
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                name="nowa"
                                id="nowa"
                                class="form-control @error('nowa') is-invalid @enderror"
                                value="{{ old('nowa') }}"
                                inputmode="tel"
                                maxlength="20"
                                placeholder="Contoh: 081234567890"
                                required
                            >

                            @error('nowa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div class="alert alert-info">
                            Setelah dikirim, pengajuan akan berstatus
                            <strong>Pending</strong> dan
                            <strong>Belum Verifikasi</strong>.
                        </div> --}}

                        <button
                            type="submit"
                            class="btn btn-primary w-100 submit-button"
                            id="submitPermohonanRekening"
                        >
                            <i class="bi bi-send me-1"></i>
                            Kirim Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER NAV --}}
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="active">
                        <a href="{{ route('surat.pengajuan_surat') }}">
                            <i class="bi bi-house"></i>
                            <span>Beranda</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jumlahInput = document.getElementById('berwenang_jumlah');
            const container = document.getElementById('berwenangContainer');
            const form = document.getElementById('formPermohonanRekeningUser');
            const submitButton = document.getElementById('submitPermohonanRekening');

            if (jumlahInput && container) {
                jumlahInput.addEventListener('input', function () {
                    let jumlah = parseInt(this.value, 10);

                    if (Number.isNaN(jumlah)) {
                        jumlah = 1;
                    }

                    jumlah = Math.max(1, Math.min(20, jumlah));
                    this.value = jumlah;

                    sesuaikanJumlahBerwenang(jumlah);
                });
            }

            if (form && submitButton) {
                form.addEventListener('submit', function () {
                    submitButton.disabled = true;
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status"></span>' +
                        'Mengirim Pengajuan...';
                });
            }

            function sesuaikanJumlahBerwenang(jumlah) {
                const items = Array.from(
                    container.querySelectorAll('.berwenang-item')
                );

                if (items.length < jumlah) {
                    for (
                        let index = items.length;
                        index < jumlah;
                        index++
                    ) {
                        container.insertAdjacentHTML(
                            'beforeend',
                            buatItemBerwenang(index)
                        );
                    }
                }

                if (items.length > jumlah) {
                    for (
                        let index = items.length - 1;
                        index >= jumlah;
                        index--
                    ) {
                        items[index].remove();
                    }
                }

                perbaruiNomorBerwenang();
            }

            function buatItemBerwenang(index) {
                const nomor = index + 1;

                return `
                    <div
                        class="card border mb-3 berwenang-item"
                        data-index="${index}"
                    >
                        <div class="card-header py-2">
                            <strong>
                                Pihak Berwenang
                                <span class="nomor-berwenang">
                                    ${nomor}
                                </span>
                            </strong>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label
                                    for="berwenang_nama_${index}"
                                    class="form-label"
                                >
                                    Nama Lengkap
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="berwenang_nama[]"
                                    id="berwenang_nama_${index}"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                >
                            </div>

                            <div>
                                <label
                                    for="berwenang_jabatan_${index}"
                                    class="form-label"
                                >
                                    Jabatan
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="berwenang_jabatan[]"
                                    id="berwenang_jabatan_${index}"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Masukkan jabatan"
                                    required
                                >
                            </div>
                        </div>
                    </div>
                `;
            }

            function perbaruiNomorBerwenang() {
                const items = Array.from(
                    container.querySelectorAll('.berwenang-item')
                );

                items.forEach(function (item, index) {
                    item.dataset.index = index;

                    const nomor = item.querySelector('.nomor-berwenang');
                    const namaInput = item.querySelector(
                        'input[name="berwenang_nama[]"]'
                    );
                    const jabatanInput = item.querySelector(
                        'input[name="berwenang_jabatan[]"]'
                    );
                    const namaLabel = item.querySelector(
                        'label[for^="berwenang_nama_"]'
                    );
                    const jabatanLabel = item.querySelector(
                        'label[for^="berwenang_jabatan_"]'
                    );

                    if (nomor) {
                        nomor.textContent = index + 1;
                    }

                    if (namaInput) {
                        namaInput.id = `berwenang_nama_${index}`;
                    }

                    if (jabatanInput) {
                        jabatanInput.id = `berwenang_jabatan_${index}`;
                    }

                    if (namaLabel) {
                        namaLabel.setAttribute(
                            'for',
                            `berwenang_nama_${index}`
                        );
                    }

                    if (jabatanLabel) {
                        jabatanLabel.setAttribute(
                            'for',
                            `berwenang_jabatan_${index}`
                        );
                    }
                });
            }
        });
    </script>
</body>

</html>
