<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Miskin SKM</title>

    <style>
        @page { margin: 1.15cm 1.8cm; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
        }

        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 13%; text-align: center; vertical-align: top; }
        .kop-logo img { width: 68px; }
        .kop-text { text-align: center; vertical-align: top; }
        .kop-text strong { font-size: 12.5pt; line-height: 1.2; }
        .kop-text small { font-size: 8.8pt; }

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

        .isi { text-align: justify; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 25px;
        }

        table.data td {
            padding: 3px 5px;
            vertical-align: top;
        }

        table.data td:first-child { width: 160px; }
        table.data td:nth-child(2) { width: 10px; }

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

        .ttd-img { width: 165px; }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        .qr-section { margin-top: 6px; text-align: center; }
        .qr-section img { width: 78px; }
        .qr-section small {
            font-size: 7.3pt;
            color: #555;
            display: block;
        }

        .space-sign { height: 65px; }
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

<div class="judul">SURAT KETERANGAN MISKIN (SKM)</div>

<div class="nomor">
    Nomor : {{ $data->nomor_surat ?? '422.4 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
</div>

<div class="isi">
    <p>Yang bertanda tangan dibawah ini:</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>MOH. HAMID ALMAULUDI, S.Pd.I</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Kepala Desa Wates Kec. Wates Kab. Blitar</td>
        </tr>
    </table>

    <p>Menerangkan dengan sebenarnya bahwa:</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat Tgl Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir ?? '....................' }}, {{ $tanggalLahir }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $data->nik ?? '...........................................' }}</td>
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
        Bahwa orang tersebut diatas adalah keluarga miskin yang belum mempunyai kartu
        Jamkesmas maupun kartu Jamkesda Provinsi Jawa Timur.
    </p>

    <p>
        Demikian surat keterangan miskin ini dibuat dan dipergunakan sesuai dengan
        ketentuan yang berlaku dalam pelayanan Jamkesda Provinsi Jawa Timur.
    </p>
</div>

<table class="ttd">
    <tr>
        <td colspan="2">Wates, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td colspan="2"><strong>TIM VERIFIKATOR DESA:</strong></td>
    </tr>
    <tr>
        <td><strong>Kepala Desa Wates</strong></td>
        <td><strong>Bidan Desa</strong></td>
    </tr>
    <tr>
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
        <td>
            <div class="space-sign"></div>
            <strong><u>...........................................</u></strong>
        </td>
    </tr>
</table>

</body>
</html>
