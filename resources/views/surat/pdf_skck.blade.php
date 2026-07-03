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
            margin: 8px 0 12px 22px;
        }

        table.data td {
            padding: 2.5px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 170px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 26px;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .space-ttd {
            height: 72px;
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
            margin-top: 26px;
        }

        .kapolsek-line {
            text-align: center;
            margin-top: 48px;
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

        $tanggalLahir = !empty($surat->tanggal_lahir)
            ? \Carbon\Carbon::parse($surat->tanggal_lahir)->translatedFormat('d F Y')
            : '...........................................';
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

    <div class="judul-surat">
        KETERANGAN PENGANTAR SKCK
    </div>

    <div class="nomor-surat">
        Nomor : {{ $surat->nomor_surat ?? '300 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <div class="isi">
        <p>
            Yang bertanda tangan dibawah ini KEPALA DESA KEMIRIGEDE, Kec. KEMIRIGEDE,
            Kab. Blitar, menerangkan bahwa :
        </p>

        <table class="data">
            <tr>
                <td>N a m a</td>
                <td>:</td>
                <td>{{ strtoupper($surat->nama ?? '...........................................') }}</td>
            </tr>
            <tr>
                <td>Tempat Tanggal lahir</td>
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
            Orang tersebut diatas adalah benar-benar penduduk Desa KEMIRIGEDE dan sepanjang
            pengetahuan dan pengamatan kami belum pernah melakukan Pelanggaran Kejahatan,
            pelanggaran polisi, selalu taat dan patuh pada Peraturan Pemerintah yang berlaku.
        </p>

        <p>
            Surat Keterangan ini di berikan untuk
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
            <td>KEMIRIGEDE, {{ $tanggalSurat }}</td>
        </tr>
        <tr>
            <td>Pemegang surat</td>
            <td><strong>KEPALA DESA KEMIRIGEDE</strong></td>
        </tr>
        <tr>
            <td>
                <div class="space-ttd"></div>
                <div class="nama-ttd">
                    {{ strtoupper($surat->nama ?? '...........................................') }}
                </div>
            </td>

            <td>
                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <div class="nama-ttd">Hari Purnawan, S.Sos. S.Pd.I</div>

                <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                </div>
            </td>
        </tr>
    </table>

    <div class="kapolsek">
        KAPOLSEK KEMIRIGEDE
    </div>

    <div class="kapolsek-line">
        ___________________
    </div>
</body>
</html>
