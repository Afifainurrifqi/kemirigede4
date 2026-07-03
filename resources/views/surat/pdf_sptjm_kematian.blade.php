<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SPTJM Kebenaran Data Kematian</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 1.45cm 1cm 1.45cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.25;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0 0 6px 0;
            padding: 0;
            text-align: justify;
        }

        /* KOP SURAT */
        .kop-container {
            width: 100%;
            margin-bottom: 8px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 95px;
            height: auto;
        }

        .kop-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.12;
        }

        .kop-baris-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-baris-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-baris-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-alamat {
            font-size: 10.5pt;
            margin-top: 2px;
        }

        .kop-kontak {
            font-size: 9.5pt;
        }

        .kop-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 5px 0 9px 0;
        }

        /* JUDUL */
        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            text-transform: uppercase;
            text-decoration: underline;
            line-height: 1.2;
            margin: 12px 0 18px 0;
        }

        /* DATA */
        .data-table {
            width: 100%;
            margin: 3px 0 10px 24px;
            border-collapse: collapse;
            table-layout: auto;
        }

        .data-table td {
            padding: 1.5px 2px;
            vertical-align: top;
            line-height: 1.25;
        }

        .label {
            width: 150px;
            white-space: nowrap;
        }

        .colon {
            width: 8px;
            text-align: center;
        }

        .value {
            width: auto;
            word-wrap: break-word;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .paragraph-final {
            margin-top: 10px;
            line-height: 1.28;
        }

        /* TANDA TANGAN */
        .ttd-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .ttd-left {
            width: 50%;
            vertical-align: top;
            text-align: left;
        }

        .ttd-right {
            width: 50%;
            vertical-align: top;
            text-align: center;
        }

        .ttd-right p {
            text-align: center;
            margin-bottom: 4px;
        }

        .saksi-title {
            margin-bottom: 32px;
        }

        .saksi-name {
            width: 230px;
            min-height: 16px;
            margin-bottom: 3px;
            border-bottom: 1px solid #000;
        }

        .saksi-nik {
            margin-bottom: 18px;
        }

        .materai-space {
            height: 58px;
            padding-top: 18px;
            text-align: center;
        }

        .nama-pernyataan {
            display: inline-block;
            min-width: 230px;
            border-bottom: 1px solid #000;
            font-weight: bold;
            text-align: center;
            padding-bottom: 2px;
        }

        .keterangan {
            margin-top: 4px;
            font-size: 10pt;
            line-height: 1.25;
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
    \Carbon\Carbon::setLocale('id');

    $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

    $tanggalLahirPemohon = !empty($data->ttl_tanggal)
        ? \Carbon\Carbon::parse($data->ttl_tanggal)->translatedFormat('d F Y')
        : '';

    $tanggalLahirJenazah = !empty($data->ttl_tanggal_jenazah)
        ? \Carbon\Carbon::parse($data->ttl_tanggal_jenazah)->translatedFormat('d F Y')
        : '';

    $tanggalKematian = !empty($data->tanggal_kematian)
        ? \Carbon\Carbon::parse($data->tanggal_kematian)->translatedFormat('d F Y')
        : '';

    $ttlPemohon = trim(
        ($data->ttl_tempat ?? '') . (!empty($tanggalLahirPemohon) ? ', ' . $tanggalLahirPemohon : '')
    );

    $ttlJenazah = trim(
        ($data->ttl_tempat_jenazah ?? '') . (!empty($tanggalLahirJenazah) ? ', ' . $tanggalLahirJenazah : '')
    );
@endphp

<!-- KOP SURAT -->
<div class="kop-container">
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
            </td>

            <td class="kop-text">
                <div class="kop-baris-1">PEMERINTAH KABUPATEN BLITAR</div>
                <div class="kop-baris-2">KECAMATAN KESAMBEN</div>
                <div class="kop-baris-3">PEMERINTAH DESA KEMIRIGEDE</div>
                <div class="kop-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                <div class="kop-kontak">
                    email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                </div>
            </td>

            <td class="kop-logo">
                <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
            </td>
        </tr>
    </table>

    <hr class="kop-garis">
</div>

<!-- JUDUL SURAT -->
<div class="judul-surat">
    SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK (SPTJM)<br>
    KEBENARAN DATA KEMATIAN
</div>

<!-- DATA PEMBUAT PERNYATAAN -->
<p>Saya yang bertanda tangan di bawah ini:</p>

<table class="data-table">
    <tr>
        <td class="label">Nama</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->nama ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">NIK</td>
        <td class="colon">:</td>
        <td class="value">{{ $data->nik ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat/Tgl. Lahir</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $ttlPemohon }}</td>
    </tr>
    <tr>
        <td class="label">Pekerjaan</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->pekerjaan ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Alamat</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->alamat ?? '' }}</td>
    </tr>
</table>

<p>Menyatakan dengan ini, bahwa:</p>

<!-- DATA JENAZAH -->
<table class="data-table">
    <tr>
        <td class="label">Nama Jenazah</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->nama_jenazah ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">NIK</td>
        <td class="colon">:</td>
        <td class="value">{{ $data->nik_jenazah ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat/Tgl. Lahir</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $ttlJenazah }}</td>
    </tr>
    <tr>
        <td class="label">Jenis Kelamin</td>
        <td class="colon">:</td>
        <td class="value">{{ $data->jenis_kelamin ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Anak ke *)</td>
        <td class="colon">:</td>
        <td class="value">{{ $data->anak_ke ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Nama Ayah Kandung</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->nama_ayah_kandung ?? '' }}</td>
    </tr>
    <tr>
        <td class="label">Nama Ibu Kandung</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->nama_ibu_kandung ?? '' }}</td>
    </tr>
</table>

<table class="data-table">
    <tr>
        <td class="label">Meninggal dunia pada tanggal</td>
        <td class="colon">:</td>
        <td class="value">{{ $tanggalKematian }}</td>
    </tr>
    <tr>
        <td class="label">Terlampir surat kematian dari</td>
        <td class="colon">:</td>
        <td class="value uppercase">{{ $data->surat_kematian_dari ?? '' }}</td>
    </tr>
</table>

<p class="paragraph-final">
    Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan apabila
    dikemudian hari ternyata pernyataan saya tidak benar, maka saya bersedia diproses
    secara hukum sesuai dengan peraturan perundang-undangan yang berlaku dan
    dokumen yang diterbitkan dari pernyataan ini menjadi tidak sah.
</p>

<!-- TANDA TANGAN DAN SAKSI -->
<table class="ttd-table">
    <tr>
        <td class="ttd-left">
            <p class="saksi-title">Saksi I,</p>
            <div class="saksi-name uppercase">{{ $data->nama_saksi_1 ?? '' }}</div>
            <div class="saksi-nik">NIK: {{ $data->nik_saksi_1 ?? '' }}</div>

            <p class="saksi-title">Saksi II,</p>
            <div class="saksi-name uppercase">{{ $data->nama_saksi_2 ?? '' }}</div>
            <div class="saksi-nik">NIK: {{ $data->nik_saksi_2 ?? '' }}</div>

            <div class="keterangan">
                Keterangan:<br>
                - Ditulis dengan huruf besar atau balok<br>
                *) Ditulis urutan kelahiran anak.
            </div>
        </td>

        <td class="ttd-right">
            <p>Blitar, {{ $tanggalSurat }}</p>
            <p>Saya yang menyatakan,</p>

            <div class="materai-space">
                Meterai 10.000
            </div>

            <div class="nama-pernyataan uppercase">
                {{ $data->nama ?? '' }}
            </div>
        </td>
    </tr>
</table>

</body>
</html>
