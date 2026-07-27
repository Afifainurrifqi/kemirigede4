<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SPPD - {{ $data->nama_pegawai ?? 'Pegawai' }}</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.25cm 1.45cm 1.15cm 1.45cm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.5pt;
            color: #000;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            vertical-align: top;
        }

        .page-break {
            page-break-after: always;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 18px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 105px;
            height: auto;
        }

        .kop-desa-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-desa-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 11pt;
            margin-top: 2px;
        }

        .kop-desa-kontak {
            font-size: 10pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 6px 0 0 0;
        }

        .judul {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 22px;
        }

        /* =========================
           HALAMAN 1
        ========================= */
        .sppd-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.3pt;
        }

        .sppd-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            line-height: 1.12;
        }

        .sppd-table .no {
            width: 5%;
            text-align: center;
        }

        .sppd-table .uraian {
            width: 37%;
        }

        .sppd-table .colon {
            width: 3%;
            text-align: center;
        }

        .sppd-table .isi {
            width: 55%;
        }

        .sub-table {
            width: 100%;
            border-collapse: collapse;
        }

        .sub-table td {
            border: none;
            padding: 0;
            line-height: 1.15;
        }

        .sub-table .huruf {
            width: 24px;
            text-align: right;
            padding-right: 6px;
        }

        .pengikut-table td {
            border: 1px solid #000;
            text-align: center;
            height: 20px;
            padding: 3px 5px;
        }

        .pengikut-space td {
            height: 58px;
        }

        .keluaran-table {
            margin-top: 18px;
            font-size: 9.5pt;
        }

        .keluaran-table td {
            border: none;
            padding: 2px 0;
            line-height: 1.15;
        }

        .keluaran-table .left {
            width: 34%;
        }

        .keluaran-table .middle {
            width: 20%;
        }

        .keluaran-table .colon {
            width: 3%;
            text-align: center;
        }

        .keluaran-table .right {
            width: 43%;
        }

        .ttd-kanan {
            width: 310px;
            margin-left: auto;
            text-align: center;
            margin-top: 16px;
            font-family: "Times New Roman", Times, serif;
            font-size: 10.5pt;
        }

        .ttd-kanan .nama {
            margin-top: 54px;
            font-weight: bold;
        }

        /* =========================
           HALAMAN 2
        ========================= */
        .lembar-table {
            width: 92%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 9.5pt;
        }

        .lembar-table td {
            border: 1px solid #000;
            padding: 5px 7px;
            line-height: 1.1;
        }

        .lembar-no {
            width: 5%;
            text-align: center;
        }

        .lembar-left {
            width: 45%;
        }

        .lembar-right {
            width: 50%;
        }

        .box-large td {
            height: 124px;
        }

        .box-medium td {
            height: 112px;
        }

        .box-final td {
            height: 190px;
        }

        .lembar-inner {
            width: 100%;
        }

        .lembar-inner td {
            border: none;
            padding: 0;
            height: auto;
        }

        .lembar-inner .label {
            width: 86px;
        }

        .lembar-inner .colon {
            width: 12px;
            text-align: center;
        }

        .lembar-ttd {
            text-align: center;
            font-family: "Times New Roman", Times, serif;
            margin-top: 20px;
        }

        .lembar-ttd .nama {
            margin-top: 48px;
            font-weight: bold;
        }

        .catatan-row td {
            height: 24px;
            padding: 4px 7px;
        }

        /* =========================
           HALAMAN 3
        ========================= */
        .perhatian {
            font-size: 10.5pt;
            line-height: 1.2;
            text-align: justify;
            margin-top: 0;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 6px 0 0 0;
            }
        }
    </style>
</head>

<body>
    @php
        $tanggalSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->locale('id') ->locale('id')->translatedFormat('d F Y')
            : now('Asia/Jakarta')->locale('id') ->locale('id')->translatedFormat('d F Y');

        $tanggalBerangkat = !empty($data->tanggal_berangkat)
            ? \Carbon\Carbon::parse($data->tanggal_berangkat)->locale('id') ->locale('id')->translatedFormat('d F Y')
            : '-';

        $tanggalKembali = !empty($data->tanggal_kembali)
            ? \Carbon\Carbon::parse($data->tanggal_kembali)->locale('id') ->locale('id')->translatedFormat('d F Y')
            : '-';

        $tahunSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->format('Y')
            : now('Asia/Jakarta')->format('Y');

        $nomorSppd =
            $data->nomor_sppd ??
            ($data->nomor_surat ?? 'B/010.02/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/409.41.2/' . $tahunSurat);

        $namaKades = $data->nama_kepala_desa ?? 'Hari Purnawan, S.Sos.';
        $pejabat = $data->pejabat_pemberi_perintah ?? 'KEPALA DESA Kemirigede Kecamatan Kesamben Kabupaten Blitar';

        $namaPegawai = $data->nama_pegawai ?? 'ITA PUJI LESTARI';
        $pangkatGolongan = $data->pangkat_golongan ?? '- Perangkat Desa Kemirigede';
        $jabatan = $data->jabatan ?? '- Kaur Keuangan';
        $tingkatBiaya = $data->tingkat_biaya ?? '';

        $maksud = $data->maksud_perjalanan ?? 'Pengiriman Berkas Revisi Lampiran Add Tahap 1 Permin1';
        $alatAngkutan = $data->alat_angkutan ?? 'Kendaraan Roda Empat';
        $tempatBerangkat = $data->tempat_berangkat ?? 'Desa Kemirigede';
        $tempatTujuan = $data->tempat_tujuan ?? 'Ke DPMD';
        $lamaPerjalanan = $data->lama_perjalanan ?? '1';

        $instansi = $data->instansi ?? 'Pemerintah Desa Kemirigede';
        $sumberAnggaran = $data->sumber_anggaran ?? 'APBDesa';
    @endphp

    <!-- ======================================================
     HALAMAN 1
