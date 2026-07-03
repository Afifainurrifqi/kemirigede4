<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Pernyataan Miskin</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm 2cm 1.2cm 2cm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.8pt;
            line-height: 1.28;
            color: #000;
        }

        p {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 9px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            padding: 0;
            vertical-align: middle;
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
            margin: 5px 0 9px 0;
        }

        /* ================= HEADER SURAT ================= */
        .header-surat {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
            margin-bottom: 24px;
        }

        .header-surat td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .header-kiri {
            width: 60%;
        }

        .header-kanan {
            width: 40%;
            padding-left: 10px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
        }

        .meta-table td {
            border: none;
            padding: 0 0 1px 0;
            font-size: 9.8pt;
            line-height: 1.12;
            vertical-align: top;
        }

        .meta-label {
            width: 82px;
            text-transform: uppercase;
        }

        .meta-colon {
            width: 10px;
            text-align: center;
        }

        .tujuan {
            font-size: 9.8pt;
            line-height: 1.18;
            text-align: left;
        }

        .tujuan .indent {
            padding-left: 24px;
        }

        /* ================= ISI SURAT ================= */
        .content {
            width: 100%;
            font-size: 10.8pt;
        }

        .salam {
            margin-bottom: 13px;
            text-align: left;
        }

        .paragraf {
            text-align: justify;
            text-indent: 45px;
            margin-bottom: 7px;
            line-height: 1.28;
        }

        .paragraf-tanpa-indent {
            text-align: justify;
            margin-bottom: 7px;
            line-height: 1.28;
        }

        /* ================= TTD ================= */
        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 54px;
        }

        .ttd-spacer {
            width: 62%;
        }

        .ttd-cell {
            width: 38%;
            text-align: center;
            vertical-align: top;
            font-size: 10pt;
        }

        .ttd-cell p {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .ttd-img-wrapper {
            margin: 8px auto 0 auto;
            text-align: center;
            width: 120px;
            height: 58px;
            position: relative;
        }

        .ttd-img {
            max-width: 120px;
            max-height: 58px;
            display: inline-block;
        }

        .nama-kades {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 5px !important;
            font-size: 10pt;
        }

        .barcode {
            text-align: center;
            margin-top: 8px;
        }

        .barcode img {
            width: 58px;
            height: auto;
        }

        .barcode small {
            font-size: 7pt;
            color: #444;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 5px 0 9px 0;
            }
        }
    </style>
</head>

<body>

    @php
        $sapaan = $data->sapaan_pasien ?? 'Tn.';
        $namaPasien = $data->nama_pasien ?? 'Cornelius Tri Utomo';
        $alamatPasien = $data->alamat_pasien ?? 'Dusun KEMIRIGEDE RT 02 RW 03 Desa KEMIRIGEDE Kec. KEMIRIGEDE Kab. Blitar';
        $rumahSakit = $data->rumah_sakit_tujuan ?? 'Ngudi Waluyo';
        $lokasiRumahSakit = $data->lokasi_rumah_sakit ?? 'Wlingi';

        $ttdKades = public_path('assets/images/ttd.png');

        $barcodeSurat = file_exists(public_path('assets/images/barcode.png'))
            ? public_path('assets/images/barcode.png')
            : public_path('assets/images/barcode_surat.png');
    @endphp

    {{-- KOP SURAT --}}
    <div class="kop-desa-container">
        <table class="kop-desa-table">
            <tr>
                <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-desa-text">
                    <div class="kop-desa-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="kop-desa-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-desa-3">PEMERINTAH DESA KEMIRIGEDE</div>
                    <div class="kop-desa-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email :Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                {{-- <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    {{-- SIFAT / LAMPIRAN / PERIHAL DAN TUJUAN --}}
    <table class="header-surat">
        <tr>
            <td class="header-kiri">
                <table class="meta-table">
                    <tr>
                        <td class="meta-label">SIFAT</td>
                        <td class="meta-colon">:</td>
                        <td>Penting</td>
                    </tr>
                    <tr>
                        <td class="meta-label">LAMPIRAN</td>
                        <td class="meta-colon">:</td>
                        <td>1 [ satu ] bendel</td>
                    </tr>
                    <tr>
                        <td class="meta-label">PERIHAL</td>
                        <td class="meta-colon">:</td>
                        <td>Permohonan surat Pernyataan miskin.</td>
                    </tr>
                </table>
            </td>

            <td class="header-kanan">
                <div class="tujuan">
                    <p>Bapak Pimpinan Rumah Sakit</p>
                    <p>{{ $rumahSakit }}</p>
                    <p>Di</p>
                    <p class="indent">Blitar</p>
                </div>
            </td>
        </tr>
    </table>

    {{-- ISI SURAT --}}
    <div class="content">
        <p class="salam">Dengan Hormat .</p>

        <p class="paragraf">
            Sehubungan dengan berobat kembali seorang yang di rawat di rumah sakit ,
            {{ $sapaan }} {{ $namaPasien }} dengan alamat {{ $alamatPasien }}
            Dan menurut diagnosa Medis harus di rujuk ke Rumah {{ $rumahSakit }} {{ $lokasiRumahSakit }}.
        </p>

        <p class="paragraf">
            Sedangkan keadaan pasien atas nama {{ $sapaan }} {{ $namaPasien }}
            dilihat kenyataannya dan kondisi perekonomian keluarga pasien tersebut masih dalam kondisi
            miskin /tidak mampu dan pasien tidak masuk dalam data base peserta jamkesmas tahun 2012
            maupun data usulan peserta jamkesmas tahun 2013.
        </p>

        <p class="paragraf-tanpa-indent">
            Sehubungan dengan kondisi tersebut, kami atas nama KEPALA DESA KEMIRIGEDE Kecamatan Kesamben
            Kabupaten Blitar, sangat berharap bantuan Bapak untuk bias memberikan keringanan berobat
        </p>

        <p class="paragraf-tanpa-indent">
            Kepada {{ $sapaan }} {{ $namaPasien }} agar dapat dipergunakan untuk mendapatkan keringanan biaya
            pengobatan ke Rumah Sakit {{ $rumahSakit }} {{ $lokasiRumahSakit }}
        </p>

        <p class="paragraf">
            Demikian surat permohonan ini kami buat dengan sebenarnya dan atas terkabulnya
            permohon ini kami ucapkan terima kasih.
        </p>

        {{-- TANDA TANGAN --}}
        <table class="ttd-table">
            <tr>
                <td class="ttd-spacer"></td>
                <td class="ttd-cell">
                    <p>KEPALA DESA KEMIRIGEDE</p>

                    <div class="ttd-img-wrapper">
                        @if (file_exists($ttdKades))
                            <img src="{{ $ttdKades }}" class="ttd-img" alt="TTD Kepala Desa">
                        @endif
                    </div>

                    <p class="nama-kades">Hari Purnawan, S.Sos.</p>

                    @if (file_exists($barcodeSurat))
                        <div class="barcode">
                            <img src="{{ $barcodeSurat }}" alt="Barcode Surat">
                            <br>
                            <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
