<?php

namespace App\Http\Controllers;

use App\Exports\LokasidanPemukimanExport;
use App\Models\agama;
use App\Models\pendidikan;
use App\Models\pekerjaan;
use App\Models\status;
use App\Models\goldar;
use App\Models\datapenduduk;
use Illuminate\Http\Request;
use App\Models\lokasipemukiman;
use App\Http\Requests\StorelokasipemukimanRequest;
use App\Http\Requests\UpdatelokasipemukimanRequest;
use App\Imports\LokasidanPemukimanImport;
use App\Models\akses_pendidikan;
use App\Models\akseskesehatan;
use App\Models\aksessarpras;
use App\Models\aksestenagakerja;
use App\Models\dataindividu;
use App\Models\laink;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class LokasipemukimanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $totalPenduduk = datapenduduk::count();

        // Dapatkan jumlah data yang sudah terisi di tabel datapekerjaansdgs
        $dataTerisi = lokasipemukiman::count();

        // Hitung presentase penyelesaian data
        $presentase = $totalPenduduk > 0 ? ($dataTerisi / $totalPenduduk) * 100 : 0;

        return view('sdgs.KK.lokasidanpemukiman', compact('presentase'));
    }

    private function baseKkQuery(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Subquery kepala keluarga
    |--------------------------------------------------------------------------
    |
    | Menghasilkan tepat satu ID penduduk untuk setiap ID KK.
    | MIN(dp.id) digunakan sebagai pengaman apabila satu KK secara tidak
    | sengaja memiliki lebih dari satu data berstatus Kepala Keluarga.
    |
    */
        $kepalaPerKk = DB::table('datapenduduks as dp')
            ->join(
                'detailkks as dkk',
                'dkk.idpenduduk',
                '=',
                'dp.id'
            )
            ->whereRaw(
                'LOWER(TRIM(dp.Datak)) IN (?, ?)',
                [
                    'tetap',
                    'tidaktetap',
                ]
            )
            ->whereRaw(
                'LOWER(TRIM(dp.hubungan)) = ?',
                [
                    'kepala keluarga',
                ]
            )
            ->selectRaw(
                '
                dkk.idkk,
                MIN(dp.id) AS penduduk_id
            '
            )
            ->groupBy('dkk.idkk');

        /*
    |--------------------------------------------------------------------------
    | Query utama
    |--------------------------------------------------------------------------
    |
    | Hanya mengambil penduduk yang terpilih sebagai Kepala Keluarga
    | pada setiap KK.
    |
    */
        $query = Datapenduduk::query()
            ->joinSub(
                $kepalaPerKk,
                'kepala_per_kk',
                function ($join) {
                    $join->on(
                        'kepala_per_kk.penduduk_id',
                        '=',
                        'datapenduduks.id'
                    );
                }
            )
            ->join(
                'kks',
                'kks.id',
                '=',
                'kepala_per_kk.idkk'
            )
            ->select([
                'datapenduduks.*',
                'kks.id as kk_id',
                'kks.nokk as nokk',
            ]);

        /*
    |--------------------------------------------------------------------------
    | Filter No KK
    |--------------------------------------------------------------------------
    */
        if ($request->filled('nokk')) {
            $nokk = trim($request->input('nokk'));

            $query->where(
                'kks.nokk',
                'like',
                '%' . $nokk . '%'
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Filter NIK Kepala Keluarga
    |--------------------------------------------------------------------------
    */
        if ($request->filled('nik')) {
            $nik = trim($request->input('nik'));

            $query->where(
                'datapenduduks.nik',
                'like',
                '%' . $nik . '%'
            );
        }

        return $query;
    }

    public function admin_index(Request $request)
    {
        /*
     * Satu baris query = satu KK.
     */
        $kepalaKeluarga = $this->baseKkQuery(
            new Request()
        );

        $totalKK = (clone $kepalaKeluarga)->count();

        /*
     * Daftar NIK kepala keluarga.
     */
        $nikKepalaList = (clone $kepalaKeluarga)
            ->pluck('datapenduduks.nik')
            ->filter()
            ->unique()
            ->values();

        /*
     * Data lokasi disimpan berdasarkan NIK penduduk yang menjadi
     * kepala keluarga.
     */
        $terisiKK = lokasipemukiman::query()
            ->whereIn('nik', $nikKepalaList)
            ->distinct()
            ->count('nik');

        $presentase = $totalKK > 0
            ? ($terisiKK / $totalKK) * 100
            : 0;

        /*
     * Mencegah persentase lebih dari 100%.
     */
        $presentase = min(
            $presentase,
            100
        );

        return view(
            'sdgs.KK.admin_lokasidanpemukiman',
            compact('presentase')
        );
    }

    public function export(Request $request)
    {
        // opsional: ambil filter NIK dari query (?nik=...)
        $filterNik = $request->query('nik');

        $file = 'lokasi_pemukiman_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new LokasidanPemukimanExport($filterNik), $file);
    }

    public function import(Request $request)
    {
        $request->validate(
            [
                'file' => [
                    'required',
                    'file',
                    'mimes:xlsx',
                    'max:20480',
                ],
            ],
            [
                'file.required' =>
                'File XLSX wajib dipilih.',

                'file.file' =>
                'File import tidak valid.',

                'file.mimes' =>
                'File import harus berformat XLSX.',

                'file.max' =>
                'Ukuran file maksimal 20 MB.',
            ]
        );

        $file = $request->file('file');

        if (
            !$file ||
            !$file->isValid()
        ) {
            return back()->withErrors([
                'file' =>
                'File gagal diunggah. Silakan pilih ulang file XLSX.',
            ]);
        }

        $import = new LokasidanPemukimanImport();

        try {
            /*
         * Satu instance import dipakai untuk seluruh file agar
         * ringkasan, cache, dan daftar No KK tetap konsisten.
         */
            Excel::import(
                $import,
                $file
            );
        } catch (Throwable $e) {
            Log::error(
                'Import Lokasi dan Pemukiman gagal',
                [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'exception_file' => $e->getFile(),
                    'exception_line' => $e->getLine(),
                    'uploaded_name' =>
                    $file->getClientOriginalName(),
                    'uploaded_size' =>
                    $file->getSize(),
                    'uploaded_mime' =>
                    $file->getMimeType(),
                    'user_id' =>
                    auth()->id(),
                    'trace' =>
                    $e->getTraceAsString(),
                ]
            );

            $message = config('app.debug')
                ? 'Import gagal: ' . $e->getMessage()
                : (
                    'Import gagal diproses. Detail kesalahan telah ' .
                    'disimpan pada storage/logs/laravel.log.'
                );

            return back()->with('error', $message);
        }

        $summary = $import->getSummary();

        $message =
            'Import selesai: ' .
            $summary['inserted'] .
            ' KK baru, ' .
            $summary['updated'] .
            ' KK diperbarui, ' .
            $summary['documents_written'] .
            ' dokumen MongoDB berhasil ditulis ke tujuh collection, ' .
            $summary['skipped_non_head'] .
            ' baris bukan kepala keluarga dilewati, ' .
            $summary['skipped_duplicate_kk'] .
            ' No KK ganda dilewati, dan ' .
            $summary['invalid'] .
            ' baris tidak valid.';

        $flashKey = (
            $summary['successful_kk'] === 0 &&
            $summary['invalid'] > 0
        )
            ? 'error'
            : 'msg';

        return back()
            ->with($flashKey, $message)
            ->with(
                'import_warnings',
                $summary['warnings']
            )
            ->with(
                'import_warning_overflow',
                $summary['warning_overflow']
            );
    }


    public function jsonadmin(Request $request)
    {
        /*
     * Query ini sudah menghasilkan:
     * - satu baris untuk satu No KK;
     * - hanya penduduk berstatus Kepala Keluarga.
     */
        $query = $this->baseKkQuery($request);

        return DataTables::of($query)

            /*
         * No KK sudah tersedia dari select:
         * kks.nokk as nokk
         */
            ->editColumn('nokk', function ($row) {
                return (string) ($row->nokk ?? '');
            })

            ->filterColumn('nokk', function ($query, $keyword) {
                $query->where(
                    'kks.nokk',
                    'like',
                    '%' . $keyword . '%'
                );
            })

            ->orderColumn('nokk', function ($query, $order) {
                $query->orderBy('kks.nokk', $order);
            })

            ->addColumn('action', function ($row) {
                return '<a href="' . route('lokasipemukiman.show', ['show' => $row->nik]) . '"
                       class="btn mb-1 btn-info btn-sm" title="Lihat">
                        <i class="fas fa-book"></i>
                    </a>
                    <a href="' . route('lokasipemukiman.edit', ['nik' => $row->nik]) . '"
                       class="btn mb-1 btn-info btn-sm" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>';
            })

            // ================== DATA PROFIL & LOKASI PEMUKIMAN ==================
            ->addColumn('nohp', function ($row) {
                $data = dataindividu::where('nik', $row->nik)->first();
                return $data?->nohp ?? '';
            })
            ->addColumn('nowa', function ($row) {
                $data = dataindividu::where('nik', $row->nik)->first();
                return $data?->nowa ?? '';
            })
            ->addColumn('nik_kepala', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->nik_kepala ?? '';
            })
            ->addColumn('tempat_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->tempat_tinggal ?? '';
            })
            ->addColumn('status_lahan', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->status_lahan ?? '';
            })
            ->addColumn('luas_lantai_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->luas_lantai_tinggal ?? '';
            })
            ->addColumn('luas_tanah_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->luas_tanah_tinggal ?? '';
            })
            ->addColumn('jenis_lantai_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->jenis_lantai_tinggal ?? '';
            })
            ->addColumn('dinding_sebagian', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->dinding_sebagian ?? '';
            })
            ->addColumn('jendela', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->jendela ?? '';
            })
            ->addColumn('atap', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->atap ?? '';
            })
            ->addColumn('penerangan', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->penerangan ?? '';
            })
            ->addColumn('energi_masak', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->energi_masak ?? '';
            })
            ->addColumn('jika_kayu_jenis', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->jika_kayu_jenis ?? '';
            })
            ->addColumn('tempat_sampah', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->tempat_sampah ?? '';
            })
            ->addColumn('mck', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->mck ?? '';
            })
            ->addColumn('sumber_air_mandi', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->sumber_air_mandi ?? '';
            })
            ->addColumn('sumber_air_mck', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->sumber_air_mck ?? '';
            })
            ->addColumn('sumber_air_minum', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->sumber_air_minum ?? '';
            })
            ->addColumn('tempat_pembuangan_limbah', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->tempat_pembuangan_limbah ?? '';
            })
            ->addColumn('rumah_sungai', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->rumah_sungai ?? '';
            })
            ->addColumn('rumah_sutet', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->rumah_sutet ?? '';
            })
            ->addColumn('rumah_lereng_gunung', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->rumah_lereng_gunung ?? '';
            })
            ->addColumn('kondi_rumah_kumuh', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                return $lokasi?->kondi_rumah_kumuh ?? '';
            })

            // ================== AKSES PENDIDIKAN ==================
            ->addColumn('jaraktempuh_paud', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_paud ?? '')
            ->addColumn('waktutempuh_paud', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_paud ?? '')
            ->addColumn('kemudahan_paud', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_paud ?? '')

            ->addColumn('jaraktempuh_tk', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_tk ?? '')
            ->addColumn('waktutempuh_tk', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_tk ?? '')
            ->addColumn('kemudahan_tk', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_tk ?? '')

            ->addColumn('jaraktempuh_sd', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_sd ?? '')
            ->addColumn('waktutempuh_sd', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_sd ?? '')
            ->addColumn('kemudahan_sd', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_sd ?? '')

            ->addColumn('jaraktempuh_smp', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_smp ?? '')
            ->addColumn('waktutempuh_smp', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_smp ?? '')
            ->addColumn('kemudahan_smp', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_smp ?? '')

            ->addColumn('jaraktempuh_sma', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_sma ?? '')
            ->addColumn('waktutempuh_sma', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_sma ?? '')
            ->addColumn('kemudahan_sma', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_sma ?? '')

            ->addColumn('jaraktempuh_pt', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_pt ?? '')
            ->addColumn('waktutempuh_pt', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_pt ?? '')
            ->addColumn('kemudahan_pt', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_pt ?? '')

            ->addColumn('jaraktempuh_ps', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_ps ?? '')
            ->addColumn('waktutempuh_ps', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_ps ?? '')
            ->addColumn('kemudahan_ps', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_ps ?? '')

            ->addColumn('jaraktempuh_seminari', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_seminari ?? '')
            ->addColumn('waktutempuh_seminari', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_seminari ?? '')
            ->addColumn('kemudahan_seminari', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_seminari ?? '')

            ->addColumn('jaraktempuh_pagamalain', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->jaraktempuh_pagamalain ?? '')
            ->addColumn('waktutempuh_pagamalain', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->waktutempuh_pagamalain ?? '')
            ->addColumn('kemudahan_pagamalain', fn($row) => optional(akses_pendidikan::where('nik', $row->nik)->first())->kemudahan_pagamalain ?? '')

            // ================== AKSES KESEHATAN ==================
            ->addColumn('jaraktempuh_rumahs', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_rumahs ?? '')
            ->addColumn('waktutempuh_rumahs', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_rumahs ?? '')
            ->addColumn('kemudahan_rumahs', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_rumahs ?? '')

            ->addColumn('jaraktempuh_rumahb', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_rumahb ?? '')
            ->addColumn('waktutempuh_rumahb', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_rumahb ?? '')
            ->addColumn('kemudahan_rumahb', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_rumahb ?? '')

            ->addColumn('jaraktempuh_poliklinik', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_poliklinik ?? '')
            ->addColumn('waktutempuh_poliklinik', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_poliklinik ?? '')
            ->addColumn('kemudahan_poliklinik', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_poliklinik ?? '')

            ->addColumn('jaraktempuh_puskesmas', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_puskesmas ?? '')
            ->addColumn('waktutempuh_puskesmas', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_puskesmas ?? '')
            ->addColumn('kemudahan_puskesmas', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_puskesmas ?? '')

            ->addColumn('jaraktempuh_poskedes', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_poskedes ?? '')
            ->addColumn('waktutempuh_poskedes', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_poskedes ?? '')
            ->addColumn('kemudahan_poskedes', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_poskedes ?? '')

            ->addColumn('jaraktempuh_posyandu', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_posyandu ?? '')
            ->addColumn('waktutempuh_posyandu', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_posyandu ?? '')
            ->addColumn('kemudahan_posyandu', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_posyandu ?? '')

            ->addColumn('jaraktempuh_apotik', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_apotik ?? '')
            ->addColumn('waktutempuh_apotik', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_apotik ?? '')
            ->addColumn('kemudahan_apotik', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_apotik ?? '')

            ->addColumn('jaraktempuh_toko_obat', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->jaraktempuh_toko_obat ?? '')
            ->addColumn('waktutempuh_toko_obat', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->waktutempuh_toko_obat ?? '')
            ->addColumn('kemudahan_toko_obat', fn($row) => optional(akseskesehatan::where('nik', $row->nik)->first())->kemudahan_toko_obat ?? '')

            // ================== AKSES TENAGA KESEHATAN ==================
            ->addColumn('jaraktempuh_dr_spesialis', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->jaraktempuh_dr_spesialis ?? '')
            ->addColumn('waktutempuh_dr_spesialis', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->waktutempuh_dr_spesialis ?? '')
            ->addColumn('kemudahan_dr_spesialis', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->kemudahan_dr_spesialis ?? '')

            ->addColumn('jaraktempuh_dr_umum', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->jaraktempuh_dr_umum ?? '')
            ->addColumn('waktutempuh_dr_umum', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->waktutempuh_dr_umum ?? '')
            ->addColumn('kemudahan_dr_umum', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->kemudahan_dr_umum ?? '')

            ->addColumn('jaraktempuh_bidan', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->jaraktempuh_bidan ?? '')
            ->addColumn('waktutempuh_bidan', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->waktutempuh_bidan ?? '')
            ->addColumn('kemudahan_bidan', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->kemudahan_bidan ?? '')

            ->addColumn('jaraktempuh_tenagakes', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->jaraktempuh_tenagakes ?? '')
            ->addColumn('waktutempuh_tenagakes', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->waktutempuh_tenagakes ?? '')
            ->addColumn('kemudahan_tenagakes', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->kemudahan_tenagakes ?? '')

            ->addColumn('jaraktempuh_dukun', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->jaraktempuh_dukun ?? '')
            ->addColumn('waktutempuh_dukun', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->waktutempuh_dukun ?? '')
            ->addColumn('kemudahan_dukun', fn($row) => optional(aksestenagakerja::where('nik', $row->nik)->first())->kemudahan_dukun ?? '')

            // ================== AKSES SARPRAS / TRANSPORTASI ==================
            ->addColumn('jenistrasport_lokasipu', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->jenistrasport_lokasipu ?? '')
            ->addColumn('pengtransportumum_lokasipu', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->pengtransportumum_lokasipu ?? '')
            ->addColumn('waktutempuh_lokasipu', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->waktutempuh_lokasipu ?? '')
            ->addColumn('biaya_lokasipu', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->biaya_lokasipu ?? '')
            ->addColumn('kemudahan_lokasipu', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->kemudahan_lokasipu ?? '')

            ->addColumn('jenistrasport_lahanpertanian', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->jenistrasport_lahanpertanian ?? '')
            ->addColumn('pengtransportumum_lahanpertanian', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->pengtransportumum_lahanpertanian ?? '')
            ->addColumn('waktutempuh_lahanpertanian', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->waktutempuh_lahanpertanian ?? '')
            ->addColumn('biaya_lahanpertanian', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->biaya_lahanpertanian ?? '')
            ->addColumn('kemudahan_lahanpertanian', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->kemudahan_lahanpertanian ?? '')

            ->addColumn('jenistrasport_sekolah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->jenistrasport_sekolah ?? '')
            ->addColumn('pengtransportumum_sekolah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->pengtransportumum_sekolah ?? '')
            ->addColumn('waktutempuh_sekolah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->waktutempuh_sekolah ?? '')
            ->addColumn('biaya_sekolah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->biaya_sekolah ?? '')
            ->addColumn('kemudahan_sekolah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->kemudahan_sekolah ?? '')

            ->addColumn('jenistrasport_berobat', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->jenistrasport_berobat ?? '')
            ->addColumn('pengtransportumum_berobat', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->pengtransportumum_berobat ?? '')
            ->addColumn('waktutempuh_berobat', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->waktutempuh_berobat ?? '')
            ->addColumn('biaya_berobat', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->biaya_berobat ?? '')
            ->addColumn('kemudahan_berobat', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->kemudahan_berobat ?? '')

            ->addColumn('jenistrasport_beribadah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->jenistrasport_beribadah ?? '')
            ->addColumn('pengtransportumum_beribadah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->pengtransportumum_beribadah ?? '')
            ->addColumn('waktutempuh_beribadah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->waktutempuh_beribadah ?? '')
            ->addColumn('biaya_beribadah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->biaya_beribadah ?? '')
            ->addColumn('kemudahan_beribadah', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->kemudahan_beribadah ?? '')

            ->addColumn('jenistrasport_rekreasi', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->jenistrasport_rekreasi ?? '')
            ->addColumn('pengtransportumum_rekreasi', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->pengtransportumum_rekreasi ?? '')
            ->addColumn('waktutempuh_rekreasi', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->waktutempuh_rekreasi ?? '')
            ->addColumn('biaya_rekreasi', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->biaya_rekreasi ?? '')
            ->addColumn('kemudahan_rekreasi', fn($row) => optional(aksessarpras::where('nik', $row->nik)->first())->kemudahan_rekreasi ?? '')

            // ================== BANTUAN LAINNYA (laink) ==================
            ->addColumn('pengtransportsebelum', fn($row) => optional(laink::where('nik', $row->nik)->first())->pengtransportsebelum ?? '')
            ->addColumn('pengtransportsesudah', fn($row) => optional(laink::where('nik', $row->nik)->first())->pengtransportsesudah ?? '')
            ->addColumn('blt', fn($row) => optional(laink::where('nik', $row->nik)->first())->blt ?? '')
            ->addColumn('pkh', fn($row) => optional(laink::where('nik', $row->nik)->first())->pkh ?? '')
            ->addColumn('bst', fn($row) => optional(laink::where('nik', $row->nik)->first())->bst ?? '')
            ->addColumn('bantuan_presiden', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_presiden ?? '')
            ->addColumn('bantuan_umkm', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_umkm ?? '')
            ->addColumn('bantuan_pekerja', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_pekerja ?? '')
            ->addColumn('bantuan_anak', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_anak ?? '')
            ->addColumn('lainnya', fn($row) => optional(laink::where('nik', $row->nik)->first())->lainnya ?? '')
            ->addColumn('rata_rata', fn($row) => optional(laink::where('nik', $row->nik)->first())->rata_rata ?? '')


            ->addColumn('pengtransportsebelum', fn($row) => optional(laink::where('nik', $row->nik)->first())->pengtransportsebelum ?? '')
            ->addColumn('pengtransportsesudah', fn($row) => optional(laink::where('nik', $row->nik)->first())->pengtransportsesudah ?? '')
            ->addColumn('blt', fn($row) => optional(laink::where('nik', $row->nik)->first())->blt ?? '')
            ->addColumn('pkh', fn($row) => optional(laink::where('nik', $row->nik)->first())->pkh ?? '')
            ->addColumn('bst', fn($row) => optional(laink::where('nik', $row->nik)->first())->bst ?? '')
            ->addColumn('bantuan_presiden', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_presiden ?? '')
            ->addColumn('bantuan_umkm', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_umkm ?? '')
            ->addColumn('bantuan_pekerja', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_pekerja ?? '')
            ->addColumn('bantuan_anak', fn($row) => optional(laink::where('nik', $row->nik)->first())->bantuan_anak ?? '')
            ->addColumn('lainnya', fn($row) => optional(laink::where('nik', $row->nik)->first())->lainnya ?? '')
            ->addColumn('rata_rata', fn($row) => optional(laink::where('nik', $row->nik)->first())->rata_rata ?? '')
            ->rawColumns(['action'])
            ->toJson();
    }
    public function json(Request $request)
    {
        $allowedDatakValues = ['tetap', 'tidaktetap'];

        // Cek apakah ada pencarian global dari DataTables atau filter nokk khusus
        $hasGlobalSearch = filled(data_get($request->all(), 'search.value')); // DataTables global search
        $hasNokkFilter   = $request->filled('nokk');

        if (! $hasGlobalSearch && ! $hasNokkFilter) {
            // Tidak ada search & tidak ada filter spesifik → sembunyikan data
            $query = Datapenduduk::query()->whereRaw('1=0');
        } else {
            // Ada search atau ada filter nokk → tampilkan data dengan relasi
            $query = Datapenduduk::with([
                'kk',
                'agama',
                'pendidikan',
                'pekerjaan',
                'goldar',
                'status',
                'detailkk.kk',
                'updatedByUser'
            ])->whereIn('Datak', $allowedDatakValues);

            // Filter opsional by NoKK dari parameter khusus
            if ($hasNokkFilter) {
                $nokk = $request->input('nokk');
                $query->whereHas('detailkk.kk', function ($qq) use ($nokk) {
                    $qq->where('nokk', 'like', "%{$nokk}%");
                });
            }
            // Catatan: global search akan ditangani otomatis oleh Yajra pada kolom sederhana.
            // Untuk kolom relasi (nokk) kita sediakan filterColumn di bawah.
        }

        return DataTables::of($query)

            ->addColumn('nokk', function ($row) {
                return optional($row->detailkk->kk)->nokk;
            })
            // ⬇️ Izinkan pencarian global di kolom NO KK (relasi)
            ->filterColumn('nokk', function ($q, $keyword) {
                $q->whereHas('detailkk.kk', function ($qq) use ($keyword) {
                    $qq->where('nokk', 'like', "%{$keyword}%");
                });
            })
            // (opsional) izinkan sorting kolom NO KK
            ->orderColumn('nokk', function ($q, $order) {
                $q->join('detailkks', 'detailkks.nik', '=', 'datapenduduks.nik')
                    ->join('kks', 'kks.id', '=', 'detailkks.kk_id')
                    ->orderBy('kks.nokk', $order)
                    ->select('datapenduduks.*'); // hindari duplikasi kolom
            })
            ->addColumn('action', function ($row) {
                return '<td>
                            <a href="' . route('lokasipemukiman.show', ['show' => $row->nik]) . '" class="btn mb-1 btn-info btn-sm" title="Lihat Data">
                                <i class="fas fa-book"></i>
                            </a>
                            <a href="' . route('lokasipemukiman.edit', ['nik' => $row->nik]) . '" class="btn mb-1 btn-info btn-sm" title="Edit Data">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>';
            })

            ->addColumn('nowa', function ($row) {
                $dataIndividu = dataindividu::where('nik', $row->nik)->first();
                $kondisi = $dataIndividu ? $dataIndividu->nowa : '';

                return $kondisi;
            })
            ->addColumn('nohp', function ($row) {
                $dataIndividu = dataindividu::where('nik', $row->nik)->first();
                $kondisi = $dataIndividu ? $dataIndividu->nohp : '';

                return $kondisi;
            })
            ->addColumn('nik_kepala', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->nik_kepala : '';

                return $kondisi;
            })
            ->addColumn('tempat_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->tempat_tinggal : '';

                return $kondisi;
            })
            ->addColumn('status_lahan', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->status_lahan : '';

                return $kondisi;
            })
            ->addColumn('luas_lantai_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->luas_lantai_tinggal : '';

                return $kondisi;
            })
            ->addColumn('luas_tanah_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->luas_tanah_tinggal : '';

                return $kondisi;
            })
            ->addColumn('jenis_lantai_tinggal', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->jenis_lantai_tinggal : '';

                return $kondisi;
            })
            ->addColumn('dinding_sebagian', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->dinding_sebagian : '';

                return $kondisi;
            })
            ->addColumn('jendela', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->jendela : '';

                return $kondisi;
            })
            ->addColumn('atap', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->atap : '';

                return $kondisi;
            })
            ->addColumn('penerangan', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->penerangan : '';

                return $kondisi;
            })
            ->addColumn('energi_masak', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->energi_masak : '';

                return $kondisi;
            })
            ->addColumn('jika_kayu_jenis', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->jika_kayu_jenis : '';

                return $kondisi;
            })
            ->addColumn('tempat_sampah', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->tempat_sampah : '';

                return $kondisi;
            })
            ->addColumn('mck', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->mck : '';

                return $kondisi;
            })
            ->addColumn('sumber_air_mandi', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->sumber_air_mandi : '';

                return $kondisi;
            })
            ->addColumn('sumber_air_mck', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->sumber_air_mck : '';

                return $kondisi;
            })
            ->addColumn('sumber_air_minum', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->sumber_air_minum : '';

                return $kondisi;
            })
            ->addColumn('tempat_pembuangan_limbah', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->tempat_pembuangan_limbah : '';

                return $kondisi;
            })
            ->addColumn('rumah_sungai', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->rumah_sungai : '';

                return $kondisi;
            })
            ->addColumn('rumah_sutet', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->rumah_sutet : '';

                return $kondisi;
            })
            ->addColumn('rumah_lereng_gunung', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->rumah_lereng_gunung : '';

                return $kondisi;
            })
            ->addColumn('kondi_rumah_kumuh', function ($row) {
                $lokasi = lokasipemukiman::where('nik', $row->nik)->first();
                $kondisi = $lokasi ? $lokasi->kondi_rumah_kumuh : '';

                return $kondisi;
            })

            ->addColumn('jaraktempuh_paud', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                $kondisi = $akses_pendidikan ? $akses_pendidikan->jaraktempuh_paud : '';
                return $kondisi;
            })

            ->addColumn('waktutempuh_paud', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_paud : '';
            })
            ->addColumn('kemudahan_paud', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_paud : '';
            })
            ->addColumn('jaraktempuh_tk', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_tk : '';
            })
            ->addColumn('waktutempuh_tk', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_tk : '';
            })
            ->addColumn('kemudahan_tk', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_tk : '';
            })
            ->addColumn('jaraktempuh_sd', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_sd : '';
            })
            ->addColumn('waktutempuh_sd', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_sd : '';
            })
            ->addColumn('kemudahan_sd', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_sd : '';
            })
            ->addColumn('jaraktempuh_smp', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_smp : '';
            })
            ->addColumn('waktutempuh_smp', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_smp : '';
            })
            ->addColumn('kemudahan_smp', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_smp : '';
            })
            ->addColumn('jaraktempuh_sma', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_sma : '';
            })
            ->addColumn('waktutempuh_sma', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_sma : '';
            })
            ->addColumn('kemudahan_sma', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_sma : '';
            })
            ->addColumn('jaraktempuh_pt', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_pt : '';
            })
            ->addColumn('waktutempuh_pt', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_pt : '';
            })
            ->addColumn('kemudahan_pt', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_pt : '';
            })
            ->addColumn('jaraktempuh_ps', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_ps : '';
            })
            ->addColumn('waktutempuh_ps', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_ps : '';
            })
            ->addColumn('kemudahan_ps', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_ps : '';
            })
            ->addColumn('jaraktempuh_seminari', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_seminari : '';
            })
            ->addColumn('waktutempuh_seminari', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_seminari : '';
            })
            ->addColumn('kemudahan_seminari', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_seminari : '';
            })
            ->addColumn('jaraktempuh_pagamalain', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->jaraktempuh_pagamalain : '';
            })
            ->addColumn('waktutempuh_pagamalain', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->waktutempuh_pagamalain : '';
            })
            ->addColumn('kemudahan_pagamalain', function ($row) {
                $akses_pendidikan = akses_pendidikan::where('nik', $row->nik)->first();
                return $akses_pendidikan ? $akses_pendidikan->kemudahan_pagamalain : '';
            })

            ->addColumn('jaraktempuh_rumahs', function ($row) {
                $datakesehatan = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_rumahs = $datakesehatan ? $datakesehatan->jaraktempuh_rumahs : '';

                return '' . $jaraktempuh_rumahs . '';
            })

            ->addColumn('jaraktempuh_rumahs', function ($row) {
                $datakesehatan = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_rumahs = $datakesehatan ? $datakesehatan->jaraktempuh_rumahs : '';
                return '' . $jaraktempuh_rumahs . '';
            })

            ->addColumn('waktutempuh_rumahs', function ($row) {
                $datakesehatan = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_rumahs = $datakesehatan ? $datakesehatan->waktutempuh_rumahs : '';
                return '' . $waktutempuh_rumahs . '';
            })

            ->addColumn('kemudahan_rumahs', function ($row) {
                $datakesehatan = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_rumahs = $datakesehatan ? $datakesehatan->kemudahan_rumahs : '';
                return '' . $kemudahan_rumahs . '';
            })

            ->addColumn('jaraktempuh_rumahb', function ($row) {
                $dataRumahB = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_rumahb = $dataRumahB ? $dataRumahB->jaraktempuh_rumahb : '';
                return '' . $jaraktempuh_rumahb . '';
            })

            ->addColumn('waktutempuh_rumahb', function ($row) {
                $dataRumahB = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_rumahb = $dataRumahB ? $dataRumahB->waktutempuh_rumahb : '';
                return '' . $waktutempuh_rumahb . '';
            })

            ->addColumn('kemudahan_rumahb', function ($row) {
                $dataRumahB = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_rumahb = $dataRumahB ? $dataRumahB->kemudahan_rumahb : '';
                return '' . $kemudahan_rumahb . '';
            })

            ->addColumn('jaraktempuh_poliklinik', function ($row) {
                $dataPoliklinik = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_poliklinik = $dataPoliklinik ? $dataPoliklinik->jaraktempuh_poliklinik : '';
                return '' . $jaraktempuh_poliklinik . '';
            })

            ->addColumn('waktutempuh_poliklinik', function ($row) {
                $dataPoliklinik = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_poliklinik = $dataPoliklinik ? $dataPoliklinik->waktutempuh_poliklinik : '';
                return '' . $waktutempuh_poliklinik . '';
            })

            ->addColumn('kemudahan_poliklinik', function ($row) {
                $dataPoliklinik = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_poliklinik = $dataPoliklinik ? $dataPoliklinik->kemudahan_poliklinik : '';
                return '' . $kemudahan_poliklinik . '';
            })

            ->addColumn('jaraktempuh_puskesmas', function ($row) {
                $dataPuskesmas = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_puskesmas = $dataPuskesmas ? $dataPuskesmas->jaraktempuh_puskesmas : '';
                return '' . $jaraktempuh_puskesmas . '';
            })

            ->addColumn('waktutempuh_puskesmas', function ($row) {
                $dataPuskesmas = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_puskesmas = $dataPuskesmas ? $dataPuskesmas->waktutempuh_puskesmas : '';
                return '' . $waktutempuh_puskesmas . '';
            })

            ->addColumn('kemudahan_puskesmas', function ($row) {
                $dataPuskesmas = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_puskesmas = $dataPuskesmas ? $dataPuskesmas->kemudahan_puskesmas : '';
                return '' . $kemudahan_puskesmas . '';
            })

            ->addColumn('jaraktempuh_poskedes', function ($row) {
                $dataPoskedes = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_poskedes = $dataPoskedes ? $dataPoskedes->jaraktempuh_poskedes : '';
                return '' . $jaraktempuh_poskedes . '';
            })

            ->addColumn('waktutempuh_poskedes', function ($row) {
                $dataPoskedes = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_poskedes = $dataPoskedes ? $dataPoskedes->waktutempuh_poskedes : '';
                return '' . $waktutempuh_poskedes . '';
            })

            ->addColumn('kemudahan_poskedes', function ($row) {
                $dataPoskedes = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_poskedes = $dataPoskedes ? $dataPoskedes->kemudahan_poskedes : '';
                return '' . $kemudahan_poskedes . '';
            })

            ->addColumn('jaraktempuh_posyandu', function ($row) {
                $dataPosyandu = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_posyandu = $dataPosyandu ? $dataPosyandu->jaraktempuh_posyandu : '';
                return '' . $jaraktempuh_posyandu . '';
            })

            ->addColumn('waktutempuh_posyandu', function ($row) {
                $dataPosyandu = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_posyandu = $dataPosyandu ? $dataPosyandu->waktutempuh_posyandu : '';
                return '' . $waktutempuh_posyandu . '';
            })

            ->addColumn('kemudahan_posyandu', function ($row) {
                $dataPosyandu = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_posyandu = $dataPosyandu ? $dataPosyandu->kemudahan_posyandu : '';
                return '' . $kemudahan_posyandu . '';
            })

            ->addColumn('jaraktempuh_apotik', function ($row) {
                $dataApotik = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_apotik = $dataApotik ? $dataApotik->jaraktempuh_apotik : '';
                return '' . $jaraktempuh_apotik . '';
            })

            ->addColumn('waktutempuh_apotik', function ($row) {
                $dataApotik = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_apotik = $dataApotik ? $dataApotik->waktutempuh_apotik : '';
                return '' . $waktutempuh_apotik . '';
            })

            ->addColumn('kemudahan_apotik', function ($row) {
                $dataApotik = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_apotik = $dataApotik ? $dataApotik->kemudahan_apotik : '';
                return '' . $kemudahan_apotik . '';
            })

            ->addColumn('jaraktempuh_toko_obat', function ($row) {
                $dataTokoObat = akseskesehatan::where('nik', $row->nik)->first();
                $jaraktempuh_toko_obat = $dataTokoObat ? $dataTokoObat->jaraktempuh_toko_obat : '';
                return '' . $jaraktempuh_toko_obat . '';
            })

            ->addColumn('waktutempuh_toko_obat', function ($row) {
                $dataTokoObat = akseskesehatan::where('nik', $row->nik)->first();
                $waktutempuh_toko_obat = $dataTokoObat ? $dataTokoObat->waktutempuh_toko_obat : '';
                return '' . $waktutempuh_toko_obat . '';
            })

            ->addColumn('kemudahan_toko_obat', function ($row) {
                $dataTokoObat = akseskesehatan::where('nik', $row->nik)->first();
                $kemudahan_toko_obat = $dataTokoObat ? $dataTokoObat->kemudahan_toko_obat : '';
                return '' . $kemudahan_toko_obat . '';
            })

            ->addColumn('jaraktempuh_dr_spesialis', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->jaraktempuh_dr_spesialis : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('waktutempuh_dr_spesialis', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->waktutempuh_dr_spesialis : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('kemudahan_dr_spesialis', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->kemudahan_dr_spesialis : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('jaraktempuh_dr_umum', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->jaraktempuh_dr_umum : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('waktutempuh_dr_umum', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->waktutempuh_dr_umum : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('kemudahan_dr_umum', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->kemudahan_dr_umum : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('jaraktempuh_bidan', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->jaraktempuh_bidan : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('waktutempuh_bidan', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->waktutempuh_bidan : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('kemudahan_bidan', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->kemudahan_bidan : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('jaraktempuh_tenagakes', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->jaraktempuh_tenagakes : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('waktutempuh_tenagakes', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->waktutempuh_tenagakes : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('kemudahan_tenagakes', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->kemudahan_tenagakes : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('jaraktempuh_dukun', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->jaraktempuh_dukun : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('waktutempuh_dukun', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->waktutempuh_dukun : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })
            ->addColumn('kemudahan_dukun', function ($row) {
                $data = aksestenagakerja::where('nik', $row->nik)->first();
                $jaraktempuh_dr_spesialis = $data ? $data->kemudahan_dukun : '';
                return '' . $jaraktempuh_dr_spesialis . '';
            })

            ->addColumn('jenistrasport_lokasipu', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->jenistrasport_lokasipu : '';
                return '' . $sarpras . '';
            })
            ->addColumn('pengtransportumum_lokasipu', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->pengtransportumum_lokasipu : '';
                return '' . $sarpras . '';
            })
            ->addColumn('waktutempuh_lokasipu', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->waktutempuh_lokasipu : '';
                return '' . $sarpras . '';
            })
            ->addColumn('biaya_lokasipu', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->biaya_lokasipu : '';
                return '' . $sarpras . '';
            })
            ->addColumn('kemudahan_lokasipu', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->kemudahan_lokasipu : '';
                return '' . $sarpras . '';
            })

            ->addColumn('jenistrasport_lahanpertanian', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->jenistrasport_lahanpertanian : '';
                return '' . $sarpras . '';
            })
            ->addColumn('pengtransportumum_lahanpertanian', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->pengtransportumum_lahanpertanian : '';
                return '' . $sarpras . '';
            })
            ->addColumn('waktutempuh_lahanpertanian', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->waktutempuh_lahanpertanian : '';
                return '' . $sarpras . '';
            })
            ->addColumn('biaya_lahanpertanian', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->biaya_lahanpertanian : '';
                return '' . $sarpras . '';
            })
            ->addColumn('kemudahan_lahanpertanian', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->kemudahan_lahanpertanian : '';
                return '' . $sarpras . '';
            })

            ->addColumn('jenistrasport_sekolah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->jenistrasport_sekolah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('pengtransportumum_sekolah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->pengtransportumum_sekolah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('waktutempuh_sekolah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->waktutempuh_sekolah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('biaya_sekolah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->biaya_sekolah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('kemudahan_sekolah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->kemudahan_sekolah : '';
                return '' . $sarpras . '';
            })

            ->addColumn('jenistrasport_berobat', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->jenistrasport_berobat : '';
                return '' . $sarpras . '';
            })
            ->addColumn('pengtransportumum_berobat', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->pengtransportumum_berobat : '';
                return '' . $sarpras . '';
            })
            ->addColumn('waktutempuh_berobat', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->waktutempuh_berobat : '';
                return '' . $sarpras . '';
            })
            ->addColumn('biaya_berobat', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->biaya_berobat : '';
                return '' . $sarpras . '';
            })
            ->addColumn('kemudahan_berobat', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->kemudahan_berobat : '';
                return '' . $sarpras . '';
            })

            ->addColumn('jenistrasport_beribadah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->jenistrasport_beribadah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('pengtransportumum_beribadah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->pengtransportumum_beribadah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('waktutempuh_beribadah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->waktutempuh_beribadah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('biaya_beribadah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->biaya_beribadah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('kemudahan_beribadah', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->kemudahan_beribadah : '';
                return '' . $sarpras . '';
            })
            ->addColumn('jenistrasport_rekreasi', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->jenistrasport_rekreasi : '';
                return '' . $sarpras . '';
            })
            ->addColumn('pengtransportumum_rekreasi', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->pengtransportumum_rekreasi : '';
                return '' . $sarpras . '';
            })
            ->addColumn('waktutempuh_rekreasi', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->waktutempuh_rekreasi : '';
                return '' . $sarpras . '';
            })
            ->addColumn('biaya_rekreasi', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->biaya_rekreasi : '';
                return '' . $sarpras . '';
            })
            ->addColumn('kemudahan_rekreasi', function ($row) {
                $akses_sarpras = aksessarpras::where('nik', $row->nik)->first();
                $sarpras = $akses_sarpras ? $akses_sarpras->kemudahan_rekreasi : '';
                return '' . $sarpras . '';
            })

            ->addColumn('pengtransportsebelum', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $pengtransportsebelum = $datakesehatan ? $datakesehatan->pengtransportsebelum : '';

                return '' . $pengtransportsebelum . '';
            })

            ->addColumn('pengtransportsesudah', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $pengtransportsesudah = $datakesehatan ? $datakesehatan->pengtransportsesudah : '';

                return '' . $pengtransportsesudah . '';
            })

            ->addColumn('blt', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $blt = $datakesehatan ? $datakesehatan->blt : '';

                return '' . $blt . '';
            })

            ->addColumn('pkh', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $pkh = $datakesehatan ? $datakesehatan->pkh : '';

                return '' . $pkh . '';
            })

            ->addColumn('bst', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $bst = $datakesehatan ? $datakesehatan->bst : '';

                return '' . $bst . '';
            })

            ->addColumn('bantuan_presiden', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $bantuan_presiden = $datakesehatan ? $datakesehatan->bantuan_presiden : '';

                return '' . $bantuan_presiden . '';
            })

            ->addColumn('bantuan_umkm', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $bantuan_umkm = $datakesehatan ? $datakesehatan->bantuan_umkm : '';

                return '' . $bantuan_umkm . '';
            })

            ->addColumn('bantuan_pekerja', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $bantuan_pekerja = $datakesehatan ? $datakesehatan->bantuan_pekerja : '';

                return '' . $bantuan_pekerja . '';
            })

            ->addColumn('bantuan_anak', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $bantuan_anak = $datakesehatan ? $datakesehatan->bantuan_anak : '';

                return '' . $bantuan_anak . '';
            })

            ->addColumn('lainnya', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $lainnya = $datakesehatan ? $datakesehatan->lainnya : '';

                return '' . $lainnya . '';
            })

            ->addColumn('rata_rata', function ($row) {
                $datakesehatan = laink::where('nik', $row->nik)->first();
                $rata_rata = $datakesehatan ? $datakesehatan->rata_rata : '';

                return '' . $rata_rata . '';
            })


            ->rawColumns([
                'action',
                'nowa',
                'nohp',
                'nik_kepala',
                'tempat_tinggal',
                'status_lahan',
                'luas_lantai_tinggal',
                'luas_tanah_tinggal',
                'jenis_lantai_tinggal',
                'dinding_sebagian',
                'jendela',
                'atap',
                'penerangan',
                'energi_masak',
                'jika_kayu_jenis',
                'tempat_sampah',
                'mck',
                'sumber_air_mandi',
                'sumber_air_mck',
                'sumber_air_minum',
                'tempat_pembuangan_limbah',
                'rumah_sungai',
                'rumah_sutet',
                'rumah_lereng_gunung',
                'kondi_rumah_kumuh',
            ])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($nik)
    {
        $datap = datapenduduk::where('nik', $nik)->first();
        $lokasi = lokasipemukiman::where('nik', $nik)->first();
        $datai = dataindividu::where('nik', $nik)->first();
        $agama = Agama::all();
        $pendidikan = Pendidikan::all();
        $pekerjaan = Pekerjaan::all();
        $goldar = Goldar::all();
        $status = Status::all();

        return view('sdgs.KK.editlokasidanpemukiman', compact('datai', 'datap', 'lokasi', 'agama', 'pendidikan', 'pekerjaan', 'goldar', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorelokasipemukimanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorelokasipemukimanRequest $request)
    {
        $lokasi = lokasipemukiman::where('nik', $request->valNIK)->first();
        if ($lokasi == NULL) {
            $lokasi = new lokasipemukiman();
        }
        $lokasi->nokk = $request->valNokk;
        $lokasi->nik = $request->valNIK;
        $lokasi->nama = $request->valNama;
        $lokasi->alamat = $request->valAlamat;
        $lokasi->nohp = $request->valNohp;
        $lokasi->nowa = $request->valNowa;
        $lokasi->nik_kepala = $request->valnik_kepala;
        $lokasi->tempat_tinggal = $request->valtempat_tinggal;
        $lokasi->status_lahan = $request->valstatus_lahan;
        $lokasi->luas_lantai_tinggal = $request->valluas_lantai_tinggal;
        $lokasi->luas_tanah_tinggal = $request->valluas_tanah_tinggal;
        $lokasi->jenis_lantai_tinggal = $request->valjenis_lantai_tinggal;
        $lokasi->dinding_sebagian = $request->valdinding_sebagian;
        $lokasi->jendela = $request->valjendela;
        $lokasi->atap = $request->valatap;
        $lokasi->penerangan = $request->valpenerangan;
        $lokasi->energi_masak = $request->valenergi_masak;
        $lokasi->jika_kayu_jenis = $request->valjika_kayu_jenis;
        $lokasi->tempat_sampah = $request->valtempat_sampah;
        $lokasi->mck = $request->valmck;
        $lokasi->sumber_air_mandi = $request->valsumber_air_mandi;
        $lokasi->sumber_air_mck = $request->valsumber_air_mck;
        $lokasi->sumber_air_minum = $request->valsumber_air_minum;
        $lokasi->tempat_pembuangan_limbah = $request->valtempat_pembuangan_limbah;
        $lokasi->rumah_sutet = $request->valrumah_sutet;
        $lokasi->rumah_sungai = $request->valrumah_sungai;
        $lokasi->rumah_lereng_gunung = $request->valrumah_lereng_gunung;
        $lokasi->kondi_rumah_kumuh = $request->valkondi_rumah_kumuh;

        $lokasi->save();

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()
                ->route('lokasipemukiman.admin_index')
                ->with('msg', 'Berhasil ditambahkan (Admin)');
        }

        // Default untuk user biasa
        return redirect()
            ->route('lokasipemukiman.index')
            ->with('msg', 'Penduduk Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lokasipemukiman  $lokasipemukiman
     * @return \Illuminate\Http\Response
     */
    public function show(lokasipemukiman $lokasipemukiman, $nik)
    {
        $datap = datapenduduk::where('nik', $nik)->first();
        $lokasi = lokasipemukiman::where('nik', $nik)->first();
        $datai = dataindividu::where('nik', $nik)->first();
        $agama = Agama::all();
        $pendidikan = Pendidikan::all();
        $pekerjaan = Pekerjaan::all();
        $goldar = Goldar::all();
        $status = Status::all();

        return view('sdgs.KK.showlokasidanpemukiman', compact('datai', 'datap', 'lokasi', 'agama', 'pendidikan', 'pekerjaan', 'goldar', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lokasipemukiman  $lokasipemukiman
     * @return \Illuminate\Http\Response
     */
    public function edit(lokasipemukiman $lokasipemukiman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelokasipemukimanRequest  $request
     * @param  \App\Models\lokasipemukiman  $lokasipemukiman
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelokasipemukimanRequest $request, lokasipemukiman $lokasipemukiman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lokasipemukiman  $lokasipemukiman
     * @return \Illuminate\Http\Response
     */
    public function destroy(lokasipemukiman $lokasipemukiman)
    {
        //
    }
}
