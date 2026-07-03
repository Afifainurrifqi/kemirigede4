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

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 12px;
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
        $tanggalSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat('d F Y')
            : now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        $tahunSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->format('Y')
            : now('Asia/Jakarta')->format('Y');

        $namaKepalaDesa = $data->nama_kepala_desa ?? 'Hari Purnawan, S.Sos.';
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
                a.n TP PKK Desa KEMIRIGEDE
            </td>
        </tr>
    </table>

    <!-- TUJUAN SURAT -->
    <div class="tujuan">
        Kepada Yth.<br>
        PT. Bank BRI Unit KEMIRIGEDE<br>
        KCP Unit KEMIRIGEDE<br>
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
            <td class="value">{{ $data->jabatan ?? 'KEPALA DESA KEMIRIGEDE' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->alamat_kepala_desa ?? 'Dusun Sidomulyo RT 004 RW 001 Desa KEMIRIGEDE Kecamatan Kesamben Kabupaten Blitar' }}
            </td>
        </tr>
    </table>

    <p class="indent-paragraph">
        Dengan ini kami memohon untuk membuka rekening tabungan pada PT Bank BRI Unit KEMIRIGEDE dengan ketentuan sebagai
        berikut :
    </p>

    <!-- DATA REKENING -->
    <table class="rekening">
        <tr>
            <td class="no">1.</td>
            <td class="label">Atas Nama Rekening</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->atas_nama_rekening ?? 'TP PKK Desa KEMIRIGEDE' }}</td>
        </tr>
        <tr>
            <td class="no">2.</td>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">
                {{ $data->alamat_rekening ?? 'Desa KEMIRIGEDE Kecamatan Kesamben Kabupaten Blitar' }}
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
                        <td>{{ $data->jabatan1 ?? 'Ketua TP PKK Desa KEMIRIGEDE' }}</td>
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
        Bank BRI Unit KEMIRIGEDE.
    </p>

    <p class="penutup-2">
        Demikian surat permohonan kami sampaikan atas bantuan kerjasama dan kepercayaan PT Bank BRI Unit KEMIRIGEDE kami
        ucapkan banyak terimakasih.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd">
        <div>Blitar, {{ $tanggalSurat }}</div>
        <div class="jabatan">KEPALA DESA KEMIRIGEDE</div>
        <div class="nama">{{ $namaKepalaDesa }}</div>
    </div>

</body>

</html>
