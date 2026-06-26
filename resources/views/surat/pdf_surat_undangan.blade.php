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

        /* =========================
           KOP SURAT
        ========================= */
        .kop {
            width: 100%;
            margin-bottom: 28px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 16%;
            text-align: center;
        }

        .kop-logo img {
            width: 76px;
            height: auto;
        }

        .kop-text {
            width: 68%;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.05;
        }

        .kop-text .line-1 {
            font-size: 15pt;
            font-weight: normal;
        }

        .kop-text .line-2 {
            font-size: 15pt;
            font-weight: normal;
        }

        .kop-text .line-3 {
            font-size: 18pt;
            font-weight: bold;
        }

        .kop-text .alamat {
            font-size: 10.5pt;
        }

        .kop-text .email {
            font-size: 8.8pt;
        }

        .kop-garis {
            border: 0;
            border-top: 3px solid #000;
            margin-top: 6px;
            margin-bottom: 0;
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
            'Sehubungan dengan akan dilaksanakan Pelantikan dan Pengambilan sumpah janji perangkat desa di Desa Wates kecematan Wates Kabupaten Blitar. Berkaitan dengan hal tersebut maka kami mengundang Bapak/Ibu /saudara untuk hadir pada:';
    @endphp

    <!-- KOP SURAT -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten">
                </td>

                <td class="kop-text">
                    <div class="line-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="line-2">KECAMATAN WATES</div>
                    <div class="line-3">KANTOR KEPALA DESA WATES</div>
                    <div class="alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="email">email :watesberkelas@gmail.com / website : wates-blitarkab.desa.id</div>
                </td>

                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa">
                </td>
            </tr>
        </table>

        <hr class="kop-garis">
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
                <div>Wates, {{ $tanggalSurat }}</div>

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
                <td class="value">{{ $data->tempat ?? 'Pendopo Kantor Balai Desa Wates' }}</td>
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
                <p>Wates, {{ $tanggalSurat }}</p>
                <p>Mengetahui,</p>
                <p>Kepala Desa Wates</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
                </div>

                <p class="nama-kades">
                    <u>{{ $namaKades }}</u>
                </p>

                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode_surat.png') }}" alt="Barcode">
                    <br>
                    <small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
