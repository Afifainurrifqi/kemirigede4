<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Ahli Waris Desa</title>
    <style>
        @page { margin: 1.2cm 1.8cm 1.2cm 1.8cm; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.8pt;
            line-height: 1.5;
        }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 12%; text-align: center; vertical-align: top; }
        .kop-logo img { width: 72px; }
        .kop-text { text-align: center; vertical-align: top; }
        .kop-garis { border: none; border-top: 3px solid #000; margin: 8px 0 12px 0; }
        .judul { text-align: center; font-weight: bold; font-size: 14pt; text-decoration: underline; margin: 20px 0 5px; }
        .nomor { text-align: center; margin-bottom: 20px; }
        table.data { width: 100%; border-collapse: collapse; margin: 10px 0; }
        table.data td { padding: 4px 6px; vertical-align: top; }
        table.data td:first-child { width: 180px; }
        .ttd-table { width: 100%; margin-top: 30px; }
        .ttd-cell { text-align: center; }
        .nama { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');
        $tanggalMeninggal = \Carbon\Carbon::parse($data->tanggal_meninggal)->translatedFormat('d F Y');
    @endphp

    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo">
            </td>
            <td class="kop-text">
                <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
                <strong>KECAMATAN WATES</strong><br>
                <strong>KANTOR KEPALA DESA WATES</strong><br>
                <small>Jl. Merdeka No. 74 Telp. 082139324445<br>
                email: watesberkelas@gmail.com | website: wates-blitarkab.desa.id</small>
            </td>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa">
            </td>
        </tr>
    </table>
    <hr class="kop-garis">

    <div class="judul">SURAT KETERANGAN AHLI WARIS DESA</div>
    <div class="nomor">Nomor : {{ $data->nomor_surat ?? '422.4/---/409.41.2/' . now()->year }}</div>

    <p>Kami yang bertanda tangan di bawah ini adalah ahli waris yang sah dari almarhum/almarhumah <strong>{{ $data->nama_almarhum }}</strong> yang meninggal dunia pada hari <strong>{{ $data->hari_meninggal }}</strong> di <strong>{{ $data->tempat_meninggal }}</strong> berdasarkan Surat Keterangan Kematian Penduduk No: <strong>{{ $data->nomor_surat_kematian }}</strong> tanggal {{ $tanggalMeninggal }}.</p>

    <p>Dengan ini menyatakan dengan sebenarnya bahwa hubungan kami dengan almarhum/almarhumah adalah sebagai berikut:</p>

    <table class="data">
        @foreach($data->ahli_waris ?? [] as $index => $waris)
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
    1. {{ $data->simpanan_jenis ?? '' }} (jenis simpanan), nomor rekening: <strong>{{ $data->simpanan_rekening ?? '' }}</strong><br>
    Atas nama <strong>{{ $data->simpanan_nama ?? $data->nama_almarhum }}</strong> di BRI Unit Wates.</p>

    <table class="ttd-table">
        <tr>
            <td></td>
            <td class="ttd-cell">
                <p>Wates, {{ $tanggalSurat }}</p>
                <p><strong>Kepala Desa Wates</strong></p>
                <br><br>
                <p class="nama"><u>MOH. HAMID ALMAULUDI, S.Pd.I</u></p>
            </td>
        </tr>
    </table>

    {{-- Tanda Tangan Ahli Waris --}}
    <p><strong>Yang Menyatakan:</strong></p>
    @foreach($data->ahli_waris ?? [] as $index => $waris)
        <p>{{ $index + 1 }}. {{ $waris['nama'] ?? '' }} ....................................</p>
    @endforeach
</body>
</html>
