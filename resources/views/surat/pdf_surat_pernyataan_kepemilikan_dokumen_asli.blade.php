<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Kepemilikan Dokumen Asli</title>
    <style>
        @page { margin: 1.2cm 1.8cm; }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11.5pt;
            line-height: 1.4;
        }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 13%; text-align: center; vertical-align: top; }
        .kop-logo img { width: 65px; }
        .kop-text { text-align: center; vertical-align: top; }
        .kop-text strong { font-size: 12.5pt; }
        .kop-text small { font-size: 8.8pt; }
        .kop-garis { border: none; border-top: 2.5px solid #000; margin: 7px 0 12px 0; }

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
        table.data td:first-child { width: 180px; }

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
        .ttd-img-wrapper { height: 55px; margin: 5px 0; }
        .ttd-img { width: 165px; }
        .nama-kades { font-weight: bold; text-decoration: underline; }
        .qr-section { margin-top: 8px; text-align: center; }
        .qr-section img { width: 78px; }
        .qr-section small { font-size: 7.5pt; color: #555; }
    </style>
</head>
<body>

@php
    $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');
@endphp

<!-- KOP -->
<table class="kop-table">
    <tr>
        <td class="kop-logo">
            <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
        </td>
        <td class="kop-text">
            <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
            <strong>KECAMATAN KEMIRIGEDE</strong><br>
            <strong>KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
            <small>
                Jln. Merdeka No. 74 Telp. 082139324445<br>
                Email: KEMIRIGEDEberkelas@gmail.com | Website: KEMIRIGEDE-blitarkab.desa.id
            </small>
        </td>
        <td class="kop-logo">
            <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa">
        </td>
    </tr>
</table>

<hr class="kop-garis">

<div class="judul">SURAT PERNYATAAN</div>

<p>Yang membuat Pernyataan di bawah ini :</p>

<table class="data">
    <tr><td>N.I.K</td><td>:</td><td>{{ $data->nik ?? '...........................................' }}</td></tr>
    <tr><td>Nama</td><td>:</td><td>{{ $data->nama ?? '...........................................' }}</td></tr>
    <tr><td>Tempat/Tgl Lahir</td><td>:</td><td>{{ $data->tempat_lahir ?? '-' }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $data->jenis_kelamin ?? '...........................................' }}</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>{{ $data->pekerjaan ?? '...........................................' }}</td></tr>
    <tr><td>No. HP</td><td>:</td><td>{{ $data->no_hp ?? '...........................................' }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat ?? '...........................................' }}</td></tr>
</table>

<p>Dengan ini menyatakan dengan sebenarnya bahwa saya benar memiliki dokumen/surat/barang berupa <strong>{{ $data->nama_dokumen ?? 'KARTU KELUARGA' }}</strong> asli dengan :</p>

<table class="data">
    <tr><td>Nomor Dokumen / Surat</td><td>:</td><td>{{ $data->nomor_dokumen ?? '...........................................' }}</td></tr>
    <tr><td>Nama Pemilik Dokumen/Surat</td><td>:</td><td>{{ $data->nama_pemilik_dokumen ?? '...........................................' }}</td></tr>
    <tr><td>Tanggal Lahir Pemilik Dokumen/Surat</td><td>:</td><td>{{ \Carbon\Carbon::parse($data->tanggal_lahir_pemilik)->translatedFormat('d F Y') ?? '...........................................' }}</td></tr>
    <tr><td>Alamat yang Tertera dalam Dokumen/Surat</td><td>:</td><td>{{ $data->alamat_dokumen ?? '...........................................' }}</td></tr>
</table>

<p>Demikian surat pernyataan ini saya buat dengan sebenarnya dan apabila ternyata saya telah memberikan informasi keterangan/data yang tidak benar, maka saya bersedia dituntut sesuai dengan Undang-Undang, dan dapat diproses sesuai dengan ketentuan hukum yang berlaku.</p>

<table class="ttd">
    <tr>
        <td></td>
        <td>KEMIRIGEDE, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>YANG MEMBUAT PERNYATAAN</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="ttd-img-wrapper">
                {{-- <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan"> --}}
            </div>
            <div class="nama-kades">{{ $data->nama ?? '...........................................' }}</div>
            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
