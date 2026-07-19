@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        Form Permohonan Pembukaan Rekening Tabungan
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
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('surat.permohonan_rekening.store') }}"
                        method="POST"
                        id="formPermohonanRekening"
                    >
                        @csrf

                        {{-- =====================================================
                             DATA TUJUAN SURAT
                        ====================================================== --}}
                        <h5 class="mb-3">Kepada</h5>

                        <div class="mb-3">
                            <label for="kepada_nama_instansi" class="form-label">
                                Nama Instansi
                                <span class="text-danger">*</span>
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
                                <span class="text-danger">*</span>
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
                        <h5 class="mb-3">Yang Bertanda Tangan</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ybt_nama" class="form-label">
                                    Nama Lengkap
                                    <span class="text-danger">*</span>
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

                            <div class="col-md-6 mb-3">
                                <label for="ybt_jabatan" class="form-label">
                                    Jabatan
                                    <span class="text-danger">*</span>
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
                        </div>

                        <div class="mb-3">
                            <label for="ybt_alamat" class="form-label">
                                Alamat
                                <span class="text-danger">*</span>
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
                        <h5 class="mb-3">Data Rekening</h5>

                        <div class="mb-3">
                            <label for="rekening_atas_nama" class="form-label">
                                Rekening Atas Nama
                                <span class="text-danger">*</span>
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
                                <span class="text-danger">*</span>
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
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                            <div>
                                <h5 class="mb-1">Pihak yang Berwenang</h5>
                                <small class="text-muted">
                                    Tentukan jumlah pihak, lalu isi nama dan jabatannya.
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="berwenang_jumlah" class="form-label">
                                    Jumlah Pihak yang Berwenang
                                    <span class="text-danger">*</span>
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
                        </div>

                        <div id="berwenangContainer">
                            @php
                                $oldJumlah = (int) old('berwenang_jumlah', 2);
                                $oldJumlah = max(1, min(20, $oldJumlah));

                                $oldNama = old('berwenang_nama', []);
                                $oldJabatan = old('berwenang_jabatan', []);
                            @endphp

                            @for ($i = 0; $i < $oldJumlah; $i++)
                                <div
                                    class="card border mb-3 berwenang-item"
                                    data-index="{{ $i }}"
                                >
                                    <div class="card-header py-2 bg-light">
                                        <strong>
                                            Pihak Berwenang
                                            <span class="nomor-berwenang">
                                                {{ $i + 1 }}
                                            </span>
                                        </strong>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3 mb-md-0">
                                                <label
                                                    for="berwenang_nama_{{ $i }}"
                                                    class="form-label"
                                                >
                                                    Nama Lengkap
                                                    <span class="text-danger">*</span>
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

                                            <div class="col-md-6">
                                                <label
                                                    for="berwenang_jabatan_{{ $i }}"
                                                    class="form-label"
                                                >
                                                    Jabatan
                                                    <span class="text-danger">*</span>
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
                             DATA UMUM
                        ====================================================== --}}
                        <h5 class="mb-3">Data Pengajuan</h5>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nowa" class="form-label">
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
                                <label for="status_surat" class="form-label">
                                    Status Surat
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="status_surat"
                                    id="status_surat"
                                    class="form-control @error('status_surat') is-invalid @enderror"
                                    required
                                >
                                    <option value="Pending"
                                        {{ old('status_surat', 'Pending') === 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="Di cek"
                                        {{ old('status_surat') === 'Di cek' ? 'selected' : '' }}>
                                        Di cek
                                    </option>
                                    <option value="Di terima"
                                        {{ old('status_surat') === 'Di terima' ? 'selected' : '' }}>
                                        Di terima
                                    </option>
                                    <option value="Selesai"
                                        {{ old('status_surat') === 'Selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>
                                    <option value="Ditolak"
                                        {{ old('status_surat') === 'Ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
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
                                <label for="status_verif" class="form-label">
                                    Status Verifikasi
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="status_verif"
                                    id="status_verif"
                                    class="form-control @error('status_verif') is-invalid @enderror"
                                    required
                                >
                                    <option value="Belum Verifikasi"
                                        {{ old('status_verif', 'Belum Verifikasi') === 'Belum Verifikasi' ? 'selected' : '' }}>
                                        Belum Verifikasi
                                    </option>
                                    <option value="Terverifikasi"
                                        {{ old('status_verif') === 'Terverifikasi' ? 'selected' : '' }}>
                                        Terverifikasi
                                    </option>
                                    <option value="Ditolak"
                                        {{ old('status_verif') === 'Ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>

                                @error('status_verif')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary btn-lg w-100"
                        >
                            Simpan Surat Permohonan Pembukaan Rekening
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jumlahInput = document.getElementById('berwenang_jumlah');
        const container = document.getElementById('berwenangContainer');

        if (!jumlahInput || !container) {
            return;
        }

        jumlahInput.addEventListener('input', function () {
            let jumlah = parseInt(this.value, 10);

            if (Number.isNaN(jumlah)) {
                jumlah = 1;
            }

            jumlah = Math.max(1, Math.min(20, jumlah));
            this.value = jumlah;

            sesuaikanJumlahBerwenang(jumlah);
        });

        function sesuaikanJumlahBerwenang(jumlah) {
            const items = Array.from(
                container.querySelectorAll('.berwenang-item')
            );

            if (items.length < jumlah) {
                for (let index = items.length; index < jumlah; index++) {
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
                    <div class="card-header py-2 bg-light">
                        <strong>
                            Pihak Berwenang
                            <span class="nomor-berwenang">${nomor}</span>
                        </strong>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label
                                    for="berwenang_nama_${index}"
                                    class="form-label"
                                >
                                    Nama Lengkap
                                    <span class="text-danger">*</span>
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

                            <div class="col-md-6">
                                <label
                                    for="berwenang_jabatan_${index}"
                                    class="form-label"
                                >
                                    Jabatan
                                    <span class="text-danger">*</span>
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
@endsection