====================================================== -->
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

    <div class="judul">SURAT PERINTAH PERJALANAN DINAS</div>

    <table class="sppd-table">
        <tr>
            <td class="no">1</td>
            <td class="uraian">Pejabat yang Berwenang Memberikan<br>Perintah</td>
            <td class="colon">:</td>
            <td class="isi">{{ $pejabat }}</td>
        </tr>

        <tr>
            <td class="no">2</td>
            <td class="uraian">Nama Pegawai Yang Diperintah</td>
            <td class="colon">:</td>
            <td class="isi">{{ $namaPegawai }}</td>
        </tr>

        <tr>
            <td class="no">3</td>
            <td class="uraian">
                <table class="sub-table">
                    <tr>
                        <td class="huruf">a.</td>
                        <td>Pangkat dan Golongan</td>
                    </tr>
                    <tr>
                        <td class="huruf">b.</td>
                        <td>Jabatan / Intansi</td>
                    </tr>
                    <tr>
                        <td class="huruf">c.</td>
                        <td>Tingkat Biaya Prjalanan Dinas</td>
                    </tr>
                </table>
            </td>
            <td class="colon">
                :<br>:<br>:
            </td>
            <td class="isi">
                {{ $pangkatGolongan }}<br>
                {{ $jabatan }}<br>
                {{ $tingkatBiaya }}
            </td>
        </tr>

        <tr>
            <td class="no">4</td>
            <td class="uraian">Maksud Perjalanan Dinas</td>
            <td class="colon">:</td>
            <td class="isi">{{ $maksud }}</td>
        </tr>

        <tr>
            <td class="no">5</td>
            <td class="uraian">Alat Angkutan Yang Digunakan</td>
            <td class="colon">:</td>
            <td class="isi">{{ $alatAngkutan }}</td>
        </tr>

        <tr>
            <td class="no">6</td>
            <td class="uraian">
                <table class="sub-table">
                    <tr>
                        <td class="huruf">a.</td>
                        <td>Tempat Berangkat</td>
                    </tr>
                    <tr>
                        <td class="huruf">b.</td>
                        <td>Tempat Tujuan</td>
                    </tr>
                </table>
            </td>
            <td class="colon">
                :<br>:
            </td>
            <td class="isi">
                {{ $tempatBerangkat }}<br>
                {{ $tempatTujuan }}
            </td>
        </tr>

        <tr>
            <td class="no">7</td>
            <td class="uraian">
                <table class="sub-table">
                    <tr>
                        <td class="huruf">a.</td>
                        <td>Lamanya Perjalanan Dinas</td>
                    </tr>
                    <tr>
                        <td class="huruf">b.</td>
                        <td>Tanggal Berangkat</td>
                    </tr>
                    <tr>
                        <td class="huruf">c.</td>
                        <td>Tanggal Harus Kembali</td>
                    </tr>
                </table>
            </td>
            <td class="colon">
                :<br>:<br>:
            </td>
            <td class="isi">
                {{ $lamaPerjalanan }} Hari<br>
                {{ $tanggalBerangkat }}<br>
                {{ $tanggalKembali }}
            </td>
        </tr>

        <tr>
            <td class="no">8</td>
            <td colspan="3" style="padding:0;">
                <table class="pengikut-table">
                    <tr>
                        <td style="width:33.33%;">Pengikut : Nama</td>
                        <td style="width:33.33%;">Pangkat/ Golongan</td>
                        <td style="width:33.33%;">Jabatan</td>
                    </tr>
                    <tr class="pengikut-space">
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td class="no">9</td>
            <td class="uraian">
                Pembebanan Anggaran<br>
                <table class="sub-table">
                    <tr>
                        <td class="huruf">a.</td>
                        <td>Instansi</td>
                    </tr>
                    <tr>
                        <td class="huruf">b.</td>
                        <td>Sumber Anggaran</td>
                    </tr>
                </table>
            </td>
            <td class="colon">
                <br>:<br>:
            </td>
            <td class="isi">
                <br>
                {{ $instansi }}<br>
                {{ $sumberAnggaran }}
            </td>
        </tr>

        <tr>
            <td class="no">10</td>
            <td class="uraian">Keterangan Lain-lain</td>
            <td class="colon">:</td>
            <td class="isi">{{ $data->keterangan_lain ?? '' }}</td>
        </tr>
    </table>

    <table class="keluaran-table">
        <tr>
            <td class="left">Dikeluarkan di</td>
            <td class="middle">Pada tanggal</td>
            <td class="colon">:</td>
            <td class="right">Kemirigede</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="colon">:</td>
            <td>{{ $tanggalSurat }}</td>
        </tr>
    </table>

    <div class="ttd-kanan">
        <div>KEPALA DESA Kemirigede</div>
        <div class="nama">{{ $namaKades }}</div>
    </div>

    <div class="page-break"></div>

    <!-- ======================================================
     HALAMAN 2
