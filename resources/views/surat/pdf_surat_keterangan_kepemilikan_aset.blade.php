<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kepemilikan Aset</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0.7cm 1.2cm 0.7cm 1.2cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.18;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 3px 0;
            text-align: justify;
        }

        /* KOP SURAT FIX COMPACT */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 7px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-logo {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 82px;
            height: auto;
        }

        .kop-desa-text {
            width: 70%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.08;
        }

        .kop-desa-1 {
            font-size: 13pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 13pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 9.5pt;
            margin-top: 1px;
        }

        .kop-desa-kontak {
            font-size: 8.8pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 2.5px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin: 4px 0 7px 0;
        }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            font-size: 12pt;
            margin: 5px 0 3px 0;
        }

        .nomor {
            text-align: center;
            margin-bottom: 7px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 6px 12px;
        }

        table.data td {
            padding: 1.4px 4px;
            vertical-align: top;
            line-height: 1.12;
        }

        table.data td:first-child {
            width: 145px;
        }

        table.data td:nth-child(2) {
            width: 8px;
        }

        .section-title td {
            padding-top: 5px !important;
            padding-bottom: 2px !important;
        }

        .ttd {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }

        .ttd-img-wrapper {
            height: 38px;
            margin: 2px 0;
        }

        .ttd-img {
            width: 125px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 1px;
        }

        .qr-section {
            margin-top: 3px;
            text-align: center;
        }

        .qr-section img {
            width: 52px;
            height: auto;
        }

        .qr-section small {
            font-size: 6.5pt;
            color: #555;
            display: block;
            line-height: 1.05;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 4px 0 7px 0;
            }
        }
    </style>
</head>

<body>

    @php
        $tanggalSurat = now('Asia/Jakarta')->locale('id')->translatedFormat('d F Y');

        $tanggalLahir = !empty($data->tanggal_lahir)
            ? \Carbon\Carbon::parse($data->tanggal_lahir)->locale('id')->translatedFormat('d F Y')
            : '-';
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

    <div class="judul">DATA KEPEMILIKAN</div>

    <div class="nomor">
        Nomor : {{ app(\App\Services\NomorSuratService::class)->display($data, 'kepemilikan_aset') }}
    </div>

    <p>Yang bertanda tangan di bawah ini KEPALA DESA Kemirigede menerangkan dengan sebenarnya bahwa :</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tempat Tgl Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir ?? '-' }}, {{ $tanggalLahir }}</td>
        </tr>
        <tr>
            <td>No KTP / NIK</td>
            <td>:</td>
            <td>{{ $data->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $data->pekerjaan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat ?? '-' }}</td>
        </tr>
    </table>

    <p>Dengan hasil survey seperti dibawah ini :</p>

    <table class="data">
        <tr class="section-title">
            <td colspan="3"><strong>A. Pendapatan Keluarga</strong></td>
        </tr>
        <tr>
            <td>Kurang dari</td>
            <td>:</td>
            <td>Rp {{ $data->pendapatan_bulanan ?? '-' }}/bulan</td>
        </tr>

        <tr class="section-title">
            <td colspan="3"><strong>B. Kepemilikan Tanah</strong></td>
        </tr>
        <tr>
            <td>Pekarangan</td>
            <td>:</td>
            <td>{{ $data->pekarangan ?? '-' }} M²</td>
        </tr>
        <tr>
            <td>Sawah</td>
            <td>:</td>
            <td>{{ $data->sawah ?? '-' }} M²</td>
        </tr>
        <tr>
            <td>Perkebunan</td>
            <td>:</td>
            <td>{{ $data->perkebunan ?? '-' }} M²</td>
        </tr>

        <tr class="section-title">
            <td colspan="3"><strong>C. Aset / Barang Berharga</strong></td>
        </tr>
        <tr>
            <td>Mobil</td>
            <td>:</td>
            <td>{{ $data->mobil ?? '-' }}</td>
        </tr>
        <tr>
            <td>Sepeda Motor</td>
            <td>:</td>
            <td>{{ $data->sepeda_motor ?? '-' }}</td>
        </tr>
        <tr>
            <td>Perhiasan Emas</td>
            <td>:</td>
            <td>{{ $data->perhiasan_emas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Lainnya</td>
            <td>:</td>
            <td>{{ $data->lainnya ?? '-' }}</td>
        </tr>

        <tr class="section-title">
            <td colspan="3"><strong>D. Kepemilikan Rumah</strong></td>
        </tr>
        <tr>
            <td colspan="3">{{ $data->kepemilikan_rumah ?? '-' }}</td>
        </tr>
    </table>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>

    <table class="ttd">
        <tr>
            <td></td>
            <td>Blitar, {{ $tanggalSurat }}</td>
        </tr>
        <tr>
            <td></td>
            <td><strong>KEPALA DESA Kemirigede</strong></td>
        </tr>
        <tr>
            <td></td>
            <td>
                {{-- <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
            </div> --}}
                <br><br><br><br>
                <div class="nama-kades">Hari Purnawan, S.Sos.</div>

                {{-- <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR">
                <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
            </div> --}}
            </td>
        </tr>
    </table>

</body>

</html>
