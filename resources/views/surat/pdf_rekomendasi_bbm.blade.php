<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Rekomendasi Pembelian BBM Jenis Tertentu</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.2cm 1.4cm 1.2cm 1.4cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.25;
            color: #000;
            margin: 0;
            padding: 0;
        }

        p {
            margin: 4px 0;
            text-align: justify;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            vertical-align: top;
        }

        /* KOP SURAT FIX */
        .kop-desa-container {
            width: 100%;
            margin-bottom: 10px;
        }

        .kop-desa-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-desa-table td {
            padding: 0;
            vertical-align: middle;
            border: none;
        }

        .kop-desa-logo {
            width: 16%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-desa-logo img {
            width: 95px;
            height: auto;
        }

        .kop-desa-text {
            width: 68%;
            text-align: center;
            vertical-align: middle;
            line-height: 1.08;
            font-family: Arial, Helvetica, sans-serif;
        }

        .kop-desa-1 {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-2 {
            font-size: 14pt;
            font-weight: normal;
            text-transform: uppercase;
        }

        .kop-desa-3 {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-desa-alamat {
            font-size: 10pt;
            margin-top: 1px;
        }

        .kop-desa-kontak {
            font-size: 8.5pt;
        }

        .kop-desa-garis {
            border: none;
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 3px;
            margin: 5px 0 10px 0;
        }

        /* ================= JUDUL ================= */
        .judul {
            text-align: center;
            font-weight: bold;
            font-size: 12pt;
            text-decoration: underline;
            margin: 8px 0 2px 0;
            text-transform: uppercase;
        }

        .nomor {
            text-align: center;
            margin-bottom: 10px;
            font-size: 11pt;
        }

        /* ================= DASAR HUKUM ================= */
        .dasar-hukum-title {
            margin-top: 4px;
            margin-bottom: 2px;
        }

        ol.dasar-hukum {
            margin-top: 2px;
            margin-bottom: 8px;
            padding-left: 22px;
        }

        ol.dasar-hukum li {
            margin-bottom: 2px;
            text-align: justify;
        }

        /* ================= DATA PEMOHON ================= */
        .table-identitas {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0 8px 0;
        }

        .table-identitas td {
            border: none;
            padding: 1px 2px;
            vertical-align: top;
        }

        .table-identitas .label {
            width: 190px;
        }

        .table-identitas .titik-dua {
            width: 10px;
            text-align: center;
        }

        /* ================= TABEL BBM ================= */
        .table-bbm {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0 8px 0;
            font-size: 8.7pt;
        }

        .table-bbm th,
        .table-bbm td {
            border: 1px solid #000;
            padding: 4px 3px;
            vertical-align: middle;
        }

        .table-bbm th {
            text-align: center;
            font-weight: bold;
            background: none;
        }

        .table-bbm td {
            text-align: center;
        }

        .table-bbm .jumlah-label {
            text-align: center;
            font-weight: bold;
        }

        /* ================= RINCIAN ALOKASI ================= */
        .alokasi {
            margin-left: 15px;
            margin-top: 2px;
            margin-bottom: 4px;
        }

        .alokasi table {
            width: 100%;
            border-collapse: collapse;
        }

        .alokasi td {
            border: none;
            padding: 1px 2px;
            vertical-align: top;
        }

        .alokasi .label {
            width: 190px;
        }

        .alokasi .titik-dua {
            width: 10px;
            text-align: center;
        }

        /* ================= TTD ================= */
        .ttd-wrapper {
            width: 100%;
            margin-top: 25px;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            border: none;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0;
        }

        .ttd-table p {
            text-align: center;
            margin: 2px 0;
        }

        .ruang-ttd-pemohon {
            height: 90px;
        }

        .ttd-img {
            width: 150px;
            height: auto;
            margin: 4px 0;
        }

        .nama-pemohon {
            font-weight: bold;
            text-decoration: underline;
        }

        .nama-kades {
            font-weight: bold;
            text-decoration: underline;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .kop-desa-garis {
                margin: 5px 0 10px 0;
            }
        }
    </style>
</head>

<body>

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
                        email :pemdeskemirigede@gmail.com / website : Kemirigede-blitarkab.desa.id
                    </div>
                </td>

                {{-- <td class="kop-desa-logo">
                    <img src="{{ public_path('assets/images/Kemirigede.png') }}" alt="Logo Desa Kemirigede">
                </td> --}}
            </tr>
        </table>

        <hr class="kop-desa-garis">
    </div>

    {{-- JUDUL --}}
    <div class="judul">SURAT REKOMENDASI PEMBELIAN BBM JENIS TERTENTU</div>

    <div class="nomor">
        Nomor : {{ $data->nomor_surat ?? '541 / / 409.41.2 / ' . date('Y') }}
    </div>

    {{-- DASAR HUKUM --}}
    <p class="dasar-hukum-title">Dasar Hukum :</p>

    <ol class="dasar-hukum">
        <li>
            Undang-Undang Nomor 22 tahun 2001 tentang Minyak dan Gas Bumi sebagaimana telah diubah
            dengan Undang-Undang No 6 Tahun 2023 tentang penetapan peraturan pemerintah pengganti
            Undang-Undang No. 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang;
        </li>
        <li>
            Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintah Daerah sebagaimana telah beberapa kali
            diubah terakhir dengan Undang-Undang No 6 Tahun 2023 tentang Penetapan Peraturan Pemerintah
            Pengganti Undang-Undang No 2 Tahun 2022 tentang Cipta Kerja Menjadi Undang-Undang; dan
        </li>
        <li>
            Perpres Nomor 191 tahun 2014 tentang Penyediaan, Pendistribusian dan Harga Jual Eceran Bahan
            Bakar Minyak sebagaimana telah beberapa kali diubah terakhir dengan Peraturan Presiden No 117
            Tahun 2021 tentang Perubahan Ketiga atas Peraturan Presiden No 191 Tahun 2014 tentang
            Penyediaan, Pendistribusian dan Harga Jual Eceran Bahan Bakar Minyak.
        </li>
        <li>
            Peraturan Badan Pengatur Hilir Minyak dan Gas Bumi No 2 Tahun 2023 tentang Penertiban Surat
            Rekomendasi Untuk Pembelian Jenis Bahan Bakar Minyak Tertentu dan Jenis Bahan Bakar Minyak
            Khusus Penugasan;
        </li>
    </ol>

    <p>Dengan ini memberikan rekomendasi kepada :</p>

    {{-- DATA PEMOHON --}}
    <table class="table-identitas">
        <tr>
            <td class="label">Nama</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->nama_lengkap ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->no_hp ?? ($data->nowa ?? '-') }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Usaha</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->alamat_usaha ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Sektor Konsumen Pengguna</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->sektor_konsumen ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Usaha / Kegiatan</td>
            <td class="titik-dua">:</td>
            <td>{{ $data->jenis_usaha_kegiatan ?? '-' }}</td>
        </tr>
    </table>

    <p>Berdasarkan hasil verifikasi kegunaan BBM, digunakan untuk sarana sebagai berikut:</p>

    <p>
        1. Kebutuhan jenis BBM tertentu/jenis BBM khusus penugasan yang digunakan untuk alat sebagai berikut:
    </p>

    {{-- TABEL KEBUTUHAN BBM --}}
    <table class="table-bbm">
        <thead>
            <tr>
                <th style="width: 4%;">NO</th>
                <th style="width: 10%;">Jenis<br>Alat</th>
                <th style="width: 8%;">Jumlah<br>Alat</th>
                <th style="width: 12%;">Fungsi<br>Alat</th>
                <th style="width: 10%;">Daya<br>Alat/<br>Mesin</th>
                <th style="width: 11%;">BBM<br>Jenis<br>Tertentu</th>
                <th style="width: 12%;">Kebutuhan<br>BBM</th>
                <th style="width: 11%;">Jam<br>Operasi /<br>Hari</th>
                <th style="width: 22%;">Konsumsi BBM<br>Jenis Tertentu<br>Per Liter</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $data->jenis_alat ?? '-' }}</td>
                <td>{{ $data->jumlah_alat ?? '-' }}</td>
                <td>{{ $data->fungsi_alat ?? '-' }}</td>
                <td>{{ $data->daya_alat ?? '-' }}</td>
                <td>{{ $data->kebutuhan_bbm ?? '-' }}</td>
                <td>{{ $data->kebutuhan_bbm ?? '-' }}</td>
                <td>{{ $data->jam_operasi ?? '-' }}</td>
                <td>{{ $data->konsumsi_bbm ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="8" class="jumlah-label">JUMLAH</td>
                <td><strong>{{ $data->konsumsi_bbm ?? '-' }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p><strong>2. Diberikan alokasi volume minyak Pertalite :</strong></p>

    <div class="alokasi">
        <table>
            <tr>
                <td class="label">- Sejumlah</td>
                <td class="titik-dua">:</td>
                <td>{{ $data->alokasi_pertalite ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">- Tempat Pengambilan</td>
                <td class="titik-dua">:</td>
                <td>{{ $data->tempat_pengambilan ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">- Nomor Lembaga Penyalur</td>
                <td class="titik-dua">:</td>
                <td>{{ $data->nomor_lembaga_penyalur ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">- Lokasi</td>
                <td class="titik-dua">:</td>
                <td>{{ $data->lokasi_penyalur ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <p>3. Alat Pembelian yang digunakan: Jurigen</p>

    <p>
        4. Jangka Waktu pemberlakuan surat Rekomendasi sampai dengan
        <strong>
            {{ !empty($data->jangka_waktu) ? \Carbon\Carbon::parse($data->jangka_waktu) ->locale('id')->translatedFormat('d F Y') : '-' }}
        </strong>
    </p>

    <p>
        5. Penyaluran SPBU/SPBKB/SPBN/SPBUN wajib mencatat riwayat pembelian konsumen pengguna dalam format sebagaimana
        terlampir.
    </p>

    <p>
        6. Surat rekomendasi ini hanya berlaku untuk perseorangan sesuai dengan identitas pemohon surat rekomendasi.
    </p>

    <p>
        7. Surat rekomendasi ini dilarang untuk diberikan, dipindah tangankan, atau dialihkan kepada pihak lain.
    </p>

    <p>
        8. Jenis BBM tertentu atau jenis BBM khusus penugasan yang diperoleh tidak untuk diperjualbelikan kembali.
    </p>

    <p>
        9. Apabila surat rekomendasi tidak dipergunakan sebagaimana mestinya dan tidak sesuai dengan ketentuan
        peraturan perundang-undangan, surat rekomendasi akan dicabut dan diproses secara hukum sesuai dengan
        ketentuan peraturan perundang-undangan.
    </p>

    <p>
        10. Surat rekomendasi ini beserta lampiran harus dilampirkan kembali saat perpanjangan atau pengajuan ulang
        permohonan Surat Rekomendasi.
    </p>

    <p>
        Masa berlaku surat rekomendasi sampai dengan
        <strong>
            {{ !empty($data->jangka_waktu) ? \Carbon\Carbon::parse($data->jangka_waktu) ->locale('id')->translatedFormat('d F Y') : '-' }}
        </strong>
    </p>

    <p>
        Apabila penggunaan surat rekomendasi ini tidak sebagaimana mestinya, maka akan dicabut dan ditindaklanjuti
        dengan proses hukum sesuai dengan ketentuan dan peraturan perundang-undangan.
    </p>

    {{-- TANDA TANGAN --}}
    <div class="ttd-wrapper">
        <table class="ttd-table">
            <tr>
                <td></td>
                <td>
                    <p>Blitar, {{ now('Asia/Jakarta')->locale('id') ->locale('id')->translatedFormat('d F Y') }}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <p>Pemohon</p>
                </td>
                <td>
                    <p><strong>KEPALA DESA Kemirigede</strong></p>
                </td>
            </tr>

            {{-- <tr>
                <td class="ruang-ttd-pemohon"></td>
                <td>
                    <img src="{{ public_path('assets/images/ttd.png') }}" alt="TTD" class="ttd-img">
                </td>
            </tr> --}}
<br><br><br>
            <tr>
                <td>
                    <p class="nama-pemohon">
                        {{ $data->nama_lengkap ?? '.................................' }}
                    </p>
                </td>
                <td>
                    <p class="nama-kades">
                        Hari Purnawan, S.Sos.
                    </p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
