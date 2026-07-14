@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col-12">


                {{-- FORM PEMBUATAN SURAT --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pembuatan Surat</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('surat.prosesForm') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="kategori">Kategori</label>
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="adminduk">Adminduk</option>
                                    <option value="keterangan">Keterangan</option>
                                    <option value="pernyataan">Pernyataan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_form">Jenis Form</label>
                                <select name="jenis_form" id="jenis_form" class="form-control" required disabled>
                                    <option value="">-- Pilih Jenis Form --</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Lanjut</button>
                        </form>
                    </div>
                </div>

                {{-- TABEL ARSIP SURAT --}}
                <div class="card shadow-sm">
                    <div class="card-header">
                        @if (session('success'))
                            <div class="alert alert-success mb-2">{{ session('success') }}</div>
                        @endif
                        <h5 class="card-title mb-0">SURAT KELUAR</h5>
                    </div>
                    <div class="card-body">
                        {{-- FILTER SEMUA JENIS SURAT --}}
                        <div class="filter-surat-panel">
                            <div class="filter-surat-heading">
                                <div class="filter-surat-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M4 5h16M7 12h10M10 19h4" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>

                                <div>
                                    <h6 class="filter-surat-title">Filter Jenis Surat</h6>
                                    <p class="filter-surat-subtitle">
                                        Pilih satu jenis surat untuk menampilkan data yang sesuai.
                                    </p>
                                </div>
                            </div>

                            <div class="filter-surat-controls">
                                <div class="filter-surat-field">
                                    <label for="filterJenisSurat" class="filter-surat-label">
                                        Jenis surat
                                    </label>

                                    <div class="filter-surat-select-wrap">
                                        <select id="filterJenisSurat" class="filter-surat-select"
                                            aria-label="Filter berdasarkan jenis surat">
                                            <option value="" data-keys="">
                                                Semua Jenis Surat
                                            </option>
                                        </select>

                                        <span class="filter-surat-chevron" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" fill="none">
                                                <path d="m7 10 5 5 5-5" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <button type="button" id="resetFilterJenisSurat" class="filter-reset-button">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M4 4v6h6M20 20v-6h-6" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.5 15a7 7 0 0 0 11.9 2.4L20 14M4 10l2.6-3.4A7 7 0 0 1 18.5 9"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    </svg>
                                    Reset Filter
                                </button>
                            </div>

                            <div class="filter-surat-result">
                                <span class="filter-result-dot" aria-hidden="true"></span>
                                <span id="filterJenisSuratInfo">
                                    Menampilkan seluruh jenis surat.
                                </span>
                                <span id="jumlahDataTampil" class="filter-count-badge">
                                    {{ $data->count() }} data
                                </span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table surat-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Action</th>
                                        <th>Nama Pelapor</th>
                                        <th>NIK Pelapor</th>
                                        <th>Jenis Surat</th>
                                        <th>No Whatsapp</th>
                                        {{-- <th>Jenis Kelamin</th> --}}
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Verifikasi</th>
                                    </tr>
                                </thead>
                                <tbody id="suratKeluarBody">

                                    @php
                                        /*
                                         * Pengurutan hanya untuk tampilan tabel:
                                         * surat yang paling baru dibuat tampil paling atas.
                                         *
                                         * Prioritas pengurutan:
                                         * 1. created_at
                                         * 2. timestamp MongoDB ObjectId (_id) untuk data lama
                                         *    yang belum memiliki created_at.
                                         */
                                        $data = collect($data)
                                            ->sortByDesc(function ($item) {
                                                $createdAt = data_get($item, 'created_at');

                                                // created_at sudah berupa Carbon/DateTime.
                                                if ($createdAt instanceof \DateTimeInterface) {
                                                    return $createdAt->getTimestamp();
                                                }

                                                // created_at berupa MongoDB UTCDateTime.
                                                if ($createdAt instanceof \MongoDB\BSON\UTCDateTime) {
                                                    return $createdAt->toDateTime()->getTimestamp();
                                                }

                                                // created_at berupa string tanggal.
                                                if (!empty($createdAt)) {
                                                    try {
                                                        return \Carbon\Carbon::parse($createdAt)->getTimestamp();
                                                    } catch (\Throwable $e) {
                                                        // Gunakan fallback ObjectId di bawah.
                                                    }
                                                }

                                                // Fallback untuk dokumen MongoDB lama tanpa created_at.
                                                $mongoId = (string) data_get($item, '_id', '');

                                                if (preg_match('/^[a-f0-9]{24}$/i', $mongoId)) {
                                                    return hexdec(substr($mongoId, 0, 8));
                                                }

                                                return 0;
                                            })
                                            ->values();
                                    @endphp

                                    @foreach ($data as $index => $item)
                                        @php
                                            $modelClass = get_class($item);
                                            $jenisSurat = match ($modelClass) {
                                                'App\Models\surat_keterangan_kehilangan' => 'SuratKeteranganKehilangan',
                                                'App\Models\surat_pernyataan_numpang_kk' => 'SuratPernyataanNumpangKk',
                                                'App\Models\surat_pernyataan_tidak_bisa_melampirkan_ktp_kematian'
                                                    => 'SuratPernyataanTidakBisaMelampirkanKtpKematian',
                                                'App\Models\suratketerangantidakmampu' => 'surat_keterangan_tidakmampu',
                                                'App\Models\surat_pernyataan_memilih_nama_alias'
                                                    => 'surat_pernyataan_memilih_nama_alias',
                                                'App\Models\nama_alias_ortu'
                                                    => 'surat_pernyataan_memilih_nama_alias_satu_orang_tua',
                                                'App\Models\surat_pernyataan_dan_jaminan'
                                                    => 'SuratPernyataanDanJaminan',
                                                'App\Models\surat_keterangan_desa_pernah_menikah'
                                                    => 'SuratKeteranganDesaPernahMenikah',
                                                'App\Models\surat_keterangan_kematian_desa'
                                                    => 'SuratKeteranganKematianDesa',
                                                'App\Models\surat_keterangan_ahli_waris' => 'SuratKeteranganAhliWaris',
                                                'App\Models\surat_kuasa' => 'SuratKuasa',
                                                'App\Models\SuratPermohonanPembukaanRekening'
                                                    => 'PermohonanPembukaanRekening',
                                                'App\Models\surat_pernyataan_belum_akta' => 'SuratPernyataanBelumAkta',
                                                'App\Models\surat_pernyataan_beda_nama_buku_nikah'
                                                    => 'SuratPernyataanBedaNamaBukuNikah',
                                                'App\Models\surat_pernyataan_anak_seorang_ibu'
                                                    => 'surat_pernyataan_anak_seorang_nama_ibu',
                                                'App\Models\surat_pernyataan_akta_barcode_nomor_sama'
                                                    => 'SuratPernyataanAktaBarcodeNomorSama',
                                                'App\Models\surat_sptjm_kematian' => 'SptjmKematian',
                                                'App\Models\surat_keterangan_harga_kepemilikan_tanah'
                                                    => 'SuratKeteranganHargaKepemilikanTanah',
                                                'App\Models\SuratPengantarSkck' => 'SuratPengantarSkck',
                                                'App\Models\surat_pernyataan_perubahan_data_pendidikan'
                                                    => 'SuratPernyataanPerubahanDataPendidikan',
                                                'App\Models\surat_pernyataan_pembetulan_data_tidak_merubah_lagi'
                                                    => 'SuratPernyataanPembetulanDataTidakMerubahLagi',
                                                'App\Models\surat_pernyataan_mengizinkan_ikut_kk'
                                                    => 'SuratPernyataanMengizinkanIkutKk',
                                                'App\Models\surat_permohonan_pengantar_keabsahan_akta_kelahiran'
                                                    => 'surat_permohonan_pengantar_keabsahan_akta_kelahiran',
                                                'App\Models\surat_pernyataan_batal_pindah_penduduk'
                                                    => 'surat_pernyataan_batal_pindah_penduduk',
                                                'App\Models\surat_formulir_pengajuan_user_id'
                                                    => 'surat_formulir_pengajuan_user_id',
                                                'App\Models\surat_keterangan_numpang_nikah'
                                                    => 'surat_keterangan_numpang_nikah',
                                                'App\Models\SuratKeteranganUsaha' => 'SuratKeteranganUsaha',
                                                'App\Models\SuratKeteranganUsaha' => 'SuratKeteranganUsaha',
                                                'App\Models\SuratKeteranganDesaMiskin' => 'SuratKeteranganDesaMiskin',
                                                'App\Models\SuratKeteranganMiskinSkm' => 'SuratKeteranganMiskinSkm',
                                                'App\Models\surat_keterangan_penghasilan'
                                                    => 'SuratKeteranganPenghasilan',
                                                'App\Models\SuratKeteranganPenghasilan' => 'SuratKeteranganPenghasilan',
                                                'App\Models\SuratKeteranganDesaSebagaiPenduduk'
                                                    => 'SuratKeteranganDesaSebagaiPenduduk',
                                                'App\Models\surat_keterangan_desa_sebagai_penduduk'
                                                    => 'SuratKeteranganDesaSebagaiPenduduk',
                                                'App\Models\SuratKeteranganDomisiliLembaga'
                                                    => 'SuratKeteranganDomisiliLembaga',
                                                'App\Models\surat_keterangan_domisili_lembaga'
                                                    => 'SuratKeteranganDomisiliLembaga',
                                                'App\Models\SuratKeteranganDomisiliWarga'
                                                    => 'SuratKeteranganDomisiliWarga', // ← BARU
                                                'App\Models\surat_keterangan_domisili_warga'
                                                    => 'SuratKeteranganDomisiliWarga', // ← BARU
                                                'App\Models\SuratKeteranganKepemilikanAset'
                                                    => 'SuratKeteranganKepemilikanAset', // ← BARU
                                                'App\Models\surat_keterangan_kepemilikan_aset'
                                                    => 'SuratKeteranganKepemilikanAset',
                                                'App\Models\SuratPernyataanKepemilikanDokumenAsli'
                                                    => 'SuratPernyataanKepemilikanDokumenAsli',
                                                'App\Models\surat_pernyataan_kepemilikan_dokumen_asli'
                                                    => 'SuratPernyataanKepemilikanDokumenAsli',
                                                'App\Models\surat_pernyataan_kesanggupan'
                                                    => 'SuratPernyataanKesanggupan',
                                                'App\Models\SuratPernyataanTidakPunyaKartuJkn'
                                                    => 'SuratPernyataanTidakPunyaKartuJkn',
                                                'App\Models\surat_pernyataan_tidak_punya_kartu_jkn'
                                                    => 'SuratPernyataanTidakPunyaKartuJkn',
                                                'App\Models\SuratPernyataanMiskin' => 'SuratPernyataanMiskin',
                                                'App\Models\surat_pernyataan_miskin' => 'SuratPernyataanMiskin',
                                                'App\Models\surat_kuasa' => 'SuratKuasa',
                                                'App\Models\SuratPerintahPerjalananDinas'
                                                    => 'SuratPerintahPerjalananDinas',
                                                'App\Models\SuratUndangan' => 'SuratUndangan',

                                                // Nota Angkutan
                                                'App\Models\SuratNotaAngkutan' => 'SuratNotaAngkutan',
                                                'App\Models\surat_nota_angkutan' => 'SuratNotaAngkutan',

                                                // Rekomendasi BBM
                                                'App\Models\SuratRekomendasiBbm' => 'SuratRekomendasiBbm',
                                                'App\Models\surat_rekomendasi_bbm' => 'SuratRekomendasiBbm',

                                                'App\Models\SuratPermohonanPernyataanMiskin'
                                                    => 'SuratPermohonanPernyataanMiskin',
                                                'surat_permohonan_pernyataan_miskin'
                                                    => 'SuratPermohonanPernyataanMiskin',
                                                'App\Models\SuratPermohonanTebangPohon' => 'SuratPermohonanTebangPohon',
                                                'surat_permohonan_tebang_pohon' => 'SuratPermohonanTebangPohon',
                                                'App\Models\surat_keterangan_ghoib' => 'surat_keterangan_ghoib',
                                                'App\Models\SuratKeteranganGhoib' => 'surat_keterangan_ghoib',
                                                'App\Models\surat_keterangan_ahli_waris' => 'SuratKeteranganAhliWaris',

                                                'App\Models\surat_keterangan_ahli_waris' => 'SuratKeteranganAhliWaris',
                                                'App\Models\SuratPerintahTugas' => 'SuratPerintahTugas',

                                                'App\Models\surat_keterangan_ahli_waris_desa'
                                                    => 'surat_keterangan_ahli_waris_desa',
                                                'App\Models\SuratRekomendasi' => 'SuratRekomendasi',
                                                'App\Models\SuratIjinKeluarga' => 'SuratIjinKeluarga',
                                                default => class_basename($item),
                                            };

                                            $statusClass = match ($item->status_surat) {
                                                'Pending' => 'bg-pending',
                                                'Di cek' => 'bg-cek',
                                                'Di terima' => 'bg-Di terima',
                                                'Ditolak' => 'bg-ditolak',
                                                default => '',
                                            };

                                            $verifClass =
                                                $item->status_verif === 'Terverifikasi'
                                                    ? 'bg-terverifikasi'
                                                    : 'bg-belum-verifikasi';
                                        @endphp
                                        <tr class="surat-row" data-jenis-surat="{{ strtolower($jenisSurat) }}">
                                            <td class="nomor-urut">{{ $index + 1 }}</td>
                                            <td>
                                                {{-- Tombol Export PDF tetap dipertahankan --}}
                                                <a href="{{ route('surat.export-pdf', ['jenis' => strtolower($jenisSurat), 'id' => $item->_id]) }}"
                                                    class="btn btn-success btn-sm" target="_blank">
                                                    Export PDF
                                                </a>

                                                @php
                                                    $docxJenisKey = strtolower(
                                                        preg_replace('/[^a-z0-9]+/i', '', $jenisSurat)
                                                    );
                                                    $docxSupported = array_key_exists(
                                                        $docxJenisKey,
                                                        config('surat_docx.documents', [])
                                                    );
                                                @endphp

                                                @if ($docxSupported)
                                                    <a href="{{ route('surat.export-docx', ['jenis' => strtolower($jenisSurat), 'id' => $item->_id]) }}"
                                                        class="btn btn-info btn-sm ms-1">
                                                        Export DOCX
                                                    </a>
                                                @endif

                                                @if ($jenisSurat === 'SuratKeteranganKehilangan')
                                                    <a href="{{ route('suratkehilangan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    <a href="{{ route('surat.kuasa.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif($jenisSurat === 'SuratKeteranganKepemilikanAset')
                                                    <a href="{{ route('surat.kepemilikan_aset.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPermohonanPernyataanMiskin' || $jenisSurat === 'surat_permohonan_pernyataan_miskin')
                                                    <a href="{{ route('surat.permohonan_pernyataan_miskin.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPermohonanTebangPohon' || $jenisSurat === 'surat_permohonan_tebang_pohon')
                                                    <a href="{{ route('surat.permohonan_tebang_pohon.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPerintahPerjalananDinas' || $jenisSurat === 'surat_perintah_perjalanan_dinas')
                                                    <a href="{{ route('surat.perintah_perjalanan_dinas.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanKesanggupan')
                                                    <a href="{{ route('surat.pernyataan_kesanggupan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanTidakPunyaKartuJkn')
                                                    <a href="{{ route('surat.pernyataan_tidak_punya_kartu_jkn.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanKepemilikanDokumenAsli')
                                                    <a href="{{ route('surat.pernyataan_kepemilikan_dokumen.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratUndangan' || $jenisSurat === 'surat_undangan')
                                                    <a href="{{ route('surat.undangan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPerintahTugas')
                                                    <a href="{{ route('surat.perintah_tugas.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">
                                                        Edit</a>
                                                @elseif ($jenisSurat === 'SuratNotaAngkutan' || $jenisSurat === 'surat_nota_angkutan')
                                                    <a href="{{ route('surat.nota_angkutan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanMiskin')
                                                    <a href="{{ route('surat.pernyataan_miskin.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif($jenisSurat === 'SuratKeteranganDomisiliWarga')
                                                    <a href="{{ route('surat.domisili_warga.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganUsaha')
                                                    <a href="{{ route('surat.usaha.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaMiskin')
                                                    <a href="{{ route('surat.miskindesa.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaSebagaiPenduduk')
                                                    <a href="{{ route('surat.desa_penduduk.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganMiskinSkm')
                                                    <a href="{{ route('surat.skm.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliLembaga')
                                                    <a href="{{ route('surat.domisili_lembaga.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif (
                                                    $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiran' ||
                                                        $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran')
                                                    <a href="{{ route('surat.pengantar_keabsahan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanNumpangKk')
                                                    <a href="{{ route('surat.numpangkk.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanTidakBisaMelampirkanKtpKematian')
                                                    <a href="{{ route('suratpernyataantidakbisamelampirkanktpkematian.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_keterangan_tidakmampu')
                                                    <a href="{{ route('surat.tidakmampu.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_pernyataan_memilih_nama_alias')
                                                    <a href="{{ route('surat.namaalias.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_pernyataan_memilih_nama_alias_satu_orang_tua')
                                                    <a href="{{ route('surat.namaaliasortu.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanDanJaminan')
                                                    <a href="{{ route('surat.pernyataandanjaminan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaPernahMenikah')
                                                    <a href="{{ route('surat.pernahmenikah.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganKematianDesa')
                                                    <a href="{{ route('surat.kematian.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganAhliWaris')
                                                    <a href="{{ route('surat.ahliwaris.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    <a href="{{ route('surat.kuasa.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanBelumAkta')
                                                    <a href="{{ route('surat.belumakta.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanBedaNamaBukuNikah')
                                                    <a href="{{ route('surat.bedanama.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_pernyataan_anak_seorang_nama_ibu')
                                                    <a href="{{ route('surat.anakseorangibu.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanAktaBarcodeNomorSama')
                                                    <a href="{{ route('surat.aktabarcode.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SptjmKematian')
                                                    <a href="{{ route('surat.sptjm.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganHargaKepemilikanTanah')
                                                    <a href="{{ route('surat.kepemilikantanah.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPengantarSkck')
                                                    <a href="{{ route('surat.skck.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanPerubahanDataPendidikan')
                                                    <a href="{{ route('surat.perubahdatapendidikan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanPembetulanDataTidakMerubahLagi')
                                                    <a href="{{ route('surat.pembetulandata.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratPernyataanMengizinkanIkutKk')
                                                    <a href="{{ route('surat.izinkk.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_pernyataan_batal_pindah_penduduk')
                                                    <a href="{{ route('surat.batal_pindah.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_formulir_pengajuan_user_id')
                                                    <a href="{{ route('surat.formulir_pengajuan_user_id.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiranAnak')
                                                    <a href="{{ route('surat.pengantar_keabsahan_anak.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>

                                                    {{-- === TAMBAHKAN DI SINI === --}}
                                                @elseif ($jenisSurat === 'surat_sptjm_suami_istri')
                                                    <a href="{{ route('surat.sptjm_suami_istri.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratKeteranganPenghasilan')
                                                    <a href="{{ route('surat.penghasilan.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_keterangan_numpang_nikah')
                                                    <a href="{{ route('surat.numpangnikah.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_keterangan_ahli_waris_desa')
                                                    <a href="{{ route('surat.ahliwarisdesa.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'surat_keterangan_ghoib')
                                                    <a href="{{ route('surat.ghoib.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'PermohonanPembukaanRekening' || $jenisSurat === 'surat_permohonan_pembukaan_rekening')
                                                    <a href="{{ route('surat.permohonan_rekening.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratRekomendasiBbm' || $jenisSurat === 'surat_rekomendasi_bbm')
                                                    <a href="{{ route('surat.rekomendasi_bbm.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratRekomendasi')
                                                    <a href="{{ route('surat.rekomendasi.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @elseif ($jenisSurat === 'SuratIjinKeluarga')
                                                    <a href="{{ route('surat.ijin_keluarga.edit', $item->_id) }}"
                                                        class="btn btn-primary btn-sm ms-1">Edit</a>
                                                @endif
                                            </td>

                                            {{-- Nama Pelapor --}}
                                            <td>
                                                @if ($jenisSurat === 'SuratKeteranganKehilangan' || $jenisSurat === 'SuratPernyataanTidakBisaMelampirkanKtpKematian')
                                                    {{ $item->nama_pelapor ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiranAnak')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganKepemilikanAset')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratNotaAngkutan' || $jenisSurat === 'surat_nota_angkutan')
                                                    {{ $item->nama_pengirim ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    {{ $item->nama_pihak1 ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_numpang_nikah')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganPenghasilan')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanNumpangKk')
                                                    {{ $item->nama_pemilik_kk ?? '-' }}
                                                @elseif($jenisSurat === 'SuratKeteranganDomisiliWarga')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_ghoib')
                                                    {{ $item->nama_pemohon ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiran')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPermohonanPernyataanMiskin' || $jenisSurat === 'surat_permohonan_pernyataan_miskin')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_tidakmampu')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_memilih_nama_alias')
                                                    {{ $item->nama_pemilih ?? ($item->nama ?? '-') }}
                                                    {{-- ⬅️ pakai nama_pemilih; fallback ke nama --}}
                                                @elseif ($jenisSurat === 'surat_pernyataan_memilih_nama_alias_satu_orang_tua')
                                                    {{-- <<< baru --}}
                                                    {{ $item->nama_menyatakan ?? ($item->nama ?? '-') }}
                                                @elseif ($jenisSurat === 'SuratPernyataanDanJaminan')
                                                    {{ $item->nama_pembuat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPermohonanTebangPohon' || $jenisSurat === 'surat_permohonan_tebang_pohon')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPerintahPerjalananDinas')
                                                    {{ $item->nama_pegawai ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanMiskin')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaPernahMenikah')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaMiskin')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganKematianDesa')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratRekomendasiBbm' || $jenisSurat === 'surat_rekomendasi_bbm')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'PermohonanPembukaanRekening' || $jenisSurat === 'surat_permohonan_pembukaan_rekening')
                                                    {{ $item->ybt_nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganAhliWaris')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_ahli_waris_desa')
                                                    {{ $item->nama_tabel !== '' ? $item->nama_almarhum : '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganUsaha')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliLembaga')
                                                    {{ $item->nama_lembaga ?? ($item->nama_pengurus ?? '-') }}
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    {{ $item->p1_nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganMiskinSkm')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanBelumAkta')
                                                    {{ $item->ybt_nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanBedaNamaBukuNikah')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanKepemilikanDokumenAsli')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanTidakPunyaKartuJkn')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_anak_seorang_nama_ibu')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanAktaBarcodeNomorSama')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SptjmKematian')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganHargaKepemilikanTanah')
                                                    {{ $item->atas_nama_hak_milik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPengantarSkck')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanPerubahanDataPendidikan')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanPembetulanDataTidakMerubahLagi')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanKesanggupan')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanMengizinkanIkutKk')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_batal_pindah_penduduk')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaSebagaiPenduduk')
                                                    {{ $item->nama_lengkap ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_formulir_pengajuan_user_id')
                                                    {{ $item->nama_pemohon ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_sptjm_suami_istri')
                                                    {{ $item->nama_deklaran ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratRekomendasi')
                                                    {{ $item->nama ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratIjinKeluarga')
                                                    {{ $item->nama_suami ?? ($item->nama_istri ?? '-') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            {{-- NIK Pelapor --}}
                                            <td>
                                                @if ($jenisSurat === 'SuratKeteranganKehilangan' || $jenisSurat === 'SuratPernyataanTidakBisaMelampirkanKtpKematian')
                                                    {{ $item->nik_pelapor ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanNumpangKk')
                                                    {{ $item->nik_pemilik_kk ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_tidakmampu')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanKepemilikanDokumenAsli')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaMiskin')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_ahli_waris_desa')
                                                    {{ $item->nama_tabel !== '' ? $item->nama_almarhum : '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanKesanggupan')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_formulir_pengajuan_user_id')
                                                    {{ $item->nik_pemohon ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratNotaAngkutan' || $jenisSurat === 'surat_nota_angkutan')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_batal_pindah_penduduk')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_pernyataan_memilih_nama_alias' ||
                                                        $jenisSurat === 'surat_pernyataan_memilih_nama_alias_satu_orang_tua')
                                                    {{-- <<< baru ikut nik utama --}}
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanDanJaminan')
                                                    {{ $item->nik_pembuat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_ghoib')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaSebagaiPenduduk')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanTidakPunyaKartuJkn')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliWarga')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPermohonanPernyataanMiskin' || $jenisSurat === 'surat_permohonan_pernyataan_miskin')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiran')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    {{ $item->nik_pihak1 ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganKepemilikanAset')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPermohonanTebangPohon' || $jenisSurat === 'surat_permohonan_tebang_pohon')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganPenghasilan')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiranAnak')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'PermohonanPembukaanRekening' || $jenisSurat === 'surat_permohonan_pembukaan_rekening')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratRekomendasiBbm' || $jenisSurat === 'surat_rekomendasi_bbm')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganUsaha')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliLembaga')
                                                    {{ $item->nik_pengurus ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaPernahMenikah')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanMiskin')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganKematianDesa')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganAhliWaris')
                                                    {{ $item->no_ktp ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    {{ $item->p1_nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratUndangan')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanBelumAkta')
                                                    {{ $item->ybt_nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganMiskinSkm')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanBedaNamaBukuNikah')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanPembetulanDataTidakMerubahLagi')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_anak_seorang_nama_ibu')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanAktaBarcodeNomorSama')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SptjmKematian')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPerintahPerjalananDinas')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganHargaKepemilikanTanah')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPengantarSkck')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanPerubahanDataPendidikan')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanMengizinkanIkutKk')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_sptjm_suami_istri')
                                                    {{ $item->nik_deklaran ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_numpang_nikah')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratRekomendasi')
                                                    {{ $item->nik ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratIjinKeluarga')
                                                    {{ $item->nik_suami ?? ($item->nik_istri ?? '-') }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            {{-- Jenis Surat --}}
                                            {{-- Jenis Surat (Nama yang Rapi) --}}
                                            <td class="jenis-surat-cell">
                                                @php
                                                    $labelSurat = match ($jenisSurat) {
                                                        'SuratKeteranganKehilangan' => 'Surat Keterangan Kehilangan',
                                                        'SuratPernyataanNumpangKk' => 'Surat Pernyataan Numpang KK',
                                                        'SuratPernyataanTidakBisaMelampirkanKtpKematian'
                                                            => 'Surat Pernyataan Tidak Bisa Melampirkan KTP Kematian',
                                                        'surat_keterangan_tidakmampu' => 'Surat Keterangan Tidak Mampu',
                                                        'surat_pernyataan_memilih_nama_alias'
                                                            => 'Surat Pernyataan Memilih Nama Alias',
                                                        'surat_pernyataan_memilih_nama_alias_satu_orang_tua'
                                                            => 'Surat Pernyataan Memilih Nama Alias Satu Orang Tua',
                                                        'SuratPernyataanDanJaminan' => 'Surat Pernyataan dan Jaminan',
                                                        'SuratKeteranganDesaPernahMenikah'
                                                            => 'Surat Keterangan Desa Pernah Menikah',
                                                        'SuratKeteranganKematianDesa'
                                                            => 'Surat Keterangan Kematian Desa',
                                                        'SuratKeteranganDomisiliWarga'
                                                            => 'Surat Keterangan Domisili Warga',
                                                        'SuratKeteranganAhliWaris' => 'Surat Keterangan Ahli Waris',
                                                        'SuratKuasa' => 'Surat Kuasa',
                                                        'PermohonanPembukaanRekening'
                                                            => 'Permohonan Pembukaan Rekening',
                                                        'SuratPernyataanBelumAkta' => 'Surat Pernyataan Belum Akta',
                                                        'SuratPernyataanBedaNamaBukuNikah'
                                                            => 'Surat Pernyataan Beda Nama Buku Nikah',
                                                        'surat_pernyataan_anak_seorang_nama_ibu'
                                                            => 'Surat Pernyataan Anak Seorang Nama Ibu',
                                                        'SuratPernyataanAktaBarcodeNomorSama'
                                                            => 'Surat Pernyataan Akta Barcode Nomor Sama',
                                                        'SptjmKematian' => 'SPTJM Kematian',
                                                        'SuratKeteranganHargaKepemilikanTanah'
                                                            => 'Surat Keterangan Harga Kepemilikan Tanah',
                                                        'SuratPengantarSkck' => 'Surat Pengantar SKCK',
                                                        'SuratPernyataanPerubahanDataPendidikan'
                                                            => 'Surat Pernyataan Perubahan Data Pendidikan',
                                                        'SuratPernyataanPembetulanDataTidakMerubahLagi'
                                                            => 'Surat Pernyataan Pembetulan Data Tidak Merubah Lagi',
                                                        'SuratPernyataanMengizinkanIkutKk'
                                                            => 'Surat Pernyataan Mengizinkan Ikut KK',
                                                        'SuratRekomendasiBbm'
                                                            => 'Surat Rekomendasi Pembelian BBM Jenis Tertentu',
                                                        'surat_rekomendasi_bbm'
                                                            => 'Surat Rekomendasi Pembelian BBM Jenis Tertentu',
                                                        'surat_permohonan_pengantar_keabsahan_akta_kelahiran'
                                                            => 'Permohonan Pengantar Keabsahan Akta Kelahiran',
                                                        'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak'
                                                            => 'Permohonan Pengantar Keabsahan Akta Kelahiran (Anak)',
                                                        'surat_pernyataan_batal_pindah_penduduk'
                                                            => 'Surat Pernyataan Batal Pindah Penduduk',
                                                        'surat_formulir_pengajuan_user_id'
                                                            => 'Formulir Pengajuan User ID (F-3.01)',
                                                        'App\Models\surat_sptjm_suami_istri'
                                                            => 'surat_sptjm_suami_istri',
                                                        'SuratPernyataanKesanggupan' => 'Surat Pernyataan Kesanggupan',
                                                        'surat_keterangan_numpang_nikah'
                                                            => 'Surat Keterangan Numpang Nikah',
                                                        'SuratPerintahPerjalananDinas'
                                                            => 'Surat Perintah Perjalanan Dinas (SPPD)',
                                                        'SuratKeteranganUsaha' => 'Surat Keterangan Usaha',
                                                        'SuratKeteranganMiskinSkm' => 'Surat Keterangan Miskin (SKM)',
                                                        'SuratKeteranganPenghasilan' => 'Surat Keterangan Penghasilan',
                                                        'SuratKeteranganDesaSebagaiPenduduk'
                                                            => 'Surat Keterangan Desa Sebagai Penduduk',
                                                        'SuratKeteranganDomisiliLembaga'
                                                            => 'Surat Keterangan Domisili Lembaga',
                                                        'SuratKeteranganKepemilikanAset'
                                                            => 'Surat Keterangan Kepemilikan Aset',
                                                        'SuratPernyataanKepemilikanDokumenAsli'
                                                            => 'Surat Pernyataan Kepemilikan Dokumen Asli',
                                                        'SuratPernyataanTidakPunyaKartuJkn'
                                                            => 'Surat Pernyataan Tidak Memiliki Kartu JAMKESMAS / ASKES / JKN',
                                                        'SuratPernyataanMiskin' => 'Surat Pernyataan Miskin',
                                                        'SuratUndangan' => 'Surat Undangan',
                                                        'SuratPermohonanTebangPohon' => 'Surat Permohonan Tebang Pohon',
                                                        'surat_permohonan_tebang_pohon'
                                                            => 'Surat Permohonan Tebang Pohon',
                                                        'SuratIjinKeluarga' => 'Surat Izin Keluarga',
                                                        'SuratPerintahTugas' => 'Surat Perintah Tugas',
                                                        'SuratNotaAngkutan' => 'Format Blangko Nota Angkutan',
                                                        'surat_nota_angkutan' => 'Format Blangko Nota Angkutan',
                                                        'SuratRekomendasi' => 'Rekomendasi',
                                                        'SuratPermohonanPernyataanMiskin'
                                                            => 'Permohonan Surat Pernyataan Miskin',
                                                        'surat_permohonan_pernyataan_miskin'
                                                            => 'Permohonan Surat Pernyataan Miskin',
                                                        'SuratKeteranganDesaMiskin'
                                                            => 'Surat Keterangan Desa Warga Miskin',
                                                        'surat_keterangan_ahli_waris_desa'
                                                            => 'Surat Keterangan Ahli Waris Desa',
                                                        'surat_keterangan_ghoib' => 'Surat Keterangan Ghoib',
                                                        'SuratKeteranganDomisiliUsaha'
                                                            => 'Surat Keterangan Domisili Usaha',
                                                        'surat_keterangan_domisili_usaha'
                                                            => 'Surat Keterangan Domisili Usaha',
                                                        'SuratPenyelenggaraanKeramaian'
                                                            => 'Surat Penyelenggaraan Keramaian',
                                                        'surat_penyelenggaraan_keramaian'
                                                            => 'Surat Penyelenggaraan Keramaian',
                                                        default => $jenisSurat,
                                                    };
                                                @endphp

                                                {{ $labelSurat }}
                                            </td>

                                            {{-- No Whatsapp --}}
                                            <td>
                                                @php
                                                    $wa = preg_replace('/\D+/', '', (string) $item->nowa);
                                                    if (str_starts_with($wa, '0')) {
                                                        $wa = '62' . substr($wa, 1);
                                                    }
                                                @endphp
                                                @if (!empty($item->nowa))
                                                    <a href="https://wa.me/{{ $wa }}" target="_blank"
                                                        rel="noopener" class="btn btn-success btn-sm">
                                                        {{ $item->nowa }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif

                                            </td>

                                            {{-- Jenis Kelamin --}}


                                            {{-- Alamat --}}
                                            <td>
                                                @if ($jenisSurat === 'SuratKeteranganKehilangan' || $jenisSurat === 'SuratPernyataanTidakBisaMelampirkanKtpKematian')
                                                    {{ $item->alamat_pelapor ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanTidakPunyaKartuJkn')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanNumpangKk')
                                                    {{ $item->alamat_pemilik_kk ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliLembaga')
                                                    {{ $item->alamat_lembaga ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaSebagaiPenduduk')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_ghoib')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiranAnak')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_batal_pindah_penduduk')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanMiskin')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPermohonanPernyataanMiskin' || $jenisSurat === 'surat_permohonan_pernyataan_miskin')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratUndangan')
                                                    {{ $item->tempat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_tidakmampu')
                                                    {{ $item->alamat_rumah ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPermohonanTebangPohon' || $jenisSurat === 'surat_permohonan_tebang_pohon')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganMiskinSkm')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_keterangan_numpang_nikah')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganUsaha')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganPenghasilan')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_pernyataan_memilih_nama_alias' ||
                                                        $jenisSurat === 'surat_pernyataan_memilih_nama_alias_satu_orang_tua')
                                                    {{-- <<< baru ikut field alamat --}}
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanDanJaminan')
                                                    {{ $item->alamat_pembuat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDesaPernahMenikah')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganKematianDesa')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliLembaga')
                                                    {{ $item->alamat_lembaga ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganKepemilikanAset')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganDomisiliLembaga')
                                                    {{ $item->alamat_lembaga ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganAhliWaris')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_sptjm_suami_istri')
                                                    {{ $item->alamat_deklaran ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran' ||
                                                        $jenisSurat === 'SuratPermohonanPengantarKeabsahanAktaKelahiran')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif (
                                                    $jenisSurat === 'SuratNotaAngkutan' ||
                                                        $jenisSurat === 'surat_nota_angkutan')
                                                    {{
                                                        $item->alamat_pengirim
                                                            ?? $item->alamat_penerima
                                                            ?? $item->tempat_muat
                                                            ?? '-'
                                                    }}

                                                @elseif (
                                                    $jenisSurat === 'SuratRekomendasiBbm' ||
                                                        $jenisSurat === 'surat_rekomendasi_bbm')
                                                    {{
                                                        $item->alamat_usaha
                                                            ?? $item->lokasi_penyalur
                                                            ?? $item->tempat_pengambilan
                                                            ?? '-'
                                                    }}

                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    {{ $item->alamat_pihak1 ?? ($item->p1_alamat ?? '-') }}

                                                @elseif (
                                                    $jenisSurat === 'PermohonanPembukaanRekening' ||
                                                        $jenisSurat === 'SuratPermohonanPembukaanRekening' ||
                                                        $jenisSurat === 'surat_permohonan_pembukaan_rekening')
                                                    {{
                                                        $item->ybt_alamat
                                                            ?? $item->rekening_alamat
                                                            ?? $item->kepada_alamat
                                                            ?? $item->alamat_kepala_desa
                                                            ?? '-'
                                                    }}

                                                @elseif ($jenisSurat === 'SuratPerintahTugas')
                                                    @php
                                                        /*
                                                         * Struktur penerima_tugas dapat berisi:
                                                         * [
                                                         *   ['nama' => '...', 'kedudukan' => '...', 'alamat' => '...']
                                                         * ]
                                                         *
                                                         * Alamat digabung jika penerima lebih dari satu.
                                                         */
                                                        $alamatPenerimaTugas = collect(
                                                            $item->penerima_tugas ?? []
                                                        )
                                                            ->pluck('alamat')
                                                            ->filter(function ($alamat) {
                                                                return filled($alamat);
                                                            })
                                                            ->map(function ($alamat) {
                                                                return trim((string) $alamat);
                                                            })
                                                            ->unique()
                                                            ->implode('; ');
                                                    @endphp

                                                    {{ $alamatPenerimaTugas !== '' ? $alamatPenerimaTugas : '-' }}

                                                @elseif (
                                                    $jenisSurat === 'SuratPerintahPerjalananDinas' ||
                                                        $jenisSurat === 'surat_perintah_perjalanan_dinas')
                                                    {{
                                                        $item->alamat
                                                            ?? $item->tempat_tujuan
                                                            ?? $item->tempat_berangkat
                                                            ?? $item->instansi
                                                            ?? '-'
                                                    }}

                                                @elseif ($jenisSurat === 'SuratPernyataanBelumAkta')
                                                    {{ $item->ybt_alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanBedaNamaBukuNikah')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'surat_pernyataan_anak_seorang_nama_ibu')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanAktaBarcodeNomorSama')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SptjmKematian')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganHargaKepemilikanTanah')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPengantarSkck')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanPerubahanDataPendidikan')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanPembetulanDataTidakMerubahLagi')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratPernyataanMengizinkanIkutKk')
                                                    {{ $item->alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratRekomendasi')
                                                    {{ $item->alamat ?? '-' }}


                                                @elseif ($jenisSurat === 'SuratIjinKeluarga')
                                                    {{ $item->alamat_suami ?? ($item->alamat_istri ?? '-') }}
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            {{-- Status Surat --}}
                                            <td><span
                                                    class="badge rounded-pill {{ $statusClass }}">{{ $item->status_surat }}</span>
                                            </td>

                                            {{-- Status Verifikasi --}}
                                            <td><span
                                                    class="badge rounded-pill {{ $verifClass }}">{{ $item->status_verif }}</span>
                                            </td>
                                        </tr>
                                    @endforeach

                                    @if ($data->isEmpty())
                                        <tr id="dataKosongAwal">
                                            <td colspan="9" class="text-center py-4">
                                                Belum ada data.
                                            </td>
                                        </tr>
                                    @endif

                                    <tr id="filterJenisSuratKosong" class="d-none">
                                        <td colspan="9" class="text-center py-4">
                                            Tidak ada surat yang sesuai dengan filter jenis surat.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Tambahan Style Badge --}}
    <style>
        .bg-pending {
            background-color: #6c757d;
            color: #fff;
        }

        .bg-cek {
            background-color: #ffc107;
            color: #000;
        }

        .bg-Di terima {
            background-color: #198754;
            color: #fff;
        }

        .bg-ditolak {
            background-color: #dc3545;
            color: #fff;
        }

        .bg-belum-verifikasi {
            background-color: #0d6efd;
            color: #fff;
        }

        .bg-terverifikasi {
            background-color: #198754;
            color: #fff;
        }
    </style>

    <style>
        /* =========================================================
                   FILTER JENIS SURAT
                ========================================================= */
        .filter-surat-panel {
            margin-bottom: 22px;
            padding: 18px;
            background: linear-gradient(135deg, #f8fbff 0%, #f5f7fb 100%);
            border: 1px solid #dfe7f1;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(31, 41, 55, 0.06);
        }

        .filter-surat-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .filter-surat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            color: #2563eb;
            background: #e8f0ff;
            border-radius: 12px;
        }

        .filter-surat-icon svg {
            width: 23px;
            height: 23px;
        }

        .filter-surat-title {
            margin: 0 0 3px;
            color: #172033;
            font-size: 16px;
            font-weight: 700;
        }

        .filter-surat-subtitle {
            margin: 0;
            color: #6b7280;
            font-size: 13px;
        }

        .filter-surat-controls {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            align-items: end;
        }

        .filter-surat-field {
            min-width: 0;
        }

        .filter-surat-label {
            display: block;
            margin-bottom: 7px;
            color: #344054;
            font-size: 13px;
            font-weight: 600;
        }

        .filter-surat-select-wrap {
            position: relative;
        }

        .filter-surat-select {
            display: block;
            width: 100%;
            height: 46px;
            padding: 0 44px 0 14px;
            color: #1f2937;
            background: #ffffff;
            border: 1px solid #cfd8e3;
            border-radius: 10px;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            font-size: 14px;
            line-height: 46px;
            cursor: pointer;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background-color 0.2s ease;
        }

        .filter-surat-select:hover {
            border-color: #9fb4d0;
        }

        .filter-surat-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.13);
        }

        .filter-surat-select optgroup {
            color: #1f2937;
            font-weight: 700;
        }

        .filter-surat-select option {
            color: #374151;
            font-weight: 400;
        }

        .filter-surat-chevron {
            position: absolute;
            top: 50%;
            right: 14px;
            display: inline-flex;
            width: 20px;
            height: 20px;
            color: #64748b;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .filter-surat-chevron svg {
            width: 100%;
            height: 100%;
        }

        .filter-reset-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 146px;
            height: 46px;
            padding: 0 16px;
            color: #344054;
            background: #ffffff;
            border: 1px solid #cfd8e3;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition:
                color 0.2s ease,
                border-color 0.2s ease,
                background-color 0.2s ease,
                transform 0.2s ease;
        }

        .filter-reset-button svg {
            width: 17px;
            height: 17px;
        }

        .filter-reset-button:hover {
            color: #1d4ed8;
            background: #eff6ff;
            border-color: #93b4ec;
            transform: translateY(-1px);
        }

        .filter-reset-button:disabled {
            opacity: 0.55;
            cursor: not-allowed;
            transform: none;
        }

        .filter-surat-result {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 13px;
            color: #667085;
            font-size: 12.5px;
        }

        .filter-result-dot {
            width: 8px;
            height: 8px;
            flex: 0 0 8px;
            background: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.12);
        }

        .filter-count-badge {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            margin-left: auto;
            padding: 3px 9px;
            color: #1d4ed8;
            background: #eaf2ff;
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* =========================================================
                   TABEL SURAT KELUAR
                ========================================================= */
        .table-responsive {
            border: 1px solid #e4e9f0;
            border-radius: 12px;
            overflow-x: auto;
            background: #ffffff;
        }

        .surat-table {
            min-width: 1120px;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            color: #344054;
            font-size: 13px;
        }

        .surat-table thead th {
            padding: 13px 12px;
            color: #475467;
            background: #f7f9fc;
            border-top: 0;
            border-bottom: 1px solid #dde4ed;
            font-size: 12px;
            font-weight: 700;
            text-transform: none;
            white-space: nowrap;
            vertical-align: middle;
        }

        .surat-table tbody td {
            padding: 12px;
            border-top: 0;
            border-bottom: 1px solid #edf0f4;
            vertical-align: middle;
        }

        .surat-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .surat-table tbody tr:nth-child(even) {
            background: #fbfcfe;
        }

        .surat-table tbody tr:hover {
            background: #f3f7ff;
        }

        .surat-table th:first-child,
        .surat-table td:first-child {
            width: 54px;
            text-align: center;
        }

        .surat-table th:nth-child(2),
        .surat-table td:nth-child(2) {
            min-width: 150px;
        }

        .surat-table .jenis-surat-cell {
            min-width: 235px;
            color: #334155;
            font-weight: 600;
        }

        .surat-table .btn {
            margin: 2px 3px 2px 0;
            border-radius: 7px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap;
        }

        .surat-table .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 24px;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 10.5px;
            font-weight: 700;
            white-space: nowrap;
        }

        #filterJenisSuratKosong td,
        #dataKosongAwal td {
            padding: 34px 16px;
            color: #667085;
            background: #ffffff;
            font-size: 13px;
        }

        @media (max-width: 767.98px) {
            .filter-surat-panel {
                padding: 15px;
            }

            .filter-surat-controls {
                grid-template-columns: 1fr;
            }

            .filter-reset-button {
                width: 100%;
            }

            .filter-surat-result {
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .filter-count-badge {
                margin-left: 16px;
            }
        }
    </style>

    <script>
        const data = {
            adminduk: [
                "SURAT PERNYATAAN TIDAK BISA MELAMPIRKAN KTP KEMATIAN",
                "SURAT PERNYATAAN NUMPANG KK",
                "SURAT PERNYATAAN MEMILIH NAMA ALIAS",
                "SURAT PERNYATAAN MEMILIH NAMA ALIAS SATU ORANG TUA",
                "SURAT PERNYATAAN DAN JAMINAN",
                "SURAT PERNYATAAN BELUM PERNAH MENGURUS AKTA KELAHIRAN",
                "SURAT PERNYATAAN BEDA NAMA BUKU NIKAH",
                "SURAT PERNYATAAN ANAK SEORANG NAMA IBU (BARU)",
                "SURAT PERNYATAAN AKTA BARCODE NOMOR SAMA-BARU ISI SENDIRI",
                "SPTJM KEMATIAN",
                "PERNYATAAN PERUBAHAN DATA PENDIDIKAN",
                "PERNYATAAN PEMBETULAN DATA TIDAK MERUBAH LAGI",
                "PERNYATAAN MENGIZINKAN IKUT KK SUAMI-ISTRI-KELUARGA",
                "PERMOHONAN PENGANTAR KEABSAHAN UNTUK DIRI SENDIRI",
                "PERMOHONAN PENGANTAR KEABSAHAN UNTUK ANAK",
                "FORM PERNYATAAN BATAL PINDAH",
                // "F-3.01 Formulir Pengajuan User ID",
                // "F-2.04 SPTJM SUAMI ISTRI",
                // "F-2.03 SPTJM KELAHIRAN",
                // "F-2.01 Form PELAPORAN CAPIL WILAYAH NKRI 1",
                // "F-1.09 Kartu Keluarga",
                // "F-1.08 Biodata Penduduk di wilayah NKRI dan WNI di luar wilayah NKRI",
                // "F-1.07 Surat Kuasa Dalam Pelayanan Administrasi Kependudukan",
                // "F-1.06 PERNYATAAN PERUBAHAN ELEMEN DATA Kependudukan",
                // "F-1.05 Surat Pernyataan Tanggung Jawab Mutlak Perkawinan Perceraian Belum Tercatat",
                // "F-1.04 Surat Pernyataan Tidak Memiliki Dokumen Kependudukan",
                // "F-1.03 PENDAFTARAN PERPINDAHAN PENDUDUK",
                // "F-1.02 PENDAFTARAN PERISTIWA KEPENDUDUKAN",
                // "F-1.01 FORM  BIODATA KELUARGA"
            ],
            keterangan: [
                "SURAT KETERANGAN KEHILANGAN",
                "SURAT KETERANGAN DESA PERNAH MENIKAH",
                "SURAT KETERANGAN TIDAK MAMPU",
                "SURAT KETERANGAN KEMATIAN DESA",
                "SURAT KETERANGAN WARIS",
                "SURAT KETERANGAN HARGA KEPEMILIKAN TANAH",
                "SURAT KETERANGAN NUMPANG NIKAH",
                "KETERANGAN PENGANTAR SKCK",
                "Surat Keterangan Desa Warga Miskin",
                "Surat Keterangan Kepemilikan Aset",
                "SURAT KETERANGAN USAHA",
                "SURAT KETERANGAN MISKIN ( SKM )",
                "SURAT KETERANGAN AHLI WARIS DESA",
                "SURAT KETERANGAN GHOIB",
                "SURAT KETERANGAN PENGHASILAN",
                "SURAT KETERANGAN DOMISILI USAHA",
                "SURAT KETERANGAN DOMISILI WARGA",
                "SURAT KETERANGAN DOMISILI LEMBAGA",
                "SURAT KETERANGAN DESA SEBAGAI PENDUDUK DESA"
            ],
            pernyataan: [
                "SURAT PERNYATAAN Kepemilikan Dokumen  Asli",
                "SURAT PERNYATAAN KESANGGUPAN",
                "Surat Pernyataan Tidak memiliki kartu JAMKESMAS,ASKES atau JKN",
                "Surat Pernyataan Miskin",
                "SURAT  IJIN KELUARGA",
                "SURAT  KUASA",
                "Permohonan Pembukaan Rekening Tabungan",
                "SURAT PERINTAH TUGAS",
                "SURAT PERINTAH PERJALANAN DINAS",
                "Undangan",
                "Rekomendasi",
                "FORMAT BLANGKO NOTA ANGKUTAN",
                "SURAT REKOMENDASI PEMBELIAN BBM JENIS TERTENTU",
                // "SURAT PENYELENGGARAAN KERAMAIAN",
                "Permohonan surat  Pernyataan miskin",
                "Surat Permohonan Tebang pohon"
            ]
        };

        const kategoriSelect = document.getElementById('kategori');
        const jenisFormSelect = document.getElementById('jenis_form');

        kategoriSelect.addEventListener('change', function() {
            const selected = this.value;
            jenisFormSelect.innerHTML = '<option value="">-- Pilih Jenis Form --</option>';
            jenisFormSelect.disabled = true;

            if (selected && data[selected]) {
                data[selected].forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item.toLowerCase()
                        .replace(/ /g, '_')
                        .replace(/[^a-z0-9_-]/g, '')
                        .replace(/_+/g, '_');
                    option.textContent = item;
                    jenisFormSelect.appendChild(option);
                });
                jenisFormSelect.disabled = false;
            }
        });

        /*
         * FILTER TABEL BERDASARKAN SELURUH JENIS SURAT
         *
         * Semua pilihan di bawah selalu ditampilkan, termasuk jenis surat
         * yang saat ini belum mempunyai data di tabel.
         */
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('filterJenisSurat');
            const resetButton = document.getElementById('resetFilterJenisSurat');
            const filterInfo = document.getElementById('filterJenisSuratInfo');
            const countBadge = document.getElementById('jumlahDataTampil');
            const emptyFilterRow = document.getElementById('filterJenisSuratKosong');

            const suratRows = Array.from(
                document.querySelectorAll('#suratKeluarBody .surat-row')
            );

            if (!filterSelect) {
                return;
            }

            /*
             * label = teks yang muncul pada dropdown.
             * keys  = nilai internal $jenisSurat pada setiap baris tabel.
             */
            const semuaJenisSurat = [{
                    kategori: 'ADMINDUK',
                    items: [{
                            label: 'SURAT PERNYATAAN TIDAK BISA MELAMPIRKAN KTP KEMATIAN',
                            keys: ['SuratPernyataanTidakBisaMelampirkanKtpKematian']
                        },
                        {
                            label: 'SURAT PERNYATAAN NUMPANG KK',
                            keys: ['SuratPernyataanNumpangKk']
                        },
                        {
                            label: 'SURAT PERNYATAAN MEMILIH NAMA ALIAS',
                            keys: ['surat_pernyataan_memilih_nama_alias']
                        },
                        {
                            label: 'SURAT PERNYATAAN MEMILIH NAMA ALIAS SATU ORANG TUA',
                            keys: ['surat_pernyataan_memilih_nama_alias_satu_orang_tua']
                        },
                        {
                            label: 'SURAT PERNYATAAN DAN JAMINAN',
                            keys: ['SuratPernyataanDanJaminan']
                        },
                        {
                            label: 'SURAT PERNYATAAN BELUM PERNAH MENGURUS AKTA KELAHIRAN',
                            keys: ['SuratPernyataanBelumAkta']
                        },
                        {
                            label: 'SURAT PERNYATAAN BEDA NAMA BUKU NIKAH',
                            keys: ['SuratPernyataanBedaNamaBukuNikah']
                        },
                        {
                            label: 'SURAT PERNYATAAN ANAK SEORANG NAMA IBU (BARU)',
                            keys: ['surat_pernyataan_anak_seorang_nama_ibu']
                        },
                        {
                            label: 'SURAT PERNYATAAN AKTA BARCODE NOMOR SAMA-BARU ISI SENDIRI',
                            keys: ['SuratPernyataanAktaBarcodeNomorSama']
                        },
                        {
                            label: 'SPTJM KEMATIAN',
                            keys: ['SptjmKematian']
                        },
                        {
                            label: 'PERNYATAAN PERUBAHAN DATA PENDIDIKAN',
                            keys: ['SuratPernyataanPerubahanDataPendidikan']
                        },
                        {
                            label: 'PERNYATAAN PEMBETULAN DATA TIDAK MERUBAH LAGI',
                            keys: ['SuratPernyataanPembetulanDataTidakMerubahLagi']
                        },
                        {
                            label: 'PERNYATAAN MENGIZINKAN IKUT KK SUAMI-ISTRI-KELUARGA',
                            keys: ['SuratPernyataanMengizinkanIkutKk']
                        },
                        {
                            label: 'PERMOHONAN PENGANTAR KEABSAHAN UNTUK DIRI SENDIRI',
                            keys: [
                                'surat_permohonan_pengantar_keabsahan_akta_kelahiran',
                                'SuratPermohonanPengantarKeabsahanAktaKelahiran'
                            ]
                        },
                        {
                            label: 'PERMOHONAN PENGANTAR KEABSAHAN UNTUK ANAK',
                            keys: [
                                'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak',
                                'SuratPermohonanPengantarKeabsahanAktaKelahiranAnak'
                            ]
                        },
                        {
                            label: 'FORM PERNYATAAN BATAL PINDAH',
                            keys: ['surat_pernyataan_batal_pindah_penduduk']
                        }
                    ]
                },
                {
                    kategori: 'KETERANGAN',
                    items: [{
                            label: 'SURAT KETERANGAN KEHILANGAN',
                            keys: ['SuratKeteranganKehilangan']
                        },
                        {
                            label: 'SURAT KETERANGAN DESA PERNAH MENIKAH',
                            keys: ['SuratKeteranganDesaPernahMenikah']
                        },
                        {
                            label: 'SURAT KETERANGAN TIDAK MAMPU',
                            keys: ['surat_keterangan_tidakmampu']
                        },
                        {
                            label: 'SURAT KETERANGAN KEMATIAN DESA',
                            keys: ['SuratKeteranganKematianDesa']
                        },
                        {
                            label: 'SURAT KETERANGAN WARIS',
                            keys: ['SuratKeteranganAhliWaris']
                        },
                        {
                            label: 'SURAT KETERANGAN HARGA KEPEMILIKAN TANAH',
                            keys: ['SuratKeteranganHargaKepemilikanTanah']
                        },
                        {
                            label: 'SURAT KETERANGAN NUMPANG NIKAH',
                            keys: ['surat_keterangan_numpang_nikah']
                        },
                        {
                            label: 'KETERANGAN PENGANTAR SKCK',
                            keys: ['SuratPengantarSkck']
                        },
                        {
                            label: 'SURAT KETERANGAN DESA WARGA MISKIN',
                            keys: ['SuratKeteranganDesaMiskin']
                        },
                        {
                            label: 'SURAT KETERANGAN KEPEMILIKAN ASET',
                            keys: ['SuratKeteranganKepemilikanAset']
                        },
                        {
                            label: 'SURAT KETERANGAN USAHA',
                            keys: ['SuratKeteranganUsaha']
                        },
                        {
                            label: 'SURAT KETERANGAN MISKIN (SKM)',
                            keys: ['SuratKeteranganMiskinSkm']
                        },
                        {
                            label: 'SURAT KETERANGAN AHLI WARIS DESA',
                            keys: ['surat_keterangan_ahli_waris_desa']
                        },
                        {
                            label: 'SURAT KETERANGAN GHOIB',
                            keys: ['surat_keterangan_ghoib']
                        },
                        {
                            label: 'SURAT KETERANGAN PENGHASILAN',
                            keys: ['SuratKeteranganPenghasilan']
                        },
                        {
                            label: 'SURAT KETERANGAN DOMISILI USAHA',
                            keys: [
                                'SuratKeteranganDomisiliUsaha',
                                'surat_keterangan_domisili_usaha'
                            ]
                        },
                        {
                            label: 'SURAT KETERANGAN DOMISILI WARGA',
                            keys: ['SuratKeteranganDomisiliWarga']
                        },
                        {
                            label: 'SURAT KETERANGAN DOMISILI LEMBAGA',
                            keys: ['SuratKeteranganDomisiliLembaga']
                        },
                        {
                            label: 'SURAT KETERANGAN DESA SEBAGAI PENDUDUK DESA',
                            keys: ['SuratKeteranganDesaSebagaiPenduduk']
                        }
                    ]
                },
                {
                    kategori: 'PERNYATAAN',
                    items: [{
                            label: 'SURAT PERNYATAAN KEPEMILIKAN DOKUMEN ASLI',
                            keys: ['SuratPernyataanKepemilikanDokumenAsli']
                        },
                        {
                            label: 'SURAT PERNYATAAN KESANGGUPAN',
                            keys: ['SuratPernyataanKesanggupan']
                        },
                        {
                            label: 'SURAT PERNYATAAN TIDAK MEMILIKI KARTU JAMKESMAS, ASKES, ATAU JKN',
                            keys: ['SuratPernyataanTidakPunyaKartuJkn']
                        },
                        {
                            label: 'SURAT PERNYATAAN MISKIN',
                            keys: ['SuratPernyataanMiskin']
                        },
                        {
                            label: 'SURAT IZIN KELUARGA',
                            keys: ['SuratIjinKeluarga']
                        },
                        {
                            label: 'SURAT KUASA',
                            keys: ['SuratKuasa']
                        },
                        {
                            label: 'PERMOHONAN PEMBUKAAN REKENING TABUNGAN',
                            keys: [
                                'PermohonanPembukaanRekening',
                                'SuratPermohonanPembukaanRekening',
                                'surat_permohonan_pembukaan_rekening'
                            ]
                        },
                        {
                            label: 'SURAT PERINTAH TUGAS',
                            keys: ['SuratPerintahTugas']
                        },
                        {
                            label: 'SURAT PERINTAH PERJALANAN DINAS',
                            keys: ['SuratPerintahPerjalananDinas']
                        },
                        {
                            label: 'UNDANGAN',
                            keys: ['SuratUndangan']
                        },
                        {
                            label: 'REKOMENDASI',
                            keys: ['SuratRekomendasi']
                        },
                        {
                            label: 'FORMAT BLANGKO NOTA ANGKUTAN',
                            keys: ['SuratNotaAngkutan', 'surat_nota_angkutan']
                        },
                        {
                            label: 'SURAT REKOMENDASI PEMBELIAN BBM JENIS TERTENTU',
                            keys: ['SuratRekomendasiBbm', 'surat_rekomendasi_bbm']
                        },
                        {
                            label: 'SURAT PENYELENGGARAAN KERAMAIAN',
                            keys: [
                                'SuratPenyelenggaraanKeramaian',
                                'surat_penyelenggaraan_keramaian'
                            ]
                        },
                        {
                            label: 'PERMOHONAN SURAT PERNYATAAN MISKIN',
                            keys: [
                                'SuratPermohonanPernyataanMiskin',
                                'surat_permohonan_pernyataan_miskin'
                            ]
                        },
                        {
                            label: 'SURAT PERMOHONAN TEBANG POHON',
                            keys: [
                                'SuratPermohonanTebangPohon',
                                'surat_permohonan_tebang_pohon'
                            ]
                        }
                    ]
                }
            ];

            const normalizeKey = function(value) {
                return String(value || '').trim().toLocaleLowerCase('id-ID');
            };

            /*
             * Hitung jumlah data aktual untuk setiap internal key.
             */
            const jumlahPerKey = new Map();

            suratRows.forEach(function(row) {
                const key = normalizeKey(row.dataset.jenisSurat);

                if (key) {
                    jumlahPerKey.set(key, (jumlahPerKey.get(key) || 0) + 1);
                }
            });

            /*
             * Buat seluruh option menggunakan optgroup per kategori.
             */
            semuaJenisSurat.forEach(function(group) {
                const optgroup = document.createElement('optgroup');
                optgroup.label = group.kategori;

                group.items.forEach(function(item) {
                    const normalizedKeys = item.keys.map(normalizeKey);

                    const jumlah = normalizedKeys.reduce(function(total, key) {
                        return total + (jumlahPerKey.get(key) || 0);
                    }, 0);

                    const option = document.createElement('option');
                    option.value = normalizeKey(item.label);
                    option.dataset.keys = normalizedKeys.join('|');
                    option.textContent = jumlah > 0 ?
                        `${item.label} — ${jumlah} data` :
                        item.label;

                    optgroup.appendChild(option);
                });

                filterSelect.appendChild(optgroup);
            });

            function terapkanFilterJenisSurat() {
                const selectedOption =
                    filterSelect.options[filterSelect.selectedIndex];

                const selectedKeys = String(
                        selectedOption?.dataset.keys || ''
                    )
                    .split('|')
                    .map(normalizeKey)
                    .filter(Boolean);

                const labelTerpilih =
                    selectedOption?.textContent
                    ?.replace(/\s+—\s+\d+\s+data$/i, '')
                    .trim() || 'Semua Jenis Surat';

                let jumlahTampil = 0;

                suratRows.forEach(function(row) {
                    const rowKey = normalizeKey(row.dataset.jenisSurat);

                    const harusTampil =
                        selectedKeys.length === 0 ||
                        selectedKeys.includes(rowKey);

                    row.classList.toggle('d-none', !harusTampil);

                    if (harusTampil) {
                        jumlahTampil++;

                        const nomorCell = row.querySelector('.nomor-urut');

                        if (nomorCell) {
                            nomorCell.textContent = jumlahTampil;
                        }
                    }
                });

                if (emptyFilterRow) {
                    emptyFilterRow.classList.toggle(
                        'd-none',
                        jumlahTampil !== 0
                    );
                }

                if (filterInfo) {
                    filterInfo.textContent = selectedKeys.length === 0 ?
                        'Menampilkan seluruh jenis surat.' :
                        `Menampilkan jenis: ${labelTerpilih}.`;
                }

                if (countBadge) {
                    countBadge.textContent = `${jumlahTampil} data`;
                }

                if (resetButton) {
                    resetButton.disabled = selectedKeys.length === 0;
                }
            }

            filterSelect.addEventListener(
                'change',
                terapkanFilterJenisSurat
            );

            resetButton?.addEventListener('click', function() {
                filterSelect.selectedIndex = 0;
                terapkanFilterJenisSurat();
                filterSelect.focus();
            });

            terapkanFilterJenisSurat();
        });
    </script>
@endsection
