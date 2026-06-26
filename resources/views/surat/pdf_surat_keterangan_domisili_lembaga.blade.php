<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Domisili Lembaga</title>
    <style>
        @page { margin: 1.15cm 1.8cm 1.15cm 1.8cm; }
        body { font-family: 'Times New Roman', serif; font-size: 11.8pt; line-height: 1.4; }
        .kop-container { width: 100%; margin-bottom: 10px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 12%; text-align: center; vertical-align: top; }
        .kop-logo img { width: 72px; height: auto; }
        .kop-text { text-align: center; vertical-align: top; }
        .kop-text strong { font-size: 12.8pt; line-height: 1.2; }
        .kop-text small { font-size: 9.2pt; line-height: 1.1; }
        .kop-garis { border: none; border-top: 2.8px solid #000; margin: 8px 0 12px 0; }
        .judul-surat { text-align: center; font-weight: bold; font-size: 14pt; text-decoration: underline; margin: 18px 0 4px 0; }
        .nomor-surat { text-align: center; margin-bottom: 20px; }
        .tulisan { text-align: justify; margin-bottom: 9px; }
        table.data { width: 100%; border-collapse: collapse; margin: 10px 0 15px 0; }
        table.data td { padding: 4px 6px; vertical-align: top; }
        table.data td:first-child { width: 165px; }
        table.data td:nth-child(2) { width: 10px; }
        .ttd-table { width: 100%; margin-top: 25px; }
        .ttd-spacer { width: 52%; }
        .ttd-cell { width: 48%; text-align: center; }
        .ttd-cell p { margin: 2px 0; }
        .ttd-img-wrapper { height: 52px; margin-bottom: 3px; text-align: center; }
        .ttd-img { width: 170px; height: auto; }
        .nama { font-weight: bold; text-decoration: underline; margin: 4px 0 2px 0; }
        .qr-section { margin-top: 8px; text-align: center; }
        .qr-section img { width: 85px; height: auto; }
        .qr-section small { font-size: 7.5pt; color: #555; display: block; margin-top: 2px; }
    </style>
</head>
<body>

@php
    $tanggalSurat = now('Asia/Jakarta')->translatedFormat('d F Y');
@endphp

{{-- KOP --}}
<div class="kop-container">
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
            </td>
            <td class="kop-text">
                <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
                <strong>KECAMATAN KEMIRIGEDE</strong><br>
                <strong>KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
                <small>Jln. Merdeka No. 74 Telp. 082139324445<br>Email: KEMIRIGEDEberkelas@gmail.com | Website: KEMIRIGEDE-blitarkab.desa.id</small>
            </td>
            <td class="kop-logo">
                <img src="{{ public_path('assets/images/KEMIRIGEDE.png') }}" alt="Logo Desa">
            </td>
        </tr>
    </table>
    <hr class="kop-garis">
</div>

<div class="judul-surat">SURAT KETERANGAN DOMISILI</div>
<div class="nomor-surat">Nomor : {{ $data->nomor_surat ?? '220 / --- / 409.41.2 / ' . now()->year }}</div>

<p class="tulisan">Yang bertanda tangan di bawah ini:</p>

<table class="data">
    <tr><td>Nama</td><td>:</td><td>{{ $data->nama_pengurus ?? 'MOH. HAMID ALMAULUDI' }}</td></tr>
    <tr><td>Jabatan</td><td>:</td><td>Kepala Desa</td></tr>
    <tr><td>Alamat</td><td>:</td><td>Dsn. Sidomulyo RT 04 RW 01 Desa KEMIRIGEDE, Kecamatan KEMIRIGEDE</td></tr>
</table>

<p class="tulisan">Dengan ini menerangkan dengan sebenarnya bahwa :</p>

<table class="data">
    <tr><td>Nama Lembaga</td><td>:</td><td>{{ $data->nama_lembaga }}</td></tr>
    <tr><td>Jenis Kegiatan</td><td>:</td><td>{{ $data->jenis_kegiatan }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat_lembaga }}</td></tr>
</table>

<p class="tulisan">Dengan Pengurus (Ketua)</p>

<table class="data">
    <tr><td>Nama</td><td>:</td><td>{{ $data->nama_pengurus }}</td></tr>
    <tr><td>NIK</td><td>:</td><td>{{ $data->nik_pengurus }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ $data->alamat_pengurus }}</td></tr>
</table>

<p class="tulisan">
    Lembaga tersebut di atas adalah benar-benar berdomisili di Desa KEMIRIGEDE Kecamatan KEMIRIGEDE Kabupaten Blitar.
    Dan sampai saat ini masih aktif. Surat keterangan ini dipergunakan untuk {{ $data->keterangan_tambahan ?? '....................' }}.
</p>

<p class="tulisan">
    Demikian Surat Keterangan Domisili ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
</p>

<table class="ttd-table">
    <tr>
        <td class="ttd-spacer"></td>
        <td class="ttd-cell">
            <p>KEMIRIGEDE, {{ $tanggalSurat }}</p>
            <p><strong>Kepala Desa KEMIRIGEDE</strong></p>
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="TTD">
            </div>
            <p class="nama"><u>MOH. HAMID ALMAULUDI, S.Pd.I</u></p>
            <div class="qr-section">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="QR">
                <small>Scan untuk verifikasi surat resmi Desa KEMIRIGEDE</small>
            </div>
        </td>
    </tr>
</table>

</body>
</html>
