<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Miskin</title>

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
        }

        /* KOP SURAT */
        .kop {
            width: 100%;
            margin-bottom: 12px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo-left {
            width: 18%;
            text-align: left;
        }

        .kop-logo-right {
            width: 18%;
            text-align: right;
        }

        .kop-logo-left img {
            width: 90px;
            height: auto;
        }

        .kop-logo-right img {
            width: 88px;
            height: auto;
        }

        .kop-text {
            width: 64%;
            text-align: center;
            line-height: 1.12;
        }

        .kop-text .baris-1 {
            font-size: 15pt;
            font-weight: normal;
        }

        .kop-text .baris-2 {
            font-size: 14pt;
            font-weight: normal;
        }

        .kop-text .baris-3 {
            font-size: 16pt;
            font-weight: bold;
        }

        .kop-text .alamat {
            font-size: 10.5pt;
        }

        .kop-text .kontak {
            font-size: 9.5pt;
        }

        .kop-garis {
            border: none;
            border-top: 2.5px solid #000;
            margin-top: 6px;
            margin-bottom: 16px;
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
            margin-bottom: 32px;
        }

        table.data td {
            padding: 8px 0;
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
            margin-top: 70px;
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

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        .nama-pemohon {
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    @php
        \Carbon\Carbon::setLocale('id');

        $tanggalSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat('j F Y')
            : \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('j F Y');

        $tanggalLahir = !empty($data->tanggal_lahir)
            ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('d-m-Y')
            : '-';
    @endphp

    <!-- KOP SURAT -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo-left">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-text">
                    <div class="baris-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="baris-2">KECAMATAN WATES</div>
                    <div class="baris-3">KANTOR KEPALA DESA WATES</div>
                    <div class="alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kontak">
                        email : watesberkelas@gmail.com / website : wates-blitarkab.desa.id
                    </div>
                </td>

                <td class="kop-logo-right">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa Wates">
                </td>
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul">
        SURAT&nbsp;&nbsp;&nbsp;PERNYATAAN
    </div>

    <p class="pembuka">Yang bertanda tangan di bawah ini :</p>

    <!-- DATA PEMOHON -->
    <table class="data">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->nama ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Tempat Tgl Lahir</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->tempat_lahir ?? '-' }}, {{ $tanggalLahir }}
            </td>
        </tr>

        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->nik ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->pekerjaan ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->alamat ?? '-' }}</td>
        </tr>
    </table>

    <!-- ISI SURAT -->
    <p class="paragraf">
        Demikian ini menyatakan bahwa saya ayah/ibu/suami/istri/anak/saudara saya
        apabila di kemudian hari dilaksanakan survey ternyata terbukti mampu dan tidak sesuai
        dengan criteria surat keterangan miskin, maka kami bersedia dan sanggup
        mengembalikan biaya yang telah ditanggung oleh pemerintah.
    </p>

    <p class="paragraf">
        Demikian surat pernyataan ini dibuat dengan sebenarnya dan dapat dipergunakan
        sesuai dengan ketentuan yang berlaku dalam pelayanan SPM kabupaten blitar.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <!-- KOLOM KEPALA DESA -->
            <td>
                <div>Mengetahui</div>
                <div class="ttd-jabatan">Kepala Desa Wates</div>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan Kepala Desa">
                </div>

                <div class="nama-kades">MOH.HAMID ALMAULUDI</div>
                <div style="margin-top: 15px;">
                    <img src="{{ public_path('assets/images/barcode.png') }}" width="70" alt="Barcode">
                    <br><small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>

            <!-- KOLOM PEMBUAT PERNYATAAN -->
            <td>
                <div>Blitar, {{ $tanggalSurat }}</div>
                <div class="ttd-jabatan">Yang membuat pernyataan</div>

                <div class="ttd-space"></div>

                <div class="nama-pemohon">
                    {{ $data->nama ?? '................................' }}
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
