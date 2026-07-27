<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Miskin SKM</title>

    <style>
        @page {
            margin: 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 14px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 105px;
            height: auto;
        }

        .kop-desa-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-desa-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 11pt;
            margin-top: 2px;
        }

        .kop-desa-kontak {
            font-size: 10pt;
        }

        .kop-desa-garis {
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
            font-size: 13.5pt;
            margin-top: 12px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 18px;
        }

        .isi {
            text-align: justify;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 25px;
        }

        table.data td {
            padding: 3px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 160px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .ttd {
            width: 100%;
            margin-top: 38px;
            border-collapse: collapse;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin: 5px 0 3px 0;
        }

        .ttd-img {
            width: 165px;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        .qr-section {
            margin-top: 6px;
            text-align: center;
        }

        .qr-section img {
            width: 78px;
        }

        .qr-section small {
            font-size: 7.3pt;
            color: #555;
            display: block;
        }

        .space-sign {
            height: 65px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>

<body>
    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

        $tanggalLahir = !empty($data->tanggal_lahir)
            ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')
            : '...........................................';
    @endphp

    <!-- KOP SURAT -->
    <div class="kop-desa-container">
        <table class="kop-desa-table">
            <tr>
                <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-desa-text">
                    <div class="kop-desa-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="kop-desa-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-desa-3">PEMERINTAH DESA Kemirigede</div>
                    <div class="kop-desa-alamat">Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email :pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                   {{-- <td class="kop-desa-logo">
                <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
            </td> --}}
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    <div class="judul">SURAT KETERANGAN MISKIN (SKM)</div>

    <div class="nomor">
        Nomor : {{ $data->nomor_surat ?? '422.4 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <div class="isi">
        <p>Yang bertanda tangan dibawah ini:</p>

        <table class="data">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>Hari Purnawan, S.Sos.</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>KEPALA DESA Kemirigede Kec. Kemirigede Kab. Blitar</td>
            </tr>
        </table>

        <p>Menerangkan dengan sebenarnya bahwa:</p>

        <table class="data">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $data->nama ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Tempat Tgl Lahir</td>
                <td>:</td>
                <td>{{ $data->tempat_lahir ?? '....................' }}, {{ $tanggalLahir }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $data->nik ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $data->pekerjaan ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $data->alamat ?? '...........................................' }}</td>
            </tr>
        </table>

        <p>
            Bahwa orang tersebut diatas adalah keluarga miskin yang belum mempunyai kartu
            Jamkesmas maupun kartu Jamkesda Provinsi Jawa Timur.
        </p>

        <p>
            Demikian surat keterangan miskin ini dibuat dan dipergunakan sesuai dengan
            ketentuan yang berlaku dalam pelayanan Jamkesda Provinsi Jawa Timur.
        </p>
    </div>

    <table class="ttd">
        <tr>
            <td colspan="2">Blitar, {{ $tanggalSurat }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>TIM VERIFIKATOR DESA:</strong></td>
        </tr>
        <tr>
            <td><strong>KEPALA DESA Kemirigede</strong></td>
            <td><strong>Bidan Desa</strong></td>
        </tr>
        <tr>
            <td>

                <br><br><br>
                {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div> --}}


                <div class="nama-kades">Hari Purnawan, S.Sos.</div>

              {{--
            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
            </div> --}}
            </td>
            <td>
                <div class="space-sign"></div>
                <strong><u>...........................................</u></strong>
            </td>
        </tr>
    </table>

</body>

</html>
