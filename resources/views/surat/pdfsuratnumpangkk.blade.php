<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Numpang KK</title>
    <style>
        @page {
            margin: 1.5cm 2cm 1.5cm 2cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.45;
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
            margin-bottom: 6px;
        }

        .judul-surat h3 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }

        .sub-judul {
            text-align: center;
            font-weight: bold;
            font-size: 11.5pt;
            margin-bottom: 4px;
        }

        .pasal {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 18px;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 16px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 8px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 0;
        }

        table.data td {
            padding: 3px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 145px;
            font-weight: bold;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 30px;
        }

        .ttd-right {
            width: 48%;
            float: right;
            text-align: center;
        }

        .ttd-right p {
            margin: 3px 0;
        }

        .materai {
            border: 1px solid #000;
            padding: 8px 20px;
            display: inline-block;
            margin: 10px 0;
            font-weight: bold;
        }

        .signature-line {
            margin-top: 45px;
            border-bottom: 1px solid #000;
            width: 220px;
            margin-left: auto;
            margin-right: auto;
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
                    <strong>KECAMATAN KEMIRIGEDE</strong><br>
                    <strong>KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
                    <small>Jln. Merdeka No. 74 Telp. 082139324445<br>
                    Email: KEMIRIGEDEberkelas@gmail.com | Website: KEMIRIGEDE-blitarkab.desa.id</small>
                </td>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td>
            </tr>
        </table>
        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN</h3>
    </div>
    <div class="sub-judul">
        BERSEDIA MENERIMA SEBAGAI ANGGOTA KELUARGA
    </div>
    <div class="pasal">
        (Pasal 12 ayat (5) Permendagri Nomor 108 Tahun 2019)
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '400 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI -->
    <p class="tulisan"><strong>Saya yang bertanda tangan di bawah ini:</strong></p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_pemilik_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_pemilik_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>No. KK</td>
            <td>: {{ $data->no_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_pemilik_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_pemilik_kk ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Selaku Kepala Keluarga, dengan ini menyatakan <strong>tidak keberatan</strong> dalam Kartu Keluarga saya dimasukkan orang tersebut di bawah ini:
    </p>

    <table class="data">
        <tr>
            <td>Nama</td>
            <td>: {{ $data->nama_penumpang_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_penumpang_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat dan Tanggal Lahir</td>
            <td>: {{ $data->tempat_lahir_penumpang_kk ?? '' }},
                {{ isset($data->tanggal_lahir_penumpang_kk) ? \Carbon\Carbon::parse($data->tanggal_lahir_penumpang_kk)->translatedFormat('d F Y') : '...........................................' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $data->agama_penumpang_kk ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_penumpang_kk ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan tanpa paksaan dari pihak manapun, untuk dipergunakan sebagaimana mestinya.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>Saya yang menyatakan,</strong></p>

            <div class="materai">Materai<br>10.000</div>

            <div class="signature-line"></div>
            <p><strong>( {{ $data->nama_pemilik_kk ?? '...........................................' }} )</strong></p>
        </div>
    </div>

</body>
</html>
