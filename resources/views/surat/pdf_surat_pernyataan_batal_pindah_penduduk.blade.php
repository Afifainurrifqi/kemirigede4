<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Batal Pindah Penduduk</title>
    <style>
        @page {
            margin: 1.2cm 1.8cm 1.2cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
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

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 8px 0 12px 0;
            font-size: 12.5pt;
        }

        .isi {
            text-align: justify;
            margin-bottom: 6px;
        }

        table.data {
            width: 100%;
            margin-bottom: 8px;
            border-collapse: collapse;
        }

        table.data td {
            padding: 2.5px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 155px;
            font-weight: bold;
        }

        .ttd-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .ttd-spacer {
            width: 52%;
        }

        .ttd-cell {
            width: 48%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-cell p {
            margin: 2px 0;
        }

        .ttd-img-wrapper {
            height: 52px;
            margin-bottom: 3px;
        }

        .ttd-img {
            width: 170px;
            height: auto;
        }

        .nama {
            font-weight: bold;
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
                    <div class="kop-baris-3">PEMERINTAH DESA Kemirigede</div>
                    <div class="kop-alamat">Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445</div>
                    <div class="kop-kontak">
                        email :pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

               {{-- <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <div class="judul">SURAT PERNYATAAN BATAL PINDAH PENDUDUK</div>

    <p class="isi"><strong>Yang bertanda tangan di bawah ini:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>TTL</td>
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
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $data->agama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: {{ $data->status ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="isi"><strong>Dengan ini menyatakan bahwa saya tidak jadi pindah penduduk:</strong></p>

    <table class="data">
        <tr>
            <td>Ke alamat</td>
            <td>: {{ $data->ke_alamat ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Dikarenakan</td>
            <td>: {{ $data->alasan_batal ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Dan akan menetap sesuai alamat asal di</td>
            <td>: {{ $data->alamat_asal ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="isi">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan tanpa ada paksaan dari pihak mana pun.
    </p>

    <!-- TANDA TANGAN + QR -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Blitar, {{ now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div> --}}

<br><br><br>
                <p class="nama">
                    <u>{{ $data->nama ?? '...........................................' }}</u>
                </p>

                <!-- QR / BARCODE -->
                {{-- <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
                </div> --}}
            </td>
        </tr>
    </table>

</body>
</html>
