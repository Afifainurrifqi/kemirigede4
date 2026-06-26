<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Kesanggupan</title>
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
        table.data td:first-child { width: 220px; }

        .ttd {
            width: 100%;
            margin-top: 50px;
            border-collapse: collapse;
        }
        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-img-wrapper { height: 60px; margin: 8px 0; }
        .ttd-img { width: 170px; }
        .nama-kades { font-weight: bold; text-decoration: underline; }
        .qr-section { margin-top: 10px; text-align: center; }
        .qr-section img { width: 80px; }
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

<div class="judul">SURAT PERNYATAAN KESANGGUPAN</div>

<p>Berdasarkan Surat Edaran Bupati Blitar tertanggal 26 April 2022 Nomor : 440/10/409.208.1/2022, tentang Standart Operasional Prosedur (SOP) Penyelenggaraan Kegiatan Sosial Kemasyarakatan Pada Masa Pemberlakuan Pembatasan Kegiatan Masyarakat Level 3, Level 2, dan Level 1 Corona Virus Disease 2019 (COVID-19) di Kabupaten Blitar, Saya yang bertanda tangan di bawah ini :</p>

<table class="data">
    <tr><td>Nama</td><td>:</td><td>{{ $data->nama ?? '...........................................' }}</td></tr>
    <tr><td>NIK</td><td>:</td><td>{{ $data->nik ?? '...........................................' }}</td></tr>
    <tr><td>Tempat/Tanggal Lahir</td><td>:</td><td>{{ $data->tempat_lahir ?? '-' }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat ?? '...........................................' }}</td></tr>
    <tr><td>Kegiatan</td><td>:</td><td>{{ $data->kegiatan ?? '...........................................' }}</td></tr>
</table>

<p><strong>Pelaksanaan</strong></p>

<table class="data">
    <tr><td>Hari/Tanggal</td><td>:</td><td>{{ $data->hari ?? '-' }}, {{ \Carbon\Carbon::parse($data->tanggal_kegiatan)->translatedFormat('d F Y') }}</td></tr>
    <tr><td>Waktu</td><td>:</td><td>{{ $data->waktu ?? '...........................................' }}</td></tr>
    <tr><td>Tempat</td><td>:</td><td>{{ $data->tempat_kegiatan ?? '...........................................' }}</td></tr>
</table>

<p>Dengan ini saya yang mengajukan rekomendasi kegiatan tersebut menyatakan sanggup memenuhi persyaratan protokol kesehatan dan memenuhi kewajiban sebagaimana yang dipersyaratkan antara lain:</p>

<ol>
    <li>Membuat acara kegiatan dengan memperhatikan protokol kesehatan baik di dalam maupun di luar ruangan;</li>
    <li>Melaporkan/membuat rencana detail pelaksanaan kegiatan dan mendapatkan rekomendasi dari Satuan Tugas Percepatan Penanganan Corona Virus Disease 2019 (COVID-19);</li>
    <li>Menyiapkan petugas dalam jumlah cukup untuk melakukan pengawasan protokol kesehatan di tempat kegiatan;</li>
    <li>Memastikan semua peserta atau tamu undangan yang hadir wajib menggunakan masker;</li>
    <li>Wajib menggunakan aplikasi Peduli Lindungi untuk melakukan skrining terhadap semua pengunjung atau tamu dan hanya pengunjung dengan kategori Hijau dalam Peduli Lindungi yang boleh masuk kecuali tidak bisa divaksin karena alasan kesehatan;</li>
    <li>Menempatkan tempat cuci tangan (wastafel) dengan sabun dan pembersih tangan mengandung alkohol di pintu masuk dan keluar dalam jumlah cukup;</li>
    <li>Melakukan pembersihan menggunakan disinfektan pada tempat kegiatan sebelum dan sesudah kegiatan;</li>
    <li>Mengatur sirkulasi dan ventilasi udara di tempat kegiatan;</li>
    <li>Menerapkan penjagaan jarak (physical distancing) antar peserta atau tamu undangan;</li>
    <li>Membatasi jumlah peserta/tamu undangan yang hadir maksimal yang disesuaikan dengan level PPKM yang berlaku;</li>
    <li>Kegiatan dilaksanakan se-efektif dan se-efisien mungkin paling lama 4 (empat) jam;</li>
    <li>Memberikan hidangan dalam bentuk kemasan;</li>
    <li>Menyiapkan Satuan Tugas Mandiri Tanggap Corona Virus Disease 2019 dan bertanggungjawab penuh;</li>
</ol>

<p>Apabila saya tidak mematuhi penerapan protokol kesehatan dalam pelaksanaan kegiatan, maka saya bersedia untuk dihentikan kegiatan tersebut oleh Tim Satuan Tugas Percepatan Penanganan Corona Virus Disease 2019 Tingkat Desa, Babinsa dan Babinkamtibmas.</p>

<p>Demikian surat pernyataan ini saya buat dengan sebenar-benarnya.</p>

<table class="ttd">
    <tr>
        <td></td>
        <td>KEMIRIGEDE, {{ $tanggalSurat }}</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>YANG MENYATAKAN</strong></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
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
