<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Surat Perintah Tugas</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 1.55cm 1cm 1.55cm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            color: #000;
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.18;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        /* =========================================================
           KOP SURAT
        ========================================================= */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-desa-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            padding: 0;
            vertical-align: middle;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
        }

        .kop-desa-logo img {
            width: 100px;
            height: auto;
        }

        .kop-desa-text {
            width: 84%;
            text-align: center;
            line-height: 1.12;
        }

        .kop-desa-1,
        .kop-desa-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            margin-top: 2px;
            font-size: 11pt;
        }

        .kop-desa-kontak {
            font-size: 10pt;
        }

        .kop-desa-garis {
            height: 3px;
            margin: 5px 0 10px;
            border: 0;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
        }

        /* =========================================================
           JUDUL DAN NOMOR
        ========================================================= */
        .judul {
            margin-top: 10px;
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .nomor {
            margin-top: 2px;
            margin-bottom: 15px;
            text-align: center;
        }

        /* =========================================================
           DASAR
        ========================================================= */
        .dasar-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .dasar-table td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.18;
        }

        .dasar-label {
            width: 88px;
        }

        .dasar-colon {
            width: 14px;
            text-align: center;
        }

        .dasar-number {
            width: 25px;
            text-align: right;
            padding-right: 7px !important;
        }

        .dasar-text {
            text-align: justify;
        }

        /* =========================================================
           PENERIMA TUGAS
        ========================================================= */
        .section-label {
            margin-top: 5px;
            margin-bottom: 3px;
        }

        .penerima-wrapper {
            margin-left: 30px;
            margin-bottom: 10px;
        }

        .penerima-table {
            width: 100%;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }

        .penerima-table td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.18;
        }

        .penerima-no {
            width: 28px;
        }

        .penerima-label {
            width: 95px;
        }

        .penerima-colon {
            width: 14px;
            text-align: center;
        }

        /* =========================================================
           UNTUK DAN PENUTUP
        ========================================================= */
        .untuk-table {
            width: 100%;
            margin-top: 7px;
            margin-bottom: 12px;
        }

        .untuk-table td {
            padding: 0;
            vertical-align: top;
            line-height: 1.22;
        }

        .untuk-label {
            width: 88px;
            font-weight: bold;
        }

        .untuk-colon {
            width: 14px;
            text-align: center;
            font-weight: bold;
        }

        .untuk-text {
            text-align: justify;
        }

        .penutup {
            margin-top: 7px;
            margin-bottom: 18px;
            text-align: justify;
            text-indent: 1.1cm;
            line-height: 1.22;
        }

        /* =========================================================
           TANDA TANGAN
        ========================================================= */
        .ttd {
            width: 330px;
            margin-right: 0;
            margin-left: auto;
            text-align: center;
            line-height: 1.15;
            page-break-inside: avoid;
        }

        .ttd-jabatan {
            margin-top: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .ttd-img-wrapper {
            height: 58px;
            margin-top: 4px;
            text-align: center;
        }

        .ttd-img {
            width: 145px;
            height: auto;
        }

        .nama-kades {
            margin-top: 3px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .qr-section {
            margin-top: 5px;
            text-align: center;
        }

        .qr-section img {
            width: 65px;
            height: auto;
        }

        .qr-section small {
            display: block;
            color: #444;
            font-size: 7pt;
            line-height: 1.15;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    @php
        /*
         * =========================================================
         * TANGGAL DAN NOMOR TAMPILAN
         * =========================================================
         * Model tidak menyimpan nomor_surat dan tanggal_surat.
         * created_at dipakai sebagai tanggal pembuatan surat.
         */
        $sumberTanggal = $data->created_at ?? now('Asia/Jakarta');

        try {
            $tanggalSurat = \Carbon\Carbon::parse($sumberTanggal)
                ->timezone('Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('d F Y');

            $tahunSurat = \Carbon\Carbon::parse($sumberTanggal)
                ->timezone('Asia/Jakarta')
                ->format('Y');
        } catch (\Throwable $e) {
            $tanggalSurat = now('Asia/Jakarta')
                ->locale('id')
                ->translatedFormat('d F Y');

            $tahunSurat = now('Asia/Jakarta')->format('Y');
        }

        /*
         * nomor_surat hanya dibaca sebagai fallback untuk data lama.
         * Data baru menampilkan format nomor yang dapat diisi manual.
         */
        $nomorSurat = filled($data->nomor_surat ?? null)
            ? $data->nomor_surat
            : '094 /        / 409.41.2 / ' . $tahunSurat;

        /*
         * =========================================================
         * DASAR SURAT
         * =========================================================
         */
        if (is_array($data->dasar ?? null)) {
            $daftarDasar = array_values(
                array_filter(
                    array_map(
                        static fn ($item) => trim((string) $item),
                        $data->dasar
                    ),
                    static fn ($item) => $item !== ''
                )
            );
        } elseif (filled($data->dasar ?? null)) {
            $daftarDasar = [trim((string) $data->dasar)];
        } else {
            $daftarDasar = [];
        }

        /*
         * =========================================================
         * PENERIMA TUGAS BARU + FALLBACK DATA LAMA
         * =========================================================
         */
        if (is_array($data->penerima_tugas ?? null)) {
            $penerimaTugas = array_values($data->penerima_tugas);
        } elseif (
            filled($data->nama_penerima ?? null) ||
            filled($data->jabatan_penerima ?? null)
        ) {
            $penerimaTugas = [
                [
                    'nama' => $data->nama_penerima ?? '-',
                    'kedudukan' => $data->jabatan_penerima ?? '-',
                ],
            ];
        } else {
            $penerimaTugas = [];
        }

        $penerimaTugas = array_values(
            array_filter(
                array_map(
                    static function ($item) {
                        $item = is_array($item) ? $item : [];

                        $nama = trim((string) ($item['nama'] ?? ''));
                        $kedudukan = trim(
                            (string) ($item['kedudukan'] ?? '')
                        );

                        if ($nama === '' && $kedudukan === '') {
                            return null;
                        }

                        return [
                            'nama' => $nama !== '' ? $nama : '-',
                            'kedudukan' =>
                                $kedudukan !== '' ? $kedudukan : '-',
                        ];
                    },
                    $penerimaTugas
                )
            )
        );

        if (count($penerimaTugas) === 0) {
            $penerimaTugas = [
                [
                    'nama' => '...........................................',
                    'kedudukan' => '...........................................',
                ],
            ];
        }

        /*
         * =========================================================
         * BAGIAN UNTUK BARU + FALLBACK DATA LAMA
         * =========================================================
         */
        $uraianUntuk = trim((string) ($data->untuk ?? ''));

        if ($uraianUntuk === '') {
            $bagianUntuk = [];

            if (filled($data->untuk_mengikuti ?? null)) {
                $bagianUntuk[] = trim(
                    (string) $data->untuk_mengikuti
                );
            }

            $detailKegiatan = [];

            if (filled($data->hari ?? null)) {
                $detailKegiatan[] =
                    'pada hari ' . trim((string) $data->hari);
            }

            if (filled($data->tanggal_kegiatan ?? null)) {
                try {
                    $tanggalKegiatan = \Carbon\Carbon::parse(
                        $data->tanggal_kegiatan
                    )
                        ->locale('id')
                        ->translatedFormat('d F Y');
                } catch (\Throwable $e) {
                    $tanggalKegiatan =
                        (string) $data->tanggal_kegiatan;
                }

                $detailKegiatan[] =
                    'tanggal ' . $tanggalKegiatan;
            }

            if (filled($data->waktu_mulai ?? null)) {
                $detailKegiatan[] =
                    'pukul ' .
                    trim((string) $data->waktu_mulai) .
                    ' WIB sampai selesai';
            }

            if (filled($data->tempat_kegiatan ?? null)) {
                $detailKegiatan[] =
                    'bertempat di ' .
                    trim((string) $data->tempat_kegiatan);
            }

            if (count($detailKegiatan) > 0) {
                $bagianUntuk[] = implode(', ', $detailKegiatan);
            }

            if (filled($data->keterangan_tugas ?? null)) {
                $bagianUntuk[] = trim(
                    (string) $data->keterangan_tugas
                );
            }

            $uraianUntuk = implode('. ', array_filter($bagianUntuk));

            if (
                filled($uraianUntuk) &&
                !str_ends_with($uraianUntuk, '.')
            ) {
                $uraianUntuk .= '.';
            }
        }

        if ($uraianUntuk === '') {
            $uraianUntuk = '.................................................................';
        }

        /*
         * Penandatangan dibuat tetap karena tidak disimpan dalam Model.
         */
        $jabatanKades = 'KEPALA DESA Kemirigede';
        $namaKades = 'Hari Purnawan, S.Sos.';
    @endphp

    {{-- =========================================================
         KOP SURAT
    ========================================================== --}}
    <div class="kop-desa-container">
        <table class="kop-desa-table">
            <tr>
                <td class="kop-desa-logo">
                    <img
                        src="{{ public_path('assets/images/blitar.jpg') }}"
                        alt="Logo Kabupaten Blitar"
                    >
                </td>

                <td class="kop-desa-text">
                    <div class="kop-desa-1">
                        PEMERINTAH KABUPATEN BLITAR
                    </div>

                    <div class="kop-desa-2">
                        KECAMATAN KESAMBEN
                    </div>

                    <div class="kop-desa-3">
                        PEMERINTAH DESA Kemirigede
                    </div>

                    <div class="kop-desa-alamat">
                        Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445
                    </div>

                    <div class="kop-desa-kontak">
                        email: pemdeskemirigede@gmail.com /
                        website: Kemirigede-blitarkab.desa.id
                    </div>
                </td>
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    {{-- =========================================================
         JUDUL DAN NOMOR
    ========================================================== --}}
    <div class="judul">
        SURAT PERINTAH TUGAS
    </div>

    <div class="nomor">
        Nomor: {{ $nomorSurat }}
    </div>

    {{-- =========================================================
         DASAR SURAT
    ========================================================== --}}
    <table class="dasar-table">
        @if (count($daftarDasar) > 0)
            @foreach ($daftarDasar as $index => $dasar)
                <tr>
                    @if ($index === 0)
                        <td
                            class="dasar-label"
                            rowspan="{{ count($daftarDasar) }}"
                        >
                            <strong>Dasar</strong>
                        </td>

                        <td
                            class="dasar-colon"
                            rowspan="{{ count($daftarDasar) }}"
                        >
                            :
                        </td>
                    @endif

                    <td class="dasar-number">
                        {{ $index + 1 }}.
                    </td>

                    <td class="dasar-text">
                        {{ $dasar }}
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="dasar-label">
                    <strong>Dasar</strong>
                </td>

                <td class="dasar-colon">:</td>

                <td class="dasar-number">1.</td>

                <td class="dasar-text">
                    ............................................................
                </td>
            </tr>
        @endif
    </table>

    {{-- =========================================================
         DIPERINTAHKAN KEPADA
    ========================================================== --}}
    <p class="section-label">
        <strong>Diperintahkan kepada:</strong>
    </p>

    <div class="penerima-wrapper">
        @foreach ($penerimaTugas as $index => $penerima)
            <table class="penerima-table">
                <tr>
                    <td class="penerima-no">
                        {{ $index + 1 }}.
                    </td>

                    <td class="penerima-label">
                        Nama
                    </td>

                    <td class="penerima-colon">
                        :
                    </td>

                    <td>
                        {{ $penerima['nama'] }}
                    </td>
                </tr>

                <tr>
                    <td></td>

                    <td class="penerima-label">
                        Kedudukan
                    </td>

                    <td class="penerima-colon">
                        :
                    </td>

                    <td>
                        {{ $penerima['kedudukan'] }}
                    </td>
                </tr>
            </table>
        @endforeach
    </div>

    {{-- =========================================================
         UNTUK
    ========================================================== --}}
    <table class="untuk-table">
        <tr>
            <td class="untuk-label">
                Untuk
            </td>

            <td class="untuk-colon">
                :
            </td>

            <td class="untuk-text">
                {!! nl2br(e($uraianUntuk)) !!}
            </td>
        </tr>
    </table>

    {{-- =========================================================
         PENUTUP
    ========================================================== --}}
    <p class="penutup">
        Demikian surat tugas ini diberikan untuk dilaksanakan
        sebaik-baiknya dan dapat dipergunakan sebagaimana perlunya.
    </p>

    {{-- =========================================================
         TANDA TANGAN
    ========================================================== --}}
    <div class="ttd">
        <div>
            Kemirigede, {{ $tanggalSurat }}
        </div>

        <div class="ttd-jabatan">
            {{ $jabatanKades }}
        </div>

        {{-- <div class="ttd-img-wrapper">
            @if (file_exists(public_path('assets/images/ttd.png')))
                <img
                    src="{{ public_path('assets/images/ttd.png') }}"
                    class="ttd-img"
                    alt="Tanda Tangan"
                >
            @endif
        </div> --}}

        <br><br><br><br><br><br>

        <div class="nama-kades">
            {{ $namaKades }}
        </div>

        {{-- @if (file_exists(public_path('assets/images/barcode.png')))
            <div class="qr-section">
                <img
                    src="{{ public_path('assets/images/barcode.png') }}"
                    alt="QR Code"
                >

                <small>
                    Scan untuk verifikasi surat resmi Desa Kemirigede
                </small>
            </div>
        @endif --}}
    </div>
</body>

</html>
