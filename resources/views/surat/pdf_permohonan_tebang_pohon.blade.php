<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Permohonan Tebang Pohon</title>

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
            margin-bottom: 12px;
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
        }

        .kop-text .kontak {
            font-size: 7.7pt;
            margin-top: 1px;
        }

        /* ================= META SURAT ================= */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .meta-table td {
            border: none;
            padding: 0 0 1px 0;
            font-size: 10.3pt;
            line-height: 1.18;
            vertical-align: top;
        }

        .meta-label {
            width: 78px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .meta-colon {
            width: 10px;
            text-align: center;
        }

        /* ================= ISI SURAT ================= */
        .content {
            width: 100%;
            font-size: 10.8pt;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .data-table td {
            border: none;
            padding: 0 0 2px 0;
            font-size: 10.8pt;
            line-height: 1.25;
            vertical-align: top;
        }

        .data-label {
            width: 78px;
        }

        .data-colon {
            width: 10px;
            text-align: center;
        }

        .paragraf {
            text-align: justify;
            margin-bottom: 7px;
            line-height: 1.28;
        }

        ol {
            margin-top: 4px;
            margin-bottom: 8px;
            padding-left: 20px;
        }

        ol li {
            text-align: justify;
            margin-bottom: 2px;
            line-height: 1.28;
        }

        /* ================= TANDA TANGAN ================= */
        .tanggal {
            width: 100%;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 2px;
            font-size: 10.5pt;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .ttd-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            text-align: center;
            font-size: 10.5pt;
        }

        .ttd-kiri {
            width: 50%;
        }

        .ttd-kanan {
            width: 50%;
        }

        .ttd-title {
            height: 18px;
        }

        .ttd-img-wrapper {
            margin: 5px auto 0 auto;
            width: 120px;
            height: 58px;
            text-align: center;
        }

        .ttd-img {
            max-width: 120px;
            max-height: 58px;
            display: inline-block;
        }

        .nama {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 3px;
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
        $tanggalSurat = !empty($data->tanggal_surat)
            ? \Carbon\Carbon::parse($data->tanggal_surat)->translatedFormat('d F Y')
            : now('Asia/Jakarta')->translatedFormat('d F Y');

        $nomorSurat = $data->nomor_surat ?? '522/ / 409.41.2/' . now('Asia/Jakarta')->year;

        $namaPemohon = $data->nama ?? 'SUTAJI';

        $jabatanPemohon = $data->jabatan ?? ($data->alamat ?? 'Dsn.KEMIRIGEDE RT 01 RW 01 Ds. KEMIRIGEDE Kec.KEMIRIGEDE Kab.Blitar');

        $alasanDefault = [
            'Pohon besar yang berada di pinggir jalan sudah terlalu besar sehingga jika terjadi hujan deras di sertai angina kencang di khawatirkan akan tumbang dan membahayakan bagi pengguna jalan, rumah sekitarnya dan fasilitas umum.',
            'Pohon kayu tersebut dalam keadaan jamuran dan sangat rapuh.',
            'Daun-daun kering yang berasal dari pohon tersebut jga menakibatkan kotor.',
            'Di daerah kami belum pernah di lakukan penebangan atau pemotongan pohon-pohon, tetapi memang pohon ini kondisi harus di tebang supaya tidak membahayakan orang banyak.',
        ];

        if (!empty($data->alasan_tebang)) {
            if (is_array($data->alasan_tebang)) {
                $alasanList = $data->alasan_tebang;
            } else {
                $alasanList = preg_split('/\r\n|\r|\n/', $data->alasan_tebang);
                $alasanList = array_filter($alasanList);
            }
        } else {
            $alasanList = $alasanDefault;
        }

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

    {{-- NOMOR DAN PERIHAL --}}
    <table class="meta-table">
        <tr>
            <td class="meta-label">NOMOR</td>
            <td class="meta-colon">:</td>
            <td>{{ $nomorSurat }}</td>
        </tr>
        <tr>
            <td class="meta-label">PERIHAL</td>
            <td class="meta-colon">:</td>
            <td>Permohonan Tebang pohon</td>
        </tr>
    </table>

    <div class="content">
        <p class="paragraf">Yang bertanda tangan dibawah ini :</p>

        <table class="data-table">
            <tr>
                <td class="data-label">Nama</td>
                <td class="data-colon">:</td>
                <td>{{ $namaPemohon }}</td>
            </tr>
            <tr>
                <td class="data-label">Jabatan</td>
                <td class="data-colon">:</td>
                <td>{{ $jabatanPemohon }}</td>
            </tr>
        </table>

        <p class="paragraf">
            Dengan surat ini saya atas nama warga {{ $jabatanPemohon }} , mengajukan untuk di lakukan
            untuk penebangan pohon yang berada di pinggir jalan sekitar tempat tinggal kami. Adapun
            alasan pengajuan ini sebagai berikut:
        </p>

        <ol>
            @foreach ($alasanList as $alasan)
                <li>{{ $alasan }}</li>
            @endforeach
        </ol>

        <p class="paragraf">
            Demikian surat permohonan ini kami buat agar sekiranya bapak/ibu bisa mempertimbangkan
            untuk di lakukan penebangan atau pemangkasan pohon-pohon yang berada di pinggir jalan
            sekitar wilayah tempat tinggal kami .Atas perhatianya saya ucapkan terima kasih.
        </p>

        {{-- TANDA TANGAN --}}
        <div class="tanggal">
            {{ $tanggalSurat }}
        </div>

        <table class="ttd-table">
            <tr>
                <td class="ttd-kiri">
                    <p>Mengetahui</p>
                </td>
                <td class="ttd-kanan"></td>
            </tr>
            <tr>
                <td class="ttd-kiri ttd-title">
                    <p>Yang Membuat pernyataan</p>
                </td>
                <td class="ttd-kanan ttd-title">
                    <p>KEPALA DESA KEMIRIGEDE</p>
                </td>
            </tr>
            <tr>
                <td class="ttd-kiri">
                    <div class="ttd-img-wrapper"></div>
                    <p class="nama">{{ $namaPemohon }}</p>
                </td>

                <td class="ttd-kanan">
                    <div class="ttd-img-wrapper">
                        @if (file_exists($ttdKades))
                            <img src="{{ $ttdKades }}" class="ttd-img" alt="TTD Kepala Desa">
                        @endif
                    </div>

                    <p class="nama">MOH. HAMID ALMAULUDI</p>

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
