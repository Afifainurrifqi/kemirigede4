<!-- resources/views/surat/pdf_surat_keterangan_desa_sebagai_penduduk.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Desa Sebagai Penduduk</title>
    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.8pt;
            line-height: 1.4;
            color: #000;
        }
        .kop-container {
            width: 100%;
        }
        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }
        .kop-logo {
            width: 12%;
            text-align: center;
            vertical-align: top;
        }
        .kop-logo img {
            width: 72px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            vertical-align: top;
        }
        .kop-text strong {
            font-size: 12.8pt;
            line-height: 1.2;
        }
        .kop-text small {
            font-size: 9.2pt;
            line-height: 1.1;
        }
        .kop-garis {
            border: none;
            border-top: 2.8px solid #000;
            margin: 8px 0 12px 0;
        }
        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin: 18px 0 4px 0;
        }
        .nomor-surat {
            text-align: center;
            font-weight: normal;
            margin-bottom: 20px;
        }
        .tulisan {
            text-align: justify;
            margin-bottom: 9px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 15px 0;
        }
        table.data td {
            padding: 4px 6px;
            vertical-align: top;
        }
        table.data td:first-child {
            width: 165px;
        }
        table.data td:nth-child(2) {
            width: 10px;
        }
        .ttd-table {
            width: 100%;
            margin-top: 25px;
        }
        .ttd-spacer {
            width: 52%;
        }
        .ttd-cell {
            width: 48%;
            text-align: center;
        }
        .ttd-cell p {
            margin: 2px 0;
        }
        .ttd-img-wrapper {
            height: 52px;
            margin-bottom: 3px;
            text-align: center;
        }
        .ttd-img {
            width: 170px;
            height: auto;
        }
        .nama {
            font-weight: bold;
            text-decoration: underline;
            margin: 4px 0 2px 0;
        }
        .qr-section {
            margin-top: 8px;
            text-align: center;
        }
        .qr-section img {
            width: 85px;
            height: auto;
        }
        .qr-section small {
            font-size: 7.5pt;
            color: #555;
            display: block;
            margin-top: 2px;
        }
    </style>
</head>
<body>

@php
    $tanggalSurat = now('Asia/Jakarta') ->locale('id')->translatedFormat('d F Y');
@endphp

{{-- KOP SURAT --}}
<div class="kop-container">
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
            </td>
            <td class="kop-text">
                <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
                <strong>KECAMATAN KESAMBEN</strong><br>
                <strong>KANTOR KEPALA DESA Kemirigede</strong><br>
                <small>
                    Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445<br>
                    Email: Kemirigedeberkelas@gmail.com | Website: Kemirigede-blitarkab.desa.id
                </small>
            </td>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
            </td>
        </tr>
    </table>
    <hr class="kop-garis">
</div>

{{-- JUDUL SURAT --}}
<div class="judul-surat">
    SURAT KETERANGAN DESA
</div>

{{-- NOMOR SURAT --}}
<div class="nomor-surat">
    Nomor : {{ app(\App\Services\NomorSuratService::class)->display($data, 'desa_penduduk') }}
</div>

<p class="tulisan">
    Yang bertanda tangan di bawah ini, kami KEPALA DESA Kemirigede Kecamatan Kesamben Kabupaten Blitar,
    menerangkan dengan sebenarnya bahwa orang tersebut di bawah ini :
</p>

<table class="data">
    <tr><td>Nama</td><td>:</td><td>{{ $data->nama_lengkap ?? '...........................................' }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $data->jenis_kelamin ?? '...........................................' }}</td></tr>
    <tr><td>Tempat, Tgl Lahir</td><td>:</td><td>{{ $data->tempat_lahir ?? '...........................................' }}, {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir) ->locale('id')->translatedFormat('d F Y') : '...........................................' }}</td></tr>
    <tr><td>Kewarganegaraan</td><td>:</td><td>{{ $data->kewarganegaraan ?? '...........................................' }}</td></tr>
    <tr><td>Agama</td><td>:</td><td>{{ $data->agama ?? '...........................................' }}</td></tr>
    <tr><td>NIK</td><td>:</td><td>{{ $data->nik ?? '...........................................' }}</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>{{ $data->pekerjaan ?? '...........................................' }}</td></tr>
    <tr><td>Status</td><td>:</td><td>{{ $data->status ?? '...........................................' }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat ?? '...........................................' }}</td></tr>
</table>

<p class="tulisan">
    Orang tersebut adalah benar-benar penduduk Desa Kemirigede Kecamatan Kesamben Kabupaten Blitar.
    Surat pengantar/keterangan ini dipergunakan untuk {{ $data->keterangan_tambahan ?? 'keperluan yang bersangkutan' }}.
</p>

<p class="tulisan">
    Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya.
</p>

<table class="ttd-table">
    <tr>
        <td class="ttd-spacer"></td>
        <td class="ttd-cell">
            <p>Kemirigede, {{ $tanggalSurat }}</p>
            <p><strong>KEPALA DESA Kemirigede</strong></p>
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div>
            <p class="nama"><u>Hari Purnawan, S.Sos.</u></p>
              {{--
            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
            </div> --}}
        </td>
    </tr>
</table>

</body>
</html>
