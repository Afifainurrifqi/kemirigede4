<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Numpang Nikah</title>

    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.8pt;
            line-height: 1.25;
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

        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 12.8pt;
            text-decoration: underline;
            margin: 6px 0 2px 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 18px;
        }

        .pembuka {
            text-align: justify;
            margin: 6px 0 6px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 7px 0;
        }

        table.data td {
            padding: 1.8px 4px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 165px;
            letter-spacing: 1px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .pengikut-label {
            margin-top: 3px;
            font-weight: bold;
            text-decoration: underline;
        }

        table.pengikut {
            width: 100%;
            border-collapse: collapse;
            margin: 3px 0 14px 0;
        }

        table.pengikut th,
        table.pengikut td {
            border: 1px solid #000;
            padding: 4px 5px;
            text-align: center;
            vertical-align: top;
        }

        table.pengikut th {
            font-weight: bold;
        }

        table.pengikut td {
            height: 26px;
        }

        .catatan-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 6px;
            margin-bottom: 4px;
        }

        ol.catatan {
            margin-top: 0;
            margin-left: 18px;
            padding-left: 12px;
        }

        ol.catatan li {
            margin-bottom: 2px;
            text-align: justify;
        }

        .penutup {
            text-align: justify;
            margin-top: 14px;
        }

        .ttd-table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }

        .ttd-spacer {
            width: 55%;
        }

        .ttd-cell {
            width: 45%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-cell p {
            margin: 2px 0;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin: 5px 0 3px 0;
            text-align: center;
        }

        .ttd-img {
            width: 165px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            margin: 3px 0 2px 0;
        }

        .qr-section {
            margin-top: 6px;
            text-align: center;
        }

        .qr-section img {
            width: 78px;
            height: auto;
        }

        .qr-section small {
            font-size: 7.2pt;
            color: #555;
            display: block;
            margin-top: 2px;
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

    $mulaiBerangkat = !empty($data->mulai_berangkat)
        ? \Carbon\Carbon::parse($data->mulai_berangkat)->translatedFormat('d F Y')
        : '...........................................';

    $namaPengikut = (array) ($data->nama_pengikut ?? []);
    $umurPengikut = (array) ($data->umur_pengikut ?? []);
    $jkPengikut = (array) ($data->jenis_kelamin_pengikut ?? []);
    $hubPengikut = (array) ($data->hubungan_keluarga_pengikut ?? []);
    $ketPengikut = (array) ($data->keterangan_pengikut ?? []);

    $jumlahPengikut = max((int) ($data->jumlah_pengikut ?? count($namaPengikut)), count($namaPengikut));
@endphp

{{-- KOP SURAT --}}
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

<div class="judul-surat">
    SURAT KETERANGAN NUMPANG NIKAH
</div>

<div class="nomor-surat">
    Reg. No : {{ $data->nomor_surat ?? '474.2 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
</div>

<p class="pembuka">
    Yang bertandatangan di bawah ini KEPALA DESA KEMIRIGEDE, Kecamatan Kesamben,
    Kabupaten Blitar, menerangkan dengan sebenarnya bahwa:
</p>

<table class="data">
    <tr>
        <td>Nama</td>
        <td>:</td>
        <td>{{ $data->nama ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Tempat Tanggal Lahir</td>
        <td>:</td>
        <td>{{ $data->tempat_lahir ?? '...........................................' }}, {{ $tanggalLahir }}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td>{{ $data->agama ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td>{{ $data->pekerjaan ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Status Perkawinan</td>
        <td>:</td>
        <td>{{ $data->status_perkawinan ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td>{{ $data->alamat ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Keperluan</td>
        <td>:</td>
        <td>{{ $data->keperluan ?? 'Pernikahan' }}</td>
    </tr>
    <tr>
        <td>Alamat yang dituju</td>
        <td>:</td>
        <td>{{ $data->alamat_tujuan ?? '...........................................' }}</td>
    </tr>
    <tr>
        <td>Mulai berangkat</td>
        <td>:</td>
        <td>{{ $mulaiBerangkat }}</td>
    </tr>
    <tr>
        <td>Pembawaan</td>
        <td>:</td>
        <td>{{ $data->pembawaan ?? 'Pakaian secukupnya' }}</td>
    </tr>
    <tr>
        <td><strong>PENGIKUT</strong></td>
        <td>:</td>
        <td>{{ $jumlahPengikut > 0 ? $jumlahPengikut . ' orang' : '-- orang' }}</td>
    </tr>
</table>

<table class="pengikut">
    <thead>
        <tr>
            <th style="width: 7%;">No</th>
            <th style="width: 28%;">Nama</th>
            <th style="width: 10%;">Umur</th>
            <th style="width: 22%;">Jenis Kelamin</th>
            <th style="width: 17%;">Hub. Kel.</th>
            <th style="width: 16%;">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @if ($jumlahPengikut > 0)
            @for ($i = 0; $i < $jumlahPengikut; $i++)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $namaPengikut[$i] ?? '' }}</td>
                    <td>{{ $umurPengikut[$i] ?? '' }}</td>
                    <td>{{ $jkPengikut[$i] ?? '' }}</td>
                    <td>{{ $hubPengikut[$i] ?? '' }}</td>
                    <td>{{ $ketPengikut[$i] ?? '' }}</td>
                </tr>
            @endfor
        @else
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
    </tbody>
</table>

<div class="catatan-title">CATATAN</div>

<ol class="catatan">
    <li>Orang tersebut di atas benar-benar penduduk kami dan sepanjang pengetahuan kami tidak pernah mengalami pelanggaran kejahatan.</li>
    <li>Setelah sampai alamat yang dituju, harap melapor diri.</li>
    <li>Tidak boleh melakukan hal-hal yang kurang baik di sepanjang jalan, maupun di tempat tujuan.</li>
    <li>Melapor kembali kepada Desa semula apabila sudah pulang dari bepergian.</li>
</ol>

<p class="penutup">
    Demikian surat keterangan ini kami buat dengan sebenarnya untuk menjadikan periksa
    dan guna seperlunya.
</p>

<table class="ttd-table">
    <tr>
        <td class="ttd-spacer"></td>
        <td class="ttd-cell">
            <p>Blitar, {{ $tanggalSurat }}</p>
            <p><strong>KEPALA DESA KEMIRIGEDE</strong></p>

            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div>

            <p class="nama-kades">Hari Purnawan, S.Sos.</p>

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
