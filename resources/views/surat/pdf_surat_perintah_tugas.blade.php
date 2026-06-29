<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Tugas</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm 1.8cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.45;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 14px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .kop-desa-table td {
            padding: 0;
            vertical-align: middle;
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
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 18px 0 4px 0;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            font-weight: bold;
            margin: 0 0 18px 0;
        }

        ol {
            margin-top: 0;
            margin-bottom: 12px;
        }

        p {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: justify;
        }

        .ttd {
            width: 330px;
            margin-left: auto;
            margin-top: 42px;
            text-align: center;
            line-height: 1.3;
        }

        .ttd-img-wrapper {
            height: 65px;
            margin: 5px 0;
            text-align: center;
        }

        .ttd-img {
            width: 160px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
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
    $tanggalSurat = !empty($data->tanggal_surat)
        ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat('d F Y')
        : now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

    $tanggalKegiatan = !empty($data->tanggal_kegiatan)
        ? \Carbon\Carbon::parse($data->tanggal_kegiatan)->locale('id')->translatedFormat('d F Y')
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

<div class="judul">SURAT PERINTAH TUGAS</div>

<div class="nomor">
    Nomor : {{ $data->nomor_surat ?? '...' }}
</div>

<p><strong>Dasar :</strong></p>

<ol>
    @if(!empty($data->dasar) && count($data->dasar) > 0)
        @foreach($data->dasar as $d)
            <li>{{ $d }}</li>
        @endforeach
    @else
        <li>Surat Undangan / Kebutuhan terkait</li>
    @endif
</ol>

<p><strong>Diperintahkan kepada :</strong></p>

<table>
    <tr>
        <td width="30%">1. Nama</td>
        <td>: {{ $data->nama_penerima ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>: {{ $data->jabatan_penerima ?? '...........................................' }}</td>
    </tr>
    @if(!empty($data->nik_penerima))
    <tr>
        <td>NIK</td>
        <td>: {{ $data->nik_penerima }}</td>
    </tr>
    @endif
</table>

<p><strong>Untuk :</strong></p>

<p>
    {{ $data->untuk_mengikuti ?? '...........................................' }}
</p>

<p><strong>Kedudukan tersebut diatas pada :</strong></p>

<table>
    <tr>
        <td width="30%">Hari / Tanggal</td>
        <td>: {{ $data->hari ?? '....................' }}, {{ $tanggalKegiatan }}</td>
    </tr>
    <tr>
        <td>Waktu</td>
        <td>: {{ $data->waktu_mulai ?? '....................' }} WIB s/d selesai</td>
    </tr>
    <tr>
        <td>Tempat</td>
        <td>: {{ $data->tempat_kegiatan ?? '...........................................' }}</td>
    </tr>
</table>

@if(!empty($data->keterangan_tugas))
<p>
    {{ $data->keterangan_tugas }}
</p>
@endif

<p>
    Demikian surat tugas ini dibuat untuk dilaksanakan sebaik-baiknya dan dapat dipergunakan sebagaimana perlunya.
</p>

<div class="ttd">
    <p style="text-align: center;">Blitar, {{ $tanggalSurat }}</p>
    <p style="text-align: center;"><strong>Kepala Desa KEMIRIGEDE</strong></p>

    <div class="ttd-img-wrapper">
        <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
    </div>

    <p class="nama-kades" style="text-align: center;">
        MOH. HAMID ALMAULUDI, S.Pd.I
    </p>

    <div class="qr-section">
        <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
        <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
    </div>
</div>

</body>
</html>
