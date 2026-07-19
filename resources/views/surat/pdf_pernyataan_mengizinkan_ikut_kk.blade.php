<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Mengizinkan Ikut KK</title>
    <style>
        @page {
            margin: 1.1cm 1.4cm 1.1cm 1.4cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
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

        .judul-surat {
            text-align: center;
            margin-bottom: 6px;
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
            margin-bottom: 6px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 8px 0;
        }

        table.data td {
            padding: 3px 5px;
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
            height: 55px;
        }

        .ttd-img {
            width: 210px;
            height: auto;
        }

        .nama-kades {
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
                    <div class="kop-baris-3">PEMERINTAH DESA Kemirigede</div>
                    <div class="kop-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kop-kontak">
                        email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

               {{-- <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN</h3>
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '490 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- DATA YANG MENYATAKAN -->
    <p class="tulisan"><strong>Yang bertanda tangan di bawah ini, Saya:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik ?? '...........................................' }}</td>
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
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan"><strong>Selaku Orang Tua / Wali / Suami / Istri dari:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_izin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_izin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat / Tanggal Lahir</td>
            <td>
                : {{ $data->ttl_tempat_izin ?? '' }} /
                {{ !empty($data->ttl_tanggal_izin)
                    ? \Carbon\Carbon::parse($data->ttl_tanggal_izin)->translatedFormat('d F Y')
                    : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_izin ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Mengizinkan yang tersebut di atas untuk pindah ke
        <strong>{{ $data->tujuan_pindah ?? '...........................................' }}</strong>
        dengan alasan
        <strong>{{ $data->alasan_pindah ?? '...........................................' }}</strong>.
    </p>

    <p class="tulisan">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan apabila dikemudian hari
        ternyata pernyataan saya tidak benar, maka saya bersedia diproses secara hukum sesuai peraturan
        perundang-undangan tanpa menyangkutpautkan Dinas Kependudukan dan Pencatatan Sipil Kabupaten Blitar
        serta dokumen yang diterbitkan akibat dari pernyataan ini menjadi tidak sah.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div> --}}


                {{-- <div class="materai">Materai<br>10.000</div> --}}

                <br><br><br>

                <p class="nama-kades">
                    <u>{{ $data->nama ?? '...........................................' }}</u>
                </p>

                <p>NIK: {{ $data->nik ?? '...........................................' }}</p>
{{--
                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                    <br>
                    <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
                </div> --}}
            </td>
        </tr>
    </table>

</body>
</html>
