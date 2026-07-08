<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SITAKRO KEMIRIGEDE | Sistem Informasi Data Mikro Desa KEMIRIGEDE</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="/assets3/img/KEMIRIGEDE.png" type="image/x-icon">

    <!-- Fonts & CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets3/css/vendors.css" rel="stylesheet">
    <link href="/assets3/css/style.css" rel="stylesheet">
    <link href="/assets3/css/custom.css" rel="stylesheet">
</head>

<body>

<div id="preloader">
    <div data-loader="circle-side"></div>
</div>

<div class="container-fluid">
    <div class="row row-height">
        <!-- Left Background -->
        <div class="col-lg-6 background-image p-0" data-background="url(/assets3/img/bg.png)">
            <div class="content-left-wrapper opacity-mask" data-opacity-mask="rgba(13, 110, 253, 0.8)">
                <div>
                    <h1>SELAMAT DATANG DI</h1>
                    <p>Sistem Informasi Data Mikro Desa KEMIRIGEDE Kecamatan Kanigoro Kabupaten Blitar</p>
                    <a href="https://www.youtube.com/watch?v=l_nwLjT8Vzg"
                       class="btn_1 black rounded pulse_bt plus_icon btn_play" target="_blank">
                        Profil SITAKRO <i class="arrow_triangle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Form -->
        <div class="col-lg-6 d-flex flex-column content-right">
            <div class="container my-auto py-5">
                <div class="row">
                    <div class="col-lg-9 col-xl-7 mx-auto position-relative">

                        <h1 class="mb-3 text-center">
                            <img src="/assets/images/logositakro.png" alt="Logo" height="55">
                        </h1>
                        <h2 class="mb-2 text-center">MASUK</h2>
                        <h3 class="mb-4 text-center">SITAKRO KEMIRIGEDE</h3>

                        <!-- Error Message -->
                        @if ($errors->has('login'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Login Gagal!</strong> <br>
                                 {{ $errors->first('login') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email"
                                    value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Password"
                                    required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn_1 full-width">Masuk</button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="container pb-3 text-center copy">
                © Desa KEMIRIGEDE 2023 - Kabupaten Blitar<br>
                by Tim Smart Village Nasional
            </div>
        </div>
    </div>
</div>

<script src="/assets3/js/common_scripts.js"></script>
<script src="/assets3/js/common_func.js"></script>

</body>
</html>
