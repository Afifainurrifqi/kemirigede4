<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Desa Pernah Menikah</title>
    <style>
        @page { margin: 1.3cm 1.8cm 1.3cm 1.8cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
        }

        .kop-container { width: 100%; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 15%; text-align: center; }
        .kop-logo img { width: 78px; height: auto; }
        .kop-text { text-align: center; }
        .kop-text strong { font-size: 12.5pt; line-height: 1.2; }
        .kop-text small { font-size: 9.3pt; line-height: 1.1; }
        .kop-garis { border: none; border-top: 2.5px solid #000; margin: 6px 0 12px 0; }

        .judul-surat {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 13.5pt;
            margin-bottom: 12px;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .tulisan { text-align: justify; margin-bottom: 8px; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 12px 0;
        }
        table.data td {
            padding: 3px 6px;
            vertical-align: top;
        }
        table.data td:first-child {
            width: 160px;
            font-weight: bold;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 35px;
        }
        .ttd-right {
            width: 48%;
            float: right;
            text-align: center;
        }
        .ttd-right p {
            margin: 3px 0;
        }
        .ttd-img-wrapper {
            height: 65px;
            text-align: center;
            margin: 8px 0;
        }
        .ttd-img {
            width: 180px;
            height: auto;
        }

        .materai {
            border: 1px solid #000;
            padding: 4px 12px;
            display: inline-block;
            margin: 6px 0;
            font-weight: bold;
            font-size: 9.5pt;
        }

        .barcode {
            margin-top: 10px;
            text-align: center;
        }
        .barcode img {
            width: 85px;
            height: auto;
        }
        .barcode small {
            font-size: 7.8pt;
            display: block;
            margin-top: 3px;
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
                    <small>Jln. Merdeka No. 74 Telp. 082139324445<br>
                    Email: watesberkelas@gmail.com | Website: wates-blitarkab.desa.id</small>
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
        SURAT KETERANGAN DESA PERNAH MENIKAH
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '465 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI -->
    <p class="tulisan">
        Yang bertanda tangan di bawah ini Kepala Desa Wates, Kecamatan Wates, Kabupaten Blitar, menerangkan dengan sebenarnya bahwa:
    </p>

    <table class="data">
        <tr><td>Nama Lengkap</td><td>: {{ $data->nama_lengkap ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik ?? '...........................................' }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>: {{ $data->jenis_kelamin ?? '...........................................' }}</td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>: {{ $data->tempat_lahir ?? '' }}, {{ isset($data->tanggal_lahir) ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') : '...........................................' }}</td></tr>
        <tr><td>Agama</td><td>: {{ $data->agama ?? '...........................................' }}</td></tr>
        <tr><td>Kewarganegaraan</td><td>: {{ $data->kewarganegaraan ?? '...........................................' }}</td></tr>
        <tr><td>Status Perkawinan</td><td>: {{ $data->status_perkawinan ?? '...........................................' }}</td></tr>
        <tr><td>Pekerjaan</td><td>: {{ $data->pekerjaan ?? '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat ?? '...........................................' }} RT {{ $data->rt ?? '' }} / RW {{ $data->rw ?? '' }}</td></tr>
    </table>

    <p class="tulisan">
        Berdasarkan data kependudukan yang ada pada Pemerintah Desa Wates, yang bersangkutan tersebut di atas benar-benar penduduk Desa Wates dan <strong>benar pernah menikah</strong>.
    </p>

    <p class="tulisan">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
        <div class="ttd-right">
            <p>Wates, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>Kepala Desa Wates</strong></p>

            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div>

            <div class="materai">Materai<br>10.000</div>

            <p><strong><u>{{ $data->nama_lengkap ?? '...........................................' }}</u></strong></p>
            <p>NIK: {{ $data->nik ?? '...........................................' }}</p>

            <div class="barcode">
                <img src="{{ public_path('assets/images/barcode_surat.png') }}" alt="Barcode">
                <small>Scan untuk verifikasi surat resmi Desa Wates</small>
            </div>
        </div>
    </div>

</body>
</html>
