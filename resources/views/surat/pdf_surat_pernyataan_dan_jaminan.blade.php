<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan dan Jaminan</title>
    <style>
        @page {
            margin: 1.1cm 1.6cm 1cm 1.6cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.8pt;
            line-height: 1.28;
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

        /* ISI SURAT */
        .judul-surat {
            text-align: center;
            margin-bottom: 4px;
        }

        .judul-surat h3 {
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 10.5pt;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 5px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 8px 0;
        }

        table.data td {
            padding: 2px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 155px;
            font-weight: bold;
        }

        ol {
            margin-left: 18px;
            margin-bottom: 8px;
            padding-left: 10px;
        }

        ol li {
            margin-bottom: 3px;
            text-align: justify;
        }

        /* TANDA TANGAN */
        .ttd-wrapper {
            width: 100%;
            margin-top: 15px;
            overflow: auto;
        }

        .ttd-right {
            width: 48%;
            float: right;
            text-align: center;
        }

        .ttd-right p {
            margin: 1.5px 0;
        }

        .materai {
            border: 1px solid #000;
            padding: 6px 16px;
            display: inline-block;
            margin: 6px 0;
            font-weight: bold;
            font-size: 10pt;
        }

        .signature-line {
            margin-top: 28px;
            border-bottom: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
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

    <!-- JUDUL SURAT -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN DAN JAMINAN</h3>
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '420 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- SECTION 1: PENJAMIN -->
    <p class="tulisan"><strong>Yang bertanda tangan di bawah ini:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_pembuat ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_pembuat ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_pembuat ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Hubungan dengan Terjamin</td>
            <td>: {{ $data->hubungan_dengan_terjamin ?? '...........................................' }}</td>
        </tr>
    </table>

    <!-- SECTION 2: ORANG YANG DIJAMIN -->
    <p class="tulisan">
        Selanjutnya menyatakan diri sebagai penjamin/penanggung jawab dengan hormat mengajukan permohonan SKTT untuk orang asing berikut:
    </p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_terjamin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_terjamin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_terjamin ?? '...........................................' }}</td>
        </tr>
    </table>

    <!-- SECTION 3: TANGGUNG JAWAB -->
    <p class="tulisan">
        <strong>Dan sebagai penjamin/penanggung jawab, Saya bertanggung jawab penuh terhadap:</strong>
    </p>

    <ol>
        <li>
            Hal ihwal keberadaan serta kegiatan orang asing yang bersangkutan selama berada di Indonesia.
        </li>
        <li>
            Setiap perubahan status sipil, status keimigrasian, dan perubahan alamat.
        </li>
        <li>
            Segala biaya yang timbul sebagai akibat dari keberadaan serta kegiatan orang asing yang bersangkutan selama di Indonesia hingga pemulangan ke negara asalnya.
        </li>
    </ol>

    <p class="tulisan">
        Demikian surat pernyataan dan jaminan ini saya buat dengan sesungguhnya, dan apabila dikemudian hari keterangan di atas ternyata tidak benar,
        maka saya sebagai penjamin bersedia dituntut sesuai dengan ketentuan perundang-undangan yang berlaku.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper clearfix">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}</p>
            <p><strong>Hormat Saya,</strong></p>

            {{-- <div class="materai">Materai<br>10.000</div> --}}

            <div class="signature-line"></div>

            <p>
                <strong>
                    ( {{ $data->nama_pembuat ?? '...........................................' }} )
                </strong>
            </p>
        </div>
    </div>

</body>
</html>
