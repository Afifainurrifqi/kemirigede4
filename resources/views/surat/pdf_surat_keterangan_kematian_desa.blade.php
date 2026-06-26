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
        }

        .kop-container {
            width: 100%;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 12%;
            text-align: center;
            vertical-align: top;
        }

        .kop-logo img {
            width: 72px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            vertical-align: top;
        }

        .kop-text strong {
            font-size: 12.8pt;
            line-height: 1.2;
        }

        .kop-text small {
            font-size: 9.2pt;
            line-height: 1.1;
        }

        .kop-garis {
            border: none;
            border-top: 2.8px solid #000;
            margin: 8px 0 12px 0;
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
    </style>
</head>

<body>

    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

        $tanggalMeninggal = !empty($data->tanggal)
            ? \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y')
            : '...........................................';

        $statusLabel = '...........................................';

        if (!empty($data->status)) {
            $statusData = \App\Models\Status::find($data->status);
            $statusLabel = $statusData->nama ?? $data->status;
        }
    @endphp

    {{-- KOP SURAT --}}
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
                </td>

                <td class="kop-text">
                    <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
                    <strong>KECAMATAN WATES</strong><br>
                    <strong>KANTOR KEPALA DESA WATES</strong><br>
                    <small>
                        Jln. Merdeka No. 74 Telp. 082139324445<br>
                        Email: watesberkelas@gmail.com | Website: wates-blitarkab.desa.id
                    </small>
                </td>

                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa Wates">
                </td>
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
        Nomor : {{ $data->nomor_surat ?? '470 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <p class="tulisan">
        Yang bertandatangan di bawah ini Kepala Desa Wates, Kecamatan Wates, Kabupaten Blitar,
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
        Orang tersebut di atas benar-benar penduduk Desa Wates, Kecamatan Wates, Kabupaten Blitar
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
                <p>Wates, {{ $tanggalSurat }}</p>
                <p><strong>Kepala Desa Wates</strong></p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <p class="nama"><u>MOH. HAMID ALMAULUDI, S.Pd.I</u></p>

                <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
