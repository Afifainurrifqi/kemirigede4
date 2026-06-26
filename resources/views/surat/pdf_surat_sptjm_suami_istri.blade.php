<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SPTJM Suami Istri (F-2.04)</title>
    <style>
        @page { margin: 1.1cm 1.5cm 1.1cm 1.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 10.5pt; line-height: 1.3; }

        .kop { text-align: center; margin-bottom: 4px; }
        .kop strong { font-size: 11pt; }
        .kop small { font-size: 8.5pt; }
        .kop-garis { border-top: 1.8px solid #000; margin: 4px 0 8px 0; }

        .judul {
            text-align: center;
            font-weight: bold;
            margin: 5px 0 10px 0;
            font-size: 11.5pt;
            text-decoration: underline;
        }

        .section-title { font-weight: bold; margin: 8px 0 4px 0; font-size: 10.5pt; }
        table.data { width: 100%; margin-bottom: 5px; }
        table.data td { padding: 2px 5px; vertical-align: top; }
        table.data td:first-child { width: 130px; font-weight: bold; }

        .ttd-table { width: 100%; margin-top: 15px; }
        .ttd-cell { text-align: center; }
        .ttd-spacer { width: 45%; }
        .nama { text-decoration: underline; font-weight: bold; }
        .materai { font-size: 9.5pt; margin-top: 3px; }

        .closing { margin: 8px 0; font-size: 10pt; }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop">
        <strong>PEMERINTAH KABUPATEN BLITAR<br>
        KECAMATAN KEMIRIGEDE<br>
        KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
        <small>Jln. Merdeka No. 74 Telp. 082139324445</small>
    </div>
    <hr class="kop-garis">

    <div class="judul">SURAT PERNYATAAN TANGGUNG JAWAB MUTLAK (SPTJM)<br>
    KEBENARAN SEBAGAI PASANGAN SUAMI ISTRI</div>

    <p class="section-title">Saya yang bertandatangan di bawah ini:</p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama_deklaran ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik_deklaran ?? '...........................................' }}</td></tr>
        <tr><td>Tempat / Tanggal Lahir</td><td>: {{ $data->ttl_deklaran ?? '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat_deklaran ?? '...........................................' }}</td></tr>
    </table>

    <p class="section-title">Menyatakan bahwa:</p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama_pasangan ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik_pasangan ?? '...........................................' }}</td></tr>
        <tr><td>Tempat / Tanggal Lahir</td><td>: {{ $data->ttl_pasangan ?? '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat_pasangan ?? '...........................................' }}</td></tr>
    </table>

    <p class="section-title">Adalah suami/istri dari:</p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama_deklaran ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik_deklaran ?? '...........................................' }}</td></tr>
        <tr><td>Tempat / Tanggal Lahir</td><td>: {{ $data->ttl_deklaran ?? '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat_deklaran ?? '...........................................' }}</td></tr>
    </table>

    <p>Sebagaimana tercantum dalam Kartu Keluarga (KK) Nomor: <strong>{{ $data->nomor_kk ?? '...........................................' }}</strong></p>

    <p class="closing">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya. Apabila dikemudian hari ternyata pernyataan saya ini tidak benar, maka saya bersedia diproses secara hukum sesuai peraturan perundang-undangan.
    </p>

    <!-- TANDA TANGAN -->
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>KEMIRIGEDE, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>
                <div style="height: 45px;"></div>
                <p class="nama"><u>{{ $data->nama_deklaran ?? '...........................................' }}</u></p>
                <p class="materai">Materai Rp10.000</p>
            </td>
        </tr>
    </table>

    <br>

    <table style="width: 100%; font-size: 9.5pt; margin-top: 10px;">
        <tr>
            <td style="width: 50%; text-align: center;">
                <strong>Saksi I</strong><br><br>
                ( ........................................ )<br>
                NIK. ................................
            </td>
            <td style="width: 50%; text-align: center;">
                <strong>Saksi II</strong><br><br>
                ( ........................................ )<br>
                NIK. ................................
            </td>
        </tr>
    </table>

</body>
</html>
