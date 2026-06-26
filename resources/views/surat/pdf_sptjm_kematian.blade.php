<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Ghoib</title>
    <style>
        @page { margin: 1cm 1.5cm 1cm 1.5cm; }
        body { font-family: 'Times New Roman', serif; font-size: 11.5pt; line-height: 1.5; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 12%; text-align: center; }
        .kop-logo img { width: 70px; }
        .kop-text { text-align: center; }
        .kop-garis { border: none; border-top: 3px solid #000; margin: 8px 0 12px 0; }
        .judul { text-align: center; font-weight: bold; font-size: 14pt; text-decoration: underline; margin: 20px 0 8px; }
        .nomor { text-align: center; margin-bottom: 20px; }
        table.data { width: 100%; border-collapse: collapse; margin: 12px 0; }
        table.data td { padding: 4px 6px; vertical-align: top; }
        table.data td:first-child { width: 190px; }
        .ttd-wrapper { width: 100%; margin-top: 40px; }
        .ttd-left, .ttd-right { width: 50%; float: left; text-align: center; }
        .signature-line { border-bottom: 1px solid #000; width: 180px; margin: 25px auto 8px auto; }
        .materai { border: 1px solid #000; padding: 4px 12px; display: inline-block; font-size: 9pt; margin: 8px 0; }
    </style>
</head>
<body>
    @php
        $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');
        $tanggalPernyataan = !empty($data->tanggal_pernyataan) ? \Carbon\Carbon::parse($data->tanggal_pernyataan)->translatedFormat('d F Y') : '................................';
        $tanggalHilang = !empty($data->tanggal_hilang) ? \Carbon\Carbon::parse($data->tanggal_hilang)->translatedFormat('d F Y') : '................................';
    @endphp

    <!-- KOP -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo"><img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo"></td>
            <td class="kop-text">
                <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
                <strong>KECAMATAN WATES</strong><br>
                <strong>KANTOR KEPALA DESA WATES</strong><br>
                <small>Jl. Merdeka No. 74 Telp. 082139324445<br>
                email: watesberkelas@gmail.com / website : wates-blitar.kab.desa.id</small>
            </td>
            <td class="kop-logo"><img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa"></td>
        </tr>
    </table>
    <hr class="kop-garis">

    <div class="judul">SURAT KETERANGAN GHOIB</div>
    <div class="nomor">Nomor : {{ $data->nomor_surat ?? '145/ /409.41.2/' . now()->year }}</div>

    <p>Berdasarkan surat Pernyataan pada tanggal <strong>{{ $tanggalPernyataan }}</strong> yang menyatakan dengan sebenarnya bahwa :</p>

    <table class="data">
        <tr><td>Nama</td><td>:</td><td>{{ $data->nama_pemohon ?? '................................' }}</td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td>{{ $data->tempat_lahir ?? '' }}, {{ $data->tanggal_lahir ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') : '' }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $data->jenis_kelamin ?? '................................' }}</td></tr>
        <tr><td>Kebangsaan</td><td>:</td><td>{{ $data->kewarganegaraan ?? 'Indonesia' }}</td></tr>
        <tr><td>Agama</td><td>:</td><td>{{ $data->agama ?? '................................' }}</td></tr>
        <tr><td>Status</td><td>:</td><td>{{ $data->status ?? '................................' }}</td></tr>
        <tr><td>Pekerjaan</td><td>:</td><td>{{ $data->pekerjaan ?? '................................' }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat ?? '................................' }}</td></tr>
    </table>

    <p>Orang tersebut diatas benar-benar penduduk Desa Wates Kecamatan Wates Kabupaten Blitar, benar-benar menyatakan bahwa {{ $data->nama_suami_istri ?? '................................' }} telah pergi meninggalkan keluarga sejak tanggal {{ $tanggalHilang }} dan sekarang tidak diketahui alamatnya dengan jelas dan pasti diwilayah Republik Indonesia.</p>

    <p>Selanjutnya surat keterangan ini dipergunakan untuk melengkapi persyaratan <strong>{{ $data->keperluan ?? 'Pengajuan Perceraian' }}</strong>.</p>

    <p>Demikian Surat Keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <!-- TTD -->
    <div class="ttd-wrapper">
        <div class="ttd-left">
            <p><strong>Pemegang Surat</strong></p>
            <div class="signature-line"></div>
            <p>{{ $data->nama_pemohon ?? '................................' }}</p>
        </div>

        <div class="ttd-right">
            <p>Wates, {{ $tanggalSurat }}</p>
            <p><strong>Kepala Desa Wates</strong></p>
            <div class="materai">Materai<br>10.000</div>
            <div class="signature-line"></div>
            <p><u>MOH. HAMID ALMAULUDI, S.Pd.I</u></p>
        </div>
    </div>
</body>
</html>
