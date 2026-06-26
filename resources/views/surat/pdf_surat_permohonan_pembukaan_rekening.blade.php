<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pembukaan Rekening</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 1.55cm 0.9cm 1.55cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.05;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        /* =========================
           KOP SURAT
        ========================= */
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

        .kop-logo-left,
        .kop-logo-right {
            width: 16%;
            text-align: center;
        }

        .kop-logo-left img {
            width: 76px;
            height: auto;
        }

        .kop-logo-right img {
            width: 74px;
            height: auto;
        }

        .kop-text {
            width: 68%;
            text-align: center;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.02;
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
            font-size: 17pt;
            font-weight: bold;
        }

        .kop-text .alamat {
            font-size: 10.3pt;
        }

        .kop-text .email {
            font-size: 8.6pt;
        }

        .kop-garis {
            border: 0;
            border-top: 3px solid #000;
            margin-top: 5px;
            margin-bottom: 0;
        }

        /* =========================
           NOMOR SURAT
        ========================= */
        .surat-meta {
            width: 100%;
            margin-bottom: 18px;
        }

        .surat-meta td {
            padding: 0;
            vertical-align: top;
            line-height: 1.08;
        }

        .surat-meta .label {
            width: 68px;
        }

        .surat-meta .colon {
            width: 14px;
            text-align: center;
        }

        .surat-meta .value {
            width: auto;
        }

        /* =========================
           TUJUAN SURAT
        ========================= */
        .tujuan {
            margin-bottom: 28px;
            line-height: 1.08;
        }

        .tempat {
            display: inline-block;
            margin-left: 42px;
        }

        /* =========================
           IDENTITAS
        ========================= */
        .biodata-title {
            margin-bottom: 2px;
        }

        .biodata {
            margin-left: 62px;
            margin-bottom: 3px;
        }

        .biodata td {
            padding: 0;
            vertical-align: top;
            line-height: 1.08;
        }

        .biodata .label {
            width: 82px;
        }

        .biodata .colon {
            width: 14px;
            text-align: center;
        }

        .biodata .value {
            width: auto;
        }

        .indent-paragraph {
            text-indent: 1.1cm;
            text-align: justify;
            margin-bottom: 3px;
            line-height: 1.08;
        }

        /* =========================
           DATA REKENING
        ========================= */
        .rekening {
            margin-left: 32px;
            margin-bottom: 14px;
        }

        .rekening td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.08;
        }

        .rekening .no {
            width: 24px;
            text-align: right;
            padding-right: 9px;
        }

        .rekening .label {
            width: 220px;
        }

        .rekening .colon {
            width: 14px;
            text-align: center;
        }

        .rekening .value {
            width: auto;
        }

        .pejabat-detail {
            margin-left: 25px;
            margin-top: 2px;
        }

        .pejabat-detail td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.08;
        }

        .pejabat-detail .huruf {
            width: 24px;
        }

        .pejabat-detail .label {
            width: 96px;
        }

        .pejabat-detail .colon {
            width: 14px;
            text-align: center;
        }

        /* =========================
           PENUTUP
        ========================= */
        .penutup-1 {
            text-indent: 1.1cm;
            text-align: justify;
            margin-top: 10px;
            margin-bottom: 8px;
            line-height: 1.08;
        }

        .penutup-2 {
            text-indent: 1.1cm;
            text-align: justify;
            margin-bottom: 28px;
            line-height: 1.08;
        }

        /* =========================
           TANDA TANGAN
        ========================= */
        .ttd {
            width: 330px;
            margin-left: auto;
            margin-right: 0;
            text-align: center;
            line-height: 1.08;
        }

        .ttd .jabatan {
            margin-top: 20px;
        }

        .ttd .nama {
            margin-top: 52px;
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

        $namaKepalaDesa = $data->nama_kepala_desa ?? 'MOH. HAMID ALMAULUDI, S.Pd.I';
    @endphp

    <!-- KOP SURAT -->
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo-left">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten">
                </td>

                <td class="kop-text">
                    <div class="line-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="line-2">KECAMATAN WATES</div>
                    <div class="line-3">KANTOR KEPALA DESA WATES</div>
                    <div class="alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="email">email :watesberkelas@gmail.com / website : wates-blitarkab.desa.id</div>
                </td>

                <td class="kop-logo-right">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa">
                </td>
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <!-- NOMOR, LAMPIRAN, PERIHAL -->
    <table class="surat-meta">
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td class="value">
                @if (!empty($data->nomor_surat))
                    {{ $data->nomor_surat }}
                @else
                    470/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/409.41.2/{{ $tahunSurat }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Lampiran</td>
            <td class="colon">:</td>
            <td class="value">-</td>
        </tr>
        <tr>
            <td class="label">Perihal</td>
            <td class="colon">:</td>
            <td class="value">
                Permohonan Pembukaan Rekening Tabungan<br>
                a.n TP PKK Desa Wates
            </td>
        </tr>
    </table>

    <!-- TUJUAN SURAT -->
    <div class="tujuan">
        Kepada Yth.<br>
        PT. Bank BRI Unit Wates<br>
        KCP Unit Wates<br>
        Di<br>
        <span class="tempat">Tempat</span>
    </div>

    <!-- IDENTITAS -->
    <p class="biodata-title">Yang bertandatangan dibawah ini :</p>

    <table class="biodata">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="value">{{ $namaKepalaDesa }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->jabatan ?? 'Kepala Desa Wates' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->alamat_kepala_desa ?? 'Dusun Sidomulyo RT 004 RW 001 Desa Wates Kecamatan Wates Kabupaten Blitar' }}
            </td>
        </tr>
    </table>

    <p class="indent-paragraph">
        Dengan ini kami memohon untuk membuka rekening tabungan pada PT Bank BRI Unit Wates dengan ketentuan sebagai
        berikut :
    </p>

    <!-- DATA REKENING -->
    <table class="rekening">
        <tr>
            <td class="no">1.</td>
            <td class="label">Atas Nama Rekening</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->atas_nama_rekening ?? 'TP PKK Desa Wates' }}</td>
        </tr>
        <tr>
            <td class="no">2.</td>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->alamat_rekening ?? 'Desa Wates Kecamatan Wates Kabupaten Blitar' }}
            </td>
        </tr>
        <tr>
            <td class="no">3.</td>
            <td class="label">Nama Pejabat Yang Berwewenang</td>
            <td class="colon">:</td>
            <td class="value"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">
                <table class="pejabat-detail">
                    <tr>
                        <td class="huruf">a.</td>
                        <td class="label">Nama</td>
                        <td class="colon">:</td>
                        <td>{{ $data->nama_pejabat1 ?? 'TITIN MASRUROH' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="label">Jabatan</td>
                        <td class="colon">:</td>
                        <td>{{ $data->jabatan1 ?? 'Ketua TP PKK Desa Wates' }}</td>
                    </tr>
                    <tr>
                        <td class="huruf">b.</td>
                        <td class="label">Nama</td>
                        <td class="colon">:</td>
                        <td>{{ $data->nama_pejabat2 ?? 'CHRISTIANA SULISTIYAH' }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="label">Jabatan</td>
                        <td class="colon">:</td>
                        <td>{{ $data->jabatan2 ?? 'Bendahara' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- PENUTUP -->
    <p class="penutup-1">
        Selanjutnya kami menyatakan sanggup mengikuti ketentuan-ketentuan untuk membuka rekening yang berlaku pada PT
        Bank BRI Unit Wates.
    </p>

    <p class="penutup-2">
        Demikian surat permohonan kami sampaikan atas bantuan kerjasama dan kepercayaan PT Bank BRI Unit Wates kami
        ucapkan banyak terimakasih.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        <div>Wates, {{ $tanggalSurat }}</div>
        <div class="jabatan">Kepala Desa Wates</div>
        <div class="nama">{{ $namaKepalaDesa }}</div>
    </div>

</body>

</html>
