<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili Lembaga</title>
    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11.8pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
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

        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin: 18px 0 4px 0;
        }

        .nomor-surat {
            text-align: center;
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
        }

        table.data td:nth-child(2) {
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

            .kop-desa-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>

<body>

    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');
    @endphp

    {{-- KOP SURAT --}}
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

    <div class="judul-surat">SURAT KETERANGAN DOMISILI</div>

    <div class="nomor-surat">
        Nomor : {{ $data->nomor_surat ?? '220 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <p class="tulisan">Yang bertanda tangan di bawah ini:</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama_pengurus ?? 'Hari Purnawan, S.Sos.' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>Kepala Desa</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>Dsn. Sidomulyo RT 04 RW 01 Desa Kemirigede, Kecamatan Kesamben</td>
        </tr>
    </table>

    <p class="tulisan">Dengan ini menerangkan dengan sebenarnya bahwa :</p>

    <table class="data">
        <tr>
            <td>Nama Lembaga</td>
            <td>:</td>
            <td>{{ $data->nama_lembaga }}</td>
        </tr>
        <tr>
            <td>Jenis Kegiatan</td>
            <td>:</td>
            <td>{{ $data->jenis_kegiatan }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat_lembaga }}</td>
        </tr>
    </table>

    <p class="tulisan">Dengan Pengurus (Ketua)</p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $data->nama_pengurus }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $data->nik_pengurus }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat_pengurus }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Lembaga tersebut di atas adalah benar-benar berdomisili di Desa Kemirigede Kecamatan Kesamben Kabupaten Blitar.
        Dan sampai saat ini masih aktif. Surat keterangan ini dipergunakan untuk
        {{ $data->keterangan_tambahan ?? '....................' }}.
    </p>

    <p class="tulisan">
        Demikian Surat Keterangan Domisili ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Kemirigede, {{ $tanggalSurat }}</p>
                <p><strong>KEPALA DESA Kemirigede</strong></p>
                {{--
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
            </div> --}}

                <br><br><br>

                <p class="nama">
                    <u>Hari Purnawan, S.Sos.</u>
                </p>

                {{-- <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR">
                <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
            </div> --}}
            </td>
        </tr>
    </table>

</body>

</html>
