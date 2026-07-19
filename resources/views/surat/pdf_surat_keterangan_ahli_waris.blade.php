<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Waris</title>

    <style>
        @page {
            size: A4;
            margin: 1.0cm 1.5cm 1.0cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            line-height: 1.25;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 8px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-logo {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 85px;
            height: auto;
        }

        .kop-desa-text {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-desa-1 {
            font-size: 13pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 13pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 10pt;
            margin-top: 1px;
        }

        .kop-desa-kontak {
            font-size: 9pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 4px 0 8px 0;
        }

        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 12.5pt;
            text-decoration: underline;
            margin: 6px 0 2px 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 10px;
        }

        .tulisan {
            text-align: justify;
            margin: 4px 0;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0;
        }

        table.data td {
            padding: 1.5px 4px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 150px;
        }

        table.data td:nth-child(2) {
            width: 10px;
        }

        .anak-list {
            margin: 2px 0 4px 20px;
            padding: 0;
        }

        .anak-list li {
            margin-bottom: 2px;
            padding-left: 4px;
        }

        /* KONTROL AREA BOTTOM AGAR TIDAK PECAH Halaman */
        .bottom-section {
            page-break-inside: avoid;
        }

        .saksi-ttd-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            margin-bottom: 4px;
            font-weight: bold;
        }

        table.saksi-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.saksi-table td {
            padding: 1.5px 2px;
            vertical-align: top;
        }

        .ttd-cell p {
            margin: 1px 0;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
            margin: 3px 0 2px 0;
        }

        .camat-section {
            width: 45%;
            text-align: center;
            margin-top: 8px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
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
                    <div class="kop-desa-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-desa-3">PEMERINTAH DESA Kemirigede</div>
                    <div class="kop-desa-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email : Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>
            </tr>
        </table>
        <hr class="kop-desa-garis">
    </div>

    {{-- JUDUL --}}
    <div class="judul-surat">SURAT KETERANGAN WARIS</div>
    <div class="nomor-surat">
        No : {{ $data->nomor_surat ?? '470 / --- / 409.41.2 / ' . now('Asia/Jakarta')->year }}
    </div>

    <p class="tulisan">
        Yang bertandatangan di bawah ini KEPALA DESA Kemirigede, Kecamatan Kesamben, Kabupaten Blitar,
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
        Menerangkan bahwa orang tersebut benar-benar penduduk Desa Kemirigede, Kecamatan Kesamben,
        Kabupaten Blitar dan benar memiliki ahli waris untuk
        <strong>{{ $data->hubungan_dengan_ahli_waris ?? '...........................................' }}</strong>.
    </p>

    <p class="tulisan">
        Demikian surat keterangan waris ini dibuat dengan sebenarnya dan dapat dipergunakan
        sebagaimana mestinya.
    </p>

    {{-- CONTAINER SAKSI & TTD (DIPAKSA TIDAK BISA BREAK HALAMAN) --}}
    <div class="bottom-section">
        <table class="saksi-ttd-table">
            <tr>
                <td class="saksi-cell">
                    <div class="saksi-title">Saksi-Saksi :</div>
                    <table class="saksi-table">
                        @for ($i = 0; $i < $jumlahSaksi; $i++)
                            <tr>
                                <td style="width: 15px;">{{ $i + 1 }}.</td>
                                <td style="width: 130px;">{{ $namaSaksi[$i] ?? '...........................................' }}</td>
                                <td style="width: 8px;">:</td>
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
                    <p><strong>KEPALA DESA Kemirigede</strong></p>

                    {{-- Jarak tanda tangan dioptimalkan dengan margin murni --}}
                    <div style="margin-top: 45px;"></div>

                    <p class="nama-kades">Hari Purnawan, S.Sos.</p>
                </td>
            </tr>
        </table>

        {{-- MENGETAHUI CAMAT --}}
        <div class="camat-section">
            <p><strong>Mengetahui</strong></p>
            <p><strong>CAMAT KESAMBEN</strong></p>
            <div style="margin-top: 45px;"></div>
            <p><strong><u>...........................................</u></strong></p>
        </div>
    </div>

</body>
</html>
