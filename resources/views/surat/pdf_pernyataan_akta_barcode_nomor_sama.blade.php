<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Ghoib</title>
    <style>
        @page {
            margin: 1.2cm 2cm 1.2cm 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
        }

        /* Kop Surat Resmi Desa */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 4px double #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        .kop-logo {
            width: 12%;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            width: 70px;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
        }
        .kop-text .kabupaten { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-text .kecamatan { font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-text .desa { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 0; }
        .kop-text .kontak { font-size: 10pt; font-style: normal; margin-top: 2px; font-weight: normal; }

        /* Judul Surat */
        .judul-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul {
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 0;
        }
        .nomor {
            font-size: 11pt;
            margin-top: 2px;
        }

        /* Paragraf & Teks Utama */
        p {
            text-align: justify;
            margin-bottom: 12px;
            margin-top: 0;
        }
        .indent {
            text-indent: 45px;
        }

        /* Tabel Data Penduduk */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-left: 45px;
            margin-bottom: 15px;
        }
        table.data td {
            padding: 3px 0;
            vertical-align: top;
        }
        table.data td.label-data {
            width: 30%;
        }
        table.data td.titik-dua {
            width: 3%;
        }
        table.data td.value-data {
            width: 67%;
        }
        .text-uppercase {
            text-transform: uppercase;
        }

        /* CSS BAGIAN TTD KADES */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        .ttd-spacer {
            width: 55%;
        }
        .ttd-cell {
            width: 45%;
            text-align: center;
            vertical-align: top;
        }
        .ttd-cell p {
            text-align: center;
            margin-bottom: 2px;
        }
        .ttd-img-wrapper {
            margin: 5px auto;
            text-align: center;
            width: 120px;
            height: 75px;
            position: relative;
        }
        .ttd-img {
            max-width: 100%;
            max-height: 100%;
            display: inline-block;
        }
        .nama-kades {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px;
            margin-bottom: 0px !important;
        }
        .barcode {
            text-align: center;
            margin-top: 15px;
        }
        .barcode img {
            width: 70px;
            height: auto;
        }
        .barcode small {
            font-size: 8pt;
            color: #444;
        }
    </style>
</head>
<body>
    @php
        $tanggalPernyataan = !empty($data->tanggal_pernyataan)
            ? \Carbon\Carbon::parse($data->tanggal_pernyataan)->translatedFormat('d F Y')
            : '................................';
        $tanggalHilang = !empty($data->tanggal_hilang)
            ? \Carbon\Carbon::parse($data->tanggal_hilang)->translatedFormat('d F Y')
            : '................................';
    @endphp

    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo">
            </td>
            <td class="kop-text">
                <div class="kabupaten">PEMERINTAH KABUPATEN BLITAR</div>
                <div class="kecamatan">KECAMATAN WATES</div>
                <div class="desa">KANTOR KEPALA DESA WATES</div>
                <div class="kontak">
                    Jl. Merdeka No. 74 Telp. 082139324445<br>
                    email: watesberkelas@gmail.com / website: wates-blitarkab.desa.id
                </div>
            </td>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa">
            </td>
        </tr>
    </table>

    <div class="judul-container">
        <div class="judul">SURAT KETERANGAN GHOIB</div>
        <div class="nomor">Nomor: {{ $data->nomor_surat ?? '145/ /409.41.2/' . now()->year }}</div>
    </div>

    <p class="indent">Berdasarkan surat Pernyataan pada tanggal <strong>{{ $tanggalPernyataan }}</strong> yang menyatakan dengan sebenarnya bahwa :</p>

    <table class="data">
        <tr>
            <td class="label-data">Nama</td>
            <td class="titik-dua">:</td>
            <td class="value-data text-uppercase" style="font-weight: bold;">{{ $data->nama_pemohon ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label-data">Tempat, Tanggal Lahir</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->tempat_lahir ?? '' }}{{ $data->tanggal_lahir ? ', ' . \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') : '' }}</td>
        </tr>
        <tr>
            <td class="label-data">Jenis Kelamin</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->jenis_kelamin ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label-data">Kebangsaan</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->kewarganegaraan ?? 'Indonesia' }}</td>
        </tr>
        <tr>
            <td class="label-data">Agama</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->agama ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label-data">Status</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->status ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label-data">Pekerjaan</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->pekerjaan ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label-data">Alamat</td>
            <td class="titik-dua">:</td>
            <td class="value-data">{{ $data->alamat ?? '................................' }}</td>
        </tr>
    </table>

    <p class="indent">Orang tersebut diatas benar-benar penduduk Desa Wates Kecamatan Wates Kabupaten Blitar, benar-benar menyatakan bahwa suaminya yang Bernama <strong class="text-uppercase">{{ $data->nama_suami_istri ?? '................................' }}</strong> telah pergi meninggalkan keluarga sejak tanggal {{ $tanggalHilang }} dan sekarang tidak diketahui alamatnya dengan jelas dan pasti diwilayah Republik Indonesia.</p>

    <p class="indent">Selanjutnya surat keterangan ini dipergunakan untuk melengkapi persyaratan <strong>{{ $data->keperluan ?? 'Pengajuan Perceraian' }}</strong>.</p>

    <p>Demikian Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Wates, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
                <p>Saya yang menyatakan,</p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
                </div>

                <p class="nama-kades"><u>{{ $data->nama ?? 'MOH. HAMID ALMAULUDI, S.Pd.I' }}</u></p>
                <p style="margin-top: 0px;">NIK: {{ $data->nik ?? '................................' }}</p>

                <div class="barcode">
                    <img src="{{ public_path('assets/images/barcode_surat.png') }}" alt="Barcode">
                    <br><small>Scan untuk verifikasi surat resmi Desa Wates</small>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
