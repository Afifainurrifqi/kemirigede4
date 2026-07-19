<?php

namespace App\Exports;

use App\Models\akses_pendidikan;
use App\Models\akseskesehatan;
use App\Models\aksessarpras;
use App\Models\aksestenagakerja;
use App\Models\dataindividu;
use App\Models\datapenduduk as DataPendudukModel;
use App\Models\laink;
use App\Models\lokasipemukiman;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\DefaultValueBinder;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use RuntimeException;

class LokasidanPemukimanExport extends DefaultValueBinder implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithCustomValueBinder,
    WithStrictNullComparison,
    WithEvents
{
    /**
     * Jumlah kolom harus sama dengan susunan importer:
     * indeks 0 sampai 134 = 135 kolom.
     */
    private const EXPECTED_COLUMN_COUNT = 135;

    /**
     * Cache MongoDB dimuat per 1.000 NIK.
     */
    private const CACHE_CHUNK_SIZE = 1000;

    /**
     * Nilai status kependudukan MySQL yang dapat diekspor.
     */
    protected array $allowedDatak = [
        'tetap',
        'tidaktetap',
    ];

    /**
     * Filter satu NIK kepala keluarga.
     */
    protected ?string $filterNik;

    /**
     * Daftar NIK kepala keluarga dari query MySQL.
     */
    protected array $nikList = [];
    protected bool $nikListLoaded = false;

    /**
     * Penanda cache MongoDB.
     */
    protected bool $cacheReady = false;

    /**
     * Cache dokumen MongoDB berdasarkan NIK.
     */
    protected Collection $lokasiMap;
    protected Collection $individuMap;
    protected Collection $pendidikanMap;
    protected Collection $kesehatanMap;
    protected Collection $tenagaMap;
    protected Collection $sarprasMap;
    protected Collection $lainMap;

    /**
     * Kelompok akses pendidikan.
     */
    protected const PENDIDIKAN = [
        ['label' => 'PAUD', 'prefix' => 'paud'],
        ['label' => 'TK/RA', 'prefix' => 'tk'],
        ['label' => 'SD/MI SEDERAJAT', 'prefix' => 'sd'],
        ['label' => 'SMP/MTs SEDERAJAT', 'prefix' => 'smp'],
        ['label' => 'SMA/MA SEDERAJAT', 'prefix' => 'sma'],
        ['label' => 'PERGURUAN TINGGI', 'prefix' => 'pt'],
        ['label' => 'PESANTREN', 'prefix' => 'ps'],
        ['label' => 'SEMINARI', 'prefix' => 'seminari'],
        [
            'label' => 'PENDIDIKAN KEAGAMAAN LAIN',
            'prefix' => 'pagamalain',
        ],
    ];

    /**
     * Kelompok fasilitas kesehatan.
     */
    protected const FASILITAS_KESEHATAN = [
        ['label' => 'RUMAH SAKIT', 'prefix' => 'rumahs'],
        ['label' => 'RUMAH SAKIT BERSALIN', 'prefix' => 'rumahb'],
        ['label' => 'POLIKLINIK', 'prefix' => 'poliklinik'],
        ['label' => 'PUSKESMAS', 'prefix' => 'puskesmas'],
        ['label' => 'POSKESDES', 'prefix' => 'poskedes'],
        ['label' => 'POSYANDU', 'prefix' => 'posyandu'],
        ['label' => 'APOTIK', 'prefix' => 'apotik'],
        ['label' => 'TOKO OBAT', 'prefix' => 'toko_obat'],
    ];

    /**
     * Kelompok tenaga kesehatan.
     */
    protected const TENAGA_KESEHATAN = [
        ['label' => 'DOKTER SPESIALIS', 'prefix' => 'dr_spesialis'],
        ['label' => 'DOKTER UMUM', 'prefix' => 'dr_umum'],
        ['label' => 'BIDAN', 'prefix' => 'bidan'],
        [
            'label' => 'TENAGA KESEHATAN / PERAWAT',
            'prefix' => 'tenagakes',
        ],
        ['label' => 'DUKUN', 'prefix' => 'dukun'],
    ];

    /**
     * Kelompok sarana/prasarana dan transportasi.
     */
    protected const SARPRAS = [
        [
            'label' => 'LOKASI PEKERJAAN UTAMA',
            'prefix' => 'lokasipu',
        ],
        [
            'label' => 'LAHAN PERTANIAN YANG DIUSAHAKAN',
            'prefix' => 'lahanpertanian',
        ],
        ['label' => 'SEKOLAH', 'prefix' => 'sekolah'],
        ['label' => 'BEROBAT', 'prefix' => 'berobat'],
        [
            'label' => 'BERIBADAH MINGGUAN/BULANAN/TAHUNAN',
            'prefix' => 'beribadah',
        ],
        ['label' => 'REKREASI TERDEKAT', 'prefix' => 'rekreasi'],
    ];

    /**
     * Program pemerintah.
     */
    protected const PROGRAM_PEMERINTAH = [
        ['label' => 'BLT', 'field' => 'blt'],
        ['label' => 'PKH', 'field' => 'pkh'],
        ['label' => 'BST', 'field' => 'bst'],
        [
            'label' => 'BANTUAN PRESIDEN',
            'field' => 'bantuan_presiden',
        ],
        ['label' => 'BANTUAN UMKM', 'field' => 'bantuan_umkm'],
        [
            'label' => 'BANTUAN PEKERJA',
            'field' => 'bantuan_pekerja',
        ],
        ['label' => 'BANTUAN ANAK', 'field' => 'bantuan_anak'],
        ['label' => 'LAINNYA', 'field' => 'lainnya'],
    ];

    public function __construct(?string $filterNik = null)
    {
        $filterNik = trim((string) $filterNik);
        $filterNik = preg_replace('/\D+/', '', $filterNik);

        $this->filterNik = $filterNik !== ''
            ? $filterNik
            : null;
    }

    /**
     * Query satu Kepala Keluarga untuk setiap No KK.
     *
     * Query tidak bergantung pada collection lokasipemukiman.
     * Karena itu, KK yang belum mengisi data MongoDB tetap ikut
     * diekspor dan kolom surveinya akan kosong.
     */
    protected function baseHeadQuery()
    {
        $kepalaPerKk = DB::table('datapenduduks as dp')
            ->join(
                'detailkks as dkk',
                'dkk.idpenduduk',
                '=',
                'dp.id'
            )
            ->whereRaw(
                'LOWER(TRIM(dp.Datak)) IN (?, ?)',
                $this->allowedDatak
            )
            ->whereRaw(
                'LOWER(TRIM(dp.hubungan)) = ?',
                ['kepala keluarga']
            )
            ->selectRaw(
                'dkk.idkk, MIN(dp.id) AS penduduk_id'
            )
            ->groupBy('dkk.idkk');

        $query = DataPendudukModel::query()
            ->joinSub(
                $kepalaPerKk,
                'kepala_per_kk',
                function ($join): void {
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
                'kks.nokk as nokk',
            ]);

        if ($this->filterNik !== null) {
            $query->where(
                'datapenduduks.nik',
                $this->filterNik
            );
        }

        return $query;
    }

    /**
     * Query utama Laravel Excel.
     */
    public function query()
    {
        return $this->baseHeadQuery()
            ->orderBy('kks.nokk')
            ->orderBy('datapenduduks.nama');
    }

    /**
     * Header lengkap. Urutan wajib sama dengan importer.
     */
    public function headings(): array
    {
        $headings = [
            'NO KK',
            'NIK',
            'NAMA',
            'ALAMAT',
            'NO. HP',
            'NO. TELPON RUMAH',

            'NIK KEPALA KELUARGA',
            'TEMPAT TINGGAL',
            'STATUS LAHAN',
            'LUAS LANTAI (M2)',
            'LUAS TANAH (M2)',
            'JENIS LANTAI',
            'DINDING',
            'JENDELA',
            'ATAP',
            'PENERANGAN',
            'ENERGI MASAK',
            'SUMBER KAYU',
            'TEMPAT SAMPAH',
            'MCK',
            'SUMBER AIR MANDI',
            'SUMBER AIR MCK',
            'SUMBER AIR MINUM',
            'PEMBUANGAN LIMBAH',
            'RUMAH SUTET',
            'RUMAH SUNGAI',
            'RUMAH LERENG',
            'RUMAH KUMUH',
        ];

        foreach (self::PENDIDIKAN as $item) {
            $this->appendTripletHeadings(
                $headings,
                $item['label']
            );
        }

        foreach (self::FASILITAS_KESEHATAN as $item) {
            $this->appendTripletHeadings(
                $headings,
                $item['label']
            );
        }

        foreach (self::TENAGA_KESEHATAN as $item) {
            $this->appendTripletHeadings(
                $headings,
                $item['label']
            );
        }

        foreach (self::SARPRAS as $item) {
            $label = $item['label'];

            $headings[] =
                $label . ' - JENIS TRANSPORTASI';

            $headings[] =
                $label . ' - TRANSPORTASI UMUM';

            $headings[] =
                $label . ' - WAKTU (JAM)';

            $headings[] =
                $label . ' - BIAYA (Rp)';

            $headings[] =
                $label . ' - KEMUDAHAN';
        }

        $headings[] =
            'TRANSPORTASI UMUM - SEBELUMNYA';

        $headings[] =
            'TRANSPORTASI UMUM - SEKARANG';

        foreach (self::PROGRAM_PEMERINTAH as $item) {
            $headings[] = $item['label'];
        }

        $headings[] =
            'RATA-RATA PENGELUARAN / BULAN (Rp)';

        if (count($headings) !== self::EXPECTED_COLUMN_COUNT) {
            throw new RuntimeException(
                'Jumlah heading export harus 135 kolom, tetapi ditemukan ' .
                count($headings) . ' kolom.'
            );
        }

        return $headings;
    }

    protected function appendTripletHeadings(
        array &$headings,
        string $label
    ): void {
        $headings[] = $label . ' - JARAK (KM)';
        $headings[] = $label . ' - WAKTU (JAM)';
        $headings[] = $label . ' - KEMUDAHAN';
    }

    /**
     * Format kolom identitas sebagai teks.
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'E' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * Mempertahankan No KK, NIK, dan nomor telepon.
     */
    public function bindValue(Cell $cell, $value)
    {
        $textColumns = [
            'A',
            'B',
            'E',
            'F',
            'G',
        ];

        if (
            in_array(
                $cell->getColumn(),
                $textColumns,
                true
            )
        ) {
            $cell->setValueExplicit(
                (string) ($value ?? ''),
                DataType::TYPE_STRING
            );

            return true;
        }

        /*
         * Angka panjang lain dipaksa sebagai teks agar tidak
         * berubah menjadi notasi ilmiah.
         */
        if (
            $value !== null &&
            is_numeric($value) &&
            strlen((string) $value) >= 12
        ) {
            $cell->setValueExplicit(
                (string) $value,
                DataType::TYPE_STRING
            );

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * Styling ringan. ShouldAutoSize sengaja tidak digunakan
     * karena 135 kolom dan ribuan baris sangat berat di hosting.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (
                AfterSheet $event
            ): void {
                $sheet = $event->sheet->getDelegate();

                $lastColumn = Coordinate::stringFromColumnIndex(
                    self::EXPECTED_COLUMN_COUNT
                );

                $headerRange = 'A1:' . $lastColumn . '1';

                $sheet->freezePane('A2');
                $sheet->setAutoFilter($headerRange);
                $sheet->getRowDimension(1)->setRowHeight(36);

                $sheet->getDefaultColumnDimension()
                    ->setWidth(15);

                $sheet->getColumnDimension('A')->setWidth(20);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(28);
                $sheet->getColumnDimension('D')->setWidth(38);
                $sheet->getColumnDimension('E')->setWidth(18);
                $sheet->getColumnDimension('F')->setWidth(20);
                $sheet->getColumnDimension('G')->setWidth(22);

                $sheet->getStyle($headerRange)
                    ->getFont()
                    ->setBold(true)
                    ->getColor()
                    ->setARGB('FFFFFFFF');

                $sheet->getStyle($headerRange)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF1F4E78');

                $sheet->getStyle($headerRange)
                    ->getAlignment()
                    ->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    )
                    ->setVertical(
                        Alignment::VERTICAL_CENTER
                    )
                    ->setWrapText(true);
            },
        ];
    }

    /**
     * Daftar NIK kepala keluarga berdasarkan query MySQL.
     */
    protected function getNikList(): array
    {
        if ($this->nikListLoaded) {
            return $this->nikList;
        }

        $this->nikList = (clone $this->baseHeadQuery())
            ->pluck('datapenduduks.nik')
            ->filter(function ($nik): bool {
                return $nik !== null &&
                    trim((string) $nik) !== '';
            })
            ->map(function ($nik): string {
                return trim((string) $nik);
            })
            ->unique()
            ->values()
            ->toArray();

        $this->nikListLoaded = true;

        return $this->nikList;
    }

    /**
     * Bangun cache seluruh collection MongoDB satu kali.
     */
    protected function buildCache(): void
    {
        if ($this->cacheReady) {
            return;
        }

        $niks = $this->getNikList();

        $this->lokasiMap = $this->fetchMap(
            lokasipemukiman::class,
            $niks
        );

        $this->individuMap = $this->fetchMap(
            dataindividu::class,
            $niks
        );

        $this->pendidikanMap = $this->fetchMap(
            akses_pendidikan::class,
            $niks
        );

        $this->kesehatanMap = $this->fetchMap(
            akseskesehatan::class,
            $niks
        );

        $this->tenagaMap = $this->fetchMap(
            aksestenagakerja::class,
            $niks
        );

        $this->sarprasMap = $this->fetchMap(
            aksessarpras::class,
            $niks
        );

        $this->lainMap = $this->fetchMap(
            laink::class,
            $niks
        );

        $this->cacheReady = true;
    }

    /**
     * Mengambil dokumen MongoDB berdasarkan NIK secara bertahap.
     */
    protected function fetchMap(
        string $modelClass,
        array $niks
    ): Collection {
        $map = collect();

        if (empty($niks)) {
            return $map;
        }

        foreach (
            array_chunk(
                $niks,
                self::CACHE_CHUNK_SIZE
            ) as $nikChunk
        ) {
            $modelClass::query()
                ->whereIn('nik', $nikChunk)
                ->get()
                ->each(function ($item) use ($map): void {
                    $nik = trim(
                        (string) data_get(
                            $item,
                            'nik',
                            ''
                        )
                    );

                    if ($nik !== '') {
                        /*
                         * Jika ada dokumen lama ganda, dokumen
                         * terakhir yang dibaca digunakan.
                         */
                        $map->put($nik, $item);
                    }
                });
        }

        return $map;
    }

    /**
     * Mapping satu Kepala Keluarga menjadi tepat 135 kolom.
     */
    public function map($row): array
    {
        $this->buildCache();

        $nik = trim((string) ($row->nik ?? ''));
        $noKk = trim((string) ($row->nokk ?? ''));

        $lokasi = $this->lokasiMap->get($nik);
        $individu = $this->individuMap->get($nik);
        $pendidikan = $this->pendidikanMap->get($nik);
        $kesehatan = $this->kesehatanMap->get($nik);
        $tenaga = $this->tenagaMap->get($nik);
        $sarpras = $this->sarprasMap->get($nik);
        $lain = $this->lainMap->get($nik);

        $nikKepala = $this->firstAvailable(
            [$lokasi, $individu],
            ['nik_kepala']
        );

        if ($nikKepala === '') {
            /*
             * Karena baris SQL sudah pasti kepala keluarga,
             * NIK baris digunakan sebagai default.
             */
            $nikKepala = $nik;
        }

        $noHp = $this->firstAvailable(
            [$individu, $lokasi],
            ['nohp']
        );

        $teleponRumah = $this->firstAvailable(
            [$individu, $lokasi],
            [
                'telpon_rumah',
                'telepon_rumah',
                'nowa',
            ]
        );

        $values = [
            $noKk,
            $nik,
            $this->cellValue($row->nama ?? ''),
            $this->cellValue($row->alamat ?? ''),
            $noHp,
            $teleponRumah,

            $nikKepala,
            $this->firstValue(
                [$lokasi],
                'tempat_tinggal'
            ),
            $this->firstValue(
                [$lokasi],
                'status_lahan'
            ),
            $this->firstValue(
                [$lokasi],
                'luas_lantai_tinggal'
            ),
            $this->firstValue(
                [$lokasi],
                'luas_tanah_tinggal'
            ),
            $this->firstValue(
                [$lokasi],
                'jenis_lantai_tinggal'
            ),
            $this->firstValue(
                [$lokasi],
                'dinding_sebagian'
            ),
            $this->firstValue(
                [$lokasi],
                'jendela'
            ),
            $this->firstValue(
                [$lokasi],
                'atap'
            ),
            $this->firstValue(
                [$lokasi],
                'penerangan'
            ),
            $this->firstValue(
                [$lokasi],
                'energi_masak'
            ),
            $this->firstValue(
                [$lokasi],
                'jika_kayu_jenis'
            ),
            $this->firstValue(
                [$lokasi],
                'tempat_sampah'
            ),
            $this->firstValue(
                [$lokasi],
                'mck'
            ),
            $this->firstValue(
                [$lokasi],
                'sumber_air_mandi'
            ),
            $this->firstValue(
                [$lokasi],
                'sumber_air_mck'
            ),
            $this->firstValue(
                [$lokasi],
                'sumber_air_minum'
            ),
            $this->firstValue(
                [$lokasi],
                'tempat_pembuangan_limbah'
            ),
            $this->firstValue(
                [$lokasi],
                'rumah_sutet'
            ),
            $this->firstValue(
                [$lokasi],
                'rumah_sungai'
            ),
            $this->firstValue(
                [$lokasi],
                'rumah_lereng_gunung'
            ),
            $this->firstValue(
                [$lokasi],
                'kondi_rumah_kumuh'
            ),
        ];

        /*
         * Pendidikan: 9 x 3 = 27 kolom.
         */
        foreach (self::PENDIDIKAN as $item) {
            $this->appendTripletValues(
                $values,
                [$pendidikan],
                $item['prefix']
            );
        }

        /*
         * Fasilitas kesehatan: 8 x 3 = 24 kolom.
         */
        foreach (self::FASILITAS_KESEHATAN as $item) {
            $this->appendTripletValues(
                $values,
                [$kesehatan],
                $item['prefix']
            );
        }

        /*
         * Tenaga kesehatan: 5 x 3 = 15 kolom.
         *
         * $kesehatan disertakan sebagai fallback untuk data lama.
         */
        foreach (self::TENAGA_KESEHATAN as $item) {
            $this->appendTripletValues(
                $values,
                [$tenaga, $kesehatan],
                $item['prefix']
            );
        }

        /*
         * Sarana/prasarana: 6 x 5 = 30 kolom.
         */
        foreach (self::SARPRAS as $item) {
            $prefix = $item['prefix'];

            $values[] = $this->firstValue(
                [$sarpras, $lokasi, $individu],
                'jenistrasport_' . $prefix
            );

            $values[] = $this->firstValue(
                [$sarpras, $lokasi, $individu],
                'pengtransportumum_' . $prefix
            );

            $values[] = $this->firstValue(
                [$sarpras, $lokasi, $individu],
                'waktutempuh_' . $prefix
            );

            $values[] = $this->firstValue(
                [$sarpras, $lokasi, $individu],
                'biaya_' . $prefix
            );

            $values[] = $this->firstValue(
                [$sarpras, $lokasi, $individu],
                'kemudahan_' . $prefix
            );
        }

        /*
         * Transportasi umum sebelum dan sekarang.
         */
        $values[] = $this->firstValue(
            [$lain, $sarpras, $lokasi, $individu],
            'pengtransportsebelum'
        );

        $values[] = $this->firstValue(
            [$lain, $sarpras, $lokasi, $individu],
            'pengtransportsesudah'
        );

        /*
         * Delapan program pemerintah.
         */
        foreach (self::PROGRAM_PEMERINTAH as $item) {
            $values[] = $this->firstValue(
                [$lain, $individu, $lokasi],
                $item['field']
            );
        }

        /*
         * Rata-rata pengeluaran.
         */
        $values[] = $this->firstValue(
            [$lain, $individu, $lokasi],
            'rata_rata'
        );

        if (count($values) !== self::EXPECTED_COLUMN_COUNT) {
            throw new RuntimeException(
                "Mapping NIK {$nik} harus menghasilkan 135 kolom, " .
                'tetapi menghasilkan ' .
                count($values) .
                ' kolom.'
            );
        }

        return $values;
    }

    /**
     * Tambahkan Jarak, Waktu, dan Kemudahan.
     */
    protected function appendTripletValues(
        array &$values,
        array $sources,
        string $prefix
    ): void {
        $values[] = $this->firstValue(
            $sources,
            'jaraktempuh_' . $prefix
        );

        $values[] = $this->firstValue(
            $sources,
            'waktutempuh_' . $prefix
        );

        $values[] = $this->firstValue(
            $sources,
            'kemudahan_' . $prefix
        );
    }

    /**
     * Ambil nilai pertama yang benar-benar terisi.
     */
    protected function firstValue(
        array $sources,
        string $field
    ) {
        foreach ($sources as $source) {
            if ($source === null) {
                continue;
            }

            $value = data_get($source, $field);

            if ($this->hasValue($value)) {
                return $this->cellValue($value);
            }
        }

        return '';
    }

    /**
     * Ambil nilai dari beberapa kemungkinan nama field.
     */
    protected function firstAvailable(
        array $sources,
        array $fields
    ) {
        foreach ($fields as $field) {
            $value = $this->firstValue(
                $sources,
                $field
            );

            if ($value !== '') {
                return $value;
            }
        }

        return '';
    }

    protected function hasValue($value): bool
    {
        if ($value === null) {
            return false;
        }

        if (
            is_string($value) &&
            trim($value) === ''
        ) {
            return false;
        }

        return true;
    }

    /**
     * Normalisasi nilai agar aman dimasukkan ke satu sel Excel.
     */
    protected function cellValue($value)
    {
        if ($value === null) {
            return '';
        }

        if ($value instanceof Collection) {
            $value = $value->toArray();
        }

        if (is_array($value)) {
            return collect($value)
                ->flatten()
                ->filter(function ($item): bool {
                    return $item !== null &&
                        trim((string) $item) !== '';
                })
                ->map(function ($item): string {
                    return trim((string) $item);
                })
                ->implode(', ');
        }

        if (is_bool($value)) {
            return $value ? 'Ya' : 'Tidak';
        }

        if (is_object($value)) {
            if (method_exists($value, '__toString')) {
                return (string) $value;
            }

            return json_encode(
                $value,
                JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES
            );
        }

        return $value;
    }
}
