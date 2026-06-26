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
        }

        .kop {
            width: 100%;
            margin-bottom: 5px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo-left {
            width: 17%;
            text-align: left;
        }

        .kop-logo-right {
            width: 17%;
            text-align: right;
        }

        .kop-logo-left img {
            width: 76px;
            height: auto;
        }

        .kop-logo-right img {
            width: 74px;
            height: auto;
        }

        .kop-text {
            width: 66%;
            text-align: center;
            line-height: 1.02;
        }

        .kop-text .baris-1 {
            font-size: 13.5pt;
            font-weight: normal;
        }

        .kop-text .baris-2 {
            font-size: 13pt;
            font-weight: normal;
        }

        .kop-text .baris-3 {
            font-size: 15.5pt;
            font-weight: bold;
        }

        .kop-text .alamat {
            font-size: 9.5pt;
        }

        .kop-text .kontak {
            font-size: 8pt;
        }

        .kop-garis {
            border: none;
            border-top: 2.3px solid #000;
            margin-top: 4px;
            margin-bottom: 6px;
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

        /* TTD 3 KOLOM AGAR TETAP 1 HALAMAN */
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

    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo-left">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-text">
                    <div class="baris-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="baris-2">KECAMATAN KEMIRIGEDE</div>
                    <div class="baris-3">KANTOR KEPALA DESA KEMIRIGEDE</div>
                    <div class="alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kontak">
                        email : KEMIRIGEDEberkelas@gmail.com / website : KEMIRIGEDE-blitarkab.desa.id
                    </div>
                </td>

                <td class="kop-logo-right">
                    <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td>
            </tr>
        </table>

        <hr class="kop-garis">
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
        KEMIRIGEDE , {{ $tanggalSurat }}
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
                <div class="ttd-jabatan">Kepala Desa KEMIRIGEDE</div>
                <div class="ttd-space"><br></div>
                <div class="nama-kades">MOH. HAMID ALMAULUDI</div>
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
