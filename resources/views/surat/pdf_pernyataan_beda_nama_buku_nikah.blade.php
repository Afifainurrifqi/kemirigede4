<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Beda Nama Buku Nikah</title>
    <style>
        @page {
            margin: 1.2cm 1.5cm 1cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.3pt;
            line-height: 1.28;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        .text-center {
            text-align: center;
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
            margin: 10px 0 6px 0;
            text-align: center;
        }

        .judul-surat h3 {
            font-size: 13pt;
            margin: 0;
            font-weight: bold;
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
            width: 165px;
            font-weight: bold;
        }

        /* TANDA TANGAN */
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

        .barcode {
            margin-top: 4px;
            text-align: center;
        }

        .barcode img {
            width: 72px;
            height: auto;
        }

        .barcode small {
            font-size: 8pt;
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

    <!-- JUDUL SURAT -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN</h3>
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '440 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI SURAT -->
    <p class="tulisan">Saya yang bertanda tangan di bawah ini:</p>

    <table class="tulisan">
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
                :
                {{ $data->ttl_tempat ?? '...........................................' }},
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

    <p class="tulisan">
        Menyatakan bahwa karena terdapat perbedaan nama orang tua di Kartu Keluarga dan
        <strong>{{ $data->sumber_data_nama ?? '...........................................' }}</strong>,
        maka nama Ayah / Ibu yang akan dicantumkan dalam Akta Kelahiran atas nama
        <strong>{{ $data->nama_sesuai ?? '...........................................' }}</strong>
        adalah nama yang sesuai dengan data yang ada pada
        <strong>{{ $data->sumber_data_nama ?? '...........................................' }}</strong>.
    </p>

    <p class="tulisan">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan saya
        bertanggung jawab sepenuhnya atas segala bentuk pembetulan data yang saya lakukan.
        Apabila dikemudian hari ternyata pernyataan saya tidak benar, maka saya bersedia
        diproses secara hukum dengan peraturan perundang-undangan dan dokumen yang
        diterbitkan akibat dari pernyataan ini menjadi tidak sah.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <p class="nama-kades">
                    <u>{{ $data->nama ?? '...........................................' }}</u>
                </p>

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
