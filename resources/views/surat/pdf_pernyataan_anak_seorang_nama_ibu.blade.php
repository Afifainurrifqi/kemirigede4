<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Anak Seorang Nama Ibu</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm 1cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.3pt;
            line-height: 1.28;
            color: #000;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 15%;
            text-align: center;
        }

        .kop-logo img {
            width: 80px;
            height: auto;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text strong {
            font-size: 12.3pt;
        }

        .kop-text small {
            font-size: 9.3pt;
        }

        .kop-garis {
            border: none;
            border-top: 2.5px solid #000;
            margin: 6px 0 10px 0;
        }

        .judul-surat {
            margin: 10px 0 6px;
            text-align: center;
        }

        .judul-surat h3 {
            font-size: 13pt;
            text-decoration: underline;
        }

        .nomor-surat {
            margin-bottom: 14px;
            font-weight: bold;
            text-align: center;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 6px;
        }

        table.tulisan {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
        }

        table.tulisan td {
            padding: 2px 6px;
            vertical-align: top;
        }

        table.tulisan td:first-child {
            width: 170px;
            font-weight: bold;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .ttd-spacer {
            width: 54%;
        }

        .ttd-cell {
            width: 46%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-img-wrapper {
            height: 68px;
            text-align: center;
            margin: -2px 0 -3px 0;
        }

        .ttd-img {
            width: 235px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            font-size: 11pt;
        }

        .barcode img {
            width: 72px;
            height: auto;
        }
    </style>
</head>

<body>

    <!-- KOP -->
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td class="kop-logo"><img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo"></td>
                <td class="kop-text">
                    <strong>PEMERINTAH KABUPATEN BLITAR<br>
                        KECAMATAN KEMIRIGEDE<br>
                        KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
                    <small>Jln. Merdeka No. 74 Telp. 082139324445<br>
                        Email: KEMIRIGEDEberkelas@gmail.com</small>
                </td>
                <td class="kop-logo"><img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo"></td>
            </tr>
        </table>
        <hr class="kop-garis">
    </div>

    <br><br>

    <div class="judul-surat">
        <h3><u>SURAT PERNYATAAN</u></h3>
    </div>

    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '450 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <p class="tulisan">Yang bertanda tangan di bawah ini, Saya:</p>

    <table class="tulisan">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Berdasarkan Peraturan Menteri Dalam Negeri RI No. 9 Tahun 2016, dan berkaitan dengan permohonan penerbitan
        Kutipan Akta Kelahiran anak kandung saya atas nama:
    </p>

    <table class="tulisan">
        <tr>
            <td>Nama Anak</td>
            <td>: {{ $data->nama_anak }}</td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td>: {{ $data->tempat_lahir }}</td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>: {{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Dengan ini menyatakan bahwa saya tidak keberatan apabila dalam Kutipan Akta Kelahiran tersebut ditulis
        <strong>“lahir dari seorang Ibu”</strong> dan tidak menyebutkan nama Ayah, dikarenakan saya belum melaksanakan
        UU No. 1 Tahun 1974 tentang Perkawinan.
    </p>

    <p class="tulisan">
        Demikian Surat Pernyataan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    <!-- TTD -->
     <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>KEMIRIGEDE, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
                </div>

                <p class="nama-kades"><u>{{ $data->nama }}</u></p>


                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                    <br><small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                </div>
            </td>
        </tr>
    </table>


</body>

</html>
