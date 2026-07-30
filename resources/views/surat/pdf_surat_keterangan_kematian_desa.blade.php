<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kematian Desa</title>

    <style>
        @page {
            margin: 1.1cm 1.8cm 1.1cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.8pt;
            line-height: 1.4;
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
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin: 18px 0 4px 0;
        }

        .nomor-surat {
            text-align: center;
            font-weight: normal;
            margin-bottom: 20px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 9px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 15px 0;
        }

        table.data td {
            padding: 4px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 165px;
            font-weight: normal;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .meninggal {
            margin-top: 5px;
            margin-bottom: 12px;
        }

        .meninggal table {
            width: 100%;
            border-collapse: collapse;
        }

        .meninggal td {
            padding: 2px 6px;
            vertical-align: top;
        }

        .meninggal td:first-child {
            width: 125px;
        }

        .meninggal td:nth-child(2) {
            width: 10px;
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
        }

        .ttd-cell p {
            margin: 2px 0;
        }

        .ttd-img-wrapper {
            height: 52px;
            margin-bottom: 3px;
            text-align: center;
        }

        .ttd-img {
            width: 170px;
            height: auto;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
            margin: 4px 0 2px 0;
        }

        .qr-section {
            margin-top: 8px;
            text-align: center;
        }

        .qr-section img {
            width: 85px;
            height: auto;
        }

        .qr-section small {
            font-size: 7.5pt;
            color: #555;
            display: block;
            margin-top: 2px;
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

    @php
        use App\Models\Status;
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

        $tanggalMeninggal = !empty($data->tanggal)
            ? \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y')
            : '...........................................';

        $statusLabel = $data->status ?? '...........................................';
    @endphp

    {{-- KOP SURAT --}}
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

    {{-- JUDUL SURAT --}}
    <div class="judul-surat">
        SURAT KETERANGAN KEMATIAN DESA
    </div>

    {{-- NOMOR SURAT --}}
    <div class="nomor-surat">
        Nomor : {{ app(\App\Services\NomorSuratService::class)->display($data, 'kematian_desa') }}
    </div>

    <p class="tulisan">
        Yang bertandatangan di bawah ini KEPALA DESA Kemirigede, Kecamatan Kesamben, Kabupaten Blitar,
        menerangkan dengan sebenarnya bahwa :
    </p>

    {{-- DATA ALMARHUM --}}
    <table class="data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $data->nama_lengkap ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $data->jenis_kelamin ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>:</td>
            <td>{{ $data->kewarganegaraan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $statusLabel }}</td>
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

    <p class="tulisan">
        Orang tersebut di atas benar-benar penduduk Desa Kemirigede, Kecamatan Kesamben, Kabupaten Blitar
        dan benar telah <strong>Meninggal Dunia</strong> pada :
    </p>

    {{-- DATA KEMATIAN --}}
    <div class="meninggal">
        <table>
            <tr>
                <td>Hari</td>
                <td>:</td>
                <td>{{ $data->hari ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ $tanggalMeninggal }}</td>
            </tr>
            <tr>
                <td>Disebabkan karena</td>
                <td>:</td>
                <td>{{ $data->penyebab ?? '...........................................' }}</td>
            </tr>
        </table>
    </div>

    <p class="tulisan">
        Demikian surat keterangan kematian ini dibuat atas dasar yang sebenarnya untuk dapat
        dipergunakan sebagaimana perlunya.
    </p>

    {{-- TANDA TANGAN + QR --}}
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Blitar, {{ $tanggalSurat }}</p>
                <p><strong>KEPALA DESA Kemirigede</strong></p>

                {{-- {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div> --}}
                --}}

                <br><br><br><br>

                <p class="nama">
                    <u>Hari Purnawan, S.Sos.</u>
                </p>

                {{-- <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
                </div> --}}
            </td>
        </tr>
    </table>

</body>

</html>
