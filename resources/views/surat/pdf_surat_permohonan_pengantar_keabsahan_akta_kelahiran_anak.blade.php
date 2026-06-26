<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pengantar Keabsahan Akta Kelahiran (Untuk Anak)</title>
    <style>
        @page { margin: 1.1cm 1.4cm 1.1cm 1.4cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.4; }

        .kop-container { width: 100%; margin-bottom: 5px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 12%; text-align: center; }
        .kop-logo img { width: 58px; height: auto; }
        .kop-text { text-align: center; }
        .kop-text strong { font-size: 11.5pt; }
        .kop-text small { font-size: 8.5pt; }
        .kop-garis { border: none; border-top: 2px solid #000; margin: 4px 0 10px 0; }

        .header-surat { width: 100%; margin-bottom: 10px; }
        .header-left { width: 50%; float: left; }
        .header-right { width: 50%; float: right; text-align: right; }
        .clearfix::after { content: ""; clear: both; display: table; }

        .isi { text-align: justify; margin-bottom: 7px; }

        table.identitas { width: 100%; margin: 6px 0 10px 0; }
        table.identitas td { padding: 3px 5px; vertical-align: top; }
        table.identitas td:first-child { width: 165px; font-weight: bold; }

        .ttd-table { width: 100%; margin-top: 30px; }
        .ttd-spacer { width: 55%; }
        .ttd-cell { width: 45%; text-align: center; vertical-align: top; }
        .ttd-img-wrapper { height: 55px; }
        .ttd-img { width: 200px; height: auto; }
        .nama { font-weight: bold; }
        .barcode { margin-top: 6px; }
        .barcode img { width: 68px; height: auto; }

        .materai {
            border: 1px solid #000;
            padding: 4px 12px;
            display: inline-block;
            margin: 4px 0;
            font-weight: bold;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
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
                    <small>Jln. Merdeka No. 74 Telp. 082139324445 | Email: watesberkelas@gmail.com</small>
                </td>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa Wates">
                </td>
            </tr>
        </table>
        <hr class="kop-garis">
    </div>

    <!-- NOMOR SURAT -->
    <div style="text-align: center; font-weight: bold; margin-bottom: 10px; font-size: 10.5pt;">
        Nomor: {{ $data->nomor_surat ?? '--- / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- Header Surat -->
    <div class="header-surat clearfix">
        <div class="header-left">
            <strong>Perihal</strong> &nbsp;&nbsp;: Permohonan Pengantar Keabsahan Akta Kelahiran<br>
            <strong>Lampiran</strong> : 1 (satu) Bendel
        </div>
        <div class="header-right">
            Wates, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}<br><br>
            Kepada Yth.<br>
            Kepala Dinas Kependudukan dan Pencatatan Sipil<br>
            Kabupaten Blitar<br>
            <strong>di - BLITAR</strong>
        </div>
    </div>

    <div style="clear: both;"></div>

    <p class="isi"><strong>Dengan hormat,</strong></p>
    <p class="isi">Yang bertanda tangan di bawah ini:</p>

    <table class="identitas">
        <tr><td>Nama</td><td>: {{ $data->nama ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik ?? '...........................................' }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{ $data->jenis_kelamin ?? '...........................................' }}</td></tr>
        <tr><td>Tempat / Tanggal Lahir</td><td>: {{ $data->ttl_tempat ?? '' }} / {{ isset($data->ttl_tanggal) ? \Carbon\Carbon::parse($data->ttl_tanggal)->translatedFormat('d F Y') : '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat ?? '...........................................' }}</td></tr>
        <tr><td>Nama Anak</td><td>: {{ $data->nama_anak ?? '...........................................' }}</td></tr>
    </table>

    <p class="isi">
        Dengan ini saya mengajukan permohonan untuk dibuatkan <strong>Surat Pengantar Keabsahan Akta Kelahiran</strong>
        anak saya atas nama <strong>{{ $data->nama_anak ?? '...........................................' }}</strong>
        ke Dinas Kependudukan dan Pencatatan Sipil Kabupaten Blitar.
    </p>

    <p class="isi"><strong>Berikut ini saya lampirkan:</strong></p>
    <ol>
        <li>Fotocopy Kutipan Akta Kelahiran</li>
        <li>Fotocopy Kartu Keluarga</li>
    </ol>

    <p class="isi">
        Demikian surat permohonan ini saya buat dengan sebenar-benarnya. Atas perhatian dan bantuannya, saya ucapkan terima kasih.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Wates, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Hormat Saya,</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
                </div>

                <div class="materai">Materai<br>10.000</div>

                <p class="nama"><u>{{ $data->nama ?? '...........................................' }}</u></p>
                <p>NIK: {{ $data->nik ?? '...........................................' }}</p>

                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode_surat.png') }}" alt="Barcode">
                    <br><small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
