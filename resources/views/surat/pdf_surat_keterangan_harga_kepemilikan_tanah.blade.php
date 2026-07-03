<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Harga Kepemilikan Tanah</title>

    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 14px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
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
            margin: 6px 0 12px 0;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 13.2pt;
            text-decoration: underline;
            margin: 8px 0 2px 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 10px;
        }

        .tulisan {
            text-align: justify;
            margin: 6px 0;
        }

        .nomor {
            width: 22px;
            vertical-align: top;
        }

        table.paragraf {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        table.paragraf td {
            vertical-align: top;
            padding: 2px 4px;
        }

        table.batas {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 8px 22px;
        }

        table.batas td {
            padding: 2px 4px;
            vertical-align: top;
        }

        table.batas td:first-child {
            width: 80px;
        }

        table.batas td:nth-child(2) {
            width: 10px;
        }

        table.data-pemilik {
            width: 100%;
            border-collapse: collapse;
            margin: 3px 0 8px 22px;
        }

        table.data-pemilik td {
            padding: 2px 4px;
            vertical-align: top;
        }

        table.data-pemilik td:first-child {
            width: 95px;
        }

        table.data-pemilik td:nth-child(2) {
            width: 10px;
        }

        table.harga {
            width: 70%;
            border-collapse: collapse;
            margin: 8px 0 8px 45px;
        }

        table.harga td {
            padding: 2px 4px;
            vertical-align: top;
        }

        table.harga td:first-child {
            width: 110px;
        }

        table.harga td:nth-child(2) {
            width: 10px;
        }

        .ttd-table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
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
            margin: 2px 0;
        }

        .ttd-img-wrapper {
            height: 55px;
            margin: 5px 0 3px 0;
            text-align: center;
        }

        .ttd-img {
            width: 165px;
            height: auto;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            margin: 3px 0 2px 0;
        }

        .qr-section {
            margin-top: 6px;
            text-align: center;
        }

        .qr-section img {
            width: 78px;
            height: auto;
        }

        .qr-section small {
            font-size: 7.3pt;
            color: #555;
            display: block;
            margin-top: 2px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>

<body>

    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');

        $jenisObjek =
            $data->jenis_objek ??
            ($data->jenis_tanah_bangunan ?? ($data->tanah_dan ?? '...........................................'));

        $dusun = $data->dusun ?? 'KEMIRIGEDE';
        $rt = $data->rt ?? '...';
        $rw = $data->rw ?? '...';

        $noPersil = $data->no_persil ?? ($data->persil ?? '...');
        $noSppt = $data->no_sppt ?? ($data->sppt ?? '...');
        $luasTanah = $data->luas_tanah ?? ($data->luas ?? '...');
        $noSertifikat = $data->no_sertifikat ?? ($data->sertifikat_no ?? ($data->sertifikat ?? '...'));
        $luasSertifikat = $data->luas_sertifikat ?? ($data->luas_bangunan ?? '...');
        $atasNamaHakMilik =
            $data->atas_nama_hak_milik ??
            ($data->atas_nama ?? ($data->nama ?? '...........................................'));

        $batasUtara = $data->batas_utara ?? ($data->utara ?? '...........................................');
        $batasTimur = $data->batas_timur ?? ($data->timur ?? '...........................................');
        $batasSelatan = $data->batas_selatan ?? ($data->selatan ?? '...........................................');
        $batasBarat = $data->batas_barat ?? ($data->barat ?? '...........................................');

        $namaPemilik =
            $data->nama ??
            ($data->nama_pemilik ?? ($data->atas_nama_hak_milik ?? '...........................................'));

        $alamatPemilik =
            $data->alamat ??
            ($data->alamat_pemilik ?? 'Dusun ........ RT ... RW ... Desa KEMIRIGEDE Kecamatan Kesamben Kabupaten Blitar');

        $pekerjaanPemilik =
            $data->pekerjaan ?? ($data->pekerjaan_pemilik ?? '...........................................');

        $tertulisAtasNama = $data->tertulis_atas_nama ?? ($data->atas_nama_hak_milik ?? $atasNamaHakMilik);

        $hargaTanah = $data->harga_tanah ?? ($data->nilai_tanah ?? null);
        $hargaBangunan = $data->harga_bangunan ?? ($data->nilai_bangunan ?? null);
        $jumlahHarga = $data->harga_jumlah ?? ($data->jumlah_harga ?? ($data->total_harga ?? ($data->jumlah ?? null)));

        if (($jumlahHarga === null || $jumlahHarga === '') && !empty($hargaTanah) && !empty($hargaBangunan)) {
            $angkaTanah = (int) preg_replace('/[^0-9]/', '', (string) $hargaTanah);
            $angkaBangunan = (int) preg_replace('/[^0-9]/', '', (string) $hargaBangunan);
            $jumlahHarga = $angkaTanah + $angkaBangunan;
        }

        if (!function_exists('formatRupiahPdf')) {
            function formatRupiahPdf($value)
            {
                if ($value === null || $value === '') {
                    return '...........................................';
                }

                $angka = preg_replace('/[^0-9]/', '', (string) $value);

                if ($angka === '') {
                    return $value;
                }

                return number_format((int) $angka, 0, ',', '.');
            }
        }
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

                <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa KEMIRIGEDE">
                </td>
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    {{-- JUDUL --}}
    <div class="judul-surat">
        SURAT KETERANGAN HARGA KEPEMILIKAN TANAH
    </div>

    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '594 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <p class="tulisan">
        Yang bertandatangan di bawah ini KEPALA DESA KEMIRIGEDE, Kecamatan Kesamben, Kabupaten Blitar,
        menerangkan dengan sebenarnya bahwa :
    </p>

    {{-- ISI SURAT --}}
    <table class="paragraf">
        <tr>
            <td class="nomor">1.</td>
            <td>
                Sebidang tanah dan {{ $jenisObjek }} yang terletak di Dusun {{ $dusun }}
                RT {{ $rt }} RW {{ $rw }} Desa KEMIRIGEDE, No persil : {{ $noPersil }},
                No SPPT : {{ $noSppt }}, Seluas {{ $luasTanah }} M<sup>2</sup>,
                Sertifikat no {{ $noSertifikat }}, Luas {{ $luasSertifikat }},
                atas nama hak milik {{ $atasNamaHakMilik }} dengan batas-batas:
            </td>
        </tr>
    </table>

    <table class="batas">
        <tr>
            <td>Utara</td>
            <td>:</td>
            <td>{{ $batasUtara }}</td>
        </tr>
        <tr>
            <td>Timur</td>
            <td>:</td>
            <td>{{ $batasTimur }}</td>
        </tr>
        <tr>
            <td>Selatan</td>
            <td>:</td>
            <td>{{ $batasSelatan }}</td>
        </tr>
        <tr>
            <td>Barat</td>
            <td>:</td>
            <td>{{ $batasBarat }}</td>
        </tr>
    </table>

    <table class="paragraf">
        <tr>
            <td class="nomor">2.</td>
            <td>
                Adapun tanah dan {{ $jenisObjek }} tersebut betul-betul milik :
            </td>
        </tr>
    </table>

    <table class="data-pemilik">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $namaPemilik }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $alamatPemilik }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $pekerjaanPemilik }}</td>
        </tr>
    </table>

    <table class="paragraf">
        <tr>
            <td class="nomor">3.</td>
            <td>
                Tanah sampai surat ini dibuat, tertulis atas nama {{ $tertulisAtasNama }}
                dan tidak menjadi perselisihan orang lain.
            </td>
        </tr>
    </table>

    <table class="paragraf">
        <tr>
            <td class="nomor">4.</td>
            <td>
                Tanah dan bangunan rumah tersebut dinilai dengan harga :
            </td>
        </tr>
    </table>

    <table class="harga">
        <tr>
            <td>- Tanah</td>
            <td>:</td>
            <td>Rp. {{ formatRupiahPdf($hargaTanah) }}</td>
        </tr>
        <tr>
            <td>- Bangunan</td>
            <td>:</td>
            <td>Rp. {{ formatRupiahPdf($hargaBangunan) }}</td>
        </tr>
        <tr>
            <td><strong>Jumlah</strong></td>
            <td>:</td>
            <td><strong>Rp. {{ formatRupiahPdf($jumlahHarga) }}</strong></td>
        </tr>
    </table>

    <p class="tulisan">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk menjadikan periksa
        dan guna seperlunya.
    </p>

    {{-- TANDA TANGAN + QR --}}
    <table class="ttd-table">
        <tr>
            <td class="ttd-spacer"></td>
            <td class="ttd-cell">
                <p>Blitar, {{ $tanggalSurat }}</p>
                <p><strong>KEPALA DESA KEMIRIGEDE</strong></p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <p class="nama-kades">Hari Purnawan, S.Sos.</p>

                <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
