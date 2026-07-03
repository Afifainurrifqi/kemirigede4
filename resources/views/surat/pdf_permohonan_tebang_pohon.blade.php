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
            margin-bottom: 12px;
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
            margin: 5px 0 12px 0;
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

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 5px 0 12px 0;
            }
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

        $ttdKades = public_path('assets/images/ttd.png');
        $barcodeSurat = public_path('assets/images/barcode.png');
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
            Blitar, {{ $tanggalSurat }}
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

                    <p class="nama">Hari Purnawan, S.Sos.</p>

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
