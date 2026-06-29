<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Kepemilikan Dokumen Asli</title>
    <style>
        @page {
            margin: 1.2cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11.5pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 14px;
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
            margin: 6px 0 12px 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13.5pt;
            margin: 15px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 15px 25px;
        }

        table.data td {
            padding: 4px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 180px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
            border-collapse: collapse;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin: 5px 0;
        }

        .ttd-img {
            width: 165px;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        .qr-section {
            margin-top: 8px;
            text-align: center;
        }

        .qr-section img {
            width: 78px;
        }

        .qr-section small {
            font-size: 7.5pt;
            color: #555;
            display: block;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>
<body>

@php
    $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

    $tanggalLahir = !empty($data->tanggal_lahir)
        ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')
        : '...........................................';

    $tanggalLahirPemilik = !empty($data->tanggal_lahir_pemilik)
        ? \Carbon\Carbon::parse($data->tanggal_lahir_pemilik)->translatedFormat('d F Y')
        : '...........................................';
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
                <div class="kop-desa-2">KECAMATAN KEMIRIGEDE</div>
                <div class="kop-desa-3">PEMERINTAH DESA KEMIRIGEDE</div>
                <div class="kop-desa-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                <div class="kop-desa-kontak">
                    email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                </div>
            </td>

            <td class="kop-desa-logo">
                <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
            </td>
        </tr>
    </table>

    <hr class="kop-desa-garis">
</div>

<div class="judul">SURAT PERNYATAAN</div>

<p>Yang membuat Pernyataan di bawah ini :</p>

<table class="data">
    <tr>
        <td>N.I.K</td>
        <td>:</td>
        <td>{{ $data->nik ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{ $data->nama ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Tempat/Tgl Lahir</td>
        <td>:</td>
        <td>{{ $data->tempat_lahir ?? '-' }}, {{ $tanggalLahir }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $data->jenis_kelamin ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $data->pekerjaan ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>No. HP</td>
        <td>:</td>
        <td>{{ $data->no_hp ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $data->alamat ?? '...........................................' }}</td>
    </tr>
</table>

<p>
    Dengan ini menyatakan dengan sebenarnya bahwa saya benar memiliki dokumen/surat/barang berupa
    <strong>{{ $data->nama_dokumen ?? 'KARTU KELUARGA' }}</strong> asli dengan :
</p>

<table class="data">
    <tr>
        <td>Nomor Dokumen / Surat</td>
        <td>:</td>
        <td>{{ $data->nomor_dokumen ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Nama Pemilik Dokumen/Surat</td>
        <td>:</td>
        <td>{{ $data->nama_pemilik_dokumen ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Tanggal Lahir Pemilik Dokumen/Surat</td>
        <td>:</td>
        <td>{{ $tanggalLahirPemilik }}</td>
    </tr>
    <tr>
        <td>Alamat yang Tertera dalam Dokumen/Surat</td>
        <td>:</td>
        <td>{{ $data->alamat_dokumen ?? '...........................................' }}</td>
    </tr>
</table>

<p>
    Demikian surat pernyataan ini saya buat dengan sebenarnya dan apabila ternyata saya telah
    memberikan informasi keterangan/data yang tidak benar, maka saya bersedia dituntut sesuai
    dengan Undang-Undang, dan dapat diproses sesuai dengan ketentuan hukum yang berlaku.
</p>

<table class="ttd">
    <tr>
        <td></td>
        <td>Blitar, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>YANG MEMBUAT PERNYATAAN</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="ttd-img-wrapper">
                {{-- Ruang tanda tangan pemohon --}}
            </div>

            <div class="nama-kades">
                {{ $data->nama ?? '...........................................' }}
            </div>

            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
