<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pengantar Keabsahan Akta Kelahiran</title>
    <style>
        @page {
            margin: 1.1cm 1.4cm 1.1cm 1.4cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT */
        .kop-container {
            width: 100%;
            margin-bottom: 12px;
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
            width: 105px;
            height: auto;
        }

        .kop-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-text .kop-baris-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text .kop-alamat {
            font-size: 11pt;
            font-weight: normal;
            margin-top: 2px;
        }

        .kop-text .kop-kontak {
            font-size: 10pt;
            font-weight: normal;
        }

        .kop-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 6px 0 12px 0;
        }

        .header-surat {
            width: 100%;
            margin-bottom: 10px;
        }

        .header-left {
            width: 50%;
            float: left;
        }

        .header-right {
            width: 50%;
            float: right;
            text-align: right;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 8px 0 12px 0;
            font-size: 13pt;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 10.5pt;
        }

        .isi {
            text-align: justify;
            margin-bottom: 7px;
        }

        table.identitas {
            width: 100%;
            margin: 6px 0 10px 0;
            border-collapse: collapse;
        }

        table.identitas td {
            padding: 3px 5px;
            vertical-align: top;
        }

        table.identitas td:first-child {
            width: 165px;
            font-weight: bold;
        }

        ol {
            margin-top: 4px;
            margin-bottom: 10px;
            padding-left: 24px;
        }

        ol li {
            margin-bottom: 3px;
        }

        .ttd-table {
            width: 100%;
            margin-top: 30px;
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
        }

        .ttd-img {
            width: 200px;
            height: auto;
        }

        .nama {
            font-weight: bold;
        }

        .barcode {
            margin-top: 6px;
        }

        .barcode img {
            width: 68px;
            height: auto;
        }

        .barcode small {
            font-size: 8pt;
        }

        .materai {
            border: 1px solid #000;
            padding: 4px 12px;
            display: inline-block;
            margin: 4px 0;
            font-weight: bold;
            font-size: 9pt;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>
<body>

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

               {{-- <td class="kop-logo">
                    <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '--- / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- HEADER SURAT -->
    <div class="header-surat clearfix">
        <div class="header-left">
            <strong>Perihal</strong> &nbsp;&nbsp;: Permohonan Pengantar Keabsahan Akta Kelahiran<br>
            <strong>Lampiran</strong> : 1 (satu) Bendel
        </div>

        <div class="header-right">
            Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}<br><br>
            Kepada Yth.<br>
            Kepala Dinas Kependudukan dan Pencatatan Sipil<br>
            Kabupaten Blitar<br>
            <strong>di BLITAR</strong>
        </div>
    </div>

    <div style="clear: both;"></div>

    <p class="isi"><strong>Dengan hormat,</strong></p>

    <p class="isi">Yang bertanda tangan di bawah ini:</p>

    <table class="identitas">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $data->jenis_kelamin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat / Tanggal Lahir</td>
            <td>
                : {{ $data->ttl_tempat ?? '' }} /
                {{ !empty($data->ttl_tanggal)
                    ? \Carbon\Carbon::parse($data->ttl_tanggal)->translatedFormat('d F Y')
                    : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="isi">
        Dengan ini saya mengajukan permohonan untuk dibuatkan
        <strong>Surat Pengantar Keabsahan Akta Kelahiran</strong>
        ke Dinas Kependudukan dan Pencatatan Sipil Kabupaten Blitar.
    </p>

    <p class="isi"><strong>Berikut ini saya lampirkan:</strong></p>

    <ol>
        <li>Fotocopy Kutipan Akta Kelahiran</li>
        <li>Fotocopy Kartu Keluarga</li>
    </ol>

    <p class="isi">
        Demikian surat permohonan ini saya buat dengan sebenar-benarnya.
        Atas perhatian dan bantuannya, saya ucapkan terima kasih.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Hormat Saya,</p>

                {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div> --}}


                <div class="materai">Materai<br>10.000</div>

                <p class="nama">
                    <u>{{ $data->nama ?? '...........................................' }}</u>
                </p>

                <p>NIK: {{ $data->nik ?? '...........................................' }}</p>

                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                    <br>
                    <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
