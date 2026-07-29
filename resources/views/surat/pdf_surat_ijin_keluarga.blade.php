<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Ijin Keluarga</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.05cm 1.55cm 1.05cm 1.55cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.5pt;
            color: #000;
            line-height: 1.22;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 6px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            vertical-align: middle;
            padding: 0;
            border: none;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 95px;
            height: auto;
        }

        .kop-desa-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.08;
        }

        .kop-desa-1 {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 10pt;
            margin-top: 1px;
        }

        .kop-desa-kontak {
            font-size: 8.5pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 5px 0 7px 0;
        }

        .judul {
            text-align: center;
            font-size: 11.8pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
            line-height: 1.05;
        }

        .nomor {
            text-align: center;
            font-size: 10.3pt;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 10px;
        }

        p {
            margin: 0 0 6px 0;
            text-align: justify;
        }

        .pembuka {
            margin-left: 0.25cm;
            margin-bottom: 8px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-left: 0.25cm;
            margin-bottom: 7px;
        }

        table.data td {
            padding: 2px 0;
            vertical-align: top;
        }

        table.data .no {
            width: 25px;
        }

        table.data .label {
            width: 175px;
        }

        table.data .colon {
            width: 16px;
            text-align: center;
        }

        table.data .value {
            padding-left: 3px;
        }

        .paragraf {
            text-align: justify;
            margin-left: 0.25cm;
            margin-bottom: 7px;
        }

        .paragraf-indent {
            text-align: justify;
            text-indent: 1.05cm;
            margin-left: 0.25cm;
            margin-bottom: 7px;
        }

        .tanggal {
            width: 100%;
            text-align: right;
            margin-top: 8px;
            margin-bottom: 12px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 0;
            page-break-inside: avoid;
        }

        .ttd-table td {
            width: 33.33%;
            text-align: center;
            vertical-align: top;
            padding: 0 8px;
        }

        .ttd-label {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 0;
        }

        .ttd-jabatan {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 2px;
        }

        .ttd-space {
            height: 54px;
        }

        .ttd-img-wrapper {
            height: 54px;
            margin: 2px auto 0 auto;
            text-align: center;
        }

        .ttd-img {
            width: 125px;
            height: auto;
            max-height: 54px;
        }

        .ttd-name {
            display: block;
            max-width: 100%;
            margin: 0 auto;
            font-size: 9.4pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            line-height: 1.15;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
        }

        .nama-kades {
            display: block;
            font-size: 10pt;
            font-weight: normal;
            text-transform: uppercase;
            line-height: 1.15;
            white-space: normal;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 5px 0 7px 0;
            }
        }
    </style>
</head>

<body>
    @php
        \Carbon\Carbon::setLocale('id');

        $tanggalSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->format('d - m - Y')
            : \Carbon\Carbon::now('Asia/Jakarta')->format('d - m - Y');

        $tanggalLahirSuami = !empty($data->tanggal_lahir_suami)
            ? \Carbon\Carbon::parse($data->tanggal_lahir_suami)->format('d - m - Y')
            : '-';

        $tanggalLahirIstri = !empty($data->tanggal_lahir_istri)
            ? \Carbon\Carbon::parse($data->tanggal_lahir_istri)->format('d - m - Y')
            : '-';
    @endphp

    <!-- KOP SURAT -->
    <div class="kop-desa-container">
        <table class="kop-desa-table">
            <tr>
                <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-desa-text">
                    <div class="kop-desa-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="kop-desa-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-desa-3">PEMERINTAH DESA Kemirigede</div>
                    <div class="kop-desa-alamat">Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email :pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                {{-- <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    <div class="judul">SURAT&nbsp;&nbsp;IJIN&nbsp;&nbsp;KELUARGA</div>

    <div class="nomor">
        Nomor :
        @if(!empty($data->nomor_surat))
            {{ $data->nomor_surat }}
        @else
            470/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/409.41.2/{{ now('Asia/Jakarta')->year }}
        @endif
    </div>

    <p class="pembuka">Yang bertanda tangan di bawah ini</p>

    <table class="data">
        <tr>
            <td class="no">1.</td>
            <td class="label">Nama lengkap</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->nama_suami ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">2.</td>
            <td class="label">Tempat tgl lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->tempat_lahir_suami ?? '-' }}, {{ $tanggalLahirSuami }}</td>
        </tr>
        <tr>
            <td class="no">3.</td>
            <td class="label">Jenis kelamin</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->jenis_kelamin_suami ?? 'Laki-laki' }}</td>
        </tr>
        <tr>
            <td class="no">4.</td>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->pekerjaan_suami ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">5.</td>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->alamat_suami ?? '-' }}</td>
        </tr>
    </table>

    <p class="paragraf">
        Suami dengan ini secara tulus dan iklas mengijinkan serta menyenyetujui istri saya di bawah ini;
    </p>

    <table class="data">
        <tr>
            <td class="no">1.</td>
            <td class="label">Nama lengkap</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->nama_istri ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">2.</td>
            <td class="label">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->tempat_lahir_istri ?? '-' }}, {{ $tanggalLahirIstri }}</td>
        </tr>
        <tr>
            <td class="no">3.</td>
            <td class="label">Jenis kelamin</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->jenis_kelamin_istri ?? 'Perempuan' }}</td>
        </tr>
        <tr>
            <td class="no">4.</td>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->pekerjaan_istri ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">5.</td>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->alamat_istri ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">6.</td>
            <td class="label">Negara Keberangkatan</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->negara_tujuan ?? '-' }}</td>
        </tr>
        <tr>
            <td class="no">7.</td>
            <td class="label">Sebagai</td>
            <td class="colon">:</td>
            <td class="value">{{ $data->sebagai ?? '-' }}</td>
        </tr>
    </table>

    <p class="paragraf-indent">
        Segala akibat yang timbul dikemudian hari dari perbuatan dan penggunaan surat ijin ini
        sepenuhnya menjadi tanggung jawab saya, baik secara hukum ataupun secara moril dan materiel
        tanpa melibatkan pihak lainnya.
    </p>

    <p class="paragraf">
        Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.
    </p>

    <br>

    <div class="tanggal">
        Blitar, {{ $tanggalSurat }}
    </div>

    <table class="ttd-table">
        <tr>
            <td>
                <div class="ttd-label">Istri</div>
                <div class="ttd-space"><br></div>
                <div class="ttd-name">
                    {{ $data->nama_istri ?? '................................' }}
                </div>
            </td>

            <td>
                <div class="ttd-label">Mengetahui :</div>
                <div class="ttd-jabatan">KEPALA DESA Kemirigede</div>

                {{-- <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD Kepala Desa">
                </div> --}}
<br><br><br><br>
                <div class="nama-kades">Hari Purnawan, S.Sos.</div>
            </td>

            <td>
                <div class="ttd-label">Suami</div>
                <div class="ttd-space"><br></div>
                <div class="ttd-name">
                    {{ $data->nama_suami ?? '................................' }}
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
