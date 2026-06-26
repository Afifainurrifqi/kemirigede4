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
        }

        /* Kop Surat Resmi Desa */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 13%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 68px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            vertical-align: middle;
        }

        .kop-text strong {
            font-size: 13pt;
            line-height: 1.2;
            display: block;
        }

        .kop-text small {
            font-size: 9pt;
            display: block;
            margin-top: 3px;
        }

        .kop-garis {
            border: none;
            border-top: 3px double #000;
            margin: 7px 0 15px 0;
        }

        /* Judul Surat */
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

        /* Tabel Data Penduduk */
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

        /* Tanda Tangan Model Baru Sejajar */
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
@endphp

<table class="kop-table">
    <tr>
        <td class="kop-logo">
            <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
        </td>

        <td class="kop-text">
            <strong>PEMERINTAH KABUPATEN BLITAR</strong>
            <strong>KECAMATAN KEMIRIGEDE</strong>
            <strong>KANTOR KEPALA DESA KEMIRIGEDE</strong>
            <small>
                Jln. Merdeka No. 74 Telp. 082139324445<br>
                Email: KEMIRIGEDEberkelas@gmail.com | Website: KEMIRIGEDE-blitarkab.desa.id
            </small>
        </td>

        <td class="kop-logo">
            <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa KEMIRIGEDE">
        </td>
    </tr>
</table>

<hr class="kop-garis">

<div class="judul">SURAT KETERANGAN GHOIB</div>
<div class="nomor">
    Nomor : {{ $data->nomor_surat ?? '145/ /409.41.2/' . now('Asia/Jakarta')->year }}
</div>

<div class="isi">
    <p class="normal">Berdasarkan surat Pernyataan pada tanggal <strong>{{ $tanggalPernyataan }}</strong> yang menyatakan dengan sebenarnya bahwa :</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td class="text-uppercase" style="font-weight: bold;">{{ $data->nama_pemohon ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir ?? '' }}{{ $data->tanggal_lahir ? ', ' . \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') : '' }}</td>
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
        Orang tersebut diatas benar-benar penduduk Desa KEMIRIGEDE Kecamatan KEMIRIGEDE Kabupaten Blitar, benar-benar menyatakan bahwa suaminya yang Bernama <strong class="text-uppercase">{{ $data->nama_suami_istri ?? '................................' }}</strong> telah pergi meninggalkan keluarga sejak tanggal {{ $tanggalHilang }} dan sekarang tidak diketahui alamatnya dengan jelas dan pasti diwilayah Republik Indonesia.
    </p>

    <p>
        Selanjutnya surat keterangan ini dipergunakan untuk melengkapi persyaratan <strong>{{ $data->keperluan ?? 'Pengajuan Perceraian' }}</strong>.
    </p>

    <p class="normal">
        Demikian Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
    </p>
</div>

<table class="ttd-table">
    <tr>
        <td></td>
        <td>KEMIRIGEDE, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td><strong>Pemegang Surat</strong></td>
        <td><strong>Kepala Desa KEMIRIGEDE</strong></td>
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

            <div class="nama-kades">MOH. HAMID ALMAULUDI, S.Pd.I</div>

            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode_surat.png') }}" alt="QR Code">
                <br><small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