====================================================== -->
    <table class="lembar-table">
        <tr class="box-large">
            <td class="lembar-no">I</td>
            <td class="lembar-left"></td>
            <td class="lembar-right">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">SPPD No.</td>
                        <td class="colon">:</td>
                        <td>{!! $nomorSppd !!}</td>
                    </tr>
                    <tr>
                        <td class="label">Berangkat<br>dari</td>
                        <td class="colon">:</td>
                        <td>{{ $tempatBerangkat }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pada<br>tanggal</td>
                        <td class="colon">:</td>
                        <td>{{ $tanggalBerangkat }}</td>
                    </tr>
                    <tr>
                        <td class="label">Ke</td>
                        <td class="colon">:</td>
                        <td>{{ $tempatTujuan }}</td>
                    </tr>
                </table>

                <div class="lembar-ttd">
                    <div>KEPALA DESA Kemirigede</div>
                    <div class="nama">{{ $namaKades }}</div>
                </div>
            </td>
        </tr>

        <tr class="box-medium">
            <td class="lembar-no">II</td>
            <td class="lembar-left">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Tiba di</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kepala</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td class="lembar-right">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Berangakat<br>dari</td>
                        <td class="colon">:</td>
                        <td>{{ $tempatBerangkat }}</td>
                    </tr>
                    <tr>
                        <td class="label">Ke</td>
                        <td class="colon">:</td>
                        <td>{{ $tempatTujuan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td>{{ $tanggalBerangkat }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kepala</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="box-medium">
            <td class="lembar-no">III</td>
            <td class="lembar-left">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Tiba di</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kepala</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td class="lembar-right">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Berangakat dari</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Ke</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kepala</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="box-medium">
            <td class="lembar-no">VI</td>
            <td class="lembar-left">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Tiba di</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kepala</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
            <td class="lembar-right">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Berangkat dari</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Ke</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kepala</td>
                        <td class="colon">:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="box-final">
            <td class="lembar-no">V</td>
            <td colspan="2">
                <table class="lembar-inner">
                    <tr>
                        <td class="label">Tiba di</td>
                        <td class="colon">:</td>
                        <td>{{ $tempatTujuan }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pada tanggal</td>
                        <td class="colon">:</td>
                        <td>{{ $tanggalKembali }}</td>
                    </tr>
                </table>

                <div style="margin-top:18px; text-align:justify;">
                    Telah diperiksa dengan keterangan bahwa perjalanan diatas benar dilakukan atas perintahnya dan
                    semata-mata untuk kepentingan jabatan dalam waktu yang sesingkat-singkatnya.
                </div>

                <div class="lembar-ttd">
                    <div>KEPALA DESA Kemirigede</div>
                    <div class="nama">{{ $namaKades }}</div>
                </div>
            </td>
        </tr>

        <tr class="catatan-row">
            <td class="lembar-no">VI</td>
            <td colspan="2">CATATAN LAIN-LAIN</td>
        </tr>

        <tr class="catatan-row">
            <td class="lembar-no">VII</td>
            <td colspan="2">PERHATIAN</td>
        </tr>
    </table>

    <div class="page-break"></div>

    <!-- ======================================================
     HALAMAN 3
====================================================== -->
    <div class="perhatian">
        Pejabat yang berwenang memberikan SPPD Pegawai yang melakukan Perjalanan Dinas para Pejabat
        yang mengesahkan tanggal berangkat, tiba serta bendaharawan bertanggung jawab berdasarkan
        peraturan-peraturan Keuangan Negara apabila negara menderita kerugian akibat kesalahan, kelalaian dan
        kealpaannya.
    </div>

</body>

</html>
