<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Rekomendasi - Desa Kemirigede</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.45cm 1.65cm 1.2cm 1.65cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.25;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 38px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            padding: 0;
            vertical-align: middle;
            border: none;
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
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-desa-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

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
            font-size: 11pt;
            margin-top: 2px;
        }

        .kop-desa-kontak {
            font-size: 10pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 6px 0 0 0;
        }

        /* =========================
           HEADER SURAT
        ========================= */
        .header-surat {
            width: 100%;
            margin-bottom: 54px;
        }

        .header-left {
            width: 62%;
        }

        .header-right {
            width: 38%;
        }

        .meta-table {
            width: 100%;
        }

        .meta-table td {
            padding: 0 0 9px 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            line-height: 1.15;
        }

        .meta-label {
            width: 75px;
        }

        .meta-colon {
            width: 18px;
            text-align: center;
        }

        .tujuan {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            line-height: 1.9;
        }

        .tempat {
            display: inline-block;
            margin-left: 42px;
            font-weight: normal;
            text-transform: uppercase;
            text-decoration: underline;
        }

        /* =========================
           ISI SURAT
        ========================= */
        .paragraph {
            text-align: justify;
            margin-bottom: 10px;
            line-height: 1.45;
        }

        .indent {
            text-indent: 1.65cm;
        }

        .data-table {
            width: 78%;
            margin-left: 1.65cm;
            margin-top: 4px;
            margin-bottom: 10px;
        }

        .data-table td {
            padding: 3px 0;
            line-height: 1.38;
        }

        .data-table .label {
            width: 120px;
        }

        .data-table .colon {
            width: 18px;
            text-align: center;
        }

        .data-table .value {
            width: auto;
        }

        .kegiatan-table {
            width: 78%;
            margin-left: 1.65cm;
            margin-top: 4px;
            margin-bottom: 10px;
        }

        .kegiatan-table td {
            padding: 3px 0;
            line-height: 1.38;
        }

        .kegiatan-table .label {
            width: 120px;
        }

        .kegiatan-table .colon {
            width: 18px;
            text-align: center;
        }

        .kegiatan-table .value {
            width: auto;
        }

        /* =========================
           TANDA TANGAN
        ========================= */
        .ttd-table {
            width: 100%;
            margin-top: 36px;
            border-collapse: collapse;
        }

        .ttd-left {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        .ttd-right {
            width: 50%;
            text-align: center;
            vertical-align: top;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
        }

        .ttd-left p,
        .ttd-right p {
            text-align: center;
            margin: 0;
            padding: 0;
            line-height: 1.45;
        }

        .space-pemohon {
            height: 95px;
        }

        .ttd-img-wrapper {
            width: 125px;
            height: 75px;
            margin: 8px auto 2px auto;
            text-align: center;
        }

        .ttd-img {
            max-width: 125px;
            max-height: 75px;
            display: inline-block;
        }

        .nama-pemohon {
            font-weight: normal;
        }

        .nama-kades {
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            line-height: 1.25;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 6px 0 0 0;
            }
        }
    </style>
</head>

