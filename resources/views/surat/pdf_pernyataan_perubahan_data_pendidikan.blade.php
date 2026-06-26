<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Perubahan Data Pendidikan</title>
    <style>
        @page { margin: 1.1cm 1.4cm 1.1cm 1.4cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 11pt; line-height: 1.35; }

        .kop-container { width: 100%; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 12%; text-align: center; }
        .kop-logo img { width: 60px; height: auto; }
        .kop-text { text-align: center; }
        .kop-text strong { font-size: 11.5pt; }
        .kop-text small { font-size: 8.5pt; }
        .kop-garis { border: none; border-top: 2px solid #000; margin: 4px 0 8px 0; }

        .judul-surat { text-align: center; margin-bottom: 6px; }
        .judul-surat h3 { font-size: 13pt; font-weight: bold; text-decoration: underline; margin: 0; }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 10.5pt;
        }

        .tulisan { text-align: justify; margin-bottom: 6px; }

        table.data { width: 100%; border-collapse: collapse; margin: 5px 0 8px 0; }
        table.data td { padding: 3px 5px; vertical-align: top; }
        table.data td:first-child { width: 150px; font-weight: bold; }

        .ttd-table { width: 100%; margin-top: 25px; }
        .ttd-spacer { width: 52%; }
        .ttd-cell { width: 48%; text-align: center; vertical-align: top; }
        .ttd-img-wrapper { height: 60px; }
        .ttd-img { width: 220px; height: auto; }
        .nama-kades { font-weight: bold; }
        .barcode { margin-top: 8px; }
        .barcode img { width: 70px; height: auto; }
        .catatan { font-size: 9pt; margin-top: 12px; }
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
                    <small>Jln. Merdeka No. 74 Telp. 082139324445<br>
                    Email: watesberkelas@gmail.com</small>
                </td>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa Wates">
                </td>
            </tr>
        </table>
        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN</h3>
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '480 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- DATA PEMOHON -->
    <p class="tulisan"><strong>Yang bertanda tangan di bawah ini, Saya:</strong></p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik ?? '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat ?? '...........................................' }}</td></tr>
    </table>

    <div class="tulisan">
        Dengan ini menyatakan dengan sesungguhnya bahwa saya dengan sadar melakukan permohonan pembetulan data tingkat Pendidikan dari
        <strong>Pendidikan setingkat {{ $data->pendidikan_lama ?? '...........................................' }}</strong>
        menjadi setingkat
        <strong>{{ $data->pendidikan_baru ?? '...........................................' }}</strong>,
        yang didasarkan pada data pendukung berupa:
    </div>

    <table class="data">
        <tr><td>Jenis Data Pendukung*</td><td>: {{ $data->jenis_data_pendukung ?? '...........................................' }}</td></tr>
        <tr><td>Nomor</td><td>: {{ $data->nomor_dokumen_pendukung ?? '...........................................' }}</td></tr>
        <tr><td>Tanggal Diterbitkan</td><td>: {{ isset($data->tanggal_diterbitkan) ? \Carbon\Carbon::parse($data->tanggal_diterbitkan)->translatedFormat('d F Y') : '...........................................' }}</td></tr>
        <tr><td>Instansi Penerbit</td><td>: {{ $data->instansi_penerbit ?? '...........................................' }}</td></tr>
    </table>

    <div class="tulisan">
        Dan saya menyatakan bahwa data yang saya sampaikan sesuai dengan kenyataan sebenarnya. Apabila dikemudian hari ternyata diketahui bahwa data yang saya sampaikan ini tidak benar, maka saya bersedia diproses secara hukum sesuai dengan peraturan perundang-undangan dan dokumen yang diterbitkan akibat dari pernyataan ini menjadi tidak sah.
    </div>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Wates, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
                </div>

                <p class="nama-kades"><u>{{ $data->nama ?? '...........................................' }}</u></p>
                <p>NIK: {{ $data->nik ?? '...........................................' }}</p>

                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode_surat.png') }}" alt="Barcode">
                    <br><small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>
        </tr>
    </table>

    <div class="catatan">
        <em>*Jenis Data Pendukung diisi dengan Ijazah / Surat Keterangan Pengganti Ijazah</em>
    </div>

</body>
</html>
