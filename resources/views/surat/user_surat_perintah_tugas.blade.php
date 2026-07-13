<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Form Pengajuan Surat Perintah Tugas">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">

    <title>Surat Perintah Tugas</title>

    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">

    <style>
        .section-title {
            margin-bottom: 5px;
            color: #1f2937;
            font-size: 16px;
            font-weight: 700;
        }

        .section-description {
            margin-bottom: 16px;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.5;
        }

        .dynamic-card {
            overflow: hidden;
            border-radius: 12px;
        }

        .dynamic-card .card-header {
            background-color: #f8f9fa;
        }

        .form-control {
            min-height: 45px;
            border-radius: 9px;
        }

        textarea.form-control {
            min-height: auto;
        }

        .action-add-button {
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .submit-button {
            min-height: 48px;
            border-radius: 10px;
            font-weight: 600;
        }

        .empty-hint {
            padding: 14px;
            color: #6b7280;
            background-color: #f8f9fa;
            border: 1px dashed #cfd6df;
            border-radius: 10px;
            font-size: 13px;
            text-align: center;
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
                        Surat Perintah Tugas
                    </h6>
                </div>

                <div style="width: 32px;"></div>
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="page-content-wrapper py-3">
        <div class="container">
            @php
                $oldDasar = old('dasar', ['']);

                if (!is_array($oldDasar) || count($oldDasar) === 0) {
                    $oldDasar = [''];
                }

                $oldPenerima = old('penerima_tugas', [
                    [
                        'nama' => '',
                        'kedudukan' => '',
                    ],
                ]);

                if (!is_array($oldPenerima) || count($oldPenerima) === 0) {
                    $oldPenerima = [
                        [
                            'nama' => '',
                            'kedudukan' => '',
                        ],
                    ];
                }
            @endphp

            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Pengajuan belum dapat dikirim.</strong>

                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('surat.user.perintah_tugas.store') }}" method="POST"
                        id="formSuratPerintahTugasUser">
                        @csrf

                        {{-- =====================================================
                             DASAR SURAT
                        ====================================================== --}}
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                            <div>
                                <h6 class="section-title">
                                    Dasar Surat
                                </h6>

                                <div class="section-description mb-0">
                                    Dasar surat bersifat opsional dan dapat ditambahkan sesuai kebutuhan.
                                </div>
                            </div>

                            <button type="button"
                                class="btn btn-outline-primary btn-sm action-add-button flex-shrink-0" id="tambahDasar">
                                + Tambah
                            </button>
                        </div>

                        <div id="dasarContainer">
                            @foreach ($oldDasar as $index => $dasar)
                                <div class="card border mb-3 dynamic-card dasar-item" data-index="{{ $index }}">
                                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                                        <strong>
                                            Dasar
                                            <span class="nomor-dasar">
                                                {{ $index + 1 }}
                                            </span>
                                        </strong>

                                        <button type="button" class="btn btn-outline-danger btn-sm hapus-dasar">
                                            Hapus
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <label for="dasar_{{ $index }}" class="form-label">
                                            Uraian Dasar
                                        </label>

                                        <textarea name="dasar[]" id="dasar_{{ $index }}"
                                            class="form-control @error('dasar.' . $index) is-invalid @enderror" rows="4" maxlength="2000"
                                            placeholder="Contoh: Surat Undangan dari Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Blitar, nomor ... tanggal ... perihal ...">{{ $dasar }}</textarea>

                                        @error('dasar.' . $index)
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('dasar')
                            <div class="alert alert-danger py-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <hr class="my-4">

                        {{-- =====================================================
                             DIPERINTAHKAN KEPADA
                        ====================================================== --}}
                        <div class="d-flex align-items-start justify-content-between gap-2 mb-3">
                            <div>
                                <h6 class="section-title">
                                    Diperintahkan kepada
                                </h6>

                                <div class="section-description mb-0">
                                    Tambahkan setiap orang yang menerima tugas beserta kedudukannya.
                                </div>
                            </div>

                            <button type="button"
                                class="btn btn-outline-primary btn-sm action-add-button flex-shrink-0"
                                id="tambahPenerima">
                                + Tambah
                            </button>
                        </div>

                        <div id="penerimaContainer">
                            @foreach ($oldPenerima as $index => $penerima)
                                <div class="card border mb-3 dynamic-card penerima-item"
                                    data-index="{{ $index }}">
                                    <div class="card-header py-2 d-flex align-items-center justify-content-between">
                                        <strong>
                                            Penerima Tugas
                                            <span class="nomor-penerima">
                                                {{ $index + 1 }}
                                            </span>
                                        </strong>

                                        <button type="button" class="btn btn-outline-danger btn-sm hapus-penerima">
                                            Hapus
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="penerima_nama_{{ $index }}" class="form-label">
                                                Nama
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="penerima_tugas[{{ $index }}][nama]"
                                                id="penerima_nama_{{ $index }}"
                                                class="form-control @error('penerima_tugas.' . $index . '.nama') is-invalid @enderror"
                                                value="{{ $penerima['nama'] ?? '' }}" maxlength="255"
                                                placeholder="Masukkan nama penerima tugas" required>

                                            @error('penerima_tugas.' . $index . '.nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="penerima_kedudukan_{{ $index }}" class="form-label">
                                                Kedudukan
                                                <span class="text-danger">*</span>
                                            </label>

                                            <input type="text" name="penerima_tugas[{{ $index }}][kedudukan]"
                                                id="penerima_kedudukan_{{ $index }}"
                                                class="form-control @error('penerima_tugas.' . $index . '.kedudukan') is-invalid @enderror"
                                                value="{{ $penerima['kedudukan'] ?? '' }}" maxlength="255"
                                                placeholder="Contoh: Direktur BUMDes Desa Kemirigede" required>

                                            @error('penerima_tugas.' . $index . '.kedudukan')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('penerima_tugas')
                            <div class="alert alert-danger py-2">
                                {{ $message }}
                            </div>
                        @enderror

                        <hr class="my-4">

                        {{-- =====================================================
                             UNTUK
                        ====================================================== --}}
                        <h6 class="section-title">
                            Untuk
                        </h6>

                        <p class="section-description">
                            Tulis uraian lengkap tugas, termasuk kegiatan, hari, tanggal, waktu, dan tempat.
                        </p>

                        <div class="mb-3">
                            <label for="untuk" class="form-label">
                                Uraian Tugas
                                <span class="text-danger">*</span>
                            </label>

                            <textarea name="untuk" id="untuk" class="form-control @error('untuk') is-invalid @enderror" rows="7"
                                maxlength="5000"
                                placeholder="Contoh: Mengikuti bimbingan teknis tersebut di atas pada hari Selasa tanggal 19 November 2024, pukul 08.00 WIB sampai selesai di Ruang Rapat Candi Penataran lantai III Kantor Bupati Blitar."
                                required>{{ old('untuk') }}</textarea>

                            @error('untuk')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- =====================================================
                             INFORMASI PENGAJUAN
                        ====================================================== --}}
                        <h6 class="section-title">
                            Informasi Pengajuan
                        </h6>

                        <p class="section-description">
                            Nomor WhatsApp digunakan untuk pemberitahuan proses surat.
                        </p>

                        <div class="mb-3">
                            <label for="nowa" class="form-label">
                                Nomor WhatsApp
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nowa" id="nowa"
                                class="form-control @error('nowa') is-invalid @enderror" value="{{ old('nowa') }}"
                                inputmode="tel" maxlength="20" placeholder="Contoh: 081234567890" required>

                            @error('nowa')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- <div class="alert alert-info">
                            Setelah dikirim, pengajuan otomatis berstatus
                            <strong>Pending</strong> dan
                            <strong>Belum Verifikasi</strong>.
                        </div> --}}

                        <button type="submit" class="btn btn-primary w-100 submit-button"
                            id="submitSuratPerintahTugas">
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
        document.addEventListener('DOMContentLoaded', function() {
            const dasarContainer =
                document.getElementById('dasarContainer');

            const penerimaContainer =
                document.getElementById('penerimaContainer');

            const tambahDasarButton =
                document.getElementById('tambahDasar');

            const tambahPenerimaButton =
                document.getElementById('tambahPenerima');

            const form =
                document.getElementById('formSuratPerintahTugasUser');

            const submitButton =
                document.getElementById('submitSuratPerintahTugas');

            tambahDasarButton?.addEventListener('click', function() {
                const jumlahDasar = dasarContainer.querySelectorAll(
                    '.dasar-item'
                ).length;

                if (jumlahDasar >= 20) {
                    alert('Maksimal 20 dasar surat.');
                    return;
                }

                dasarContainer.insertAdjacentHTML(
                    'beforeend',
                    buatDasarItem(jumlahDasar)
                );

                perbaruiDasar();
            });

            tambahPenerimaButton?.addEventListener('click', function() {
                const jumlahPenerima = penerimaContainer.querySelectorAll(
                    '.penerima-item'
                ).length;

                if (jumlahPenerima >= 50) {
                    alert('Maksimal 50 penerima tugas.');
                    return;
                }

                penerimaContainer.insertAdjacentHTML(
                    'beforeend',
                    buatPenerimaItem(jumlahPenerima)
                );

                perbaruiPenerima();
            });

            dasarContainer?.addEventListener('click', function(event) {
                const button = event.target.closest('.hapus-dasar');

                if (!button) {
                    return;
                }

                const item = button.closest('.dasar-item');

                if (!item) {
                    return;
                }

                const jumlahDasar = dasarContainer.querySelectorAll(
                    '.dasar-item'
                ).length;

                /*
                 * Karena dasar bersifat opsional, item terakhir cukup
                 * dikosongkan agar pengguna tetap dapat mengisinya lagi.
                 */
                if (jumlahDasar === 1) {
                    const textarea = item.querySelector(
                        'textarea[name="dasar[]"]'
                    );

                    if (textarea) {
                        textarea.value = '';
                        textarea.focus();
                    }

                    return;
                }

                item.remove();
                perbaruiDasar();
            });

            penerimaContainer?.addEventListener('click', function(event) {
                const button = event.target.closest('.hapus-penerima');

                if (!button) {
                    return;
                }

                const item = button.closest('.penerima-item');

                if (!item) {
                    return;
                }

                const jumlahPenerima = penerimaContainer.querySelectorAll(
                    '.penerima-item'
                ).length;

                if (jumlahPenerima === 1) {
                    alert('Minimal satu penerima tugas wajib tersedia.');
                    return;
                }

                item.remove();
                perbaruiPenerima();
            });

            form?.addEventListener('submit', function() {
                if (!submitButton) {
                    return;
                }

                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2" role="status"></span>' +
                    'Mengirim Pengajuan...';
            });

            function buatDasarItem(index) {
                return `
                    <div
                        class="card border mb-3 dynamic-card dasar-item"
                        data-index="${index}"
                    >
                        <div class="card-header py-2 d-flex align-items-center justify-content-between">
                            <strong>
                                Dasar
                                <span class="nomor-dasar">
                                    ${index + 1}
                                </span>
                            </strong>

                            <button
                                type="button"
                                class="btn btn-outline-danger btn-sm hapus-dasar"
                            >
                                Hapus
                            </button>
                        </div>

                        <div class="card-body">
                            <label
                                for="dasar_${index}"
                                class="form-label"
                            >
                                Uraian Dasar
                            </label>

                            <textarea
                                name="dasar[]"
                                id="dasar_${index}"
                                class="form-control"
                                rows="4"
                                maxlength="2000"
                                placeholder="Contoh: Surat Undangan dari Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Blitar, nomor ... tanggal ... perihal ..."
                            ></textarea>
                        </div>
                    </div>
                `;
            }

            function buatPenerimaItem(index) {
                return `
                    <div
                        class="card border mb-3 dynamic-card penerima-item"
                        data-index="${index}"
                    >
                        <div class="card-header py-2 d-flex align-items-center justify-content-between">
                            <strong>
                                Penerima Tugas
                                <span class="nomor-penerima">
                                    ${index + 1}
                                </span>
                            </strong>

                            <button
                                type="button"
                                class="btn btn-outline-danger btn-sm hapus-penerima"
                            >
                                Hapus
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="mb-3">
                                <label
                                    for="penerima_nama_${index}"
                                    class="form-label"
                                >
                                    Nama
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="penerima_tugas[${index}][nama]"
                                    id="penerima_nama_${index}"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Masukkan nama penerima tugas"
                                    required
                                >
                            </div>

                            <div>
                                <label
                                    for="penerima_kedudukan_${index}"
                                    class="form-label"
                                >
                                    Kedudukan
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="penerima_tugas[${index}][kedudukan]"
                                    id="penerima_kedudukan_${index}"
                                    class="form-control"
                                    maxlength="255"
                                    placeholder="Contoh: Direktur BUMDes Desa Kemirigede"
                                    required
                                >
                            </div>
                        </div>
                    </div>
                `;
            }

            function perbaruiDasar() {
                const items = Array.from(
                    dasarContainer.querySelectorAll('.dasar-item')
                );

                items.forEach(function(item, index) {
                    item.dataset.index = index;

                    const nomor = item.querySelector('.nomor-dasar');
                    const textarea = item.querySelector(
                        'textarea[name="dasar[]"]'
                    );
                    const label = item.querySelector(
                        'label[for^="dasar_"]'
                    );

                    if (nomor) {
                        nomor.textContent = index + 1;
                    }

                    if (textarea) {
                        textarea.id = `dasar_${index}`;
                    }

                    if (label) {
                        label.setAttribute(
                            'for',
                            `dasar_${index}`
                        );
                    }
                });
            }

            function perbaruiPenerima() {
                const items = Array.from(
                    penerimaContainer.querySelectorAll('.penerima-item')
                );

                items.forEach(function(item, index) {
                    item.dataset.index = index;

                    const nomor = item.querySelector('.nomor-penerima');
                    const namaInput = item.querySelector(
                        'input[name*="[nama]"]'
                    );
                    const kedudukanInput = item.querySelector(
                        'input[name*="[kedudukan]"]'
                    );
                    const namaLabel = item.querySelector(
                        'label[for^="penerima_nama_"]'
                    );
                    const kedudukanLabel = item.querySelector(
                        'label[for^="penerima_kedudukan_"]'
                    );

                    if (nomor) {
                        nomor.textContent = index + 1;
                    }

                    if (namaInput) {
                        namaInput.name =
                            `penerima_tugas[${index}][nama]`;

                        namaInput.id =
                            `penerima_nama_${index}`;
                    }

                    if (kedudukanInput) {
                        kedudukanInput.name =
                            `penerima_tugas[${index}][kedudukan]`;

                        kedudukanInput.id =
                            `penerima_kedudukan_${index}`;
                    }

                    if (namaLabel) {
                        namaLabel.setAttribute(
                            'for',
                            `penerima_nama_${index}`
                        );
                    }

                    if (kedudukanLabel) {
                        kedudukanLabel.setAttribute(
                            'for',
                            `penerima_kedudukan_${index}`
                        );
                    }
                });
            }

            perbaruiDasar();
            perbaruiPenerima();
        });
    </script>
</body>

</html>
