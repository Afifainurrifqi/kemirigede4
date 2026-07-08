<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tidak Mampu</title>
    <style>
        @page {
            margin: 1.3cm 1.8cm 1.3cm 1.8cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* KOP SURAT */
        .kop-container {
            width: 100%;
            margin-bottom: 12px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 105px;
            height: auto;
        }

        .kop-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.15;
        }

        .kop-text .kop-baris-1 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-2 {
            font-size: 15pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-text .kop-baris-3 {
            font-size: 17pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-text .kop-alamat {
            font-size: 11pt;
            font-weight: normal;
            margin-top: 2px;
        }

        .kop-text .kop-kontak {
            font-size: 10pt;
            font-weight: normal;
        }

        .kop-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 6px 0 12px 0;
        }

        .judul-surat {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 13.5pt;
            margin-bottom: 12px;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 8px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 6px 0 12px 0;
        }

        table.data td {
            padding: 3px 6px;
            vertical-align: top;
        }

        table.data td:first-child {
            width: 165px;
            font-weight: bold;
        }

        table.bantuan {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0 12px 0;
        }

        table.bantuan th,
        table.bantuan td {
            border: 1px solid #000;
            padding: 5px 7px;
            vertical-align: top;
        }

        table.bantuan th {
            text-align: center;
            font-weight: bold;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 35px;
        }

        .ttd-right {
            width: 48%;
            float: right;
            text-align: center;
        }

        .ttd-right p {
            margin: 3px 0;
        }

        .ttd-img-wrapper {
            height: 65px;
            text-align: center;
            margin: 8px 0;
        }

        .ttd-img {
            width: 180px;
            height: auto;
        }

        .materai {
            border: 1px solid #000;
            padding: 4px 12px;
            display: inline-block;
            margin: 6px 0;
            font-weight: bold;
            font-size: 9.5pt;
        }

        .barcode {
            margin-top: 10px;
            text-align: center;
        }

        .barcode img {
            width: 85px;
            height: auto;
        }

        .barcode small {
            font-size: 7.8pt;
            display: block;
            margin-top: 3px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-garis {
                margin: 6px 0 12px 0;
            }
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Kabupaten Blitar">
                </td>

                <td class="kop-text">
                    <div class="kop-baris-1">PEMERINTAH KABUPATEN BLITAR</div>
                    <div class="kop-baris-2">KECAMATAN KESAMBEN</div>
                    <div class="kop-baris-3">PEMERINTAH DESA KEMIRIGEDE</div>
                    <div class="kop-alamat">Jln. Merdeka No. 74 Telp. 082139324445</div>
                    <div class="kop-kontak">
                        email : Kemiriberkelas@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                {{--
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/wates.png') }}" alt="Logo Desa Kemirigede">
                </td>
                --}}
            </tr>
        </table>

        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul-surat">
        SURAT KETERANGAN TIDAK MAMPU
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '475 / --- / 409.41.2 / ' . now()->year }}
    </div>

    @php
        $bansosMap = [
            'pkh' => 'PKH',
            'kip' => 'KIP',
            'kis' => 'KIS',
            'bpnt' => 'BPNT',
            'dtks' => 'ID. DTKS',
            'blt_dd' => 'BLT DD',
            'bansos' => 'BANSOS',
        ];

        $bantuan = $data->bantuan ?? [];
        $bantuanId = $data->bantuan_id ?? [];

        if ($bantuan instanceof \Illuminate\Support\Collection) {
            $bantuan = $bantuan->toArray();
        }

        if ($bantuanId instanceof \Illuminate\Support\Collection) {
            $bantuanId = $bantuanId->toArray();
        }

        if (is_string($bantuan)) {
            $decodedBantuan = json_decode($bantuan, true);
            $bantuan = is_array($decodedBantuan)
                ? $decodedBantuan
                : (!empty($bantuan) ? [$bantuan] : []);
        }

        if (is_string($bantuanId)) {
            $decodedBantuanId = json_decode($bantuanId, true);
            $bantuanId = is_array($decodedBantuanId)
                ? $decodedBantuanId
                : [];
        }

        if (is_object($bantuan)) {
            $bantuan = (array) $bantuan;
        }

        if (is_object($bantuanId)) {
            $bantuanId = (array) $bantuanId;
        }

        $bantuan = array_values(array_filter((array) $bantuan, function ($item) {
            return !is_null($item) && $item !== '';
        }));

        $bantuanId = (array) $bantuanId;
    @endphp

    <!-- ISI -->
    <p class="tulisan">
        Yang bertanda tangan di bawah ini KEPALA DESA KEMIRIGEDE, Kecamatan Kesamben,
        Kabupaten Blitar, menerangkan dengan sebenarnya bahwa:
    </p>

    <table class="data">
        <tr>
            <td>Nama Lengkap</td>
            <td>: {{ $data->nama_lengkap ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{ $data->nik ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Tempat, Tanggal Lahir</td>
            <td>
                : {{ $data->tempat_lahir ?? '' }},
                {{ !empty($data->tanggal_lahir)
                    ? \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y')
                    : '...........................................' }}
            </td>
        </tr>
        <tr>
            <td>Kewarganegaraan</td>
            <td>: {{ $data->kewarganegaraan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>: {{ $data->agama ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Status Perkawinan</td>
            <td>: {{ $data->status_perkawinan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>: {{ $data->pekerjaan ?? '...........................................' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: {{ $data->alamat_rumah ?? '...........................................' }}</td>
        </tr>
    </table>

    <p class="tulisan">
        Bahwa berdasarkan keterangan yang bersangkutan serta data administrasi yang ada,
        nama tersebut di atas adalah benar warga Desa Kemirigede yang kondisi sosial ekonominya
        tergolong kurang mampu/tidak mampu.
    </p>

    <p class="tulisan">
        Surat keterangan ini dibuat untuk keperluan
        <strong>{{ $data->peruntukan_sktm ?? '...........................................' }}</strong>,
        dengan keterangan fungsi surat:
        <strong>{{ $data->keterangan_fungsi_surat ?? '...........................................' }}</strong>.
    </p>

    <p class="tulisan">
        Berdasarkan keterangan pemohon, data kepesertaan atau bantuan sosial yang dimiliki
        oleh yang bersangkutan adalah sebagai berikut:
    </p>

    @if (!empty($bantuan))
        <table class="bantuan">
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 42%;">Jenis Bantuan Sosial</th>
                    <th style="width: 50%;">Nomor / ID Kepesertaan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bantuan as $key)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $bansosMap[$key] ?? strtoupper(str_replace('_', ' ', $key)) }}</td>
                        <td>{{ $bantuanId[$key] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="tulisan">
            Yang bersangkutan tidak mencantumkan kepesertaan bantuan sosial dalam permohonan ini.
        </p>
    @endif

    <p class="tulisan">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.
        Apabila di kemudian hari terdapat kekeliruan atau data yang tidak benar, maka surat keterangan
        ini dapat ditinjau kembali sesuai dengan ketentuan yang berlaku.
    </p>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>KEPALA DESA KEMIRIGEDE</strong></p>

            {{--
            <div class="ttd-img-wrapper">
                <img src="{{ public_path('assets/images/ttd.png') }}" class="ttd-img" alt="Tanda Tangan">
            </div>
            --}}

            <br><br><br>

            {{-- <div class="materai">Materai<br>10.000</div> --}}

            <p><strong><u>Hari Purnawan, S.Sos. S.Pd.I</u></strong></p>

            {{--
            <div class="barcode">
                <img src="{{ public_path('assets/images/barcode.png') }}" alt="Barcode">
                <small>Scan untuk verifikasi surat resmi Desa Kemirigede</small>
            </div>
            --}}
        </div>
    </div>

</body>
</html>
