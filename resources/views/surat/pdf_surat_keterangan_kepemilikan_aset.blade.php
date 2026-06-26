<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kepemilikan Aset</title>
    <style>
        @page {
            margin: 1.0cm 1.5cm;
            size: A4 portrait;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.4;
        }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 12%; text-align: center; vertical-align: top; }
        .kop-logo img { width: 65px; }
        .kop-text { text-align: center; vertical-align: top; }
        .kop-text strong { font-size: 12pt; }
        .kop-text small { font-size: 8.5pt; }
        .kop-garis { border: none; border-top: 2.5px solid #000; margin: 6px 0 10px 0; }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 13pt;
            margin: 10px 0;
        }
        .nomor { text-align: center; margin-bottom: 15px; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 20px;
        }
        table.data td {
            padding: 3px 6px;
            vertical-align: top;
        }
        table.data td:first-child { width: 160px; }

        .ttd {
            width: 100%;
            margin-top: 30px;
        }
        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-img-wrapper { height: 50px; margin: 5px 0; }
        .ttd-img { width: 160px; }
        .nama-kades { font-weight: bold; text-decoration: underline; }
        .qr-section { margin-top: 8px; text-align: center; }
        .qr-section img { width: 75px; }
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
            <small>Jln. Merdeka No. 74 Telp. 082139324445<br>
            Email: KEMIRIGEDEberkelas@gmail.com | Website: KEMIRIGEDE-blitarkab.desa.id</small>
        </td>
        <td class="kop-logo">
            <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa">
        </td>
    </tr>
</table>

<hr class="kop-garis">

<div class="judul">DATA KEPEMILIKAN</div>
<div class="nomor">Nomor : {{ $data->nomor_surat ?? '470 / --- / 409.41.2 / ' . now()->year }}</div>

<p>Yang bertanda tangan di bawah ini Kepala Desa KEMIRIGEDE menerangkan dengan sebenarnya bahwa :</p>

<table class="data">
    <tr><td>Nama</td><td>:</td><td>{{ $data->nama ?? '-' }}</td></tr>
    <tr><td>Tempat Tgl Lahir</td><td>:</td><td>{{ $data->tempat_lahir ?? '-' }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
    <tr><td>No KTP / NIK</td><td>:</td><td>{{ $data->nik ?? '-' }}</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>{{ $data->pekerjaan ?? '-' }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat ?? '-' }}</td></tr>
</table>

<p>Dengan hasil survey seperti dibawah ini :</p>

<table class="data">
    <tr><td colspan="3"><strong>A. Pendapatan Keluarga</strong></td></tr>
    <tr><td>Kurang dari</td><td>:</td><td>Rp {{ $data->pendapatan_bulanan ?? '-' }}/bulan</td></tr>

    <tr><td colspan="3"><strong>B. Kepemilikan Tanah</strong></td></tr>
    <tr><td>Pekarangan</td><td>:</td><td>{{ $data->pekarangan ?? '-' }} M²</td></tr>
    <tr><td>Sawah</td><td>:</td><td>{{ $data->sawah ?? '-' }} M²</td></tr>
    <tr><td>Perkebunan</td><td>:</td><td>{{ $data->perkebunan ?? '-' }} M²</td></tr>

    <tr><td colspan="3"><strong>C. Aset / Barang Berharga</strong></td></tr>
    <tr><td>Mobil</td><td>:</td><td>{{ $data->mobil ?? '-' }}</td></tr>
    <tr><td>Sepeda Motor</td><td>:</td><td>{{ $data->sepeda_motor ?? '-' }}</td></tr>
    <tr><td>Perhiasan Emas</td><td>:</td><td>{{ $data->perhiasan_emas ?? '-' }}</td></tr>
    <tr><td>Lainnya</td><td>:</td><td>{{ $data->lainnya ?? '-' }}</td></tr>

    <tr><td colspan="3"><strong>D. Kepemilikan Rumah</strong></td></tr>
    <tr><td colspan="3">{{ $data->kepemilikan_rumah ?? '-' }}</td></tr>
</table>

<p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

<table class="ttd">
    <tr>
        <td></td>
        <td>KEMIRIGEDE, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>KEPALA DESA KEMIRIGEDE</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
            </div>
            <div class="nama-kades">MOH. HAMID ALMAULUDI, S.Pd.I</div>
            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR">
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
