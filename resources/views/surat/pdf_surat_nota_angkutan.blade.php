<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Angkutan Hasil Hutan Kayu - Desa Kemirigede</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.25cm 1.55cm 1.15cm 1.55cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.5pt;
            line-height: 1.15;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 0;
            vertical-align: top;
        }

        p {
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 8px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            padding: 0;
            vertical-align: middle;
            border: none;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 95px;
            height: auto;
        }

        .kop-desa-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.08;
        }

        .kop-desa-1 {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 10pt;
            margin-top: 1px;
        }

        .kop-desa-kontak {
            font-size: 8.5pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 5px 0 8px 0;
        }

        /* =========================
           LAMPIRAN
        ========================= */
        .lampiran {
            width: 55%;
            margin-bottom: 10px;
            font-size: 9.7pt;
            line-height: 1.12;
        }

        .lampiran td {
            padding: 0;
        }

        .lampiran .label-main {
            width: 100%;
        }

        .lampiran .label {
            width: 70px;
        }

        .lampiran .colon {
            width: 14px;
            text-align: center;
        }

        /* =========================
           JUDUL
        ========================= */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            line-height: 1.18;
            margin-top: 6px;
            margin-bottom: 9px;
        }

        .subjudul {
            text-align: center;
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 10px;
        }

        .nomor {
            text-align: center;
            font-weight: bold;
            font-size: 10.5pt;
            margin-bottom: 10px;
        }

        /* =========================
           WILAYAH
        ========================= */
        .wilayah-table {
            width: 86%;
            margin: 0 auto 18px auto;
            font-size: 10pt;
        }

        .wilayah-table td {
            padding: 1px 0;
            line-height: 1.15;
        }

        .wilayah-label {
            width: 90px;
        }

        .wilayah-colon {
            width: 13px;
            text-align: center;
        }

        .wilayah-gap {
            width: 18%;
        }

        /* =========================
           DATA ASAL DAN TUJUAN
        ========================= */
        .info-table {
            width: 86%;
            margin: 0 auto 20px auto;
            font-size: 10pt;
        }

        .info-table td {
            padding: 0;
        }

        .info-left {
            width: 48%;
        }

        .info-gap {
            width: 4%;
        }

        .info-right {
            width: 48%;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 7px;
            font-size: 10pt;
        }

        .field-table td {
            padding: 1px 0;
            line-height: 1.18;
        }

        .field-label {
            width: 155px;
        }

        .field-colon {
            width: 13px;
            text-align: center;
        }

        .field-value {
            width: auto;
        }

        .masa-title {
            font-weight: bold;
            margin-top: 13px;
            margin-bottom: 4px;
            font-size: 10pt;
        }

        /* =========================
           TABEL KAYU
        ========================= */
        .kayu-table {
            width: 90%;
            margin: 0 auto 18px auto;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        .kayu-table th,
        .kayu-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: center;
            vertical-align: middle;
            line-height: 1.1;
        }

        .kayu-table th {
            font-weight: bold;
        }

        .kayu-table .no-col {
            width: 19%;
        }

        .kayu-table .jenis-col {
            width: 19%;
        }

        .kayu-table .jumlah-col {
            width: 24%;
        }

        .kayu-table .volume-col {
            width: 19%;
        }

        .kayu-table .ket-col {
            width: 19%;
        }

        .nomor-kolom td {
            font-weight: bold;
            height: 18px;
            padding: 1px 4px;
        }

        .isi-kayu td {
            height: 160px;
            vertical-align: top;
            padding-top: 8px;
        }

        .jumlah-row td {
            height: 18px;
            font-weight: bold;
            padding: 2px 4px;
        }

        .jumlah-label {
            text-align: center;
        }

        /* =========================
           CATATAN DAN TTD
        ========================= */
        .bottom-table {
            width: 90%;
            margin: 0 auto;
            font-size: 10pt;
        }

        .catatan {
            width: 58%;
            line-height: 1.15;
        }

        .ttd-cell {
            width: 42%;
            text-align: center;
            vertical-align: top;
            padding-top: 54px;
        }

        .ttd-cell p {
            text-align: center;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        .ttd-space {
            height: 68px;
        }

        .nama-ttd {
            font-weight: normal;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 5px 0 8px 0;
            }
        }
    </style>
</head>

