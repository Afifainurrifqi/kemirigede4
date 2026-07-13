@extends(Auth::check() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    @php
        /*
         * Data lama dari validasi dikembalikan agar input tidak hilang.
         */
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

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">
                            Form Surat Perintah Tugas
                        </h5>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Data belum dapat disimpan.</strong>

                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            action="{{ route('surat.perintah_tugas.store') }}"
                            method="POST"
                            id="formSuratPerintahTugas"
                        >
                            @csrf

                            {{-- =====================================================
                                 DASAR SURAT
                            ====================================================== --}}
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                <div>
                                    <h5 class="mb-1">Dasar Surat</h5>
                                    <small class="text-muted">
                                        Dasar surat bersifat opsional dan dapat ditambahkan sampai 20 item.
                                    </small>
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    id="tambahDasar"
                                >
                                    + Tambah Dasar
                                </button>
                            </div>

                            <div id="dasarContainer">
                                @foreach ($oldDasar as $index => $dasar)
                                    <div
                                        class="card border mb-3 dasar-item"
                                        data-index="{{ $index }}"
                                    >
                                        <div class="card-header py-2 bg-light d-flex align-items-center justify-content-between">
                                            <strong>
                                                Dasar
                                                <span class="nomor-dasar">
                                                    {{ $index + 1 }}
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
                                                for="dasar_{{ $index }}"
                                                class="form-label"
                                            >
                                                Uraian Dasar Surat
                                            </label>

                                            <textarea
                                                name="dasar[]"
                                                id="dasar_{{ $index }}"
                                                class="form-control @error('dasar.' . $index) is-invalid @enderror"
                                                rows="3"
                                                maxlength="2000"
                                                placeholder="Contoh: Surat Undangan dari Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Blitar, nomor ... tanggal ... perihal ..."
                                            >{{ $dasar }}</textarea>

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
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                                <div>
                                    <h5 class="mb-1">
                                        Diperintahkan kepada
                                    </h5>

                                    <small class="text-muted">
                                        Minimal satu penerima tugas dan maksimal 50 orang.
                                    </small>
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    id="tambahPenerima"
                                >
                                    + Tambah Penerima
                                </button>
                            </div>

                            <div id="penerimaContainer">
                                @foreach ($oldPenerima as $index => $penerima)
                                    <div
                                        class="card border mb-3 penerima-item"
                                        data-index="{{ $index }}"
                                    >
                                        <div class="card-header py-2 bg-light d-flex align-items-center justify-content-between">
                                            <strong>
                                                Penerima Tugas
                                                <span class="nomor-penerima">
                                                    {{ $index + 1 }}
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
                                            <div class="row">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <label
                                                        for="penerima_nama_{{ $index }}"
                                                        class="form-label"
                                                    >
                                                        Nama
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="penerima_tugas[{{ $index }}][nama]"
                                                        id="penerima_nama_{{ $index }}"
                                                        class="form-control @error('penerima_tugas.' . $index . '.nama') is-invalid @enderror"
                                                        value="{{ $penerima['nama'] ?? '' }}"
                                                        maxlength="255"
                                                        placeholder="Masukkan nama penerima tugas"
                                                        required
                                                    >

                                                    @error('penerima_tugas.' . $index . '.nama')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label
                                                        for="penerima_kedudukan_{{ $index }}"
                                                        class="form-label"
                                                    >
                                                        Kedudukan
                                                        <span class="text-danger">*</span>
                                                    </label>

                                                    <input
                                                        type="text"
                                                        name="penerima_tugas[{{ $index }}][kedudukan]"
                                                        id="penerima_kedudukan_{{ $index }}"
                                                        class="form-control @error('penerima_tugas.' . $index . '.kedudukan') is-invalid @enderror"
                                                        value="{{ $penerima['kedudukan'] ?? '' }}"
                                                        maxlength="255"
                                                        placeholder="Contoh: Direktur BUMDes Desa Kemirigede"
                                                        required
                                                    >

                                                    @error('penerima_tugas.' . $index . '.kedudukan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
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
                                 BAGIAN UNTUK
                            ====================================================== --}}
                            <h5 class="mb-3">Untuk</h5>

                            <div class="mb-3">
                                <label
                                    for="untuk"
                                    class="form-label"
                                >
                                    Uraian Tugas
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    name="untuk"
                                    id="untuk"
                                    class="form-control @error('untuk') is-invalid @enderror"
                                    rows="6"
                                    maxlength="5000"
                                    placeholder="Contoh: Mengikuti bimbingan teknis tersebut di atas pada hari Selasa tanggal 19 November 2024, pukul 08.00 WIB sampai selesai di Ruang Rapat Candi Penataran lantai III Kantor Bupati Blitar."
                                    required
                                >{{ old('untuk') }}</textarea>

                                <div class="form-text">
                                    Tulis uraian lengkap kegiatan, hari, tanggal, waktu, dan tempat dalam satu paragraf.
                                </div>

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
                            <h5 class="mb-3">Informasi Pengajuan</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="nowa"
                                        class="form-label"
                                    >
                                        Nomor WhatsApp
                                        <span class="text-danger">*</span>
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

                                <div class="col-md-6 mb-3">
                                    <label
                                        for="status_surat"
                                        class="form-label"
                                    >
                                        Status Surat
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        name="status_surat"
                                        id="status_surat"
                                        class="form-control @error('status_surat') is-invalid @enderror"
                                        required
                                    >
                                        @foreach (['Pending', 'Di cek', 'Di terima', 'Selesai', 'Ditolak'] as $status)
                                            <option
                                                value="{{ $status }}"
                                                {{ old('status_surat', 'Pending') === $status ? 'selected' : '' }}
                                            >
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status_surat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label
                                        for="status_verif"
                                        class="form-label"
                                    >
                                        Status Verifikasi
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select
                                        name="status_verif"
                                        id="status_verif"
                                        class="form-control @error('status_verif') is-invalid @enderror"
                                        required
                                    >
                                        @foreach (['Belum Verifikasi', 'Terverifikasi', 'Ditolak'] as $statusVerif)
                                            <option
                                                value="{{ $statusVerif }}"
                                                {{ old('status_verif', 'Belum Verifikasi') === $statusVerif ? 'selected' : '' }}
                                            >
                                                {{ $statusVerif }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('status_verif')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary btn-lg px-5"
                                    id="submitSuratPerintahTugas"
                                >
                                    Simpan Surat
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dasarContainer =
                document.getElementById('dasarContainer');

            const penerimaContainer =
                document.getElementById('penerimaContainer');

            const tambahDasarButton =
                document.getElementById('tambahDasar');

            const tambahPenerimaButton =
                document.getElementById('tambahPenerima');

            const form =
                document.getElementById('formSuratPerintahTugas');

            const submitButton =
                document.getElementById('submitSuratPerintahTugas');

            tambahDasarButton?.addEventListener('click', function () {
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

            tambahPenerimaButton?.addEventListener('click', function () {
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

            dasarContainer?.addEventListener('click', function (event) {
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

            penerimaContainer?.addEventListener('click', function (event) {
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

            form?.addEventListener('submit', function () {
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Menyimpan...';
                }
            });

            function buatDasarItem(index) {
                return `
                    <div
                        class="card border mb-3 dasar-item"
                        data-index="${index}"
                    >
                        <div class="card-header py-2 bg-light d-flex align-items-center justify-content-between">
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
                                Uraian Dasar Surat
                            </label>

                            <textarea
                                name="dasar[]"
                                id="dasar_${index}"
                                class="form-control"
                                rows="3"
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
                        class="card border mb-3 penerima-item"
                        data-index="${index}"
                    >
                        <div class="card-header py-2 bg-light d-flex align-items-center justify-content-between">
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
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
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

                                <div class="col-md-6">
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
                    </div>
                `;
            }

            function perbaruiDasar() {
                const items = Array.from(
                    dasarContainer.querySelectorAll('.dasar-item')
                );

                items.forEach(function (item, index) {
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
                        label.setAttribute('for', `dasar_${index}`);
                    }
                });
            }

            function perbaruiPenerima() {
                const items = Array.from(
                    penerimaContainer.querySelectorAll('.penerima-item')
                );

                items.forEach(function (item, index) {
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
@endsection
