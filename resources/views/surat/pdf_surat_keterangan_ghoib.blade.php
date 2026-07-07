<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Ghoib</title>

    <style>
        @page {
            margin: 1.2cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
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
            font-size: 14pt;
            margin-top: 10px;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            margin-bottom: 20px;
            font-size: 11pt;
        }

        .isi {
            text-align: justify;
        }

        p {
            margin-bottom: 10px;
            margin-top: 0;
            text-indent: 45px;
        }

        p.normal {
            text-indent: 0px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 45px;
        }

        table.data td {
            padding: 2px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 170px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .ttd-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-img-wrapper {
            height: 60px;
            margin: 5px 0;
            text-align: center;
        }

        .ttd-img {
            width: 140px;
            height: auto;
            display: inline-block;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .qr-section {
            margin-top: 8px;
            text-align: center;
        }

        .qr-section img {
            width: 75px;
            height: auto;
        }

        .qr-section small {
            font-size: 7.5pt;
            color: #444;
            display: block;
            line-height: 1.2;
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

    $tanggalPernyataan = !empty($data->tanggal_pernyataan)
        ? \Carbon\Carbon::parse($data->tanggal_pernyataan)->translatedFormat('d F Y')
        : '................................';

    $tanggalHilang = !empty($data->tanggal_hilang)
        ? \Carbon\Carbon::parse($data->tanggal_hilang)->translatedFormat('d F Y')
        : '................................';

    $tanggalLahir = !empty($data->tanggal_lahir)
        ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')
        : '';
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
                <div class="kop-desa-3">PEMERINTAH DESA KEMIRIGEDE</div>
                <div class="kop-desa-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                <div class="kop-desa-kontak">
                    email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                </div>
            </td>

                 {{-- <td class="kop-desa-logo">
                <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
            </td> --}} 
        </tr>
    </table>

    <hr class="kop-desa-garis">
</div>

<div class="judul">SURAT KETERANGAN GHOIB</div>

<div class="nomor">
    Nomor : {{ $data->nomor_surat ?? '145/ /409.41.2/' . now('Asia/Jakarta')->year }}
</div>

<div class="isi">
    <p class="normal">
        Berdasarkan surat Pernyataan pada tanggal <strong>{{ $tanggalPernyataan }}</strong>
        yang menyatakan dengan sebenarnya bahwa :
    </p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td class="text-uppercase" style="font-weight: bold;">
                {{ $data->nama_pemohon ?? '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>
                {{ $data->tempat_lahir ?? '' }}{{ !empty($tanggalLahir) ? ', ' . $tanggalLahir : '' }}
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->jenis_kelamin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Kebangsaan</td>
            <td>:</td>
            <td>{{ $data->kewarganegaraan ?? 'Indonesia' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $data->agama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $data->status ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $data->pekerjaan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat ?? '...........................................' }}</td>
        </tr>
    </table>

    <p>
        Orang tersebut diatas benar-benar penduduk Desa KEMIRIGEDE Kecamatan Kesamben Kabupaten Blitar,
        benar-benar menyatakan bahwa suaminya yang Bernama
        <strong class="text-uppercase">{{ $data->nama_suami_istri ?? '................................' }}</strong>
        telah pergi meninggalkan keluarga sejak tanggal {{ $tanggalHilang }} dan sekarang tidak diketahui
        alamatnya dengan jelas dan pasti diwilayah Republik Indonesia.
    </p>

    <p>
        Selanjutnya surat keterangan ini dipergunakan untuk melengkapi persyaratan
        <strong>{{ $data->keperluan ?? 'Pengajuan Perceraian' }}</strong>.
    </p>

    <p class="normal">
        Demikian Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
    </p>
</div>

<table class="ttd-table">
    <tr>
        <td></td>
        <td>Blitar, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td><strong>Pemegang Surat</strong></td>
        <td><strong>KEPALA DESA KEMIRIGEDE</strong></td>
    </tr>
    <tr>
        <td>
            <div style="height: 65px;"></div>
            <div class="text-uppercase" style="font-weight: bold; text-decoration: underline;">
                {{ $data->nama_pemohon ?? '...........................................' }}
            </div>
        </td>
        <td>
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div>

            <div class="nama-kades">Hari Purnawan, S.Sos.</div>

              {{--
            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div> --}}
        </td>
    </tr>
</table>

</body>
</html>