<body>
@php
    $tanggalSurat = !empty($data->tanggal_surat)
        ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id') ->locale('id')->translatedFormat('d F Y')
        : now('Asia/Jakarta')->locale('id') ->locale('id')->translatedFormat('d F Y');

    $tahunSurat = !empty($data->tanggal_surat)
        ? \Carbon\Carbon::parse($data->tanggal_surat)->format('Y')
        : now('Asia/Jakarta')->format('Y');

    $tanggalMulai = !empty($data->tanggal_mulai)
        ? \Carbon\Carbon::parse($data->tanggal_mulai)->locale('id')
        : null;

    $tanggalSelesai = !empty($data->tanggal_selesai)
        ? \Carbon\Carbon::parse($data->tanggal_selesai)->locale('id')
        : null;

    if ($tanggalMulai && $tanggalSelesai) {
        if ($tanggalMulai->format('Y-m') === $tanggalSelesai->format('Y-m')) {
            $rentangTanggal = $tanggalMulai->format('j') . ' - ' . $tanggalSelesai->translatedFormat('j F Y');
        } elseif ($tanggalMulai->format('Y') === $tanggalSelesai->format('Y')) {
            $rentangTanggal = $tanggalMulai->translatedFormat('j F') . ' - ' . $tanggalSelesai->translatedFormat('j F Y');
        } else {
            $rentangTanggal = $tanggalMulai->translatedFormat('j F Y') . ' - ' . $tanggalSelesai->translatedFormat('j F Y');
        }
    } else {
        $rentangTanggal = '-';
    }

    $nomorSurat = $data->nomor_surat ?? '500/113/409.41.2/' . $tahunSurat;
    $perihal = $data->perihal ?? 'Rekomendasi';

    $namaPemohon = $data->nama ?? 'Agus Setyawan';
    $nikPemohon = $data->nik ?? '3572011108900001';

    $alamatPemohon = $data->alamat
        ?? 'Dsn. Sumberejo RT 003 RW 003 Desa Sumberejo Kecamatan Sanankulon Kabupaten Blitar';

    $kegiatan = $data->kegiatan ?? 'Pasar Malam';
    $pukul = $data->pukul ?? $data->waktu ?? '17.00 - Selesai';
    $tempat = $data->tempat ?? 'Lapangan Desa Kemirigede Kab Blitar';
    $keperluan = $data->keperluan ?? 'Pasar Malam';

    $namaKades = $data->nama_kepala_desa ?? 'Hari Purnawan, S.Sos.';
    $namaKadesFormatted = str_replace(', ', ",\n", $namaKades);
@endphp

    <!-- KOP SURAT -->
    <div class="kop-desa-container">
        <table class="kop-desa-table">
            <tr>
                <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-desa-text">
                    <div class="kop-desa-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="kop-desa-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-desa-3">PEMERINTAH DESA Kemirigede</div>
                    <div class="kop-desa-alamat">Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email :pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                {{-- <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    <!-- NOMOR, PERIHAL, DAN TUJUAN -->
    <table class="header-surat">
        <tr>
            <td class="header-left">
                <table class="meta-table">
                    <tr>
                        <td class="meta-label">Nomor</td>
                        <td class="meta-colon">:</td>
                        <td>{{ $nomorSurat }}</td>
                    </tr>
                    <tr>
                        <td class="meta-label">Perihal</td>
                        <td class="meta-colon">:</td>
                        <td>{{ $perihal }}</td>
                    </tr>
                </table>
            </td>

            <td class="header-right">
                <div class="tujuan">
                    Kepada :<br>
                    Yth. Muspika Kecamatan Kesamben<br>
                    Di<br>
                    <span class="tempat">TEMPAT</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- ISI SURAT -->
    <p class="paragraph indent">
        Yang bertandatangan dibawah ini KEPALA DESA Kemirigede Kecamatan Kesamben Kabupaten Blitar menerangkan bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="value">{{ $namaPemohon }}</td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td class="value">{{ $nikPemohon }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">{{ $alamatPemohon }}</td>
        </tr>
    </table>

    <p class="paragraph">
        Bersama ini memohon ijin untuk menyelenggarakan {{ $kegiatan }} yang akan dilaksanakan pada :
    </p>

    <table class="kegiatan-table">
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ $rentangTanggal }}</td>
        </tr>
        <tr>
            <td class="label">Pukul</td>
            <td class="colon">:</td>
            <td class="value">{{ $pukul }}</td>
        </tr>
        <tr>
            <td class="label">Tempat</td>
            <td class="colon">:</td>
            <td class="value">{{ $tempat }}</td>
        </tr>
        <tr>
            <td class="label">Keperluan</td>
            <td class="colon">:</td>
            <td class="value">{{ $keperluan }}</td>
        </tr>
    </table>

    <p class="paragraph">
        Demikian surat rekomendasi ini dibuat untuk menjadikan maklum dan terimakasih atas kerjasamanya.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-left">
                <p style="visibility: hidden;">Blitar, {{ $tanggalSurat }}</p>
                <p>Pemohon</p>

                <div class="space-pemohon"></div>

                <p class="nama-pemohon">{{ $namaPemohon }}</p>
            </td>

            <td class="ttd-right">
                <p>Blitar, {{ $tanggalSurat }}</p>
                <p>Mengetahui</p>
                <p>KEPALA DESA Kemirigede</p>

                {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD Kepala Desa">
                </div> --}}
<br><br><br><br><br><br>
                <p class="nama-kades">
                    {!! nl2br(e($namaKadesFormatted)) !!}
                </p>
            </td>
        </tr>
    </table>

</body>
</html>
