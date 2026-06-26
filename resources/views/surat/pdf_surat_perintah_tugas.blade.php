<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Perintah Tugas</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; line-height: 1.6; }
        .kop { text-align: center; margin-bottom: 30px; border-bottom: 3px solid black; padding-bottom: 10px; }
        .kop h1 { margin: 0; font-size: 18px; }
        .kop p { margin: 2px 0; font-size: 14px; }
        .judul { text-align: center; font-size: 18px; font-weight: bold; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        td { padding: 6px; vertical-align: top; }
        .ttd { text-align: right; margin-top: 50px; }
        .ttd img { width: 180px; }
        .nomor { text-align: center; font-weight: bold; margin: 10px 0; }
    </style>
</head>
<body>

    <div class="kop">
        <h1>PEMERINTAH KABUPATEN BLITAR</h1>
        <h1>KECAMATAN KEMIRIGEDE</h1>
        <h1>KANTOR KEPALA DESA KEMIRIGEDE</h1>
        <p>Jl. Merdeka No. 74 Telp. 082139324445</p>
        <p>email: KEMIRIGEDEberkelas@gmail.com | website: KEMIRIGEDE-blitarkab.desa.id</p>
    </div>

    <div class="judul">SURAT PERINTAH TUGAS</div>
    <div class="nomor">Nomor : {{ $data->nomor_surat ?? '...' }}</div>

    <p><strong>Dasar :</strong></p>
    <ol>
        @if($data->dasar && count($data->dasar) > 0)
            @foreach($data->dasar as $d)
                <li>{{ $d }}</li>
            @endforeach
        @else
            <li>Surat Undangan / Kebutuhan terkait</li>
        @endif
    </ol>

    <p><strong>Diperintahkan kepada :</strong></p>

    <table>
        <tr>
            <td width="30%">1. Nama</td>
            <td>: {{ $data->nama_penerima }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: {{ $data->jabatan_penerima }}</td>
        </tr>
        @if($data->nik_penerima)
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik_penerima }}</td>
        </tr>
        @endif
    </table>

    <p><strong>Untuk :</strong></p>
    <p>{{ $data->untuk_mengikuti }}</p>

    <p><strong>Kedudukan tersebut diatas pada :</strong></p>
    <table>
        <tr>
            <td width="30%">Hari / Tanggal</td>
            <td>: {{ $data->hari }}, {{ \Carbon\Carbon::parse($data->tanggal_kegiatan)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>: {{ $data->waktu_mulai }} WIB s/d selesai</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>: {{ $data->tempat_kegiatan }}</td>
        </tr>
    </table>

    @if($data->keterangan_tugas)
    <p>{{ $data->keterangan_tugas }}</p>
    @endif

    <p>Demikian surat tugas ini dibuat untuk dilaksanakan sebaik-baiknya dan dapat dipergunakan sebagaimana perlunya.</p>

    <div class="ttd">
        <p>KEMIRIGEDE, {{ \Carbon\Carbon::parse($data->tanggal_surat)->format('d F Y') }}</p>
        <p><strong>Kepala Desa KEMIRIGEDE</strong></p>
        <br><br><br>
        <p><u>MOH. HAMID ALMAULUDI, S.Pd.I</u></p>
    </div>

</body>
</html>
