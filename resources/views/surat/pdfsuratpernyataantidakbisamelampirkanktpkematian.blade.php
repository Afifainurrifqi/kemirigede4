<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Tidak Bisa Melampirkan KTP Kematian</title>
    <style>
        @page {
            margin: 1.3cm 1.8cm 1.3cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
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
            font-weight: light;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-2 {
            font-size: 15pt;
            font-weight: light;
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
            text-decoration: underline;
            font-weight: bold;
            font-size: 13.5pt;
            margin-bottom: 12px;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 6px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
        }

        table.data td {
            padding: 2.5px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 155px;
            font-weight: bold;
        }

        .label-box {
            border: 1px solid #000;
            padding: 1px 6px;
            font-size: 9.5pt;
            font-weight: bold;
            display: inline-block;
            margin-left: 8px;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 25px;
        }

        .ttd-right {
            width: 48%;
            float: right;
            text-align: center;
        }

        .ttd-right p {
            margin: 2px 0;
        }

        .ttd-img-wrapper {
            margin: 8px 0;
            text-align: center;
        }

        .ttd-img {
            width: 160px;
            height: auto;
        }

        .barcode {
            margin-top: 8px;
            text-align: center;
        }

        .barcode img {
            width: 85px;
            height: auto;
        }

        .barcode small {
            font-size: 7.8pt;
            display: block;
            margin-top: 3px;
        }

        .catatan {
            font-size: 9.5pt;
            margin-top: 15px;
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

    <!-- JUDUL -->
    <div class="judul-surat">
        SURAT PERNYATAAN
    </div>

    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '300 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI -->
    <p class="tulisan"><strong>Yang bertanda tangan di bawah ini, Saya:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>: {{ $data->tempat_lahir_pelapor ?? '' }},
                {{ isset($data->tanggal_lahir_pelapor) ? \Carbon\Carbon::parse($data->tanggal_lahir_pelapor)->translatedFormat('d F Y') : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $data->jenis_kelamin_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_pelapor ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Menyatakan dengan sebenarnya bahwa tidak bisa melampirkan KTP termohon yang akan digunakan untuk pengurusan Akta Kematian
        dikarenakan <strong>{{ $data->alasan ?? 'Hilang / Belum ber KTP / Belum perekaman' }}</strong> *) atas nama:
    </p>

    <table class="data">
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_jenazah ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Nama / Tanggal Lahir</td>
            <td>: {{ $data->nama_jenazah ?? '...........................................' }} /
                {{ isset($data->tanggal_lahir_jenazah) ? \Carbon\Carbon::parse($data->tanggal_lahir_jenazah)->translatedFormat('d F Y') : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $data->jenis_kelamin_jenazah ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_jenazah ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Demikian Surat Pernyataan ini saya buat dengan sebenar-benarnya dan apabila dikemudian hari ternyata pernyataan saya tidak benar,
        maka saya bersedia diproses secara hukum sesuai dengan peraturan perundang-undangan yang berlaku dan dokumen yang diterbitkan dari pernyataan ini menjadi tidak sah.
    </p>

    <div class="catatan">
        *) Coret yang tidak perlu
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper" style="margin-top: 35px;">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>Yang membuat pernyataan</strong></p>

            {{-- <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div> --}}

            <br><br><br><br><br>

            <p><strong><u>{{ $data->nama_pelapor ?? '...........................................' }}</u></strong></p>

            {{-- <div class="barcode">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                <small>Dokumen ini resmi dikeluarkan oleh Pemerintah Desa KEMIRIGEDE</small>
            </div> --}}
        </div>
    </div>

</body>
</html>
