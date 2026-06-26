<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pengajuan User ID (F-3.01)</title>
    <style>
        @page { margin: 1.2cm 1.6cm 1.2cm 1.6cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 10.5pt; line-height: 1.3; }
        .kop { text-align: center; margin-bottom: 8px; }
        .kop strong { font-size: 11pt; }
        .judul { text-align: center; font-weight: bold; margin: 8px 0; font-size: 11.5pt; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 4px 6px; font-size: 9.5pt; }
        .ttd { margin-top: 25px; width: 100%; }
        .ttd td { border: none; }
    </style>
</head>
<body>

    <div class="kop">
        <strong>PEMERINTAH KABUPATEN BLITAR<br>
        KECAMATAN KEMIRIGEDE<br>
        KANTOR KEPALA DESA KEMIRIGEDE</strong><br>
        <small>Jln. Merdeka No. 74 Telp. 082139324445</small>
    </div>

    <div class="judul">FORMULIR PENGAJUAN USER ID (F-3.01)</div>

    <p><strong>Kepada Yth.</strong><br>
    Menteri Dalam Negeri<br>
    c.q Direktur Jenderal Kependudukan dan Pencatatan Sipil<br>
    di Jakarta</p>

    <p>Dengan ini kami mengajukan permohonan User ID dengan rincian sebagai berikut:</p>

    <table>
        <tr><td width="30%"><strong>Nama Instansi</strong></td><td>: {{ $data->instansi_pemohon ?? '-' }}</td></tr>
        <tr><td><strong>Alamat</strong></td><td>: {{ $data->alamat_instansi ?? '-' }}</td></tr>
        <tr><td><strong>Nama Pemohon</strong></td><td>: {{ $data->nama_pemohon ?? '-' }}</td></tr>
        <tr><td><strong>NIK Pemohon</strong></td><td>: {{ $data->nik_pemohon ?? '-' }}</td></tr>
        <tr><td><strong>Jabatan</strong></td><td>: {{ $data->jabatan_pemohon ?? '-' }}</td></tr>
    </table>

    <p><strong>Daftar Personil yang Diajukan:</strong></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Tempat / Tanggal Lahir</th>
            </tr>
        </thead>
        <tbody>
            @php $personil = $data->personil ?? []; @endphp
            @for($i = 1; $i <= 4; $i++)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $personil[$i]['nik'] ?? '' }}</td>
                <td>{{ $personil[$i]['nama'] ?? '' }}</td>
                <td>{{ $personil[$i]['jenis_kelamin'] ?? '' }}</td>
                <td>{{ $personil[$i]['ttl'] ?? '' }}</td>
            </tr>
            @endfor
        </tbody>
    </table>

    <p>Kami bertanggung jawab penuh atas penggunaan User ID ini sesuai ketentuan yang berlaku.</p>

    <table class="ttd">
        <tr>
            <td width="55%"></td>
            <td width="45%" style="text-align: center;">
                KEMIRIGEDE, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}<br>
                Yang Mengajukan,<br><br><br><br>
                <u><strong>{{ $data->nama_pemohon ?? '...........................................' }}</strong></u><br>
                NIK. {{ $data->nik_pemohon ?? '...........................................' }}
            </td>
        </tr>
    </table>

</body>
</html>

