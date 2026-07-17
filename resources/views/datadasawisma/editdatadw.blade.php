@extends(Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('title', 'Edit Dasawisma')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-lg-12">

                {{-- Pesan validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        <strong>
                            Periksa kembali data berikut:
                        </strong>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                @endif

                {{-- Pesan berhasil --}}
                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        {{ session('msg') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                @endif

                {{-- Pesan gagal --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        {{ session('error') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                @endif

                <div class="card">

                    <div class="card-body">

                        <h1 class="card-title">
                            Edit Dasawisma
                        </h1>

                        <br><br>

                        <form action="{{ route('dasawisma.update', ['nik' => $nik]) }}" method="POST"
                            id="form-edit-dasawisma" autocomplete="off">

                            @csrf


                            {{-- NIK awal akun yang sedang diedit --}}
                            <input type="hidden" id="current_nik" name="current_nik" value="{{ $nik }}">

                            {{-- =========================================
                                NIK
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="ValNIK">

                                    NIK
                                    <span class="text-danger">*</span>

                                </label>

                                <div class="col-lg-6">

                                    <div class="input-group">

                                        <input type="text" class="form-control @error('ValNIK') is-invalid @enderror"
                                            id="ValNIK" name="ValNIK" value="{{ old('ValNIK', $valNIK ?? $nik) }}"
                                            placeholder="Masukkan 16 digit NIK" inputmode="numeric" minlength="16"
                                            maxlength="16" pattern="[0-9]{16}" title="NIK harus tepat 16 digit angka"
                                            required>

                                        <div class="input-group-append">

                                            <button class="btn btn-secondary" type="button" id="btnCariNik">

                                                <span id="btnCariNikText">
                                                    Cari
                                                </span>

                                                <span id="btnCariNikSpinner" class="spinner-border spinner-border-sm d-none"
                                                    role="status" aria-hidden="true">
                                                </span>

                                            </button>

                                        </div>

                                    </div>

                                    @error('ValNIK')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div id="nik-alert" class="mt-2">
                                    </div>

                                    <small class="form-text text-muted">
                                        Masukkan NIK, kemudian tekan tombol
                                        Cari agar data penduduk terisi otomatis.
                                    </small>

                                </div>

                            </div>

                            {{-- =========================================
                                NAMA
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="nama">

                                    Nama
                                    <span class="text-danger">*</span>

                                </label>

                                <div class="col-lg-6">

                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama', $valNama ?? '') }}"
                                        placeholder="Nama..." readonly required>

                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            {{-- =========================================
                                ALAMAT
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="alamat">

                                    Alamat

                                </label>

                                <div class="col-lg-6">

                                    <input type="text" class="form-control" id="alamat" name="alamat"
                                        value="{{ old('alamat', $valAlamat ?? '') }}" placeholder="Alamat..." readonly>

                                </div>

                            </div>

                            {{-- =========================================
                                RT DAN RW
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="rt">

                                    RT

                                </label>

                                <div class="col-lg-2">

                                    <input type="text" class="form-control" id="rt" name="rt"
                                        value="{{ old('rt', $valRT ?? '') }}" placeholder="RT" readonly>

                                </div>

                                <label class="col-lg-2 col-form-label" for="rw">

                                    RW

                                </label>

                                <div class="col-lg-2">

                                    <input type="text" class="form-control" id="rw" name="rw"
                                        value="{{ old('rw', $valRW ?? '') }}" placeholder="RW" readonly>

                                </div>

                            </div>

                            {{-- =========================================
                                EMAIL
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="email">

                                    Email
                                    <span class="text-danger">*</span>

                                </label>

                                <div class="col-lg-6">

                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $valEmail ?? '') }}"
                                        placeholder="Email..." maxlength="255" required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>

                            {{-- =========================================
                                PASSWORD BARU
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="password">

                                    Password Baru

                                </label>

                                <div class="col-lg-6">

                                    <div class="input-group">

                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Kosongkan jika tidak ingin mengganti password"
                                            minlength="6">

                                        <div class="input-group-append">

                                            <button type="button" class="btn btn-outline-secondary" id="togglePassword"
                                                title="Tampilkan password">

                                                <i class="fa fa-eye" id="passwordIcon">
                                                </i>

                                            </button>

                                        </div>

                                    </div>

                                    @error('password')
                                        <div class="text-danger mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <small class="form-text text-muted">
                                        Minimal 6 karakter. Kosongkan apabila
                                        password lama tidak ingin diganti.
                                    </small>

                                </div>

                            </div>

                            {{-- =========================================
                                KONFIRMASI PASSWORD
                            ========================================== --}}
                            <div class="form-group row">

                                <label class="col-lg-4 col-form-label" for="password_confirmation">

                                    Konfirmasi Password

                                </label>

                                <div class="col-lg-6">

                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Ulangi password baru" minlength="6">

                                    <div id="password-confirmation-error" class="text-danger mt-1 d-none">

                                        Konfirmasi password tidak sama.

                                    </div>

                                </div>

                            </div>

                            {{-- Role tetap dasawisma --}}
                            <input type="hidden" id="role" name="role" value="dasawisma">

                            {{-- =========================================
                                TOMBOL
                            ========================================== --}}
                            <div class="form-group row">

                                <div class="col-lg-8 ml-auto">

                                    <a href="{{ route('dasawisma.index_admin') }}" class="btn btn-light mr-2">

                                        <i class="fa fa-arrow-left"></i>
                                        Kembali

                                    </a>

                                    <button type="button" class="btn btn-primary" id="btnOpenConfirm"
                                        data-toggle="modal" data-target="#confirmModal">

                                        <i class="fa fa-save"></i>
                                        Update

                                    </button>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- =============================================
        MODAL KONFIRMASI
    ============================================== --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="confirmModalLabel">

                        Konfirmasi Update

                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">

                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    Apakah Anda yakin ingin memperbarui data
                    anggota Dasawisma ini?

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">

                        Batal

                    </button>

                    {{--
                        Tombol berada di luar form, sehingga memakai
                        atribut form agar tetap mengirim form edit.
                    --}}
                    <button type="submit" class="btn btn-primary" id="confirmSave" form="form-edit-dasawisma">

                        <i class="fa fa-save"></i>
                        Ya, Update

                    </button>

                </div>

            </div>

        </div>

    </div>

    {{-- =============================================
        JAVASCRIPT
        Diletakkan langsung di content agar tidak bergantung
        pada @yield('scripts') di layout.
    ============================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById(
                'form-edit-dasawisma'
            );

            const inputNik = document.getElementById(
                'ValNIK'
            );

            const currentNikInput = document.getElementById(
                'current_nik'
            );

            const namaInput = document.getElementById(
                'nama'
            );

            const alamatInput = document.getElementById(
                'alamat'
            );

            const rtInput = document.getElementById('rt');
            const rwInput = document.getElementById('rw');

            const btnCari = document.getElementById(
                'btnCariNik'
            );

            const btnCariText = document.getElementById(
                'btnCariNikText'
            );

            const btnCariSpinner = document.getElementById(
                'btnCariNikSpinner'
            );

            const nikAlert = document.getElementById(
                'nik-alert'
            );

            const btnOpenConfirm = document.getElementById(
                'btnOpenConfirm'
            );

            const confirmSave = document.getElementById(
                'confirmSave'
            );

            const passwordInput = document.getElementById(
                'password'
            );

            const passwordConfirmationInput =
                document.getElementById(
                    'password_confirmation'
                );

            const passwordConfirmationError =
                document.getElementById(
                    'password-confirmation-error'
                );

            const togglePassword = document.getElementById(
                'togglePassword'
            );

            const passwordIcon = document.getElementById(
                'passwordIcon'
            );

            const routeUrl =
                "{{ route('datapenduduk.findByNik') }}";

            /*
             * NIK awal dianggap telah valid karena berasal
             * dari data yang sedang diedit.
             */
            let verifiedNik = (
                inputNik.value || ''
            ).trim();

            /*
             * Status pencarian sedang berjalan.
             */
            let searchingNik = false;

            function getCsrfToken() {
                const csrfMeta = document.querySelector(
                    'meta[name="csrf-token"]'
                );

                return csrfMeta ?
                    csrfMeta.getAttribute('content') :
                    '';
            }

            function setSearchLoading(status) {
                searchingNik = status;
                btnCari.disabled = status;

                if (status) {
                    btnCariText.textContent = 'Mencari...';

                    btnCariSpinner.classList.remove(
                        'd-none'
                    );
                } else {
                    btnCariText.textContent = 'Cari';

                    btnCariSpinner.classList.add(
                        'd-none'
                    );
                }
            }

            function clearPendudukFields() {
                namaInput.value = '';
                alamatInput.value = '';
                rtInput.value = '';
                rwInput.value = '';
            }

            function fillPendudukFields(data) {
                namaInput.value =
                    data.nama ??
                    data.NAMA ??
                    '';

                alamatInput.value =
                    data.alamat ??
                    data.ALAMAT ??
                    '';

                rtInput.value =
                    data.rt ??
                    data.RT ??
                    '';

                rwInput.value =
                    data.rw ??
                    data.RW ??
                    '';
            }

            function showNikAlert(
                type,
                message,
                timeout = 7000
            ) {
                nikAlert.innerHTML = `
                    <div class="alert alert-${type}
                                alert-dismissible fade show"
                         role="alert">

                        ${message}

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Tutup">

                            <span aria-hidden="true">
                                &times;
                            </span>

                        </button>

                    </div>
                `;

                if (timeout > 0) {
                    setTimeout(function() {
                        const alertElement =
                            nikAlert.querySelector('.alert');

                        if (alertElement) {
                            alertElement.remove();
                        }
                    }, timeout);
                }
            }

            async function cariNik(nik) {
                if (searchingNik) {
                    return;
                }

                setSearchLoading(true);
                clearPendudukFields();

                const csrfToken = getCsrfToken();

                if (!csrfToken) {
                    setSearchLoading(false);

                    showNikAlert(
                        'danger',
                        'CSRF token tidak ditemukan. Muat ulang halaman.'
                    );

                    return;
                }

                try {
                    const response = await fetch(
                        routeUrl, {
                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',

                                'Accept': 'application/json',

                                'X-CSRF-TOKEN': csrfToken
                            },

                            credentials: 'same-origin',

                            body: JSON.stringify({
                                nik: nik,
                                current_nik: currentNikInput.value
                            })
                        }
                    );

                    const responseText =
                        await response.text();

                    let result = null;

                    try {
                        result = JSON.parse(
                            responseText
                        );
                    } catch (error) {
                        result = null;
                    }

                    if (!response.ok) {
                        verifiedNik = '';

                        if (response.status === 419) {
                            showNikAlert(
                                'warning',
                                'Sesi telah berakhir. Silakan login ulang.'
                            );

                            return;
                        }

                        if (response.status === 404) {
                            showNikAlert(
                                'warning',
                                result?.message ||
                                'NIK tidak ditemukan.'
                            );

                            return;
                        }

                        if (response.status === 409) {
                            showNikAlert(
                                'warning',
                                result?.message ||
                                'NIK sudah digunakan oleh akun lain.'
                            );

                            return;
                        }

                        if (response.status === 422) {
                            let validationMessage =
                                result?.message ||
                                'Input tidak valid.';

                            if (result?.errors) {
                                const errorValues =
                                    Object.values(
                                        result.errors
                                    );

                                if (
                                    errorValues.length > 0 &&
                                    errorValues[0].length > 0
                                ) {
                                    validationMessage =
                                        errorValues[0][0];
                                }
                            }

                            showNikAlert(
                                'warning',
                                validationMessage
                            );

                            return;
                        }

                        showNikAlert(
                            'danger',
                            result?.message ||
                            'Terjadi kesalahan ketika mencari NIK.'
                        );

                        return;
                    }

                    if (
                        result &&
                        result.ok &&
                        result.data
                    ) {
                        fillPendudukFields(
                            result.data
                        );

                        verifiedNik = nik;

                        showNikAlert(
                            'success',
                            'Data NIK ditemukan dan terisi otomatis.'
                        );
                    } else {
                        verifiedNik = '';

                        showNikAlert(
                            'warning',
                            result?.message ||
                            'NIK tidak ditemukan.'
                        );
                    }
                } catch (error) {
                    verifiedNik = '';

                    showNikAlert(
                        'danger',
                        'Gagal terhubung ke server: ' +
                        (
                            error.message ||
                            'Kesalahan tidak diketahui.'
                        )
                    );
                } finally {
                    setSearchLoading(false);
                }
            }

            /*
             * NIK hanya boleh angka.
             */
            inputNik.addEventListener(
                'input',
                function() {
                    this.value = this.value
                        .replace(/\D/g, '')
                        .slice(0, 16);

                    const currentValue =
                        this.value.trim();

                    if (currentValue !== verifiedNik) {
                        verifiedNik = '';
                        clearPendudukFields();

                        showNikAlert(
                            'info',
                            'Tekan tombol Cari untuk memuat data berdasarkan NIK.',
                            4000
                        );
                    }
                }
            );

            /*
             * Cari NIK.
             */
            btnCari.addEventListener(
                'click',
                function(event) {
                    event.preventDefault();

                    const nik = (
                        inputNik.value || ''
                    ).trim();

                    if (!/^\d{16}$/.test(nik)) {
                        showNikAlert(
                            'warning',
                            'NIK harus terdiri dari tepat 16 digit.'
                        );

                        inputNik.focus();

                        return;
                    }

                    cariNik(nik);
                }
            );

            /*
             * Enter pada input NIK menjalankan pencarian.
             */
            inputNik.addEventListener(
                'keydown',
                function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        btnCari.click();
                    }
                }
            );

            /*
             * Validasi password dan konfirmasi.
             */
            function validatePasswordConfirmation() {
                const password =
                    passwordInput.value;

                const confirmation =
                    passwordConfirmationInput.value;

                passwordConfirmationInput
                    .setCustomValidity('');

                passwordConfirmationError
                    .classList.add('d-none');

                if (password !== '') {
                    passwordConfirmationInput.required = true;

                    if (password !== confirmation) {
                        passwordConfirmationInput
                            .setCustomValidity(
                                'Konfirmasi password tidak sama.'
                            );

                        passwordConfirmationError
                            .classList.remove('d-none');

                        return false;
                    }
                } else {
                    passwordConfirmationInput.required = false;
                    passwordConfirmationInput.value = '';
                }

                return true;
            }

            passwordInput.addEventListener(
                'input',
                validatePasswordConfirmation
            );

            passwordConfirmationInput.addEventListener(
                'input',
                validatePasswordConfirmation
            );

            /*
             * Tampilkan atau sembunyikan password.
             */
            togglePassword.addEventListener(
                'click',
                function() {
                    const showPassword =
                        passwordInput.type === 'password';

                    passwordInput.type =
                        showPassword ?
                        'text' :
                        'password';

                    passwordConfirmationInput.type =
                        showPassword ?
                        'text' :
                        'password';

                    passwordIcon.className =
                        showPassword ?
                        'fa fa-eye-slash' :
                        'fa fa-eye';
                }
            );

            /*
             * Periksa data sebelum modal dibuka.
             */
            btnOpenConfirm.addEventListener(
                'click',
                function(event) {
                    const nik = (
                        inputNik.value || ''
                    ).trim();

                    if (!/^\d{16}$/.test(nik)) {
                        event.preventDefault();
                        event.stopImmediatePropagation();

                        showNikAlert(
                            'warning',
                            'NIK harus terdiri dari tepat 16 digit.'
                        );

                        inputNik.focus();

                        return;
                    }

                    if (nik !== verifiedNik) {
                        event.preventDefault();
                        event.stopImmediatePropagation();

                        showNikAlert(
                            'warning',
                            'Tekan tombol Cari terlebih dahulu sampai data NIK ditemukan.'
                        );

                        return;
                    }

                    if (!validatePasswordConfirmation()) {
                        event.preventDefault();
                        event.stopImmediatePropagation();

                        passwordConfirmationInput.focus();

                        return;
                    }

                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopImmediatePropagation();

                        form.reportValidity();
                    }
                }
            );

            /*
             * Saat form dikirim, tombol dibuat disabled agar
             * tidak terjadi submit dua kali.
             */
            form.addEventListener(
                'submit',
                function(event) {
                    const nik = (
                        inputNik.value || ''
                    ).trim();

                    if (
                        nik !== verifiedNik ||
                        !/^\d{16}$/.test(nik)
                    ) {
                        event.preventDefault();

                        showNikAlert(
                            'warning',
                            'Cari dan verifikasi NIK terlebih dahulu.'
                        );

                        return;
                    }

                    if (!validatePasswordConfirmation()) {
                        event.preventDefault();

                        passwordConfirmationInput.focus();

                        return;
                    }

                    confirmSave.disabled = true;

                    confirmSave.innerHTML =
                        '<span class="spinner-border ' +
                        'spinner-border-sm mr-1" ' +
                        'role="status"></span>' +
                        'Menyimpan...';
                }
            );

        });
    </script>

@endsection
