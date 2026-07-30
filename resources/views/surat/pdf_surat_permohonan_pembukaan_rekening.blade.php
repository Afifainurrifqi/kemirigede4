<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Surat Permohonan Pembukaan Rekening</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 1.55cm 0.9cm 1.55cm;
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
            line-height: 1.12;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        .text-justify {
            text-align: justify;
        }

        /* =========================================================
           KOP SURAT
        ========================================================= */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 12px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 105px;
            height: auto;
        }

        .kop-desa-text {
            width: 84%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
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
            margin: 6px 0 12px;
            border: 0;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
        }

        /* =========================================================
           NOMOR, LAMPIRAN, PERIHAL
        ========================================================= */
        .surat-meta {
            width: 100%;
            margin-bottom: 18px;
        }

        .surat-meta td {
            padding: 0;
            vertical-align: top;
            line-height: 1.12;
        }

        .surat-meta .label {
            width: 68px;
        }

        .surat-meta .colon {
            width: 14px;
            text-align: center;
        }

        .surat-meta .value {
            width: auto;
        }

        /* =========================================================
           TUJUAN SURAT
        ========================================================= */
        .tujuan {
            margin-bottom: 24px;
            line-height: 1.18;
        }

        .tujuan-nama {
            margin-left: 0;
            font-weight: normal;
        }

        .tujuan-alamat {
            margin-left: 32px;
        }

        /* =========================================================
           IDENTITAS PENANDATANGAN
        ========================================================= */
        .biodata-title {
            margin-bottom: 3px;
        }

        .biodata {
            width: calc(100% - 62px);
            margin-left: 62px;
            margin-bottom: 7px;
        }

        .biodata td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.15;
        }

        .biodata .label {
            width: 92px;
        }

        .biodata .colon {
            width: 14px;
            text-align: center;
        }

        .biodata .value {
            width: auto;
        }

        .indent-paragraph {
            margin-bottom: 6px;
            text-align: justify;
            text-indent: 1.1cm;
            line-height: 1.18;
        }

        /* =========================================================
           DATA REKENING
        ========================================================= */
        .rekening {
            width: calc(100% - 32px);
            margin-left: 32px;
            margin-bottom: 8px;
        }

        .rekening td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.15;
        }

        .rekening .no {
            width: 24px;
            padding-right: 9px;
            text-align: right;
        }

        .rekening .label {
            width: 220px;
        }

        .rekening .colon {
            width: 14px;
            text-align: center;
        }

        .rekening .value {
            width: auto;
        }

        /* =========================================================
           PIHAK YANG BERWENANG
        ========================================================= */
        .berwenang-wrapper {
            margin-left: 55px;
            margin-bottom: 12px;
        }

        .berwenang-item {
            width: 100%;
            margin-bottom: 4px;
            page-break-inside: avoid;
        }

        .berwenang-item td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.15;
        }

        .berwenang-item .huruf {
            width: 24px;
        }

        .berwenang-item .label {
            width: 92px;
        }

        .berwenang-item .colon {
            width: 14px;
            text-align: center;
        }

        .berwenang-item .value {
            width: auto;
        }

        /* =========================================================
           PENUTUP
        ========================================================= */
        .penutup-1 {
            margin-top: 9px;
            margin-bottom: 8px;
            text-align: justify;
            text-indent: 1.1cm;
            line-height: 1.18;
        }

        .penutup-2 {
            margin-bottom: 26px;
            text-align: justify;
            text-indent: 1.1cm;
            line-height: 1.18;
        }

        /* =========================================================
           TANDA TANGAN
        ========================================================= */
        .ttd {
            width: 330px;
            margin-right: 0;
            margin-left: auto;
            text-align: center;
            line-height: 1.12;
            page-break-inside: avoid;
        }

        .ttd .jabatan {
            margin-top: 20px;
            text-transform: uppercase;
        }

        .ttd .nama {
            margin-top: 52px;
            font-weight: bold;
            text-decoration: underline;
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
         * TANGGAL SURAT
         * =========================================================
         * Prioritas:
         * 1. tanggal_surat untuk kompatibilitas data lama;
         * 2. created_at dari MongoDB;
         * 3. tanggal saat PDF dibuat.
         */
        $sumberTanggal =
            $data->tanggal_surat ??
            $data->created_at ??
            now('Asia/Jakarta');

        try {
            $tanggalSurat = \Carbon\Carbon::parse($sumberTanggal)
                ->timezone('Asia/Jakarta')
                ->locale('id')
                 ->locale('id')->translatedFormat('d F Y');

            $tahunSurat = \Carbon\Carbon::parse($sumberTanggal)
                ->timezone('Asia/Jakarta')
                ->format('Y');
        } catch (\Throwable $e) {
            $tanggalSurat = now('Asia/Jakarta')
                ->locale('id')
                 ->locale('id')->translatedFormat('d F Y');

            $tahunSurat = now('Asia/Jakarta')->format('Y');
        }

        /*
         * =========================================================
         * FIELD BARU + FALLBACK DATA LAMA
         * =========================================================
         */
        $kepadaNamaInstansi =
            $data->kepada_nama_instansi ??
            'PT Bank BRI Unit Kemirigede';

        $kepadaAlamat =
            $data->kepada_alamat ??
            'Kemirigede';

        $ybtNama =
            $data->ybt_nama ??
            $data->nama_kepala_desa ??
            '-';

        $ybtJabatan =
            $data->ybt_jabatan ??
            $data->jabatan ??
            'KEPALA DESA Kemirigede';

        $ybtAlamat =
            $data->ybt_alamat ??
            $data->alamat_kepala_desa ??
            '-';

        $rekeningAtasNama =
            $data->rekening_atas_nama ??
            $data->atas_nama_rekening ??
            '-';

        $rekeningAlamat =
            $data->rekening_alamat ??
            $data->alamat_rekening ??
            '-';

        /*
         * =========================================================
         * DAFTAR PIHAK YANG BERWENANG
         * =========================================================
         */
        $berwenangNama = is_array($data->berwenang_nama ?? null)
            ? array_values($data->berwenang_nama)
            : array_values(
                array_filter(
                    [
                        $data->nama_pejabat1 ?? null,
                        $data->nama_pejabat2 ?? null,
                    ],
                    fn ($value) => filled($value)
                )
            );

        $berwenangJabatan = is_array($data->berwenang_jabatan ?? null)
            ? array_values($data->berwenang_jabatan)
            : array_values(
                array_filter(
                    [
                        $data->jabatan1 ?? null,
                        $data->jabatan2 ?? null,
                    ],
                    fn ($value) => filled($value)
                )
            );

        $jumlahBerwenang = max(
            (int) ($data->berwenang_jumlah ?? 0),
            count($berwenangNama),
            count($berwenangJabatan)
        );

        $daftarBerwenang = [];

        for ($i = 0; $i < $jumlahBerwenang; $i++) {
            $nama = trim((string) ($berwenangNama[$i] ?? ''));
            $jabatan = trim((string) ($berwenangJabatan[$i] ?? ''));

            if ($nama !== '' || $jabatan !== '') {
                $daftarBerwenang[] = [
                    'nama' => $nama !== '' ? $nama : '-',
                    'jabatan' => $jabatan !== '' ? $jabatan : '-',
                ];
            }
        }

        if (empty($daftarBerwenang)) {
            $daftarBerwenang[] = [
                'nama' => '-',
                'jabatan' => '-',
            ];
        }

        /*
         * nomor_surat tidak lagi ada pada Model/Controller.
         * Nilai lama tetap digunakan jika dokumen lama masih memilikinya.
         */
        $nomorSurat = app(\App\Services\NomorSuratService::class)->display($data, 'pembukaan_rekening');
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
         NOMOR, LAMPIRAN, DAN PERIHAL
    ========================================================== --}}
    <table class="surat-meta">
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td class="value">{{ $nomorSurat }}</td>
        </tr>

        <tr>
            <td class="label">Lampiran</td>
            <td class="colon">:</td>
            <td class="value">-</td>
        </tr>

        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td class="value">
                Permohonan Pembukaan Rekening Tabungan
                <br>
                a.n {{ $rekeningAtasNama }}
            </td>
        </tr>
    </table>

    {{-- =========================================================
         TUJUAN SURAT
    ========================================================== --}}
    <div class="tujuan">
        <div>Kepada Yth.</div>

        <div class="tujuan-nama">
            {{ $kepadaNamaInstansi }}
        </div>

        <div>Di</div>

        <div class="tujuan-alamat">
            {!! nl2br(e($kepadaAlamat)) !!}
        </div>
    </div>

    {{-- =========================================================
         IDENTITAS PENANDATANGAN
    ========================================================== --}}
    <p class="biodata-title">
        Yang bertanda tangan di bawah ini:
    </p>

    <table class="biodata">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="value">{{ $ybtNama }}</td>
        </tr>

        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td class="value">{{ $ybtJabatan }}</td>
        </tr>

        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {!! nl2br(e($ybtAlamat)) !!}
            </td>
        </tr>
    </table>

    <p class="indent-paragraph">
        Dengan ini kami memohon untuk membuka rekening tabungan pada
        {{ $kepadaNamaInstansi }} dengan ketentuan sebagai berikut:
    </p>

    {{-- =========================================================
         DATA REKENING
    ========================================================== --}}
    <table class="rekening">
        <tr>
            <td class="no">1.</td>
            <td class="label">Atas Nama Rekening</td>
            <td class="colon">:</td>
            <td class="value">{{ $rekeningAtasNama }}</td>
        </tr>

        <tr>
            <td class="no">2.</td>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {!! nl2br(e($rekeningAlamat)) !!}
            </td>
        </tr>

        <tr>
            <td class="no">3.</td>
            <td class="label">Pihak yang Berwenang</td>
            <td class="colon">:</td>
            <td class="value"></td>
        </tr>
    </table>

    <div class="berwenang-wrapper">
        @foreach ($daftarBerwenang as $index => $pejabat)
            <table class="berwenang-item">
                <tr>
                    <td class="huruf">
                        {{ chr(97 + $index) }}.
                    </td>

                    <td class="label">Nama</td>
                    <td class="colon">:</td>
                    <td class="value">
                        {{ $pejabat['nama'] }}
                    </td>
                </tr>

                <tr>
                    <td></td>
                    <td class="label">Jabatan</td>
                    <td class="colon">:</td>
                    <td class="value">
                        {{ $pejabat['jabatan'] }}
                    </td>
                </tr>
            </table>
        @endforeach
    </div>

    {{-- =========================================================
         PENUTUP
    ========================================================== --}}
    <p class="penutup-1">
        Selanjutnya kami menyatakan sanggup mengikuti ketentuan-ketentuan
        pembukaan rekening yang berlaku pada {{ $kepadaNamaInstansi }}.
    </p>

    <p class="penutup-2">
        Demikian surat permohonan ini kami sampaikan. Atas bantuan,
        kerja sama, dan kepercayaan yang diberikan, kami mengucapkan
        terima kasih.
    </p>

    {{-- =========================================================
         TANDA TANGAN
    ========================================================== --}}
    <div class="ttd">
        <div>
            Blitar, {{ $tanggalSurat }}
        </div>

        <div class="jabatan">
            {{ $ybtJabatan }}
        </div>

        <div class="nama">
            {{ $ybtNama }}
        </div>
    </div>
</body>

</html>
