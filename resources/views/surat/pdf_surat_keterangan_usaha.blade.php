<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Usaha</title>

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

<div class="judul">SURAT KETERANGAN USAHA</div>

<div class="nomor">
    No : {{ $data->nomor_surat ?? '470 / --- / 409.42.1 / ' . now('Asia/Jakarta')->year }}
</div>

<div class="isi">
    <p>Yang bertanda tangan dibawah ini:</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>Moh. Hamid Almauludi, S.Pd.I</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Kepala Desa Wates</td>
        </tr>
    </table>

    <p>Menerangkan dengan sebenarnya bahwa orang tersebut dibawah ini:</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Nama/Bidang Usaha</td>
            <td>:</td>
            <td>{{ $data->nama_usaha ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>No NIK</td>
            <td>:</td>
            <td>{{ $data->nik ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir ?? '....................' }}, {{ $tanggalLahir }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->jenis_kelamin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>:</td>
            <td>{{ $data->kewarganegaraan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{ $data->keperluan ?? '...........................................' }}</td>
        </tr>
    </table>

    <p>
        Demikian surat ini yang kami buat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>
</div>

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
