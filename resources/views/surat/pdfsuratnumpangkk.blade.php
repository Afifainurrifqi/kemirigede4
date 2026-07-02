<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Numpang KK</title>
    <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.45;
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
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            letter-spacing: 1px;
        }

        .sub-judul {
            text-align: center;
            font-weight: bold;
            font-size: 11.5pt;
            margin-bottom: 2px;
        }

        .pasal {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 16px;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 14px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 6px;
            text-indent: 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
        }

        table.data td {
            padding: 2px 4px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 155px;
            font-weight: bold;
        }

        /* TANDA TANGAN */
        .ttd-wrapper {
            width: 100%;
            margin-top: 28px;
            overflow: auto;
        }

        .ttd-right {
            width: 45%;
            float: right;
            text-align: center;
        }

        .ttd-right p {
            margin: 2px 0;
        }

        .materai {
            border: 1px solid #000;
            padding: 6px 18px;
            display: inline-block;
            margin: 8px 0;
            font-weight: bold;
            font-size: 10pt;
        }

        .signature-line {
            margin-top: 40px;
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
                    <div class="kop-baris-2">KECAMATAN KEMIRIGEDE</div>
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

    <!-- JUDUL SURAT -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN</h3>
    </div>

    <div class="sub-judul">
        BERSEDIA MENERIMA SEBAGAI ANGGOTA KELUARGA
    </div>

    <div class="pasal">
        (Pasal 12 ayat (5) Permendagri Nomor 108 Tahun 2019)
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '400 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI SURAT -->
    <p class="tulisan"><strong>Saya yang bertanda tangan di bawah ini:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_pemilik_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_pemilik_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>No. KK</td>
            <td>: {{ $data->no_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_pemilik_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_pemilik_kk ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Selaku Kepala Keluarga, dengan ini menyatakan <strong>tidak keberatan</strong>
        dalam Kartu Keluarga saya dimasukkan orang tersebut di bawah ini:
    </p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_penumpang_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_penumpang_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat dan Tanggal Lahir</td>
            <td>
                : {{ $data->tempat_lahir_penumpang_kk ?? '' }},
                {{ !empty($data->tanggal_lahir_penumpang_kk)
                    ? \Carbon\Carbon::parse($data->tanggal_lahir_penumpang_kk)->translatedFormat('d F Y')
                    : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $data->agama_penumpang_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_penumpang_kk ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan tanpa paksaan
        dari pihak manapun, untuk dipergunakan sebagaimana mestinya.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper clearfix">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>Saya yang menyatakan,</strong></p>

            <div class="materai">Materai<br>10.000</div>

            <div class="signature-line"></div>

            <p>
                <strong>
                    ( {{ $data->nama_pemilik_kk ?? '...........................................' }} )
                </strong>
            </p>
        </div>
    </div>

</body>
</html>
