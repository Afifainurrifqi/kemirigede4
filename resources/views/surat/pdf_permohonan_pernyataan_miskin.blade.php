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
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10.8pt;
            line-height: 1.28;
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
            border-bottom: 4px solid #000;
            margin-bottom: 9px;
        }

        .kop-logo {
            width: 13%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 72px;
            height: auto;
        }

        .kop-text {
            width: 74%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.03;
            padding-bottom: 3px;
        }

        .kop-text .kabupaten {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .kop-text .kecamatan {
            font-size: 12.5pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .kop-text .desa {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.2px;
        }

        .kop-text .alamat {
            font-size: 9.5pt;
            margin-top: 1px;
            font-weight: normal;
        }

        .kop-text .kontak {
            font-size: 7.7pt;
            margin-top: 1px;
            font-weight: normal;
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
    </style>
</head>

<body>

    @php
        $sapaan = $data->sapaan_pasien ?? 'Tn.';
        $namaPasien = $data->nama_pasien ?? 'Cornelius Tri Utomo';
        $alamatPasien = $data->alamat_pasien ?? 'Dusun KEMIRIGEDE RT 02 RW 03 Desa KEMIRIGEDE Kec. KEMIRIGEDE Kab. Blitar';
        $rumahSakit = $data->rumah_sakit_tujuan ?? 'Ngudi Waluyo';
        $lokasiRumahSakit = $data->lokasi_rumah_sakit ?? 'Wlingi';

        $logoKabupaten = file_exists(public_path('assets/images/blitar.jpg'))
            ? public_path('assets/images/blitar.jpg')
            : public_path('assets/images/logo-blitar.png');

        $logoDesa = file_exists(public_path('assets/images/KEMIRIGEDE.png'))
            ? public_path('assets/images/KEMIRIGEDE.png')
            : public_path('assets/images/logo-desa-KEMIRIGEDE.png');

        $ttdKades = public_path('assets/images/ttd.png');
        $barcodeSurat = public_path('assets/images/barcode_surat.png');
    @endphp

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if (file_exists($logoKabupaten))
                    <img src="{{ $logoKabupaten }}" alt="Logo Kabupaten Blitar">
                @endif
            </td>

            <td class="kop-text">
                <div class="kabupaten">PEMERINTAH KABUPATEN BLITAR</div>
                <div class="kecamatan">KECAMATAN KEMIRIGEDE</div>
                <div class="desa">KANTOR KEPALA DESA KEMIRIGEDE</div>
                <div class="alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                <div class="kontak">email :KEMIRIGEDEberkelas@gmail.com / website : KEMIRIGEDE-blitarkab.desa.id</div>
            </td>

            <td class="kop-logo">
                @if (file_exists($logoDesa))
                    <img src="{{ $logoDesa }}" alt="Logo Desa KEMIRIGEDE">
                @endif
            </td>
        </tr>
    </table>

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
            Sehubungan dengan kondisi tersebut, kami atas nama Kepala Desa KEMIRIGEDE Kecamatan KEMIRIGEDE
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
                    <p>Kepala Desa KEMIRIGEDE</p>

                    <div class="ttd-img-wrapper">
                        @if (file_exists($ttdKades))
                            <img src="{{ $ttdKades }}" class="ttd-img" alt="TTD Kepala Desa">
                        @endif
                    </div>

                    <p class="nama-kades">MOH.HAMID ALMAULUDI</p>

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
