<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>
        Surat Pernyataan Tidak Memiliki Kartu JAMKESMAS, ASKES atau JKN
    </title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.6cm 1.8cm 2cm 1.8cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            color: #000;
            line-height: 1.35;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT */
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

        /* JUDUL */
        .judul {
            text-align: center;
            font-size: 15pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .pembuka {
            margin-left: 1.2cm;
            margin-top: 0;
            margin-bottom: 18px;
        }

        /* DATA PEMOHON */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-left: 1.2cm;
            margin-bottom: 40px;
        }

        table.data td {
            padding: 9px 0;
            vertical-align: top;
        }

        table.data .label {
            width: 165px;
        }

        table.data .colon {
            width: 18px;
            text-align: center;
        }

        table.data .value {
            padding-left: 8px;
        }

        /* ISI SURAT */
        .paragraf {
            text-align: justify;
            text-indent: 1.2cm;
            margin: 0 0 10px 0;
        }

        /* TANDA TANGAN */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 85px;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }

        .ttd-jabatan {
            margin-top: 18px;
        }

        .ttd-img-wrapper {
            height: 92px;
            margin-top: 5px;
            margin-bottom: 0;
            text-align: center;
        }

        .ttd-img {
            width: 145px;
            height: auto;
            max-height: 90px;
        }

        .ttd-space {
            height: 92px;
        }

        .nama-kades,
        .nama-pemohon {
            font-weight: bold;
            text-decoration: underline;
        }

        .nama-pemohon {
            text-transform: uppercase;
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
        \Carbon\Carbon::setLocale('id');

        $tanggalSurat = \Carbon\Carbon::now('Asia/Jakarta')
            ->locale('id')
            ->translatedFormat('j F Y');

        $tanggalLahir = !empty($data->tanggal_lahir)
            ? \Carbon\Carbon::parse($data->tanggal_lahir)
                ->locale('id')
                 ->locale('id')->translatedFormat('d F Y')
            : '-';

        $namaPemohon = !empty($data->nama)
            ? mb_strtoupper($data->nama, 'UTF-8')
            : '-';
    @endphp

    {{-- KOP SURAT --}}
    <div class="kop-desa-container">
        <table class="kop-desa-table">
            <tr>
                <td class="kop-desa-logo">
                    <img
                        src="{{ public_path('assets/images/blitar.jpg') }}"
                        alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-desa-text">
                    <div class="kop-desa-1">
                        PEMERINTAH KABUPATEN BLITAR
                    </div>

                    <div class="kop-desa-2">
                        KECAMATAN KESAMBEN
                    </div>

                    <div class="kop-desa-3">
                        PEMERINTAH DESA Kemirigede
                    </div>

                    <div class="kop-desa-alamat">
                        Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445
                    </div>

                    <div class="kop-desa-kontak">
                        Email: pemdeskemirigede@gmail.com /
                        Website: Kemirigede-blitarkab.desa.id
                    </div>
                </td>
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    {{-- JUDUL --}}
    <div class="judul">
        SURAT&nbsp;&nbsp;&nbsp;PERNYATAAN
    </div>

    <p class="pembuka">
        Yang bertanda tangan di bawah ini:
    </p>

    {{-- DATA PEMOHON --}}
    <table class="data">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->nama ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Tempat, Tanggal Lahir</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->tempat_lahir ?? '-' }},
                {{ $tanggalLahir }}
            </td>
        </tr>

        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->nik ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->pekerjaan ?? '-' }}
            </td>
        </tr>

        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->alamat ?? '-' }}
            </td>
        </tr>
    </table>

    {{-- ISI SURAT --}}
    <p class="paragraf">
        Dengan ini menyatakan bahwa saya tidak memiliki kartu JAMKESMAS,
        ASKES, atau JKN.
    </p>

    <p class="paragraf">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya
        untuk dipergunakan sebagaimana mestinya sesuai dengan ketentuan
        yang berlaku dalam pelayanan JAMKESDA Provinsi Jawa Timur.
    </p>

    {{-- TANDA TANGAN --}}
    <table class="ttd-table">
        <tr>
            {{-- Kepala Desa --}}
            <td>
                <div>Mengetahui,</div>

                <div class="ttd-jabatan">
                    KEPALA DESA Kemirigede
                </div>

                <div class="ttd-img-wrapper">
                    <img
                        src="{{ public_path('assets/images/ttd.png') }}"
                        class="ttd-img"
                        alt="Tanda Tangan Kepala Desa">
                </div>

                <div class="nama-kades">
                    Hari Purnawan, S.Sos.
                </div>
            </td>

            {{-- Pemohon --}}
            <td>
                <div>
                    Blitar, {{ $tanggalSurat }}
                </div>

                <div class="ttd-jabatan">
                    Yang membuat pernyataan,
                </div>

                <div class="ttd-space"></div>

                <div class="nama-pemohon">
                    {{ $namaPemohon }}
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
