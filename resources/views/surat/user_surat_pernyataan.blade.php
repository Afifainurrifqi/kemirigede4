<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sitakro - Aplikasi Pertanian">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>Sitakro Pelayanan Surat Pernyataan</title>

    <link rel="icon" href="{{ asset('assets4/img/core-img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets4/img/icons/icon-96x96.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets4/img/icons/icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{ asset('assets4/img/icons/icon-167x167.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets4/img/icons/icon-180x180.png') }}">
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
    <link rel="manifest" href="/assets4/dist/manifest.json">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>

    <!-- Internet Connection Status -->
    <div class="internet-connection-status" id="internetStatus"></div>

    <!-- Header Area -->
    <div class="header-area" id="headerArea">
        <div class="container">
            <div
                class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Surat Pernyataan</h6>
                </div>
                <div class="setting-wrapper"></div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">

            @php
                $rawTitles = [
                    'SURAT PERNYATAAN Kepemilikan Dokumen  Asli', // ← BARU
                    'SURAT PERNYATAAN KESANGGUPAN',
                    'Surat Pernyataan Tidak memiliki kartu JAMKESMAS,ASKES atau JKN',
                    'Surat Pernyataan Miskin',
                    'SURAT  IJIN KELUARGA',
                    'SURAT  KUASA ',
                    'Permohonan Pembukaan Rekening Tabungan ',
                    'SURAT PERINTAH TUGAS   ',
                    'SURAT PERINTAH PERJALANAN DINAS',
                    'Undangan',
                    'Rekomendasi',
                    'FORMAT BLANGKO NOTA ANGKUTAN',
                    'SURAT REKOMENDASI PEMBELIAN BBM JENIS TERTENTU',
                    'SURAT PENYELENGGARAAN KERAMAIAN',
                    'Permohonan surat  Pernyataan miskin',
                    'Surat Permohonan Tebang pohon',
                    'SURAT KETERANGAN USAHA',
                    'SURAT KETERANGAN DESA MISKIN',
                ];

                $titles = collect($rawTitles)
                    ->map(function ($t) {
                        return preg_replace('/\s+/', ' ', trim($t));
                    })
                    ->values();

                $routeMap = [
                    'SURAT PERNYATAAN KEPEMILIKAN DOKUMEN ASLI' => 'surat.user_pernyataan_kepemilikan_dokumen',
                    'SURAT PERNYATAAN KESANGGUPAN' => 'surat.user_pernyataan_kesanggupan',
                    'SURAT PERNYATAAN TIDAK MEMILIKI KARTU JAMKESMAS,ASKES ATAU JKN' =>
                        'surat.pernyataan_tidak_punya_kartu_jkn.user', // ← GANTI INI
                    'SURAT PERNYATAAN MISKIN' => 'surat.userpernyataanmiskin.index',
                    'SURAT IJIN KELUARGA' => 'surat.userijinkeluarga.index',
                    'PERMOHONAN PEMBUKAAN REKENING TABUNGAN' => 'surat.user.permohonan_rekening',
                    'SURAT PERINTAH TUGAS' => 'surat.user.perintah_tugas',
                    'SURAT PERINTAH PERJALANAN DINAS' => 'surat.user.perintah_perjalanan_dinas',
                    'UNDANGAN' => 'surat.user.undangan',
                    'REKOMENDASI' => 'surat.user.rekomendasi',
                    'FORMAT BLANGKO NOTA ANGKUTAN' => 'surat.user.nota_angkutan',
                    'SURAT REKOMENDASI PEMBELIAN BBM JENIS TERTENTU' => 'surat.user_rekomendasi_bbm',
                    'SURAT PENYELENGGARAAN KERAMAIAN' => 'surat.userkeramaian.index',
                    'PERMOHONAN SURAT PERNYATAAN MISKIN' => 'surat.userpermohonanmiskin.index',
                    'SURAT PERMOHONAN TEBANG POHON' => 'surat.user_permohonan_tebang_pohon', // ← BARU
                    'SURAT KETERANGAN USAHA' => 'surat.userusaha',
                    'SURAT KETERANGAN DESA MISKIN' => 'surat.usermiskindesa',
                    'SURAT PERNYATAAN MISKIN' => 'surat.pernyataan_miskin.user',
                    'SURAT IJIN KELUARGA' => 'surat.ijin_keluarga.user',
                    'SURAT KUASA' => 'surat.user_kuasa',
                    'PERMOHONAN SURAT PERNYATAAN MISKIN' => 'surat.user_permohonan_pernyataan_miskin',
                ];

                $colors = ['danger', 'info', 'success', 'warning', 'primary'];
            @endphp

            @foreach ($titles as $i => $titleDisplay)
                @php
                    $key = mb_strtoupper($titleDisplay, 'UTF-8');
                    $key = preg_replace('/\s+/', ' ', trim($key));

                    $routeName = $routeMap[$key] ?? null;
                    $href = $routeName && Route::has($routeName) ? route($routeName) : null;

                    $titlePretty = ucwords(strtolower($titleDisplay));
                    $subtitle = 'Surat Pernyataan';
                    $color = $colors[$i % count($colors)];
                    $textDark = in_array($color, ['success', 'warning', 'primary']) ? 'text-dark' : '';
                @endphp

                <div class="card service-card bg-{{ $color }} bg-gradient mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="service-text">
                                <h5 class="{{ $textDark }}">{{ $titlePretty }}</h5>
                                <p class="mb-0 {{ $textDark }}">{{ $subtitle }}</p>
                            </div>
                            <div class="service-img">
                                @if ($href)
                                    <a class="btn m-1 btn-creative btn-light" href="{{ $href }}">Buat Surat</a>
                                @else
                                    <button class="btn m-1 btn-creative btn-light" type="button"
                                        disabled>Maintance</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- Footer Nav -->
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

    <!-- All JavaScript Files -->
    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/slideToggle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/internet-status.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/venobox.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/countdown.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/rangeslider.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/vanilla-dataTables.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/index.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/dark-rtl.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/pwa.js') }}"></script>
</body>

</html>
