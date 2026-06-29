<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Waris</title>

    <style>
        @page {
            margin: 1.15cm 1.8cm 1.15cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.3pt;
            line-height: 1.33;
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
            font-size: 13.5pt;
            text-decoration: underline;
            margin: 12px 0 4px 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 16px;
        }

        .tulisan {
            text-align: justify;
            margin: 6px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 10px 0;
        }

        table.data td {
            padding: 2.5px 5px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 165px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .anak-list {
            margin: 4px 0 8px 22px;
            padding: 0;
        }

        .anak-list li {
            margin-bottom: 3px;
            padding-left: 4px;
        }

        .saksi-ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 18px;
        }

        .saksi-cell {
            width: 52%;
            vertical-align: top;
        }

        .ttd-cell {
            width: 48%;
            text-align: center;
            vertical-align: top;
        }

        .saksi-title {
            margin-bottom: 6px;
            font-weight: bold;
        }

        table.saksi-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.saksi-table td {
            padding: 2px 3px;
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

        .camat-section {
            width: 45%;
            text-align: center;
            margin-top: 10px;
        }

        .space-camat {
            height: 55px;
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

        $tanggalLahir = !empty($data->tanggal_lahir)
            ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')
            : '...........................................';

        $tanggalLahirIstri = !empty($data->tanggal_lahir_istri)
            ? \Carbon\Carbon::parse($data->tanggal_lahir_istri)->translatedFormat('d F Y')
            : '...........................................';

        $namaAnak = (array) ($data->nama_anak ?? []);
        $namaSaksi = (array) ($data->nama_saksi ?? []);
        $nikSaksi = (array) ($data->nik_saksi ?? []);

        $jumlahAnak = max((int) ($data->jumlah_anak ?? count($namaAnak)), count($namaAnak), 2);
        $jumlahSaksi = max((int) ($data->jumlah_saksi ?? count($namaSaksi)), count($namaSaksi), 2);
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
                    <div class="kop-desa-2">KECAMATAN KEMIRIGEDE</div>
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
        SURAT KETERANGAN WARIS
    </div>

    <div class="nomor-surat">
        No : {{ $data->nomor_surat ?? '470 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <p class="tulisan">
        Yang bertandatangan di bawah ini Kepala Desa KEMIRIGEDE, Kecamatan KEMIRIGEDE, Kabupaten Blitar,
        menerangkan dengan sebenarnya bahwa :
    </p>

    {{-- DATA UTAMA --}}
    <table class="data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $data->nama_lengkap ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir ?? '...........................................' }}, {{ $tanggalLahir }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $data->agama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $data->pekerjaan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>No KTP</td>
            <td>:</td>
            <td>{{ $data->no_ktp ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $data->status ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Orang tersebut di atas adalah benar-benar penduduk kami dan benar pernah menikah dengan
        seorang perempuan bernama:
    </p>

    {{-- DATA ISTRI --}}
    <table class="data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $data->nama_istri ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $data->tempat_lahir_istri ?? '...........................................' }}, {{ $tanggalLahirIstri }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $data->agama_istri ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $data->pekerjaan_istri ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ $data->status_istri ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>No KTP</td>
            <td>:</td>
            <td>{{ $data->no_ktp_istri ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $data->alamat_istri ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Dan dikaruniai {{ $data->jumlah_anak ?? $jumlahAnak }} orang anak sebagai ahli warisnya yaitu:
    </p>

    <ol class="anak-list">
        @for ($i = 0; $i < $jumlahAnak; $i++)
            <li>{{ $namaAnak[$i] ?? '...........................................' }}</li>
        @endfor
    </ol>

    <p class="tulisan">
        Menerangkan bahwa orang tersebut benar-benar penduduk Desa KEMIRIGEDE, Kecamatan KEMIRIGEDE,
        Kabupaten Blitar dan benar memiliki ahli waris untuk
        <strong>{{ $data->hubungan_dengan_ahli_waris ?? '...........................................' }}</strong>.
    </p>

    <p class="tulisan">
        Demikian surat keterangan waris ini dibuat dengan sebenarnya dan dapat dipergunakan
        sebagaimana mestinya.
    </p>

    {{-- SAKSI DAN TANDA TANGAN --}}
    <table class="saksi-ttd-table">
        <tr>
            <td class="saksi-cell">
                <div class="saksi-title">Saksi-Saksi :</div>

                <table class="saksi-table">
                    @for ($i = 0; $i < $jumlahSaksi; $i++)
                        <tr>
                            <td style="width: 18px;">{{ $i + 1 }}.</td>
                            <td style="width: 140px;">{{ $namaSaksi[$i] ?? '...........................................' }}</td>
                            <td style="width: 10px;">:</td>
                            <td>__________________</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NIK</td>
                            <td>:</td>
                            <td>{{ $nikSaksi[$i] ?? '...........................................' }}</td>
                        </tr>
                    @endfor
                </table>
            </td>

            <td class="ttd-cell">
                <p>Blitar, {{ $tanggalSurat }}</p>
                <p><strong>Kepala Desa KEMIRIGEDE</strong></p>

                <div class="ttd-img-wrapper">
                    <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
                </div>

                <p class="nama-kades">MOH. HAMID ALMAULUDI, S.Pd.I</p>

                <div class="qr-section">
                    <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR Code">
                    <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
                </div>
            </td>
        </tr>
    </table>

    {{-- MENGETAHUI CAMAT --}}
    <div class="camat-section">
        <p><strong>Mengetahui</strong></p>
        <p><strong>CAMAT KEMIRIGEDE</strong></p>
        <div class="space-camat"></div>
        <p><strong><u>...........................................</u></strong></p>
    </div>

</body>
</html>
