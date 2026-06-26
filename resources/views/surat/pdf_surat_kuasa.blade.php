<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Kuasa</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.25cm 1.55cm 1cm 1.55cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.22;
            color: #000;
        }

        p {
            margin: 0;
            padding: 0;
        }

        /* ================= KOP SURAT ================= */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .kop-table td {
            padding: 0;
            vertical-align: middle;
        }

        .kop-logo {
            width: 17%;
            text-align: center;
        }

        .kop-logo img {
            width: 88px;
            height: auto;
        }

        .kop-text {
            width: 66%;
            text-align: center;
            line-height: 1.08;
        }

        .kop-text .kabupaten {
            font-size: 16pt;
            font-weight: normal;
        }

        .kop-text .kecamatan {
            font-size: 16pt;
            font-weight: normal;
        }

        .kop-text .desa {
            font-size: 18pt;
            font-weight: bold;
        }

        .kop-text .kontak {
            font-size: 9.8pt;
            margin-top: 2px;
        }

        .garis-kop {
            border: none;
            border-top: 2.5px solid #000;
            margin: 5px 0 18px 0;
        }

        /* ================= JUDUL ================= */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12.5pt;
            text-decoration: underline;
            margin: 0 0 3px 0;
        }

        .nomor {
            text-align: center;
            font-size: 11.2pt;
            margin-bottom: 18px;
        }

        /* ================= ISI SURAT ================= */
        .pembuka {
            text-align: left;
            margin-bottom: 3px;
        }

        table.data {
            width: 86%;
            margin-left: 50px;
            border-collapse: collapse;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        table.data td {
            padding: 1px 0;
            vertical-align: top;
            line-height: 1.2;
        }

        table.data tr.section-row td {
            padding-top: 10px;
            padding-bottom: 5px;
        }

        .label {
            width: 190px;
        }

        .colon {
            width: 12px;
            text-align: center;
        }

        .isi-kuasa {
            margin-top: 10px;
            text-align: justify;
            line-height: 1.25;
        }

        .penutup {
            margin-top: 10px;
            text-align: justify;
            text-indent: 35px;
            line-height: 1.25;
        }

        /* ================= TANDA TANGAN ================= */
        .ttd-wrapper {
            page-break-inside: avoid;
            margin-top: 12px;
        }

        .tanggal {
            text-align: right;
            padding-right: 75px;
            margin-bottom: 8px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }

        .jabatan-ttd {
            margin-bottom: 55px;
        }

        .nama-pihak {
            font-weight: bold;
            text-decoration: underline;
        }

        .mengetahui {
            text-align: center;
            margin-top: 8px;
            page-break-inside: avoid;
        }

        .mengetahui p {
            text-align: center;
        }

        .ttd-img-wrapper {
            height: 58px;
            margin-top: 2px;
            margin-bottom: 0;
            text-align: center;
        }

        .ttd-img {
            width: 155px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            margin-top: -3px;
        }

        .barcode {
            text-align: center;
            margin-top: 4px;
            font-size: 7.5pt;
        }

        .barcode img {
            width: 72px;
            height: auto;
        }
    </style>
</head>

<body>

    <!-- KOP -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten">
            </td>

            <td class="kop-text">
                <div class="kabupaten">PEMERINTAH KABUPATEN BLITAR</div>
                <div class="kecamatan">KECAMATAN KEMIRIGEDE</div>
                <div class="desa">KANTOR KEPALA DESA KEMIRIGEDE</div>
                <div class="kontak">
                    Jln. Merdeka No. 74 Telp. 082139324445<br>
                    email :KEMIRIGEDEberkelas@gmail.com / website : KEMIRIGEDE-blitarkab.desa.id
                </div>
            </td>

            <td class="kop-logo">
                <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa">
            </td>
        </tr>
    </table>

    <hr class="garis-kop">

    <!-- JUDUL -->
    <div class="judul">SURAT KUASA</div>

    <p class="nomor">
        No : {{ $data->nomor_surat ?? '470 / --- / 409.42.1 / ' . now()->year }}
    </p>

    <!-- PEMBUKA -->
    <p class="pembuka">
        Yang bertanda tangan dibawah ini Kepala Desa KEMIRIGEDE Kec.KEMIRIGEDE Kab.Blitar
    </p>
    <p class="pembuka">
        Menerangkan dengan sebenarnya bahwa :
    </p>

    <!-- DATA PIHAK -->
    <table class="data">
        <tr class="section-row">
            <td colspan="3">Pihak I :</td>
        </tr>

        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $data->nama_pihak1 }}</td>
        </tr>
        <tr>
            <td class="label">Jenis kelamin</td>
            <td class="colon">:</td>
            <td>{{ $data->jenis_kelamin_pihak1 }}</td>
        </tr>
        <tr>
            <td class="label">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td>{{ $data->tempat_lahir_pihak1 }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir_pihak1)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $data->agama_pihak1 }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="colon">:</td>
            <td>{{ $data->status_pihak1 }}</td>
        </tr>
        <tr>
            <td class="label">Nik</td>
            <td class="colon">:</td>
            <td>{{ $data->nik_pihak1 }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>{{ $data->pekerjaan_pihak1 }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $data->alamat_pihak1 }}</td>
        </tr>

        <tr class="section-row">
            <td colspan="3">Pihak II :</td>
        </tr>

        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $data->nama_pihak2 }}</td>
        </tr>
        <tr>
            <td class="label">Jenis kelamin</td>
            <td class="colon">:</td>
            <td>{{ $data->jenis_kelamin_pihak2 }}</td>
        </tr>
        <tr>
            <td class="label">Tempat tanggal lahir</td>
            <td class="colon">:</td>
            <td>{{ $data->tempat_lahir_pihak2 }}, {{ \Carbon\Carbon::parse($data->tanggal_lahir_pihak2)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $data->agama_pihak2 }}</td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="colon">:</td>
            <td>{{ $data->status_pihak2 }}</td>
        </tr>
        <tr>
            <td class="label">Nik</td>
            <td class="colon">:</td>
            <td>{{ $data->nik_pihak2 }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>{{ $data->pekerjaan_pihak2 }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $data->alamat_pihak2 }}</td>
        </tr>
    </table>

    <!-- ISI KUASA -->
    <p class="isi-kuasa">
        Pihak I telah memberikan kuasa kepada Pihak II untuk
        <strong>{{ $data->keterangan_kuasa }}</strong>.
    </p>

    <p class="penutup">
        Demikian surat kuasa ini di buat atas dasar yang sebenarnya untuk menjadikan periksa dan guna seperlunya.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">

        <p class="tanggal">
            KEMIRIGEDE, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}
        </p>

        <table class="ttd-table">
            <tr>
                <td>
                    <p class="jabatan-ttd">Pemberi Kuasa</p>
                    <p class="nama-pihak">{{ strtoupper($data->nama_pihak1) }}</p>
                </td>

                <td>
                    <p class="jabatan-ttd">Penerima Kuasa</p>
                    <p class="nama-pihak">{{ strtoupper($data->nama_pihak2) }}</p>
                </td>
            </tr>
        </table>

        <div class="mengetahui">
            <p>Mengetahui</p>
            <p>Kepala Desa KEMIRIGEDE</p>

            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD Kepala Desa">
            </div>

            <p class="nama-kades">MOH. HAMID ALMAULUDI, S.Pd.I</p>

            <div class="barcode">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                <br>
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div>
        </div>

    </div>

</body>
</html>
