<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Ahli Waris Desa</title>
    <style>
        @page {
            margin: 1.2cm 1.8cm 1.2cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.8pt;
            line-height: 1.5;
        }

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

        .tulisan {
            text-align: justify;
            margin: 4px 0;
        }

        .nomor-surat {
            text-align: center;
            margin-bottom: 10px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table.data td {
            padding: 4px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 180px;
        }

        .ttd-table {
            width: 100%;
            margin-top: 30px;
        }

        .ttd-cell {
            text-align: center;
        }

        .nama {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    @php
        $tanggalSurat = now('Asia/Jakarta') ->locale('id')->translatedFormat('d F Y');
        $tanggalMeninggal = \Carbon\Carbon::parse($data->tanggal_meninggal) ->locale('id')->translatedFormat('d F Y');
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
                    <div class="kop-desa-alamat">Jln. Kawi No. 4 Desa Kemirigede Telp. 082139324445</div>
                    <div class="kop-desa-kontak">
                        email : pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>
            </tr>
        </table>
        <hr class="kop-desa-garis">
    </div>

    <div class="judul-surat">SURAT KETERANGAN AHLI WARIS DESA</div>
    <div class="nomor-surat">Nomor : {{ $data->nomor_surat ?? '422.4/---/409.41.2/' . now()->year }}</div>

    <p>Kami yang bertanda tangan di bawah ini adalah ahli waris yang sah dari almarhum/almarhumah
        <strong>{{ $data->nama_almarhum }}</strong> yang meninggal dunia pada hari
        <strong>{{ $data->hari_meninggal }}</strong> di <strong>{{ $data->tempat_meninggal }}</strong> berdasarkan Surat
        Keterangan Kematian Penduduk No: <strong>{{ $data->nomor_surat_kematian }}</strong> tanggal
        {{ $tanggalMeninggal }}.
    </p>

    <p>Dengan ini menyatakan dengan sebenarnya bahwa hubungan kami dengan almarhum/almarhumah adalah sebagai berikut:
    </p>

    <table class="data">
        @foreach ($data->ahli_waris ?? [] as $index => $waris)
            <tr>
                <td>{{ $index + 1 }}. Nama</td>
                <td>:</td>
                <td>{{ $waris['nama'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Sesuai akta kelahiran/Kartu keluarga No</td>
                <td>:</td>
                <td>{{ $waris['no_akta'] ?? '' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $waris['alamat'] ?? '' }}</td>
            </tr>
        @endforeach
    </table>

    <p>Demikian surat keterangan ini kami buat dengan sebenarnya untuk mencairkan:</p>

    <p><strong>Simpanan:</strong><br>
        1. {{ $data->simpanan_jenis ?? '' }} (jenis simpanan), nomor rekening:
        <strong>{{ $data->simpanan_rekening ?? '' }}</strong><br>
        Atas nama <strong>{{ $data->simpanan_nama ?? $data->nama_almarhum }}</strong> di BRI Unit Kemirigede.
    </p>

    <table class="ttd-table">
        <tr>
            <td></td>
            <td class="ttd-cell">
                <p>Kemirigede, {{ $tanggalSurat }}</p>
                <p><strong>KEPALA DESA Kemirigede</strong></p>
                <br><br>
                <p class="nama"><u>Hari Purnawan, S.Sos.</u></p>
            </td>
        </tr>
    </table>

    {{-- Tanda Tangan Ahli Waris --}}
    <p><strong>Yang Menyatakan:</strong></p>
    @foreach ($data->ahli_waris ?? [] as $index => $waris)
        <p>{{ $index + 1 }}. {{ $waris['nama'] ?? '' }} ....................................</p>
    @endforeach
</body>

</html>
