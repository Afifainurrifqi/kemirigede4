<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Memilih Nama Alias Satu Orang Tua</title>
    <style>
        @page {
            margin: 1.2cm 1.7cm 1.2cm 1.7cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.35;
            color: #000;
        }

        .kop-container { width: 100%; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 14%; text-align: center; }
        .kop-logo img { width: 72px; height: auto; }
        .kop-text { text-align: center; }
        .kop-text strong { font-size: 12pt; }
        .kop-text small { font-size: 9pt; }
        .kop-garis { border: none; border-top: 2px solid #000; margin: 5px 0 10px 0; }

        .judul-surat {
            text-align: center;
            margin-bottom: 4px;
        }
        .judul-surat h3 {
            font-size: 13.5pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 14px;
        }

        .tulisan {
            text-align: justify;
            margin-bottom: 6px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 9px 0;
        }
        table.data td {
            padding: 2.5px 6px;
            vertical-align: top;
        }
        table.data td:first-child {
            width: 155px;
            font-weight: bold;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 22px;
        }
        .ttd-right {
            width: 48%;
            float: right;
            text-align: center;
        }
        .ttd-right p {
            margin: 2px 0;
        }
        .materai {
            border: 1px solid #000;
            padding: 7px 18px;
            display: inline-block;
            margin: 8px 0;
            font-weight: bold;
        }
        .signature-line {
            margin-top: 32px;
            border-bottom: 1px solid #000;
            width: 210px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-container">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/blitar.jpg') }}" alt="Logo Blitar">
                </td>
                <td class="kop-text">
                    <strong>PEMERINTAH KABUPATEN BLITAR</strong><br>
                    <strong>KECAMATAN WATES</strong><br>
                    <strong>KANTOR KEPALA DESA WATES</strong><br>
                    <small>Jln. Merdeka No. 74 Telp. 082139324445<br>
                    Email: watesberkelas@gmail.com | Website: wates-blitarkab.desa.id</small>
                </td>
                <td class="kop-logo">
                    <img src="{{ public_path('assets/images/Wates.png') }}" alt="Logo Desa Wates">
                </td>
            </tr>
        </table>
        <hr class="kop-garis">
    </div>

    <!-- JUDUL -->
    <div class="judul-surat">
        <h3>SURAT PERNYATAAN</h3>
    </div>

    <!-- NOMOR SURAT -->
    <div class="nomor-surat">
        Nomor: {{ $data->nomor_surat ?? '411 / --- / 409.41.2 / ' . now()->year }}
    </div>

    <!-- ISI -->
    <p class="tulisan"><strong>Yang bertanda tangan di bawah ini, Saya:</strong></p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama_menyatakan ?? $data->nama ?? '...........................................' }}</td></tr>
        <tr><td>NIK</td><td>: {{ $data->nik ?? '...........................................' }}</td></tr>
        <tr><td>Alamat</td><td>: {{ $data->alamat ?? '...........................................' }}</td></tr>
    </table>

    <p class="tulisan">
        Menyatakan dengan sebenarnya bahwa pada Akta Kelahiran:
    </p>

    <table class="data">
        <tr><td>Nama</td><td>: {{ $data->nama_menyatakan ?? '...........................................' }}</td></tr>
        <tr><td>No. Akta Kelahiran</td><td>: {{ $data->no_akta_kelahiran ?? '...........................................' }}</td></tr>
    </table>

    <p class="tulisan">
        Nama orang tua <strong>Ayah/Ibu*</strong> yang tercatat adalah:
    </p>
    <p class="tulisan" style="margin-left: 15px;">
        {{ $data->nama_ortu_ayah_tercatat ?? $data->nama_ortu_ibu_tercatat ?? '...........................................' }}
        alias {{ $data->nama_alias_ayah ?? $data->nama_alias_ibu ?? '...........................................' }}
    </p>

    <p class="tulisan">
        Selanjutnya saya mengajukan pembetulan nama orang tua pada Akta Kelahiran dengan menghapus bagian nama alias menjadi:
    </p>
    <p class="tulisan" style="margin-left: 15px;">
        {{ $data->nama_alias_dihapus_1 ?? '...........................................' }}
        @if($data->nama_alias_dihapus_2) dan {{ $data->nama_alias_dihapus_2 }} @endif
    </p>

    <p class="tulisan">
        Berdasarkan: {{ $data->berdasarkan ?? '...........................................' }}
    </p>

    <p class="tulisan">
        Demikian surat pernyataan ini saya buat dengan sebenar-sebenarnya dan apabila dikemudian hari ternyata pernyataan saya ini tidak benar, maka saya bersedia diproses secara hukum sesuai dengan peraturan perundang-undangan dan dokumen yang diterbitkan akibat dari pernyataan ini menjadi tidak sah.
    </p>

    <div style="font-size: 10pt; margin-top: 8px;">
        *Pilih salah satu
    </div>

    <!-- TANDA TANGAN -->
    <div class="ttd-wrapper">
        <div class="ttd-right">
            <p>Blitar, {{ now('Asia/Jakarta')->translatedFormat('d F Y') }}</p>
            <p><strong>Saya yang menyatakan,</strong></p>

            <div class="materai">Materai<br>10.000</div>

            <div class="signature-line"></div>
            <p><strong>( {{ $data->nama_menyatakan ?? $data->nama ?? '...........................................' }} )</strong></p>
        </div>
    </div>

</body>
</html>