<body>
@php
    $tanggalMulai = !empty($data->tanggal_mulai)
        ? \Carbon\Carbon::parse($data->tanggal_mulai)->locale('id') ->locale('id')->translatedFormat('d F Y')
        : '';

    $tanggalSelesai = !empty($data->tanggal_selesai)
        ? \Carbon\Carbon::parse($data->tanggal_selesai)->locale('id') ->locale('id')->translatedFormat('d F Y')
        : '';

    $bulanTahunSurat = !empty($data->tanggal_surat)
        ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id')->translatedFormat('F Y')
        : now('Asia/Jakarta')->locale('id')->translatedFormat('F Y');

    $nomorSurat = app(\App\Services\NomorSuratService::class)->display($data, 'nota_angkutan');
    $nomorPeraturan = $data->nomor_peraturan ?? '';
    $tanggalPeraturan = !empty($data->tanggal_peraturan)
        ? \Carbon\Carbon::parse($data->tanggal_peraturan)->locale('id') ->locale('id')->translatedFormat('d F Y')
        : '';

    $desa = $data->desa ?? 'Kemirigede';
    $kecamatan = $data->kecamatan ?? 'Kemirigede';
    $kabupaten = $data->kabupaten ?? 'Blitar';
    $provinsi = $data->provinsi ?? 'Jawa Timur';

    $buktiKepemilikan = $data->bukti_kepemilikan ?? '';
    $nomorBuktiKepemilikan = $data->nomor_bukti_kepemilikan ?? '';
    $namaPengirim = $data->nama_pengirim ?? '';
    $alamatPengirim = $data->alamat_pengirim ?? '';
    $tempatMuat = $data->tempat_muat ?? '';
    $jenisIdentitas = $data->jenis_identitas ?? $data->jenis_kayu ?? '';
    $alatAngkut = $data->alat_angkut ?? '';

    $namaPenerima = $data->nama_penerima ?? '';
    $alamatPenerima = $data->alamat_penerima ?? '';

    $jenisKayu = $data->jenis_kayu ?? '';
    $jumlah = $data->jumlah ?? '';
    $volume = $data->volume ?? '';
    $keterangan = $data->keterangan ?? '';

    $namaPemilik = $data->nama_pemilik ?? $data->nama_pengirim ?? '................................';
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

    <!-- LAMPIRAN -->
    <table class="lampiran">
        <tr>
            <td colspan="3">Lampiran I Peraturan Menteri Lingkungan Hidup dan Kehutanan</td>
        </tr>
        <tr>
            <td class="label">Nomor</td>
            <td class="colon">:</td>
            <td>{{ $nomorPeraturan }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td>{{ $tanggalPeraturan }}</td>
        </tr>
    </table>

    <!-- JUDUL -->
    <div class="judul">
        FORMAT BLANGKO NOTA ANGKUTAN<br>
        NOTA ANGKUTAN HASIL HUTAN KAYU BUDIDAYA YANG BERASAL DARI HUTAN<br>
        HAK
    </div>

    <div class="subjudul">( berlaku sebagai DKP )</div>

    <div class="nomor">
        Nomor : {{ $nomorSurat }}
    </div>

    <!-- DESA / KABUPATEN -->
    <table class="wilayah-table">
        <tr>
            <td class="wilayah-label">Desa</td>
            <td class="wilayah-colon">:</td>
            <td>{{ $desa }}</td>

            <td class="wilayah-gap"></td>

            <td class="wilayah-label">Kabupaten</td>
            <td class="wilayah-colon">:</td>
            <td>{{ $kabupaten }}</td>
        </tr>
        <tr>
            <td class="wilayah-label">Kecamatan</td>
            <td class="wilayah-colon">:</td>
            <td>{{ $kecamatan }}</td>

            <td class="wilayah-gap"></td>

            <td class="wilayah-label">Provinsi</td>
            <td class="wilayah-colon">:</td>
            <td>{{ $provinsi }}</td>
        </tr>
    </table>

    <!-- ASAL KAYU DAN TUJUAN PENGANGKUTAN -->
    <table class="info-table">
        <tr>
            <td class="info-left">
                <div class="section-title">ASAL KAYU</div>

                <table class="field-table">
                    <tr>
                        <td class="field-label">Bukti kepemilikan *)</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $buktiKepemilikan }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Nomor bukti kepemilikan</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $nomorBuktiKepemilikan }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Pengirim</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $namaPengirim }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Alamat Pengiriman</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $alamatPengirim }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Tempat muat</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $tempatMuat }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Jenis dan identitas</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $jenisIdentitas }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Alat angkut</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $alatAngkut }}</td>
                    </tr>
                </table>
            </td>

            <td class="info-gap"></td>

            <td class="info-right">
                <div class="section-title">TUJUAN PENGANGKUTAN</div>

                <table class="field-table">
                    <tr>
                        <td class="field-label">Penerima</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $namaPenerima }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Alamat penerima</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $alamatPenerima }}</td>
                    </tr>
                </table>

                <div class="masa-title">MASA BERLAKU</div>

                <table class="field-table">
                    <tr>
                        <td class="field-label">Selama</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">
                            @if(!empty($data->selama))
                                {{ $data->selama }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="field-label">Dari tanggal</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $tanggalMulai }}</td>
                    </tr>
                    <tr>
                        <td class="field-label">Sampai tanggal</td>
                        <td class="field-colon">:</td>
                        <td class="field-value">{{ $tanggalSelesai }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- TABEL KAYU -->
    <table class="kayu-table">
        <thead>
            <tr>
                <th class="no-col">Nomor</th>
                <th class="jenis-col">Jenis Kayu</th>
                <th class="jumlah-col">Jumlah<br>(batang/keping/ikat)</th>
                <th class="volume-col">Volume (m3)</th>
                <th class="ket-col">Keterangan</th>
            </tr>
        </thead>

        <tbody>
            <tr class="nomor-kolom">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>

            <tr class="isi-kayu">
                <td>1</td>
                <td>{{ $jenisKayu }}</td>
                <td>{{ $jumlah }}</td>
                <td>{{ $volume }}</td>
                <td>{{ $keterangan }}</td>
            </tr>

            <tr class="jumlah-row">
                <td colspan="2" class="jumlah-label">JUMLAH</td>
                <td>{{ $jumlah }}</td>
                <td>{{ $volume }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- CATATAN DAN TANDA TANGAN -->
    <table class="bottom-table">
        <tr>
            <td class="catatan">
                Catatan :<br>
                *) diisi bukti pemilikan / penguasaan yang diakui BPN
            </td>

            <td class="ttd-cell">
                <p>Blitar, &nbsp;&nbsp;&nbsp; {{ $bulanTahunSurat }}</p>
                <p>Pemilik Hutan HAK</p>

                <div class="ttd-space"></div>

                <p class="nama-ttd">{{ $namaPemilik }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
