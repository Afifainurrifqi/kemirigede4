<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Batal Pindah Penduduk</title>
    <style>
        @page { margin: 1.2cm 1.8cm 1.2cm 1.8cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
        }

        .kop-container { margin-bottom: 4px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo img { width: 62px; }
        .kop-text strong { font-size: 11.5pt; }
        .kop-text small { font-size: 8pt; }
        .kop-garis { border-top: 2px solid #000; margin: 5px 0 10px 0; }

        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 8px 0 12px 0;
            font-size: 12.5pt;
        }

        .isi { text-align: justify; margin-bottom: 6px; }

        table.data { width: 100%; margin-bottom: 8px; }
        table.data td { padding: 2.5px 5px; vertical-align: top; }
        table.data td:first-child { width: 155px; font-weight: bold; }

        .ttd-table { width: 100%; margin-top: 25px; }
        .ttd-spacer { width: 52%; }
        .ttd-cell { width: 48%; text-align: center; }
        .ttd-img-wrapper { height: 52px; margin-bottom: 3px; }
        .ttd-img { width: 170px; height: auto; }
        .nama { font-weight: bold; text-decoration: underline; margin: 4px 0 2px 0; }

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
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td style="width: 13%; text-align: center;">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" width="62" alt="Logo Blitar">
                </td>
                <td style="text-align: center;">
                    <strong>PEMERINTAH KABUPATEN BLITAR<br>
                    KECAMATAN KEMIRIGEDE<br>
                    KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
                    <small>Jln. Merdeka No. 74 Telp. 082139324445</small>
                </td>
                <td style="width: 13%; text-align: center;">
                    <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" width="62" alt="Logo Desa KEMIRIGEDE">
                </td>
            </tr>
        </table>
        <hr class="kop-garis">
    </div>

    <div class="judul">SURAT PERNYATAAN BATAL PINDAH PENDUDUK</div>

    <p class="isi"><strong>Yang bertanda tangan di bawah ini:</strong></p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama ?? '...........................................' }}</td></tr>
        <tr><td>TTL</td><td>: {{ $data->ttl_tempat ?? '' }} / {{ isset($data->ttl_tanggal) ? \Carbon\Carbon::parse($data->ttl_tanggal)->translatedFormat('d F Y') : '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik ?? '...........................................' }}</td></tr>
        <tr><td>Agama</td><td>: {{ $data->agama ?? '...........................................' }}</td></tr>
        <tr><td>Status</td><td>: {{ $data->status ?? '...........................................' }}</td></tr>
    </table>

    <p class="isi"><strong>Dengan ini menyatakan bahwa saya tidak jadi pindah penduduk:</strong></p>

    <table class="data">
        <tr><td>Ke alamat</td><td>: {{ $data->ke_alamat ?? '...........................................' }}</td></tr>
        <tr><td>dikarenakan</td><td>: {{ $data->alasan_batal ?? '...........................................' }}</td></tr>
        <tr><td>dan akan menetap sesuai alamat asal di</td><td>: {{ $data->alamat_asal ?? '...........................................' }}</td></tr>
    </table>

    <p class="isi">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan tanpa ada paksaan dari pihak mana pun.
    </p>

    <!-- TANDA TANGAN + QR -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>KEMIRIGEDE, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <p class="nama"><u>{{ $data->nama ?? '...........................................' }}</u></p>

                <!-- QR / BARCODE -->
                <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
