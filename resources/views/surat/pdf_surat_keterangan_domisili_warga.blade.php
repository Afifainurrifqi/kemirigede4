<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili Warga</title>

    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 13%;
            text-align: center;
            vertical-align: top;
        }

        .kop-logo img {
            width: 68px;
        }

        .kop-text {
            text-align: center;
            vertical-align: top;
        }

        .kop-text strong {
            font-size: 12.5pt;
            line-height: 1.2;
        }

        .kop-text small {
            font-size: 8.8pt;
        }

        .kop-garis {
            border: none;
            border-top: 2.5px solid #000;
            margin: 7px 0 12px 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13.5pt;
            margin-top: 12px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 18px;
        }

        .isi {
            text-align: justify;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 25px;
        }

        table.data td {
            padding: 3px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 165px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .ttd {
            width: 100%;
            margin-top: 38px;
            border-collapse: collapse;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin: 5px 0 3px 0;
        }

        .ttd-img {
            width: 165px;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        .qr-section {
            margin-top: 6px;
            text-align: center;
        }

        .qr-section img {
            width: 78px;
        }

        .qr-section small {
            font-size: 7.3pt;
            color: #555;
            display: block;
        }
    </style>
</head>
<body>

@php
    $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');
    $tanggalLahir = !empty($data->tanggal_lahir)
        ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')
        : '...........................................';
@endphp

<!-- KOP SURAT -->
<table class="kop-table">
    <tr>
        <td class="kop-logo">
            <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
        </td>

        <td class="kop-text">
            <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
            <strong>KECAMATAN WATES</strong><br>
            <strong>KANTOR KEPALA DESA WATES</strong><br>
            <small>
                Jln. Merdeka No. 74 Telp. 082139324445<br>
                Email: watesberkelas@gmail.com | Website: wates-blitarkab.desa.id
            </small>
        </td>

        <td class="kop-logo">
            <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa Wates">
        </td>
    </tr>
</table>

<hr class="kop-garis">

<div class="judul">SURAT KETERANGAN DOMISILI</div>

<div class="nomor">
    No : {{ $data->nomor_surat ?? '470 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
</div>

<div class="isi">
    <p>Yang bertanda tangan dibawah ini Kepala Desa Wates Kecamatan Wates Kabupaten Blitar menerangkan dengan sebenarnya bahwa :</p>

    <table class="data">
        <tr><td>Nama Lengkap</td><td>:</td><td>{{ $data->nama_lengkap ?? '...........................................' }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $data->jenis_kelamin ?? '...........................................' }}</td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td>{{ $data->tempat_lahir ?? '....................' }}, {{ $tanggalLahir }}</td></tr>
        <tr><td>Agama</td><td>:</td><td>{{ $data->agama ?? '...........................................' }}</td></tr>
        <tr><td>Status</td><td>:</td><td>{{ $data->status ?? '...........................................' }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td>{{ $data->pekerjaan ?? '...........................................' }}</td></tr>
        <tr><td>Alamat Asal</td><td>:</td><td>{{ $data->alamat_asal ?? '...........................................' }}</td></tr>
    </table>

    <p>Orang tersebut di atas benar penduduk Desa Wates namun berdomisili di <strong>{{ $data->alamat_domisili ?? '...........................................' }}</strong>.</p>

    <p>Demikian surat keterangan Domisili ini dibuat atas dasar yang sebenarnya untuk dijadikan periksa dan dapat dipergunakan sebagaimana perlunya.</p>
</div>

<!-- TANDA TANGAN -->
<table class="ttd">
    <tr>
        <td></td>
        <td>Wates, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>KEPALA DESA WATES</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div>

            <div class="nama-kades">MOH. HAMID ALMAULUDI, S.Pd.I</div>

            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                <small>Scan untuk verifikasi surat resmi Desa Wates</small>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
