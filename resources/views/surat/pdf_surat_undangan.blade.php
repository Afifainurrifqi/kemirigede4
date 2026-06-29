<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Undangan</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.25cm 1.75cm 1.25cm 1.75cm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.18;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            vertical-align: top;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 28px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            vertical-align: middle;
            padding: 0;
            border: none;
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
            margin: 6px 0 0 0;
        }

        /* =========================
           HEADER SURAT
        ========================= */
        .meta-wrapper {
            width: 100%;
            margin-bottom: 20px;
        }

        .meta-left {
            width: 58%;
        }

        .meta-right {
            width: 42%;
            text-align: left;
        }

        .meta-table td {
            font-size: 12pt;
            line-height: 1.18;
            padding: 1px 0;
        }

        .meta-table .label {
            width: 68px;
        }

        .meta-table .colon {
            width: 16px;
            text-align: center;
        }

        .tujuan {
            margin-top: 18px;
            margin-left: 18px;
            line-height: 1.18;
        }

        .tujuan .tempat {
            margin-left: 26px;
        }

        /* =========================
           ISI SURAT
        ========================= */
        .isi {
            margin-top: 22px;
            text-align: justify;
            line-height: 1.35;
        }

        .isi p {
            margin-bottom: 12px;
        }

        .indent {
            text-indent: 1.15cm;
        }

        .agenda-table {
            width: 82%;
            margin-left: 38px;
            margin-top: 2px;
            margin-bottom: 12px;
        }

        .agenda-table td {
            font-size: 12pt;
            line-height: 1.35;
            padding: 0;
        }

        .agenda-table .label {
            width: 90px;
        }

        .agenda-table .colon {
            width: 16px;
            text-align: center;
        }

        .agenda-table .value {
            width: auto;
        }

        /* =========================
           CSS BAGIAN TTD KADES
        ========================= */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .ttd-spacer {
            width: 55%;
        }

        .ttd-cell {
            width: 45%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-cell p {
            text-align: center;
            margin-bottom: 2px;
        }

        .ttd-img-wrapper {
            margin: 5px auto;
            text-align: center;
            width: 120px;
            height: 75px;
            position: relative;
        }

        .ttd-img {
            max-width: 100%;
            max-height: 100%;
            display: inline-block;
        }

        .nama-kades {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px;
            margin-bottom: 0px !important;
        }

        .barcode {
            text-align: center;
            margin-top: 15px;
        }

        .barcode img {
            width: 70px;
            height: auto;
        }

        .barcode small {
            font-size: 8pt;
            color: #444;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 6px 0 0 0;
            }
        }
    </style>
</head>

<body>
    @php
        $tanggalSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat('d F Y')
            : now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        $tahunSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->format('Y')
            : now('Asia/Jakarta')->format('Y');

        $tanggalAcara = !empty($data->tanggal_acara)
            ? \Carbon\Carbon::parse($data->tanggal_acara)->locale('id')->translatedFormat('d F Y')
            : '-';

        $hariAcara =
            $data->hari ??
            (!empty($data->tanggal_acara)
                ? \Carbon\Carbon::parse($data->tanggal_acara)->locale('id')->translatedFormat('l')
                : '-');

        $nomorSurat = $data->nomor_surat ?? '005/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/409.41.2/' . $tahunSurat;

        $namaKades = $data->nama_kepala_desa ?? 'MOH. HAMID ALMAULUDI, S.Pd.I';

        $perihal = $data->perihal ?? 'Undangan';

        $acara = $data->acara ?? 'Pelantikan Dan Pengambilan sumpah / janji perangkat desa';

        $isiPembuka =
            $data->isi_pembuka ??
            'Sehubungan dengan akan dilaksanakan Pelantikan dan Pengambilan sumpah janji perangkat desa di Desa KEMIRIGEDE kecematan KEMIRIGEDE Kabupaten Blitar. Berkaitan dengan hal tersebut maka kami mengundang Bapak/Ibu /saudara untuk hadir pada:';
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
                    <div class="kop-desa-2">KECAMATAN KEMIRIGEDE</div>
                    <div class="kop-desa-3">PEMERINTAH DESA KEMIRIGEDE</div>
                    <div class="kop-desa-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td>
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    <!-- NOMOR, TANGGAL, TUJUAN -->
    <table class="meta-wrapper">
        <tr>
            <td class="meta-left">
                <table class="meta-table">
                    <tr>
                        <td class="label">Nomor</td>
                        <td class="colon">:</td>
                        <td>{!! $nomorSurat !!}</td>
                    </tr>
                    <tr>
                        <td class="label">Sifat</td>
                        <td class="colon">:</td>
                        <td>{{ $data->sifat ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Lamp</td>
                        <td class="colon">:</td>
                        <td>{{ $data->lampiran ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Perihal</td>
                        <td class="colon">:</td>
                        <td>{{ $perihal }}</td>
                    </tr>
                </table>
            </td>

            <td class="meta-right">
                <div>Blitar, {{ $tanggalSurat }}</div>

                <div class="tujuan">
                    Kepada Yth :<br>
                    {{ $data->kepada_yth ?? '' }}<br>
                    <span class="tempat">Di</span><br>
                    Tempat
                </div>
            </td>
        </tr>
    </table>

    <!-- ISI SURAT -->
    <div class="isi">
        <p class="indent">
            {{ $isiPembuka }}
        </p>

        <table class="agenda-table">
            <tr>
                <td class="label">Hari</td>
                <td class="colon">:</td>
                <td class="value">{{ $hariAcara }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ $tanggalAcara }}</td>
            </tr>
            <tr>
                <td class="label">Jam</td>
                <td class="colon">:</td>
                <td class="value">{{ $data->jam ?? '08.30 Wib s/d selesai' }}</td>
            </tr>
            <tr>
                <td class="label">Tempat</td>
                <td class="colon">:</td>
                <td class="value">{{ $data->tempat ?? 'Pendopo Kantor Balai Desa KEMIRIGEDE' }}</td>
            </tr>
            <tr>
                <td class="label">Acara</td>
                <td class="colon">:</td>
                <td class="value">{{ $acara }}</td>
            </tr>
        </table>

        @if (!empty($data->keterangan_tambahan))
            <p class="indent">
                {{ $data->keterangan_tambahan }}
            </p>
        @endif

        <p class="indent">
            Demikian undangan ini dibuat untuk menjadikan maklum dan atas kehadirannya disampaikan banyak terimakasih.
        </p>
    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>

            <td class="ttd-cell">
                <p>Blitar, {{ $tanggalSurat }}</p>
                <p>Mengetahui,</p>
                <p>Kepala Desa KEMIRIGEDE</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
                </div>

                <p class="nama-kades">
                    <u>{{ $namaKades }}</u>
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
