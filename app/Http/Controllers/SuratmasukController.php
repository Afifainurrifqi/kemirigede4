<?php

namespace App\Http\Controllers;

use App\Models\suratmasuk;
use App\Http\Requests\StoresuratmasukRequest;
use App\Http\Requests\UpdatesuratmasukRequest;
use App\Models\nama_alias_ortu;
use App\Models\surat_keterangan_ahli_waris;
use App\Models\surat_keterangan_desa_pernah_menikah;
use App\Models\surat_keterangan_harga_kepemilikan_tanah;
use App\Models\surat_keterangan_kehilangan;
use App\Models\surat_keterangan_kematian_desa;
use App\Models\surat_keterangan_numpang_nikah;
use App\Models\surat_keterangan_penghasilan;

use App\Models\surat_permohonan_pembukaan_rekening;
use App\Models\surat_permohonan_pengantar_keabsahan_akta_kelahiran;
use App\Models\surat_pernyataan_akta_barcode_nomor_sama;
use App\Models\surat_pernyataan_anak_seorang_nama_ibu;
use App\Models\surat_pernyataan_beda_nama_buku_nikah;
use App\Models\surat_pernyataan_belum_akta;
use App\Models\surat_pernyataan_dan_jaminan;
use App\Models\surat_pernyataan_kesanggupan;
use App\Models\surat_pernyataan_memilih_nama_alias;
use App\Models\surat_pernyataan_mengizinkan_ikut_kk;
use App\Models\surat_pernyataan_numpang_kk;
use App\Models\surat_pernyataan_pembetulan_data_tidak_merubah_lagi;
use App\Models\surat_pernyataan_perubahan_data_pendidikan;
use App\Models\surat_pernyataan_tidak_bisa_melampirkan_ktp_kematian;
use App\Models\surat_sptjm_kematian;
use App\Models\SuratIjinKeluarga;
use App\Models\SuratKeteranganDesaMiskin;
use App\Models\SuratKeteranganDesaSebagaiPenduduk;
use App\Models\SuratKeteranganDomisiliLembaga;
use App\Models\SuratKeteranganDomisiliWarga;
use App\Models\SuratKeteranganKepemilikanAset;
use App\Models\SuratKeteranganMiskinSkm;
use App\Models\suratketerangantidakmampu;
use App\Models\SuratKeteranganUsaha;
use App\Models\SuratKuasa;
use App\Models\SuratNotaAngkutan;
use App\Models\SuratPengantarSkck;
use App\Models\SuratPerintahPerjalananDinas;
use App\Models\SuratPerintahTugas;
use App\Models\SuratPermohonanPembukaanRekening;
use App\Models\SuratPermohonanPernyataanMiskin;
use App\Models\SuratPermohonanTebangPohon;
use App\Models\SuratPernyataanKepemilikanDokumenAsli;
use App\Models\SuratPernyataanKesanggupan;
use App\Models\SuratPernyataanMiskin;
use App\Models\SuratPernyataanTidakPunyaKartuJkn;
use App\Models\SuratRekomendasi;
use App\Models\SuratRekomendasiBbm;
use App\Models\SuratUndangan;
use App\Services\SuratDocxService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SuratMasuk::all(); // Ambil semua data dari MongoDB
        return view('surat.suratmasuk', compact('data'));
    }

    public function arsipsuratmasuk()
    {
        return view('surat.arsipsuratmasuk');
    }


    public function suratkeluar(Request $request)
    {
        $data = collect();

        /*
         * Hanya ambil surat yang BELUM memenuhi syarat arsip.
         *
         * Surat dengan:
         * - status_surat = Di terima
         * - status_verif = Terverifikasi
         *
         * tidak boleh tampil di Surat Keluar.
         */
        foreach ($this->daftarModelSuratKeluar() as $model) {
            $data = $data->merge(
                $this->ambilSuratBelumArsip($model)
            );
        }

        $data = $data
            ->unique(function ($item) {
                return get_class($item)
                    . '|'
                    . (string) $item->getKey();
            })
            ->values();

        /*
         * Pemeriksaan opsional:
         * /surat/suratkeluar?debug_surat=1
         */
        if ($request->boolean('debug_surat')) {
            $notaSemua = SuratNotaAngkutan::all();
            $bbmSemua = SuratRekomendasiBbm::all();

            return response()->json([
                'database' => config(
                    'database.connections.mongodb.database'
                ),

                'nota_angkutan' => [
                    'collection' => (new SuratNotaAngkutan())
                        ->getCollection(),
                    'semua' => $notaSemua->count(),
                    'surat_keluar' => $notaSemua
                        ->reject(fn($item) => $this->sudahMasukArsip($item))
                        ->count(),
                    'arsip' => $notaSemua
                        ->filter(fn($item) => $this->sudahMasukArsip($item))
                        ->count(),
                ],

                'rekomendasi_bbm' => [
                    'collection' => (new SuratRekomendasiBbm())
                        ->getCollection(),
                    'semua' => $bbmSemua->count(),
                    'surat_keluar' => $bbmSemua
                        ->reject(fn($item) => $this->sudahMasukArsip($item))
                        ->count(),
                    'arsip' => $bbmSemua
                        ->filter(fn($item) => $this->sudahMasukArsip($item))
                        ->count(),
                ],

                'total_surat_keluar' => $data->count(),
            ]);
        }

        return view(
            'surat.suratkeluar',
            compact('data')
        );
    }

    public function arsipsuratkeluar()
    {
        $data = collect();

        foreach ($this->daftarModelSuratKeluar() as $model) {
            $data = $data->merge(
                $this->ambilSuratSudahArsip($model)
            );
        }

        $data = $data
            ->unique(function ($item) {
                return get_class($item) .
                    '|' .
                    (string) $item->getKey();
            })
            ->values();

        return view(
            'surat.arsipsuratkeluar',
            compact('data')
        );
    }

    /**
     * Daftar semua model surat yang masuk ke Surat Keluar dan Arsip Surat.
     */
    private function daftarModelSuratKeluar(): array
    {
        return [
            surat_pernyataan_tidak_bisa_melampirkan_ktp_kematian::class,
            surat_keterangan_kehilangan::class,
            surat_pernyataan_numpang_kk::class,
            SuratPermohonanPernyataanMiskin::class,
            SuratKuasa::class,
            suratketerangantidakmampu::class,
            SuratNotaAngkutan::class,
            surat_pernyataan_memilih_nama_alias::class,
            SuratPernyataanMiskin::class,
            nama_alias_ortu::class,
            surat_pernyataan_dan_jaminan::class,
            surat_keterangan_desa_pernah_menikah::class,
            surat_keterangan_kematian_desa::class,
            surat_keterangan_ahli_waris::class,
            SuratPernyataanKesanggupan::class,
            SuratPermohonanPembukaanRekening::class,
            surat_pernyataan_belum_akta::class,
            surat_pernyataan_beda_nama_buku_nikah::class,
            surat_pernyataan_anak_seorang_nama_ibu::class,
            surat_pernyataan_akta_barcode_nomor_sama::class,
            surat_sptjm_kematian::class,
            surat_keterangan_harga_kepemilikan_tanah::class,
            SuratPerintahTugas::class,
            SuratPengantarSkck::class,
            surat_pernyataan_perubahan_data_pendidikan::class,
            surat_pernyataan_pembetulan_data_tidak_merubah_lagi::class,
            surat_pernyataan_mengizinkan_ikut_kk::class,
            surat_permohonan_pengantar_keabsahan_akta_kelahiran::class,
            \App\Models\surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak::class,
            \App\Models\surat_pernyataan_batal_pindah_penduduk::class,
            \App\Models\surat_formulir_pengajuan_user_id::class,
            \App\Models\surat_sptjm_suami_istri::class,
            surat_keterangan_numpang_nikah::class,
            SuratKeteranganUsaha::class,
            SuratKeteranganDesaMiskin::class,
            SuratKeteranganMiskinSkm::class,
            \App\Models\surat_keterangan_ahli_waris_desa::class,
            \App\Models\surat_keterangan_ghoib::class,
            surat_keterangan_penghasilan::class,
            SuratKeteranganDesaSebagaiPenduduk::class,
            SuratKeteranganDomisiliLembaga::class,
            SuratRekomendasiBbm::class,
            SuratKeteranganDomisiliWarga::class,
            SuratRekomendasi::class,
            SuratIjinKeluarga::class,
            SuratKeteranganKepemilikanAset::class,
            SuratUndangan::class,
            SuratPerintahPerjalananDinas::class,
            SuratPermohonanTebangPohon::class,
            SuratPernyataanTidakPunyaKartuJkn::class,
            SuratPernyataanKepemilikanDokumenAsli::class,
        ];
    }

    /**
     * Surat yang masih tampil di Surat Keluar.
     *
     * Akan tetap tampil selama BELUM memenuhi dua syarat:
     * - status_surat = Di terima
     * - status_verif = Terverifikasi
     */
    private function ambilSuratBelumArsip(string $model)
    {
        return $model::all()
            ->reject(function ($item) {
                return $this->sudahMasukArsip($item);
            })
            ->values();
    }

    /**
     * Surat yang tampil di Arsip Surat Keluar.
     *
     * Hanya tampil jika kedua status sudah terpenuhi.
     */
    private function ambilSuratSudahArsip(string $model)
    {
        return $model::all()
            ->filter(function ($item) {
                return $this->sudahMasukArsip($item);
            })
            ->values();
    }

    /**
     * Normalisasi status agar perbedaan spasi dan kapitalisasi
     * tidak mengganggu pemindahan surat ke arsip.
     *
     * Contoh yang dianggap sama:
     * - "Di terima"
     * - "di terima"
     * - "Diterima"
     */
    private function sudahMasukArsip($item): bool
    {
        $statusSurat = preg_replace(
            '/[^a-z0-9]+/',
            '',
            mb_strtolower(
                trim(
                    (string) data_get(
                        $item,
                        'status_surat',
                        ''
                    )
                )
            )
        );

        $statusVerif = preg_replace(
            '/[^a-z0-9]+/',
            '',
            mb_strtolower(
                trim(
                    (string) data_get(
                        $item,
                        'status_verif',
                        ''
                    )
                )
            )
        );

        return (
            $statusSurat === 'diterima'
            && $statusVerif === 'terverifikasi'
        );
    }


    public function prosesForm(Request $request)
    {
        $request->validate([
            'kategori'   => 'required|string',
            'jenis_form' => 'required|string',
        ]);

        $kategori = Str::of($request->kategori)
            ->lower()
            ->trim()
            ->toString();

        /*
         * Normalisasi nilai jenis_form agar nilai dari JavaScript,
         * tulisan manual, spasi ganda, tanda hubung, dan kapitalisasi
         * menghasilkan key yang konsisten.
         *
         * Contoh:
         * "Permohonan surat  Pernyataan miskin"
         * menjadi:
         * "permohonan_surat_pernyataan_miskin"
         */
        $jenis_form = Str::of($request->jenis_form)
            ->lower()
            ->ascii()
            ->replaceMatches('/[^a-z0-9]+/', '_')
            ->trim('_')
            ->toString();

        /*
         * =====================================================
         * SURAT MISKIN
         * =====================================================
         *
         * Dua surat ini berbeda dan harus diarahkan ke route
         * yang berbeda:
         *
         * 1. Surat Pernyataan Miskin
         * 2. Permohonan Surat Pernyataan Miskin
         */

        // SURAT PERNYATAAN MISKIN
        if (
            $kategori === 'pernyataan' &&
            in_array($jenis_form, [
                'surat_pernyataan_miskin',
                'pernyataan_miskin',
            ], true)
        ) {
            return redirect()->route(
                'surat.pernyataan_miskin.index'
            );
        }

        // PERMOHONAN SURAT PERNYATAAN MISKIN
        if (
            in_array($kategori, [
                'pernyataan',
                'keterangan',
            ], true) &&
            in_array($jenis_form, [
                'permohonan_surat_pernyataan_miskin',
                'surat_permohonan_pernyataan_miskin',
                'permohonan_pernyataan_miskin',
            ], true)
        ) {
            return redirect()->route(
                'surat.permohonan_pernyataan_miskin.index'
            );
        }

        // =====================================================
        // ==================== ADMINDUK =======================
        // =====================================================

        // Pengantar Keabsahan
        if ($kategori === 'adminduk' && Str::contains($jenis_form, 'pengantar_keabsahan_untuk_diri')) {
            return redirect()->route('surat.pengantar_keabsahan.index');
        }

        if ($kategori === 'adminduk' && Str::contains($jenis_form, 'pengantar_keabsahan_untuk_anak')) {
            return redirect()->route('surat.pengantar_keabsahan_anak.index');
        }

        // Formulir Pengajuan User ID (F-3.01)
        if ($kategori === 'adminduk' && Str::contains($jenis_form, 'formulir_pengajuan_user_id')) {
            return redirect()->route('surat.formulir_pengajuan_user_id.index');
        }

        // === TAMBAHKAN DI SINI ===
        if (
            $kategori === 'pernyataan' &&
            (Str::contains(strtolower($jenis_form), 'rekomendasi_bbm') ||
                Str::contains(strtolower($jenis_form), 'bbm'))
        ) {
            return redirect()->route('surat.rekomendasi_bbm.index');
        }

        if ($kategori === 'pernyataan' && $jenis_form === 'surat_perintah_tugas') {
            return redirect()->route('surat.perintah_tugas.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_ahli_waris_desa') {
            return redirect()->route('surat.ahliwarisdesa.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_penghasilan') {
            return redirect()->route('surat.penghasilan.index');   // sesuaikan nama route loe
        }

        if ($kategori === 'pernyataan' && Str::contains($jenis_form, 'rekomendasi')) {
            return redirect()->route('surat.rekomendasi.index');
        }

        // Batal Pindah Penduduk
        if ($kategori === 'adminduk' && Str::contains($jenis_form, 'batal_pindah')) {
            return redirect()->route('surat.batal_pindah.index');
        }
        if (
            ($kategori === 'pernyataan' || $kategori === 'keterangan') &&
            (Str::contains(strtolower($jenis_form), 'tebang_pohon') ||
                Str::contains(strtolower($jenis_form), 'permohonan tebang pohon') ||
                Str::contains(strtolower($jenis_form), 'tebangpohon'))
        ) {
            return redirect()->route('surat.permohonan_tebang_pohon.index');
        }

        // Lainnya (Adminduk)
        if ($kategori === 'adminduk' && $jenis_form === 'pernyataan_pembetulan_data_tidak_merubah_lagi') {
            return redirect()->route('surat.pembetulandata.index');
        }

        if ($kategori === 'pernyataan' && Str::contains($jenis_form, 'nota_angkutan')) {
            return redirect()->route('surat.nota_angkutan.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_domisili_warga') {
            return redirect()->route('surat.domisili_warga.index');
        }

        /*
|--------------------------------------------------------------------------
| Surat Pernyataan Mengizinkan Ikut KK Suami, Istri, atau Keluarga
|--------------------------------------------------------------------------
*/

        if (
            $kategori === 'adminduk' &&
            in_array($jenis_form, [
                'surat_pernyataan_mengizinkan_ikut_kk_suami_istri_keluarga',
                'pernyataan_mengizinkan_ikut_kk_suami_istri_keluarga',
                'surat_mengizinkan_ikut_kk_suami_istri_keluarga',
                'mengizinkan_ikut_kk_suami_istri_keluarga',
            ], true)
        ) {
            return redirect()->route('surat.izinkk.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_numpang_kk') {
            return redirect()->route('surat.numpangkk.create');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_tidak_bisa_melampirkan_ktp_kematian') {
            return redirect()->route('surat.suratpernyataantidakbisamelampirkanktpkematian');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_desa_warga_miskin') {
            return redirect()->route('surat.miskindesa.index');
        }

        if ($kategori === 'keterangan' && Str::contains($jenis_form, 'perintah_tugas')) {
            return redirect()->route('surat.perintah_tugas.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_memilih_nama_alias') {
            return redirect()->route('surat.namaalias.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_memilih_nama_alias_satu_orang_tua') {
            return redirect()->route('surat.namaaliasortu.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_dan_jaminan') {
            return redirect()->route('surat.pernyataandanjaminan.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_belum_pernah_mengurus_akta_kelahiran') {
            return redirect()->route('surat.belumakta.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_beda_nama_buku_nikah') {
            return redirect()->route('surat.bedanama.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'surat_pernyataan_anak_seorang_nama_ibu_baru') {
            return redirect()->route('surat.anakseorangibu.index');
        }

        if (
            $kategori === 'adminduk' &&
            Str::contains(strtolower($jenis_form), 'akta_barcode')
        ) {
            return redirect()->route('surat.aktabarcode.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'sptjm_kematian') {
            return redirect()->route('surat.sptjm.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_ghoib') {
            return redirect()->route('surat.ghoib.index');
        }

        if ($kategori === 'adminduk' && $jenis_form === 'pernyataan_perubahan_data_pendidikan') {
            return redirect()->route('surat.perubahdatapendidikan.index');
        }

        // =====================================================
        // ==================== KETERANGAN =====================
        // =====================================================

        if ($kategori == 'keterangan' && $jenis_form == 'surat_keterangan_kehilangan') {
            return redirect()->route('surat.surat_keterangan_kehilangan');
        }

        if ($kategori === 'pernyataan' && $jenis_form === 'surat_kuasa') {
            return redirect()->route('surat.kuasa.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_tidak_mampu') {
            return redirect()->route('surat.tidakmampu.create');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_desa_pernah_menikah') {
            return redirect()->route('surat.pernahmenikah.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_kematian_desa') {
            return redirect()->route('surat.kematian.index');
        }

        // Surat Keterangan Ahli Waris
        if (
            $kategori === 'keterangan' &&
            in_array($jenis_form, [
                'surat_keterangan_waris',
                'surat_keterangan_ahli_waris',
            ], true)
        ) {
            return redirect()->route('surat.ahliwaris.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_harga_kepemilikan_tanah') {
            return redirect()->route('surat.kepemilikantanah.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'keterangan_pengantar_skck') {
            return redirect()->route('surat.skck.index');
        }

        // =====================================================
        // ==================== PERNYATAAN =====================
        // =====================================================

        if ($kategori === 'pernyataan' && $jenis_form === 'surat_pernyataan_kesanggupan') {
            return redirect()->route('surat.pernyataan_kesanggupan.index');
        }
        if ($kategori === 'pernyataan' && Str::contains($jenis_form, 'perintah_perjalanan_dinas')) {
            return redirect()->route('surat.perintah_perjalanan_dinas.index');
        }




        if (
            $kategori === 'pernyataan' &&
            Str::contains($jenis_form, 'permohonan_pembukaan_rekening')
        ) {
            return redirect()->route('surat.bukaanrekening.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_numpang_nikah') {
            return redirect()->route('surat.numpangnikah.index');
        }

        if ($kategori === 'adminduk' && Str::contains($jenis_form, 'sptjm_suami_istri')) {
            return redirect()->route('surat.sptjm_suami_istri.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_usaha') {
            return redirect()->route('surat.usaha.index');
        }
        if ($kategori === 'keterangan' && Str::contains($jenis_form, 'surat_keterangan_miskin')) {
            return redirect()->route('surat.skm.index');
        }
        if (
            $kategori === 'keterangan' &&
            in_array($jenis_form, [
                'surat_keterangan_desa_sebagai_penduduk',
                'surat_keterangan_desa_sebagai_penduduk_desa',
            ], true)
        ) {
            return redirect()->route('surat.desa_penduduk.index');
        }

        if ($kategori === 'pernyataan' && $jenis_form === 'surat_ijin_keluarga') {
            return redirect()->route('surat.ijin_keluarga.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_domisili_lembaga') {
            return redirect()->route('surat.domisili_lembaga.index');
        }

        if ($kategori === 'keterangan' && $jenis_form === 'surat_keterangan_kepemilikan_aset') {
            return redirect()->route('surat.kepemilikan_aset.index');
        }

        if ($kategori === 'pernyataan' && $jenis_form === 'surat_pernyataan_kesanggupan') {
            return redirect()->route('surat.pernyataan_kesanggupan.index');
        } // ← TAMBAHKAN DI BAWAH INI

        if ($kategori === 'pernyataan' && Str::contains($jenis_form, 'undangan')) {
            return redirect()->route('surat.undangan.index');
        }




        if (
            $kategori === 'pernyataan' &&
            ($jenis_form === 'surat_pernyataan_tidak_punya_kartu_jkn' ||
                Str::contains($jenis_form, 'jamkesmas') ||
                Str::contains($jenis_form, 'tidak_punya_kartu'))
        ) {

            return redirect()->route('surat.pernyataan_tidak_punya_kartu_jkn.index');
        }

        if (
            $kategori === 'pernyataan' &&
            (Str::contains($jenis_form, 'kepemilikan_dokumen_asli') ||
                $jenis_form === 'surat_pernyataan_kepemilikan_dokumen_asli')
        ) {

            return redirect()->route('surat.pernyataan_kepemilikan_dokumen.index');
        }
        // Jika tidak ada yang cocok
        return redirect()->back()->withErrors(['jenis_form' => 'Form tidak ditemukan.']);
    }




    public function tambahsuratmasuk()
    {
        return view('surat.tambahsuratmasuk');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function exportPdf($jenis, $id)
    {

        if (
            $jenis === 'suratpernyataanmengizinkanikutkk' ||
            $jenis === 'pernyataan_mengizinkan_ikut_kk_suami_istri_keluarga'
        ) {
            $data = surat_pernyataan_mengizinkan_ikut_kk::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_pernyataan_mengizinkan_ikut_kk', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_mengizinkan_ikut_kk_' . $filename . '.pdf');
        }

        if (
            $jenis === 'suratketerangandesasebagaipenduduk' ||
            $jenis === 'surat_keterangan_desa_sebagai_penduduk' ||
            $jenis === 'desa_penduduk' ||
            $jenis === 'desa-sebagai-penduduk'
        ) {
            $data = SuratKeteranganDesaSebagaiPenduduk::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_desa_sebagai_penduduk', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_lengkap ?? 'desa_penduduk', '_');

            return $pdf->download('surat_keterangan_desa_sebagai_penduduk_' . $filename . '.pdf');
        }

        // SURAT KUASA
        if ($jenis === 'suratkuasa' || $jenis === 'surat_kuasa' || $jenis === 'kuasa') {
            $data = SuratKuasa::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_kuasa', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_pihak1 ?? 'surat_kuasa', '_');

            return $pdf->download('surat_kuasa_' . $filename . '.pdf');
        }

        // SURAT PERNYATAAN MISKIN
        if (
            $jenis === 'surat_pernyataan_miskin' ||
            $jenis === 'pernyataan_miskin' ||
            $jenis === 'suratpernyataanmiskin'
        ) {
            $data = SuratPernyataanMiskin::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_miskin', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'pernyataan_miskin', '_');

            return $pdf->download('surat_pernyataan_miskin_' . $filename . '.pdf');
        }

        // SURAT REKOMENDASI PEMBELIAN BBM
        // SURAT REKOMENDASI PEMBELIAN BBM
        if (
            Str::contains(strtolower($jenis), 'rekomendasi_bbm') ||
            $jenis === 'surat_rekomendasi_bbm' ||
            $jenis === 'surat-rekomendasi-bbm' ||
            $jenis === 'rekomendasi_bbm' ||
            $jenis === 'suratrekomendasibbm' ||           // ← TAMBAHKAN INI
            strtolower($jenis) === 'suratrekomendasibbm'
        ) {
            $data = SuratRekomendasiBbm::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_rekomendasi_bbm', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_lengkap ?? 'rekomendasi_bbm', '_');

            return $pdf->download('surat_rekomendasi_pembelian_bbm_' . $filename . '.pdf');
        }

        // SURAT PERMOHONAN PERNYATAAN MISKIN
        // SURAT PERMOHONAN PERNYATAAN MISKIN
        if (
            Str::contains(strtolower($jenis), 'permohonan_pernyataan_miskin') ||
            Str::contains(strtolower($jenis), 'permohonanpernyataanmiskin') ||   // ← TAMBAHKAN INI
            $jenis === 'surat_permohonan_pernyataan_miskin' ||
            $jenis === 'suratpermohonanpernyataanmiskin' ||                      // ← TAMBAHKAN INI
            $jenis === 'permohonan_pernyataan_miskin'
        ) {
            $data = SuratPermohonanPernyataanMiskin::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_permohonan_pernyataan_miskin', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_lengkap ?? 'permohonan_miskin', '_');

            return $pdf->download('surat_permohonan_pernyataan_miskin_' . $filename . '.pdf');
        }

        // SURAT PERMOHONAN TEBANG POHON
        if (
            Str::contains(strtolower($jenis), 'permohonan_tebang_pohon') ||
            Str::contains(strtolower($jenis), 'tebangpohon') ||
            $jenis === 'surat_permohonan_tebang_pohon' ||
            $jenis === 'permohonan_tebang_pohon'
        ) {
            $data = SuratPermohonanTebangPohon::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_permohonan_tebang_pohon', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'tebang_pohon', '_');

            return $pdf->download('surat_permohonan_tebang_pohon_' . $filename . '.pdf');
        }

        if (
            Str::contains(strtolower($jenis), 'nota_angkutan') ||
            Str::contains(strtolower($jenis), 'notaangkutan') ||
            $jenis === 'surat_nota_angkutan'
        ) {
            $data = SuratNotaAngkutan::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_nota_angkutan', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_pengirim ?? 'nota_angkutan', '_');

            return $pdf->download('nota_angkutan_' . $filename . '.pdf');
        }

        // SURAT IJIN KELUARGA
        if (
            $jenis === 'surat_ijin_keluarga' ||
            $jenis === 'ijin_keluarga' ||
            $jenis === 'suratijin_keluarga' ||
            $jenis === 'suratijinkeluarga'
        ) {
            $data = SuratIjinKeluarga::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_ijin_keluarga', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_suami ?? 'ijin_keluarga', '_');

            return $pdf->download('surat_ijin_keluarga_' . $filename . '.pdf');
        }

        // ================================================
        // SURAT PERINTAH PERJALANAN DINAS (SPPD)
        // ================================================
        if (
            Str::contains(strtolower($jenis), 'perintah_perjalanan_dinas') ||
            Str::contains(strtolower($jenis), 'perjalanan_dinas') ||
            Str::contains(strtolower($jenis), 'sppd') ||
            $jenis === 'surat_perintah_perjalanan_dinas' ||
            $jenis === 'perintahperjalanandinas' ||
            $jenis === 'suratperintahperjalanandinas'
        ) {
            $data = SuratPerintahPerjalananDinas::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_perintah_perjalanan_dinas', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_pegawai ?? 'sppd', '_');

            return $pdf->download('surat_perintah_perjalanan_dinas_' . $filename . '.pdf');
        }

        // ================================================
        // SURAT UNDANGAN
        // ================================================
        if (
            Str::contains(strtolower($jenis), 'undangan') ||
            $jenis === 'surat_undangan' ||
            $jenis === 'suratundangan'
        ) {
            $data = SuratUndangan::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_undangan', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->perihal ?? 'undangan', '_');

            return $pdf->download('surat_undangan_' . $filename . '.pdf');
        }

        if (in_array($jenis, ['surat_keterangan_kepemilikan_aset', 'kepemilikan_aset', 'suratketerangankepemilikanaset'])) {
            $data = SuratKeteranganKepemilikanAset::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_kepemilikan_aset', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'kepemilikan_aset', '_');

            return $pdf->download('surat_keterangan_kepemilikan_aset_' . $filename . '.pdf');
        }

        if (in_array($jenis, ['surat_pernyataan_kepemilikan_dokumen_asli', 'pernyataan_kepemilikan_dokumen', 'suratpernyataankepemilikandokumenasli'])) {
            $data = SuratPernyataanKepemilikanDokumenAsli::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_kepemilikan_dokumen_asli', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'pernyataan_dokumen', '_');

            return $pdf->download('surat_pernyataan_kepemilikan_dokumen_asli_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_keterangan_penghasilan' ||
            $jenis === 'suratketeranganpenghasilan' ||
            $jenis === 'penghasilan'
        ) {
            $data = surat_keterangan_penghasilan::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_penghasilan', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_lengkap ?? 'keterangan_penghasilan', '_');

            return $pdf->download('surat_keterangan_penghasilan_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_keterangan_domisili_warga' ||
            $jenis === 'domisili_warga' ||
            $jenis === 'suratketerangandomisiliwarga'
        ) {
            $data = SuratKeteranganDomisiliWarga::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_domisili_warga', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_lengkap ?? 'domisili_warga', '_');

            return $pdf->download('surat_keterangan_domisili_warga_' . $filename . '.pdf');
        }

        // ====================== SURAT PERINTAH TUGAS ======================
        if (
            $jenis === 'surat_perintah_tugas' ||
            $jenis === 'perintah_tugas' ||
            $jenis === 'suratperintahtugas'
        ) {
            $data = SuratPerintahTugas::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_perintah_tugas', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_penerima ?? 'perintah_tugas', '_');

            return $pdf->download('surat_perintah_tugas_' . $filename . '.pdf');
        }

        if ($jenis === 'surat_keterangan_ghoib' || $jenis === 'ghoib') {
            $data = \App\Models\surat_keterangan_ghoib::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_ghoib', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_pemohon ?? 'ghoib', '_');

            return $pdf->download('surat_keterangan_ghoib_' . $filename . '.pdf');
        }
        if (
            $jenis === 'suratketerangandesamiskin' ||
            $jenis === 'surat_keterangan_desa_miskin' ||
            $jenis === 'miskindesa'
        ) {
            $data = SuratKeteranganDesaMiskin::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_desa_miskin', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'surat_keterangan_desa_miskin', '_');

            return $pdf->download('surat_keterangan_desa_miskin_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_keterangan_ahli_waris_desa' ||
            $jenis === 'ahliwarisdesa' ||
            $jenis === 'suratketeranganahliwarisdesa'
        ) {
            $data = \App\Models\surat_keterangan_ahli_waris_desa::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_ahli_waris_desa', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_almarhum ?? 'ahli_waris_desa', '_');

            return $pdf->download('surat_keterangan_ahli_waris_desa_' . $filename . '.pdf');
        }

        if (
            $jenis === 'suratketeranganmiskinskm' ||
            $jenis === 'surat_keterangan_miskin_skm' ||
            $jenis === 'skm'
        ) {
            $data = SuratKeteranganMiskinSkm::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_miskin_skm', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'surat_keterangan_miskin_skm', '_');

            return $pdf->download('surat_keterangan_miskin_skm_' . $filename . '.pdf');
        }

        if (
            $jenis === 'suratketerangannumpangnikah' ||
            $jenis === 'surat_keterangan_numpang_nikah' ||
            $jenis === 'numpang_nikah'
        ) {
            $data = surat_keterangan_numpang_nikah::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_numpang_nikah', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = 'Surat_Keterangan_Numpang_Nikah_'
                . Str::slug($data->nama ?? $id, '_')
                . '.pdf';

            return $pdf->download($filename);
        }

        if (
            $jenis === 'suratketerangankematiandesa' ||
            $jenis === 'surat_keterangan_kematian_desa' ||
            $jenis === 'kematian_desa'
        ) {
            $data = surat_keterangan_kematian_desa::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_kematian_desa', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = 'Surat_Keterangan_Kematian_Desa_'
                . Str::slug($data->nama_lengkap ?? $id, '_')
                . '.pdf';

            return $pdf->download($filename);
        }
        if (
            $jenis === 'surat_sptjm_suami_istri' ||
            $jenis === 'sptjm_suami_istri'
        ) {
            $data = \App\Models\surat_sptjm_suami_istri::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_sptjm_suami_istri', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_deklaran ?? 'dokumen', '_');
            return $pdf->download('sptjm_suami_istri_' . $filename . '.pdf');
        }
        if (
            $jenis === 'suratpernyataanpembetulandatatidakmerubahlagi' ||
            $jenis === 'pernyataan_pembetulan_data_tidak_merubah_lagi'
        ) {
            $data = surat_pernyataan_pembetulan_data_tidak_merubah_lagi::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_pernyataan_pembetulan_data_tidak_merubah_lagi', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_pembetulan_data_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran' ||
            $jenis === 'permohonan_pengantar_keabsahan_akta_kelahiran'
        ) {
            $data = surat_permohonan_pengantar_keabsahan_akta_kelahiran::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_permohonan_pengantar_keabsahan_akta_kelahiran', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('surat_permohonan_pengantar_keabsahan_akta_kelahiran_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_pernyataan_batal_pindah_penduduk' ||
            $jenis === 'pernyataan_batal_pindah_penduduk'
        ) {
            $data = \App\Models\surat_pernyataan_batal_pindah_penduduk::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_batal_pindah_penduduk', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('surat_pernyataan_batal_pindah_penduduk_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_formulir_pengajuan_user_id' ||
            $jenis === 'formulir_pengajuan_user_id'
        ) {
            $data = \App\Models\surat_formulir_pengajuan_user_id::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_formulir_pengajuan_user_id', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->instansi_pemohon ?? 'dokumen', '_');
            return $pdf->download('formulir_pengajuan_user_id_' . $filename . '.pdf');
        }

        if ($jenis === 'suratpernyataanperubahandatapendidikan') {
            $data = surat_pernyataan_perubahan_data_pendidikan::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_pernyataan_perubahan_data_pendidikan', compact('data'))
                ->setPaper('A4', 'portrait');
            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_perubahan_data_pendidikan_' . $filename . '.pdf');
        }

        if ($jenis === 'suratketerangankehilangan') {
            $data = surat_keterangan_kehilangan::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdfsuratketerangankehilangan', compact('data'))
                ->setPaper('A4');
            return $pdf->download('pdfsuratketerangankehilangan' . $data->nama_pelapor . '.pdf');
        }

        if ($jenis === 'suratpernyataantidakbisamelampirkanktpkematian') {
            $data = surat_pernyataan_tidak_bisa_melampirkan_ktp_kematian::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdfsuratpernyataantidakbisamelampirkanktpkematian', compact('data'))->setPaper('A4');
            return $pdf->download('Surat_Pernyataan_KTP_' . $data->nama_pelapor . '.pdf');
        }

        if (
            $jenis === 'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak' ||
            $jenis === 'permohonan_pengantar_keabsahan_akta_kelahiran_anak'
        ) {
            $data = \App\Models\surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak_' . $filename . '.pdf');
        }

        if ($jenis === 'suratpernyataannumpangkk') {
            $data = surat_pernyataan_numpang_kk::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdfsuratnumpangkk', compact('data'))->setPaper('A4');
            return $pdf->download('pdfsuratnumpangkk_' . $data->nama_pelapor . '.pdf');
        }

        if ($jenis === 'surat_keterangan_tidakmampu') {
            $data = suratketerangantidakmampu::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_tidakmampu', compact('data'))->setPaper('A4');
            return $pdf->download('pdf_surat_keterangan_tidakmampu' . $data->nama_pelapor . '.pdf');
        }

        if ($jenis === 'surat_pernyataan_memilih_nama_alias') {
            $data = surat_pernyataan_memilih_nama_alias::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_memilih_nama_alias', compact('data'))->setPaper('A4');
            return $pdf->download('pdf_surat_pernyataan_memilih_nama_alias' . $data->nama_pelapor . '.pdf');
        }


        if (
            $jenis === 'surat_pernyataan_memilih_nama_alias_satu_orang_tua' ||
            $jenis === 'surat_pernyataan_memilih_nama_alias_satu_ortu'
        ) {
            $data = nama_alias_ortu::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_memilih_nama_alias_satu_ortu', compact('data'))->setPaper('A4');
            // pakai nama yang tersedia: nama_menyatakan → fallback nama → fallback 'dokumen'
            $filenameName = $data->nama_menyatakan ?? $data->nama ?? 'dokumen';
            return $pdf->download('pdf_surat_pernyataan_memilih_nama_alias_satu_ortu_' . $filenameName . '.pdf');
        }

        if ($jenis === 'suratketerangandesapernahmenikah') {
            $data = surat_keterangan_desa_pernah_menikah::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_surat_keterangan_desa_pernah_menikah', compact('data'))->setPaper('A4');
            $filenameName = $data->nama_lengkap ?? 'dokumen';
            return $pdf->download('pdf_surat_keterangan_desa_pernah_menikah_' . $filenameName . '.pdf');
        }

        if ($jenis === 'suratpernyataandanjaminan') {
            $data = surat_pernyataan_dan_jaminan::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_surat_pernyataan_dan_jaminan', compact('data'))->setPaper('A4');
            $filename = $data->nama_lengkap ?? 'dokumen';
            return $pdf->download('pdf_surat_pernyataan_dan_jaminan_' . $filename . '.pdf');
        }


        if ($jenis === 'suratketeranganahliwaris') {
            $data = surat_keterangan_ahli_waris::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_surat_keterangan_ahli_waris', compact('data'))->setPaper('A4');
            $filename = $data->nama_lengkap ?? 'dokumen';
            return $pdf->download('pdf_surat_keterangan_ahli_waris_' . $filename . '.pdf');
        }

        // ================================================
        // SURAT REKOMENDASI
        // ================================================
        if (
            Str::contains(strtolower($jenis), 'rekomendasi') ||
            $jenis === 'surat_rekomendasi' ||
            $jenis === 'suratrekomendasi'
        ) {
            $data = SuratRekomendasi::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_rekomendasi', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'rekomendasi', '_');

            return $pdf->download('surat_rekomendasi_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_pernyataan_kesanggupan' ||
            $jenis === 'pernyataan_kesanggupan' ||
            $jenis === 'suratpernyataankesanggupan' ||   // ← TAMBAHKAN INI
            $jenis === 'kesanggupan'
        ) {
            $data = SuratPernyataanKesanggupan::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_kesanggupan', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'kesanggupan', '_');

            return $pdf->download('surat_pernyataan_kesanggupan_' . $filename . '.pdf');
        }

        // ================================================
        // SURAT PERNYATAAN TIDAK MEMILIKI KARTU JAMKESMAS
        // ================================================
        // ================================================
        // SURAT PERNYATAAN TIDAK MEMILIKI KARTU JAMKESMAS
        // ================================================
        if (
            $jenis === 'surat_pernyataan_tidak_punya_kartu_jkn' ||
            $jenis === 'pernyataan_tidak_punya_kartu_jkn' ||
            $jenis === 'tidak_punya_kartu' ||
            $jenis === 'jamkesmas' ||
            $jenis === 'jkn' ||
            $jenis === 'suratpernyataantidakpunyakartujkn' ||   // ← TAMBAHKAN INI
            $jenis === 'suratpernyataantidakpunyakartu'          // ← TAMBAHKAN INI
        ) {
            $data = SuratPernyataanTidakPunyaKartuJkn::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_pernyataan_tidak_punya_kartu_jkn', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'pernyataan_kartu', '_');

            return $pdf->download('surat_pernyataan_tidak_punya_kartu_' . $filename . '.pdf');
        }



        // ================================================
        // SURAT PERMOHONAN PEMBUKAAN REKENING
        // ================================================
        if (
            Str::contains(strtolower($jenis), 'permohonan_pembukaan_rekening') ||
            Str::contains(strtolower($jenis), 'bukaanrekening') ||
            $jenis === 'surat_permohonan_pembukaan_rekening' ||
            $jenis === 'permohonanpembukaanrekening' ||
            $jenis === 'SuratPermohonanPembukaanRekening'
        ) {
            $data = SuratPermohonanPembukaanRekening::findOrFail($id);

            // SESUAIKAN NAMA VIEW DENGAN FILE ANDA
            $pdf = Pdf::loadView('surat.pdf_surat_permohonan_pembukaan_rekening', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama_kepala_desa ?? 'permohonan_rekening', '_');

            return $pdf->download('surat_permohonan_pembukaan_rekening_' . $filename . '.pdf');
        }

        if ($jenis === 'suratpernyataanbelumakta') {
            $data = surat_pernyataan_belum_akta::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_surat_pernyataan_belum_akta', compact('data'))->setPaper('A4');
            $filename = Str::slug($data->ybt_nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_belum_akta_' . $filename . '.pdf');
        }

        if ($jenis === 'suratpernyataanbedanamabukunikah') {
            $data = surat_pernyataan_beda_nama_buku_nikah::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_pernyataan_beda_nama_buku_nikah', compact('data'))->setPaper('A4');
            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_beda_nama_buku_nikah_' . $filename . '.pdf');
        }

        if ($jenis === 'surat_pernyataan_anak_seorang_nama_ibu') {
            $data = surat_pernyataan_anak_seorang_nama_ibu::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_pernyataan_anak_seorang_nama_ibu', compact('data'))->setPaper('A4');
            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_anak_seorang_nama_ibu_' . $filename . '.pdf');
        }

        if ($jenis === 'suratpernyataanaktabarcodenomorsama') {
            $data = surat_pernyataan_akta_barcode_nomor_sama::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_pernyataan_akta_barcode_nomor_sama', compact('data'))->setPaper('A4');
            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_pernyataan_akta_barcode_nomor_sama_' . $filename . '.pdf');
        }

        if ($jenis === 'sptjmkematian') {
            $data = surat_sptjm_kematian::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_sptjm_kematian', compact('data'))->setPaper('A4');
            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_sptjm_kematian_' . $filename . '.pdf');
        }

        if ($jenis === 'suratketeranganhargakepemilikantanah') {
            $data = \App\Models\surat_keterangan_harga_kepemilikan_tanah::findOrFail($id);
            $pdf  = Pdf::loadView('surat.pdf_surat_keterangan_harga_kepemilikan_tanah', compact('data'))->setPaper('A4');
            $filename = Str::slug($data->nama ?? 'dokumen', '_');
            return $pdf->download('pdf_surat_keterangan_harga_kepemilikan_tanah_' . $filename . '.pdf');
        }

        if (
            $jenis === 'suratpengantarskck' ||
            $jenis === 'surat_pengantar_skck' ||
            $jenis === 'skck'
        ) {
            $surat = SuratPengantarSkck::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_skck', compact('surat'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($surat->nama ?? 'surat_pengantar_skck', '_');

            return $pdf->download('surat_pengantar_skck_' . $filename . '.pdf');
        }

        if (
            $jenis === 'suratketeranganusaha' ||
            $jenis === 'surat_keterangan_usaha' ||
            $jenis === 'usaha'
        ) {
            $data = SuratKeteranganUsaha::findOrFail($id);

            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_usaha', compact('data'))
                ->setPaper('A4', 'portrait');

            $filename = Str::slug($data->nama ?? 'surat_keterangan_usaha', '_');

            return $pdf->download('surat_keterangan_usaha_' . $filename . '.pdf');
        }

        if (
            $jenis === 'surat_keterangan_domisili_lembaga' ||
            $jenis === 'domisili_lembaga' ||
            $jenis === 'suratketerangandomisililembaga'
        ) {
            $data = SuratKeteranganDomisiliLembaga::findOrFail($id);
            $pdf = Pdf::loadView('surat.pdf_surat_keterangan_domisili_lembaga', compact('data'))
                ->setPaper('A4', 'portrait');
            $filename = Str::slug($data->nama_lembaga ?? 'domisili_lembaga', '_');
            return $pdf->download('surat_keterangan_domisili_lembaga_' . $filename . '.pdf');
        }













        abort(404);
    }


    /**
     * Halaman proses Export DOCX hybrid.
     *
     * Browser merender PDF yang sama menjadi gambar, lalu server membuat
     * DOCX dengan halaman tersebut sebagai background. Hanya nilai nomor
     * surat yang tetap menjadi teks Word dan dapat diedit.
     */
    public function exportDocx(
        string $jenis,
        string $id,
        SuratDocxService $docxService
    ) {
        $docxService->prepare($jenis, $id);

        return view('surat.export_docx_hybrid', [
            'sourceUrl' => route(
                'surat.export-docx.source',
                ['jenis' => $jenis, 'id' => $id]
            ),
            'buildUrl' => route(
                'surat.export-docx.build',
                ['jenis' => $jenis, 'id' => $id]
            ),
            'backUrl' => route('surat.keluar'),
        ]);
    }

    /**
     * PDF sumber untuk proses hybrid.
     */
    public function exportDocxSource(
        string $jenis,
        string $id,
        SuratDocxService $docxService
    ) {
        return $docxService->streamPdf($jenis, $id);
    }

    /**
     * Terima hasil render halaman dari browser dan buat DOCX.
     */
    public function exportDocxBuild(
        Request $request,
        string $jenis,
        string $id,
        SuratDocxService $docxService
    ) {
        $validated = $request->validate([
            'pages' => ['required', 'array', 'min:1', 'max:12'],
            'pages.*' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png',
                'max:12288',
            ],
            'metadata' => ['required', 'string', 'max:50000'],
        ]);

        $metadata = json_decode(
            $validated['metadata'],
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (! is_array($metadata)) {
            abort(422, 'Metadata DOCX tidak valid.');
        }

        return $docxService->buildDocx(
            $jenis,
            $id,
            $request->file('pages', []),
            $metadata
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresuratmasukRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'keterangan'    => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'file'          => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        // Nama file yang aman
        $original = $request->file('file')->getClientOriginalName();
        $safeName = time() . '_' . Str::slug(pathinfo($original, PATHINFO_FILENAME), '_')
            . '.' . $request->file('file')->getClientOriginalExtension();

        // Pastikan direktori disk siap (opsional, biasanya otomatis)
        if (! Storage::disk('suratdesa')->exists('')) {
            Storage::disk('suratdesa')->makeDirectory('');
        }

        // Simpan file ke disk 'suratdesa'
        // Hasil $path hanya nama file (tanpa folder), contoh: 1758682751_surat_pengantar.pdf
        $path = $request->file('file')->storeAs('', $safeName, 'suratdesa');

        // Simpan data ke MongoDB
        SuratMasuk::create([
            'nama_instansi' => $request->nama_instansi,
            'keterangan'    => $request->keterangan,
            'tanggal_masuk' => $request->tanggal_masuk,
            'file'          => $path, // simpan nama file saja
        ]);

        return redirect()->route('surat.masuk')->with('msg', 'Surat masuk berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\suratmasuk  $suratmasuk
     * @return \Illuminate\Http\Response
     */
    public function show(suratmasuk $suratmasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\suratmasuk  $suratmasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(suratmasuk $suratmasuk)
    {
        return view('surat.editsuratmasuk', compact('suratmasuk'));
    }




    // Update the specified Surat Masuk
    public function update(Request $request, SuratMasuk $suratmasuk)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'keterangan'    => 'required|string|max:255',
            'tanggal_masuk' => 'required|date',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ]);

        // Update field non-file
        $suratmasuk->fill($request->only(['nama_instansi', 'keterangan', 'tanggal_masuk']));

        // Jika ada file baru, hapus yang lama lalu simpan yang baru
        if ($request->hasFile('file')) {

            // Hapus file lama jika ada
            if ($suratmasuk->file && Storage::disk('suratdesa')->exists($suratmasuk->file)) {
                Storage::disk('suratdesa')->delete($suratmasuk->file);
            }

            $original = $request->file('file')->getClientOriginalName();
            $safeName = time() . '_' . Str::slug(pathinfo($original, PATHINFO_FILENAME), '_')
                . '.' . $request->file('file')->getClientOriginalExtension();

            if (! Storage::disk('suratdesa')->exists('')) {
                Storage::disk('suratdesa')->makeDirectory('');
            }

            $path = $request->file('file')->storeAs('', $safeName, 'suratdesa');

            $suratmasuk->file = $path; // simpan nama file baru
        }

        $suratmasuk->save();

        return redirect()->route('surat.masuk')->with('msg', 'Surat masuk berhasil diperbarui.');
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\suratmasuk  $suratmasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(suratmasuk $suratmasuk)
    {
        //
    }
}
