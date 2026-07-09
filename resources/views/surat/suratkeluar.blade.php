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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
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
                                <tbody>
                                    @php use Illuminate\Support\Str; @endphp
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
                                                'App\Models\SuratNotaAngkutan' => 'SuratNotaAngkutan',
                                                'App\Models\SuratPermohonanPernyataanMiskin'
                                                    => 'SuratPermohonanPernyataanMiskin',
                                                'surat_permohonan_pernyataan_miskin'
                                                    => 'SuratPermohonanPernyataanMiskin',
                                                'App\Models\SuratPermohonanTebangPohon' => 'SuratPermohonanTebangPohon',
                                                'surat_permohonan_tebang_pohon' => 'SuratPermohonanTebangPohon',
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
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <a href="{{ route('surat.export-pdf', ['jenis' => strtolower($jenisSurat), 'id' => $item->_id]) }}"
                                                    class="btn btn-success btn-sm" target="_blank">Export PDF</a>

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
                                                    {{ $item->nama_kepala_desa ?? '-' }}
                                                @elseif ($jenisSurat === 'SuratKeteranganAhliWaris')
                                                    {{ $item->nama_lengkap ?? '-' }}
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
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            {{-- Jenis Surat --}}
                                            {{-- Jenis Surat (Nama yang Rapi) --}}
                                            <td>
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
                                                <a href="https://wa.me/{{ $wa }}" target="_blank"
                                                    class="btn btn-success btn-sm">{{ $item->nowa }}</a>

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
                                                @elseif ($jenisSurat === 'SuratKuasa')
                                                    {{ $item->p1_alamat ?? '-' }}
                                                @elseif ($jenisSurat === 'PermohonanPembukaanRekening' || $jenisSurat === 'surat_permohonan_pembukaan_rekening')
                                                    {{ $item->alamat_kepala_desa ?? '-' }}
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
                                        <tr>
                                            <td colspan="10" class="text-center">Belum ada data.</td>
                                        </tr>
                                    @endif
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
                "SURAT KETERANGAN AHLI WARIS",
                "SURAT KETERANGAN GHOIB",
                "SURAT KETERANGAN PENGHASILAN",
                "SURAT KETERANGAN DOMISILI USAHA",
                "SURAT KETERANGAN DOMISILI WARGA",
                "SURAT KETERANGAN DOMISILI LEMBAGA"
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
                "SURAT PENYELENGGARAAN KERAMAIAN",
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
                        .replace(/_+/g, '_'); // <-- tambahkan tanda strip (-)
                    option.textContent = item;
                    jenisFormSelect.appendChild(option);
                });
                jenisFormSelect.disabled = false;
            }
        });
    </script>
@endsection
