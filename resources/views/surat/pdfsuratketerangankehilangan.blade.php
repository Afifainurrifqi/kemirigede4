<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kehilangan</title>
    <style>
        @page {
            margin: 1.3cm 1.8cm 1.3cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT */
        .kop-container {
            width: 100%;
            margin-bottom: 12px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 105px;
            height: auto;
        }

        .kop-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-text .kop-baris-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text .kop-alamat {
            font-size: 11pt;
            font-weight: normal;
            margin-top: 2px;
        }

        .kop-text .kop-kontak {
            font-size: 10pt;
            font-weight: normal;
        }

        .kop-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 6px 0 12px 0;
        }

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

        .tulisan {
            text-align: justify;
            margin-bottom: 6px;
        }

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

        .ttd-img-wrapper {
            margin: 8px 0;
            text-align: center;
        }

        .ttd-img {
            width: 160px;
            height: auto;
        }

        .barcode {
            margin-top: 8px;
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

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-text">
                    <div class="kop-baris-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="kop-baris-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-baris-3">PEMERINTAH DESA KEMIRIGEDE</div>
                    <div class="kop-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kop-kontak">
                        email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                {{-- <td class="kop-logo">
                    <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul-surat">
        SURAT KETERANGAN KEHILANGAN
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '430 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI -->
    <p class="tulisan">
        Yang bertanda tangan di bawah ini, Kepala Desa KEMIRIGEDE, Kecamatan KEMIRIGEDE, Kabupaten Blitar,
        menerangkan dengan sebenarnya bahwa:
    </p>

    <table class="data">
        <tr>
            <td>Nama Lengkap</td>
            <td>: {{ $data->nama_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>
                : {{ $data->tempat_lahir_pelapor ?? '' }},
                {{ !empty($data->tanggal_lahir_pelapor)
                    ? \Carbon\Carbon::parse($data->tanggal_lahir_pelapor)->translatedFormat('d F Y')
                    : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>: {{ $data->jenis_kelamin_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $data->agama_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td>: {{ $data->status_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan_pelapor ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_pelapor ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Telah kehilangan <strong>{{ $data->jenis_kehilangan ?? '...........................................' }}</strong>
        atas nama <strong>{{ $data->atas_nama ?? '...........................................' }}</strong>
        dengan keterangan <strong>{{ $data->berisi ?? '...........................................' }}</strong>
        pada tanggal
        <strong>
            {{ !empty($data->tanggal_kehilangan)
                ? \Carbon\Carbon::parse($data->tanggal_kehilangan)->translatedFormat('d F Y')
                : '...........................................' }}
        </strong>,
        hilang saat <strong>{{ $data->hilang_saat ?? '...........................................' }}</strong>.
    </p>

    <p class="tulisan">
        Demikian surat keterangan kehilangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>Kepala Desa KEMIRIGEDE</strong></p>

            {{-- <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div> --}}

            <br><br>

            <p><strong><u>MOH. HAMID ALMAULUDI S.Pd.I</u></strong></p>

            {{-- <div class="barcode">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                <small>Dokumen ini resmi dikeluarkan oleh Pemerintah Desa KEMIRIGEDE</small>
            </div> --}}
        </div>
    </div>

</body>
</html>
