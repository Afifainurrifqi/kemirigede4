<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Akta Kelahiran Tidak Ditemukan atau Tidak Tercatat</title>
    <style>
        @page {
            margin: 1.2cm 2cm 1.2cm 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            text-align: justify;
            margin-top: 0;
            margin-bottom: 12px;
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
            margin: 10px 0 6px 0;
        }

        .judul-surat h3 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            text-transform: uppercase;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 8px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 14px 0;
        }

        table.data td {
            padding: 3px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 165px;
            font-weight: bold;
        }

        /* TANDA TANGAN */
        .ttd-wrapper {
            width: 100%;
            margin-top: 30px;
            overflow: auto;
        }

        .ttd-right {
            width: 46%;
            float: right;
            text-align: center;
        }

        .ttd-right p {
            text-align: center;
            margin: 2px 0;
        }

        .materai {
            border: 1px solid #000;
            padding: 7px 18px;
            display: inline-block;
            margin: 10px 0;
            font-weight: bold;
            font-size: 10pt;
        }

        .signature-line {
            margin-top: 36px;
            border-bottom: 1px solid #000;
            width: 210px;
            margin-left: auto;
            margin-right: auto;
        }

        .barcode {
            text-align: center;
            margin-top: 10px;
        }

        .barcode img {
            width: 72px;
            height: auto;
        }

        .barcode small {
            font-size: 8pt;
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
        Nomor: {{ $data->nomor_surat ?? '460 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI SURAT -->
    <p class="tulisan">
        Yang bertanda tangan di bawah ini, Saya:
    </p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama ?? $data->nama_pemohon ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik ?? $data->nik_pemohon ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat ?? $data->alamat_pemohon ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Menyatakan dengan sebenarnya bahwa Akta Kelahiran:
    </p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_akta ?? $data->nama_dalam_akta ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>No. Akta Kelahiran</td>
            <td>: {{ $data->no_akta_kelahiran ?? $data->no_akta ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Ternyata tidak dapat ditemukan / tidak tercatat di Dinas Kependudukan dan
        Pencatatan Sipil Kota Blitar.
    </p>

    <p class="tulisan">
        Selanjutnya saya mengurus Akta Kelahiran dengan nomor yang
        {{ $data->jenis_nomor_akta ?? 'sama / baru' }} sesuai asas domisili dan
        ketentuan perundang-undangan yang berlaku.
    </p>

    <p class="tulisan">
        Demikian surat pernyataan ini saya buat dengan sebenar-sebenarnya dan apabila
        dikemudian hari ternyata pernyataan saya ini tidak benar, maka saya bersedia
        diproses secara hukum sesuai dengan peraturan perundang-undangan dan dokumen
        yang diterbitkan akibat dari pernyataan ini menjadi tidak sah.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper clearfix">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p>Saya yang menyatakan,</p>

            {{-- <div class="materai">Materai<br>10.000</div> --}}

            <br><br><br>
            <div class="signature-line"></div>

            <p>
                <strong>
                    ( {{ $data->nama ?? $data->nama_pemohon ?? '...........................................' }} )
                </strong>
            </p>

            {{-- <div class="barcode">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                <br>
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div> --}}
        </div>
    </div>

</body>
</html>
