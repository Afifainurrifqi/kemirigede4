<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Kuasa</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 1.45cm 0.9cm 1.45cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10.8pt;
            line-height: 1.18;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 10px;
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
            width: 98px;
            height: auto;
        }

        .kop-desa-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.08;
        }

        .kop-desa-1 {
            font-size: 14.5pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 14.5pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 16.5pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 10pt;
            margin-top: 1px;
        }

        .kop-desa-kontak {
            font-size: 8.8pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 5px 0 10px 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12.8pt;
            text-decoration: underline;
            margin: 0 0 3px 0;
        }

        .nomor {
            text-align: center;
            font-size: 10.8pt;
            margin-bottom: 13px;
        }

        .pembuka {
            text-align: left;
            margin-bottom: 3px;
            line-height: 1.18;
        }

        table.data {
            width: 88%;
            margin-left: 45px;
            border-collapse: collapse;
            margin-top: 7px;
            margin-bottom: 8px;
        }

        table.data td {
            padding: 1.8px 0;
            vertical-align: top;
            line-height: 1.18;
        }

        table.data tr.section-row td {
            padding-top: 8px;
            padding-bottom: 4px;
            font-weight: bold;
        }

        .label {
            width: 180px;
        }

        .colon {
            width: 12px;
            text-align: center;
        }

        .isi-kuasa {
            margin-top: 12px;
            text-align: justify;
            line-height: 1.2;
        }

        .penutup {
            margin-top: 10px;
            text-align: justify;
            text-indent: 35px;
            line-height: 1.2;
        }

        .ttd-wrapper {
            page-break-inside: avoid;
            margin-top: 24px;
        }

        .tanggal {
            text-align: right;
            padding-right: 68px;
            margin-bottom: 8px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }

        .jabatan-ttd {
            margin-bottom: 48px;
        }

        .nama-pihak {
            font-weight: bold;
            text-decoration: underline;
            font-size: 10.5pt;
        }

        .mengetahui {
            text-align: center;
            margin-top: 14px;
            page-break-inside: avoid;
        }

        .mengetahui p {
            text-align: center;
            line-height: 1.12;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin-top: 3px;
            margin-bottom: 0;
            text-align: center;
        }

        .ttd-img {
            width: 145px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            margin-top: -2px;
            font-size: 10.3pt;
        }

        .barcode {
            text-align: center;
            margin-top: 5px;
            font-size: 7.2pt;
            line-height: 1.08;
        }

        .barcode img {
            width: 68px;
            height: auto;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 5px 0 10px 0;
            }

            table,
            tr,
            td,
            p,
            div {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
@php
    $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

    $tanggalLahirPihak1 = !empty($data->tanggal_lahir_pihak1)
        ? \Carbon\Carbon::parse($data->tanggal_lahir_pihak1)->format('d-m-Y')
        : '...........................................';

    $tanggalLahirPihak2 = !empty($data->tanggal_lahir_pihak2)
        ? \Carbon\Carbon::parse($data->tanggal_lahir_pihak2)->format('d-m-Y')
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
                <div class="kop-desa-2">KECAMATAN KESAMBEN</div>
                <div class="kop-desa-3">PEMERINTAH DESA Kemirigede</div>
                <div class="kop-desa-alamat">Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445</div>
                <div class="kop-desa-kontak">
                    email :pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                </div>
            </td>

                {{-- <td class="kop-desa-logo">
                <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
            </td> --}}
        </tr>
    </table>

    <hr class="kop-desa-garis">
</div>

<div class="judul">SURAT KUASA</div>

<p class="nomor">
    No : {{ $data->nomor_surat ?? '470 / --- / 409.42.1 / ' . now('Asia/Jakarta')->year }}
</p>

<p class="pembuka">
    Yang bertanda tangan dibawah ini KEPALA DESA Kemirigede Kec.Kemirigede Kab.Blitar
</p>
<p class="pembuka">
    Menerangkan dengan sebenarnya bahwa :
</p>

<table class="data">
    <tr class="section-row">
        <td colspan="3">Pihak I :</td>
    </tr>

    <tr>
        <td class="label">Nama Lengkap</td>
        <td class="colon">:</td>
        <td>{{ $data->nama_pihak1 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Jenis kelamin</td>
        <td class="colon">:</td>
        <td>{{ $data->jenis_kelamin_pihak1 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat tanggal lahir</td>
        <td class="colon">:</td>
        <td>{{ $data->tempat_lahir_pihak1 ?? '....................' }}, {{ $tanggalLahirPihak1 }}</td>
    </tr>
    <tr>
        <td class="label">Agama</td>
        <td class="colon">:</td>
        <td>{{ $data->agama_pihak1 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Status</td>
        <td class="colon">:</td>
        <td>{{ $data->status_pihak1 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Nik</td>
        <td class="colon">:</td>
        <td>{{ $data->nik_pihak1 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Pekerjaan</td>
        <td class="colon">:</td>
        <td>{{ $data->pekerjaan_pihak1 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Alamat</td>
        <td class="colon">:</td>
        <td>{{ $data->alamat_pihak1 ?? '...........................................' }}</td>
    </tr>

    <tr class="section-row">
        <td colspan="3">Pihak II :</td>
    </tr>

    <tr>
        <td class="label">Nama Lengkap</td>
        <td class="colon">:</td>
        <td>{{ $data->nama_pihak2 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Jenis kelamin</td>
        <td class="colon">:</td>
        <td>{{ $data->jenis_kelamin_pihak2 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat tanggal lahir</td>
        <td class="colon">:</td>
        <td>{{ $data->tempat_lahir_pihak2 ?? '....................' }}, {{ $tanggalLahirPihak2 }}</td>
    </tr>
    <tr>
        <td class="label">Agama</td>
        <td class="colon">:</td>
        <td>{{ $data->agama_pihak2 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Status</td>
        <td class="colon">:</td>
        <td>{{ $data->status_pihak2 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Nik</td>
        <td class="colon">:</td>
        <td>{{ $data->nik_pihak2 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Pekerjaan</td>
        <td class="colon">:</td>
        <td>{{ $data->pekerjaan_pihak2 ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td class="label">Alamat</td>
        <td class="colon">:</td>
        <td>{{ $data->alamat_pihak2 ?? '...........................................' }}</td>
    </tr>
</table>

<p class="isi-kuasa">
    Pihak I telah memberikan kuasa kepada Pihak II untuk
    <strong>{{ $data->keterangan_kuasa ?? '...........................................' }}</strong>.
</p>

<p class="penutup">
    Demikian surat kuasa ini di buat atas dasar yang sebenarnya untuk menjadikan periksa dan guna seperlunya.
</p>

<div class="ttd-wrapper">
    <p class="tanggal">
        Blitar, {{ $tanggalSurat }}
    </p>

    <table class="ttd-table">
        <tr>
            <td>
                <p class="jabatan-ttd">Pemberi Kuasa</p>
                <p class="nama-pihak">
                    {{ strtoupper($data->nama_pihak1 ?? '...........................................') }}
                </p>
            </td>

            <td>
                <p class="jabatan-ttd">Penerima Kuasa</p>
                <p class="nama-pihak">
                    {{ strtoupper($data->nama_pihak2 ?? '...........................................') }}
                </p>
            </td>
        </tr>
    </table>

    <div class="mengetahui">
        <p>Mengetahui</p>
        <p>KEPALA DESA Kemirigede</p>

        {{-- <div class="ttd-img-wrapper">
            <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD Kepala Desa">
        </div> --}}
<br><br><br>
        <p class="nama-kades">Hari Purnawan, S.Sos.</p>

        <div class="barcode">
            <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
            <br>
            <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
        </div>
    </div>
</div>

</body>
</html>
