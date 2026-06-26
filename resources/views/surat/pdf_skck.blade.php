<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keterangan Pengantar SKCK</title>

    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
        }

        .kop-container {
            width: 100%;
            margin-bottom: 4px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 13%;
            text-align: center;
            vertical-align: top;
        }

        .kop-logo img {
            width: 68px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            vertical-align: top;
        }

        .kop-text strong {
            font-size: 12.5pt;
            line-height: 1.2;
        }

        .kop-text small {
            font-size: 8.8pt;
            line-height: 1.1;
        }

        .kop-garis {
            border: none;
            border-top: 2.5px solid #000;
            margin: 7px 0 12px 0;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 13.5pt;
            text-decoration: underline;
            margin: 12px 0 2px 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 16px;
        }

        .isi {
            text-align: justify;
        }

        .isi p {
            margin: 6px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 25px;
        }

        table.data td {
            padding: 2.5px 5px;
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
            border-collapse: collapse;
            margin-top: 30px;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin: 5px 0 3px 0;
            text-align: center;
        }

        .ttd-img {
            width: 165px;
            height: auto;
        }

        .nama-ttd {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 3px;
        }

        .qr-section {
            margin-top: 6px;
            text-align: center;
        }

        .qr-section img {
            width: 78px;
            height: auto;
        }

        .qr-section small {
            font-size: 7.3pt;
            color: #555;
            display: block;
            margin-top: 2px;
        }

        .kapolsek {
            text-align: center;
            font-weight: bold;
            margin-top: 22px;
        }
    </style>
</head>

<body>
    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

        $tanggalLahir = !empty($surat->tanggal_lahir)
            ? \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d F Y')
            : '...........................................';
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

    <div class="judul-surat">
        KETERANGAN PENGANTAR SKCK
    </div>

    <div class="nomor-surat">
        Nomor : {{ $surat->nomor_surat ?? '300 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <div class="isi">
        <p>
            Yang bertanda tangan dibawah ini Kepala Desa Wates, Kec. Wates,
            Kab. Blitar, menerangkan bahwa:
        </p>

        <table class="data">
            <tr>
                <td>N a m a</td>
                <td>:</td>
                <td>{{ strtoupper($surat->nama ?? '...........................................') }}</td>
            </tr>
            <tr>
                <td>Tempat Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $surat->tempat_lahir ?? '....................' }}, {{ $tanggalLahir }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $surat->jenis_kelamin ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td>{{ $surat->kewarganegaraan ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td>{{ $surat->status ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Nomor NIK</td>
                <td>:</td>
                <td>{{ $surat->nik ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ strtoupper($surat->agama ?? '...........................................') }}</td>
            </tr>
            <tr>
                <td>Pendidikan</td>
                <td>:</td>
                <td>{{ $surat->pendidikan ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $surat->pekerjaan ?? '...........................................' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $surat->alamat ?? '...........................................' }}</td>
            </tr>
        </table>

        <p>
            Orang tersebut diatas adalah benar-benar penduduk Desa Wates dan sepanjang
            pengetahuan dan pengamatan kami belum pernah melakukan pelanggaran kejahatan,
            pelanggaran polisi, selalu taat dan patuh pada peraturan pemerintah yang berlaku.
        </p>

        <p>
            Surat Keterangan ini diberikan untuk
            <strong>{{ $surat->keperuntukan ?? '...........................................' }}</strong>.
        </p>

        <p>
            Demikian surat keterangan SKCK ini dibuat atas dasar yang sebenarnya untuk
            menjadikan periksa dan guna semestinya.
        </p>
    </div>

    <table class="ttd-table">
        <tr>
            <td></td>
            <td>Wates, {{ $tanggalSurat }}</td>
        </tr>
        <tr>
            <td>Pemegang Surat</td>
            <td><strong>Kepala Desa Wates</strong></td>
        </tr>
        <tr>
            <td>
                <div style="height: 63px;"></div>
                <div class="nama-ttd">
                    {{ strtoupper($surat->nama ?? '...........................................') }}
                </div>
            </td>
            <td>
                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <div class="nama-ttd">MOH. HAMID ALMAULUDI, S.Pd.I</div>

                <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>
        </tr>
    </table>

    <div class="kapolsek">
        KAPOLSEK WATES
    </div>
</body>
</html>
