<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SI TAKRO</title>

    <!-- Tambahkan CSRF meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/Kemirigede2.png">

    <!-- Pignose Calender -->
    <link href="/assets/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="/assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">

    <!-- Custom Stylesheet & vendor CSS -->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
</head>

<body>
    <style>
        .surat-notification-link {
            position: relative;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            min-height: 44px;
        }

        .surat-notification-link i {
            font-size: 21px;
        }

        .surat-notification-badge {
            position: absolute;
            top: 1px;
            right: 1px;
            min-width: 19px;
            height: 19px;
            padding: 2px 5px;
            border-radius: 10px;
            font-size: 11px;
            line-height: 15px;
            text-align: center;
        }

        .surat-notification-dropdown {
            width: 380px;
            max-width: calc(100vw - 30px);
            padding: 0;
        }

        .surat-notification-heading {
            padding: 14px 16px;
            border-bottom: 1px solid #eeeeee;
            font-weight: 600;
        }

        .surat-notification-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .surat-notification-item {
            display: block;
            padding: 12px 16px;
            color: #333333;
            white-space: normal;
            border-bottom: 1px solid #eeeeee;
            transition: background-color 0.2s ease;
        }

        .surat-notification-item:hover {
            color: #333333;
            text-decoration: none;
            background-color: #f5f5f5;
        }

        .surat-notification-title {
            display: block;
            margin-bottom: 3px;
            font-weight: 600;
            line-height: 1.35;
        }

        .surat-notification-name {
            display: block;
            font-size: 12px;
            color: #555555;
        }

        .surat-notification-time {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            color: #999999;
        }

        .surat-notification-empty {
            padding: 25px 15px;
            text-align: center;
            color: #999999;
        }

        .surat-notification-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
        }

        .surat-notification-footer a,
        .surat-notification-footer button {
            font-size: 12px;
        }

        @media (max-width: 576px) {
            .surat-notification-dropdown {
                width: 320px;
            }
        }
    </style>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        <!-- Nav header -->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}">
                    <b class="logo-abbr"><img src="/assets/images/logositakro.png" alt=""></b>
                    <span class="logo-compact"><img src="/assets/images/logositakro.png" alt=""></span>
                    <span class="brand-title">
                        <img src="/assets/images/logositakro.png" width="120" alt="">
                    </span>
                </a>
            </div>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-content clearfix">

                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <div class="input-group icons">
                        <span class="brand-title">
                            <img src="/assets/images/Kemirigede2.png" style="width:20%" alt="">
                        </span>
                        <span class="nav-link" style="font-weight: bold; font-size: 16px;">Haloo,
                            {{ Auth::user()->role }}</span>
                    </div>
                </div>
                <div class="header-right">
                    <ul class="clearfix">

                        {{-- ====================================================== --}}
                        {{-- NOTIFIKASI PENGAJUAN SURAT --}}
                        {{-- ====================================================== --}}
                        @if (Auth::check() && strtolower(Auth::user()->role) === 'admin')
                            <li class="icons dropdown" id="surat-notification-wrapper">

                                <a href="javascript:void(0)" class="nav-link surat-notification-link"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    title="Notifikasi pengajuan surat">

                                    <i class="fas fa-bell"></i>

                                    <span id="surat-notification-count"
                                        class="badge badge-danger surat-notification-badge"
                                        style="{{ ($jumlahNotifikasiSurat ?? 0) > 0 ? '' : 'display: none;' }}">
                                        {{ $jumlahNotifikasiSurat ?? 0 }}
                                    </span>
                                </a>

                                <div
                                    class="drop-down dropdown-menu dropdown-menu-right animated fadeIn surat-notification-dropdown">

                                    <div class="surat-notification-heading">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Pengajuan Surat Baru</span>

                                            <span id="surat-notification-heading-count" class="badge badge-danger">
                                                {{ $jumlahNotifikasiSurat ?? 0 }}
                                            </span>
                                        </div>
                                    </div>

                                    <div id="surat-notification-list" class="surat-notification-list">

                                        @forelse ($notifikasiSurat ?? [] as $notifikasi)
                                            <a href="{{ route('notifikasi-surat.buka', ['id' => (string) $notifikasi->getKey()]) }}"
                                                class="surat-notification-item">

                                                <span class="surat-notification-title">
                                                    {{ $notifikasi->jenis_surat ?: 'Pengajuan Surat' }}
                                                </span>

                                                <span class="surat-notification-name">
                                                    Diajukan oleh:
                                                    {{ $notifikasi->nama_pemohon ?: 'Pemohon' }}
                                                </span>

                                                <span class="surat-notification-time">
                                                    <i class="far fa-clock mr-1"></i>

                                                    {{ $notifikasi->created_at ? $notifikasi->created_at->diffForHumans() : '' }}
                                                </span>
                                            </a>
                                        @empty
                                            <div class="surat-notification-empty">
                                                <i class="far fa-bell-slash mb-2" style="font-size: 25px;"></i>

                                                <div>
                                                    Belum ada pengajuan surat baru.
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>

                                    <div class="surat-notification-footer">

                                        <button type="button" id="surat-notification-read-all"
                                            class="btn btn-sm btn-link p-0">
                                            Tandai semua dibaca
                                        </button>

                                        <a href="{{ route('surat.keluar') }}">
                                            Lihat semua pengajuan
                                        </a>

                                    </div>
                                </div>
                            </li>
                        @endif

                        {{-- ====================================================== --}}
                        {{-- PROFIL ADMIN --}}
                        {{-- ====================================================== --}}
                        <li class="icons dropdown">
                            <div class="user-img c-pointer position-relative" data-toggle="dropdown">

                                <span class="activity active"></span>

                                <img src="/assets/images/Kemirigede2.png" height="40" width="40"
                                    alt="Profil">
                            </div>

                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="{{ route('logout') }}">
                                                <i class="icon-key"></i>
                                                <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
        <div class="nk-sidebar">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a class="nav-link {{ request()->segment('1') == 'home' ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt menu-icon"></i><span class="nav-text">Dashboard
                                Admin</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="nav-link" href="{{ route('datapenduduk.index_admin') }}">
                            <i class="fas fa-users menu-icon"></i><span class="nav-text">Data Penduduk</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="nav-link" href="{{ '/datamutasi/admin' }}">
                            <i class="fas fa-random menu-icon"></i><span class="nav-text">Data Mutasi</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="nav-link" href="{{ route('dasawisma.index_admin') }}">
                            <i class="fas fa-home menu-icon"></i><span class="nav-text">Data Dasa wisma</span>
                        </a>
                    </li>

                    <li class="nav-label">SGDS Desa</li>

                    <li>
                        <a class="has-arrow nav-link" href="javascript:void(0)">
                            <i class="fas fa-user menu-icon"></i><span class="nav-text">Individu</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('individu.admin') }}">Data individu</a></li>
                            <li><a href="{{ route('pekerjaan.admin_index') }}">Pekerjaan</a></li>
                            <li><a href="{{ route('datapenghasilan.admin_index') }}">Penghasilan</a></li>
                            <li><a href="{{ route('datakesehatan.admin_index') }}">Kesehatan</a></li>
                            <li><a href="{{ route('disabilitas.admin_index') }}">Jenis disabilitas</a></li>
                            <li><a href="{{ route('pendidikan.admin_index') }}">Pendidikan</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow nav-link" href="javascript:void(0)">
                            <i class="fas fa-id-card menu-icon"></i><span class="nav-text">KK</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('lokasipemukiman.admin_index') }}">Lokasi dan pemukiman</a></li>
                            <li><a href="{{ route('aksespendidikan.admin_index') }}">Akses pendidikan</a></li>
                            <li><a href="{{ route('akseskesehatan.admin_index') }}">Akses kesehatan</a></li>
                            <li><a href="{{ route('aksestenagakerja.admin_index') }}">Akses tenaga kesehatan</a></li>
                            <li><a href="{{ route('aksessarpras.admin_index') }}">Akses sarana prasarana</a></li>
                            <li><a href="{{ route('laink.admin_index') }}">Lain-lain</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow nav-link" href="javascript:void(0)">
                            <i class="fas fa-house-user menu-icon"></i><span class="nav-text">RT</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('datart.admin_index') }}">Data RT</a></li>
                            <li><a href="{{ route('rtlokasi.admin_index') }}">Lokasi</a></li>
                            <li><a href="{{ route('rtpengurus.admin_index') }}">Pengurus</a></li>
                            <li><a href="{{ route('rtlembaga_ekonomi.admin_index') }}">Lembaga Ekonomi</a></li>
                            <li><a href="{{ route('rtindustri.admin_index') }}">Industri</a></li>
                            <li><a href="{{ route('rtsare.admin_index') }}">Sarana Ekonomi</a></li>
                            <li><a href="{{ route('rt_fasilitas_ekonomi.admin_index') }}">Fasilitas Ekonomi</a></li>
                            <li><a href="{{ route('rtinfrastuktur.admin_index') }}">Infrastuktur</a></li>
                            <li><a href="{{ route('rtlingkungan.admin_index') }}">Lingkungan</a></li>
                            <li><a href="{{ route('rtbencana.admin_index') }}">Bencana</a></li>
                            <li><a href="{{ route('rtmitigasib.admin_index') }}">Mitigasi Bencana</a></li>
                            <li><a href="{{ route('rt_saranapendidikan.admin_index') }}">Sarana pendidikan</a></li>
                            <li><a href="{{ route('rt_kesehatan.admin_index') }}">Kesehatan</a></li>
                            <li><a href="{{ route('rt_kejadianluarbiasa.admin_index') }}">Kejadian Luar biasa</a></li>
                            <li><a href="{{ route('rt_agama.admin_index') }}">Agama/Sosbud</a></li>
                            <li><a href="{{ route('rtlembaga_keagamaan.admin_index') }}">Lembaga agama</a></li>
                            <li><a href="{{ route('rtlembaga_masyarakat.admin_index') }}">Lembaga masyarakat</a></li>
                            <li><a href="{{ route('rt_keamanan.admin_index') }}">Keamanan</a></li>
                            <li><a href="{{ route('rt_tkejahatan.admin_index') }}">Tindak kejahatan</a></li>
                            <li><a href="{{ route('rt_kegiatanwarga.admin_index') }}">Kegiatan Warga...</a></li>
                        </ul>
                    </li>

                    <li>
                        <a class="has-arrow nav-link" href="javascript:void(0)">
                            <i class="fas fa-envelope menu-icon"></i><span class="nav-text">Pelayanan Surat</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('surat.masuk') }}">Surat Masuk</a></li>
                            <li><a href="{{ route('surat.keluar') }}">Surat Keluar</a></li>
                            <li><a href="{{ route('surat.arsipsuratkeluar') }}">Arsip Surat Keluar</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>

        <!-- Content -->
        <div class="content-body">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed & Developed by
                    <a href="https://wa.me/62811988274">Tim Smart Village Nasional</a> 2023
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts (vendor) -->



    <script src="/assets/plugins/common/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
    <script src="/assets/js/styleSwitcher.js"></script>

    <script src="/assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="/assets/plugins/circle-progress/circle-progress.min.js"></script>
    <script src="/assets/plugins/d3v3/index.js"></script>
    <script src="/assets/plugins/topojson/topojson.min.js"></script>
    <script src="/assets/plugins/datamaps/datamaps.world.min.js"></script>
    <script src="/assets/plugins/raphael/raphael.min.js"></script>
    <script src="/assets/plugins/morris/morris.min.js"></script>
    <script src="/assets/js/plugins-init/morris-init.js"></script>
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <script src="/assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>
    <script src="/assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.8/datatables.min.js"></script>
    <script src="/assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
    <script src="/assets/js/dashboard/dashboard-1.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    {{-- Penting: tempatkan script view --}}

    @if (Auth::check() && strtolower(Auth::user()->role) === 'admin')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const notificationDataUrl =
                    @json(route('notifikasi-surat.data'));

                const notificationReadAllUrl =
                    @json(route('notifikasi-surat.tandai-semua'));

                const csrfToken =
                    document.querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content');

                const countElement =
                    document.getElementById('surat-notification-count');

                const headingCountElement =
                    document.getElementById(
                        'surat-notification-heading-count'
                    );

                const listElement =
                    document.getElementById('surat-notification-list');

                const readAllButton =
                    document.getElementById(
                        'surat-notification-read-all'
                    );

                /**
                 * Mengamankan teks dari karakter HTML.
                 */
                function escapeHtml(value) {
                    return String(value ?? '').replace(
                        /[&<>"']/g,
                        function(character) {
                            const characters = {
                                '&': '&amp;',
                                '<': '&lt;',
                                '>': '&gt;',
                                '"': '&quot;',
                                "'": '&#039;'
                            };

                            return characters[character];
                        }
                    );
                }

                /**
                 * Memperbarui badge jumlah notifikasi.
                 */
                function updateCount(count) {
                    const total = Number(count) || 0;

                    if (countElement) {
                        countElement.textContent = total;
                        countElement.style.display =
                            total > 0 ? 'inline-block' : 'none';
                    }

                    if (headingCountElement) {
                        headingCountElement.textContent = total;
                    }

                    if (readAllButton) {
                        readAllButton.disabled = total === 0;
                    }
                }

                /**
                 * Menampilkan daftar notifikasi.
                 */
                function renderNotificationList(items) {
                    if (!listElement) {
                        return;
                    }

                    if (!Array.isArray(items) || items.length === 0) {
                        listElement.innerHTML = `
                        <div class="surat-notification-empty">
                            <i class="far fa-bell-slash mb-2"
                               style="font-size: 25px;"></i>

                            <div>
                                Belum ada pengajuan surat baru.
                            </div>
                        </div>
                    `;

                        return;
                    }

                    listElement.innerHTML = items.map(function(item) {
                        return `
                        <a
                            href="${escapeHtml(item.url)}"
                            class="surat-notification-item">

                            <span class="surat-notification-title">
                                ${escapeHtml(item.jenis_surat)}
                            </span>

                            <span class="surat-notification-name">
                                Diajukan oleh:
                                ${escapeHtml(item.nama_pemohon)}
                            </span>

                            <span class="surat-notification-time">
                                <i class="far fa-clock mr-1"></i>
                                ${escapeHtml(item.waktu)}
                            </span>
                        </a>
                    `;
                    }).join('');
                }

                /**
                 * Mengambil notifikasi terbaru dari server.
                 */
                async function refreshNotifikasiSurat() {
                    try {
                        const response = await fetch(
                            notificationDataUrl, {
                                method: 'GET',
                                credentials: 'same-origin',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }
                        );

                        /*
                         * Session habis atau tidak lagi terautentikasi.
                         */
                        if (
                            response.status === 401 ||
                            response.status === 403
                        ) {
                            return;
                        }

                        if (!response.ok) {
                            throw new Error(
                                'HTTP error ' + response.status
                            );
                        }

                        const result = await response.json();

                        if (!result.success) {
                            return;
                        }

                        updateCount(result.count);
                        renderNotificationList(result.items);

                    } catch (error) {
                        console.error(
                            'Gagal mengambil notifikasi surat:',
                            error
                        );
                    }
                }

                /**
                 * Menandai semua notifikasi sudah dibaca.
                 */
                async function tandaiSemuaDibaca() {
                    if (!readAllButton) {
                        return;
                    }

                    readAllButton.disabled = true;

                    try {
                        const response = await fetch(
                            notificationReadAllUrl, {
                                method: 'POST',
                                credentials: 'same-origin',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({})
                            }
                        );

                        if (!response.ok) {
                            throw new Error(
                                'HTTP error ' + response.status
                            );
                        }

                        const result = await response.json();

                        if (result.success) {
                            updateCount(0);
                            renderNotificationList([]);
                        }

                    } catch (error) {
                        console.error(
                            'Gagal menandai notifikasi:',
                            error
                        );

                        readAllButton.disabled = false;
                    }
                }

                if (readAllButton) {
                    readAllButton.addEventListener(
                        'click',
                        tandaiSemuaDibaca
                    );
                }

                /*
                 * Ambil data ketika halaman pertama dibuka.
                 */
                refreshNotifikasiSurat();

                /*
                 * Periksa pengajuan baru setiap 10 detik.
                 */
                window.setInterval(
                    refreshNotifikasiSurat,
                    10000
                );
            });
        </script>
    @endif

    @yield('scripts')
</body>

</html>
