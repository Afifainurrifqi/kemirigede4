<?php

namespace App\Exports;

use App\Models\datapenduduk;
use App\Models\lokasipemukiman;
use App\Models\dataindividu;
use App\Models\akses_pendidikan;
use App\Models\akseskesehatan;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\DefaultValueBinder;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class LokasidanPemukimanExport extends DefaultValueBinder implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithColumnFormatting,
    WithCustomValueBinder
{
    protected array $allowedDatak = [
        'tetap',
        'tidaktetap',
    ];

    protected array $nikList = [];

    protected bool $cacheReady = false;

    protected Collection $lokasiMap;
    protected Collection $individuMap;
    protected Collection $pendMap;
    protected Collection $kesMap;
    protected Collection $tenagaMap;
    protected Collection $sarprasMap;
    protected Collection $lainMap;

    /**
     * Kelompok akses pendidikan.
     *
     * label  = judul kolom Excel
     * prefix = akhiran nama field database
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
        ['label' => 'PENDIDIKAN KEAGAMAAN LAIN', 'prefix' => 'pagamalain'],
    ];

    /**
     * Akses fasilitas kesehatan.
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
     * Akses tenaga kesehatan.
     */
    protected const TENAGA_KESEHATAN = [
        ['label' => 'DOKTER SPESIALIS', 'prefix' => 'dr_spesialis'],
        ['label' => 'DOKTER UMUM', 'prefix' => 'dr_umum'],
        ['label' => 'BIDAN', 'prefix' => 'bidan'],
        ['label' => 'TENAGA KESEHATAN / PERAWAT', 'prefix' => 'tenagakes'],
        ['label' => 'DUKUN', 'prefix' => 'dukun'],
    ];

    /**
     * Akses sarana dan prasarana.
     */
    protected const SARPRAS = [
        ['label' => 'LOKASI PEKERJAAN UTAMA', 'prefix' => 'lokasipu'],
        ['label' => 'LAHAN PERTANIAN YANG DIUSAHAKAN', 'prefix' => 'lahanpertanian'],
        ['label' => 'SEKOLAH', 'prefix' => 'sekolah'],
        ['label' => 'BEROBAT', 'prefix' => 'berobat'],
        ['label' => 'BERIBADAH MINGGUAN/BULANAN/TAHUNAN', 'prefix' => 'beribadah'],
        ['label' => 'REKREASI TERDEKAT', 'prefix' => 'rekreasi'],
    ];

    /**
     * Program pemerintah dan data lainnya.
     */
    protected const PROGRAM_PEMERINTAH = [
        ['label' => 'BLT', 'field' => 'blt'],
        ['label' => 'PKH', 'field' => 'pkh'],
        ['label' => 'BST', 'field' => 'bst'],
        ['label' => 'BANTUAN PRESIDEN', 'field' => 'bantuan_presiden'],
        ['label' => 'BANTUAN UMKM', 'field' => 'bantuan_umkm'],
        ['label' => 'BANTUAN PEKERJA', 'field' => 'bantuan_pekerja'],
        ['label' => 'BANTUAN ANAK', 'field' => 'bantuan_anak'],
        ['label' => 'LAINNYA', 'field' => 'lainnya'],
    ];

    public function __construct(protected ?string $filterNik = null)
    {
        $this->filterNik = $this->filterNik !== null
            ? trim((string) $this->filterNik)
            : null;

        /*
         * Ambil semua NIK yang mempunyai data lokasi/pemukiman
         * dan NIK kepala keluarga yang terisi.
         */
        $this->nikList = lokasipemukiman::whereNotNull('nik_kepala')
            ->where('nik_kepala', '!=', '')
            ->pluck('nik')
            ->filter(function ($nik) {
                return $nik !== null && trim((string) $nik) !== '';
            })
            ->map(function ($nik) {
                return trim((string) $nik);
            })
            ->unique()
            ->values()
            ->toArray();

        /*
         * Export satu NIK.
         */
        if ($this->filterNik !== null && $this->filterNik !== '') {
            $this->nikList = in_array(
                $this->filterNik,
                $this->nikList,
                true
            )
                ? [$this->filterNik]
                : [];
        }
    }

    /**
     * Query utama data penduduk MySQL.
     */
    public function query()
    {
        if (empty($this->nikList)) {
            return datapenduduk::query()->whereRaw('1 = 0');
        }

        return datapenduduk::query()
            ->with(['detailkk.kk'])
            ->whereIn('Datak', $this->allowedDatak)
            ->whereIn('nik', $this->nikList)
            ->orderBy('nama');
    }

    /**
     * Header lengkap Excel.
     *
     * Total: 135 kolom.
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

            $headings[] = $label . ' - JENIS TRANSPORTASI';
            $headings[] = $label . ' - TRANSPORTASI UMUM';
            $headings[] = $label . ' - WAKTU (JAM)';
            $headings[] = $label . ' - BIAYA (Rp)';
            $headings[] = $label . ' - KEMUDAHAN';
        }

        $headings[] = 'TRANSPORTASI UMUM - SEBELUMNYA';
        $headings[] = 'TRANSPORTASI UMUM - SEKARANG';

        foreach (self::PROGRAM_PEMERINTAH as $item) {
            $headings[] = $item['label'];
        }

        $headings[] = 'RATA-RATA PENGELUARAN / BULAN (Rp)';

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
     * Format identitas dan nomor telepon sebagai teks.
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
     * Paksa KK, NIK, nomor HP, dan angka panjang sebagai teks.
     */
    public function bindValue(Cell $cell, $value)
    {
        if (
            in_array(
                $cell->getColumn(),
                ['A', 'B', 'E', 'F', 'G'],
                true
            )
        ) {
            $cell->setValueExplicit(
                (string) $value,
                DataType::TYPE_STRING
            );

            return true;
        }

        if (
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
     * Bangun seluruh cache satu kali untuk mencegah N+1 query.
     */
    protected function buildCache(): void
    {
        if ($this->cacheReady) {
            return;
        }

        $niks = $this->nikList;

        $this->lokasiMap = lokasipemukiman::whereIn(
            'nik',
            $niks
        )->get()->keyBy(function ($item) {
            return trim((string) data_get($item, 'nik', ''));
        });

        $this->individuMap = dataindividu::whereIn(
            'nik',
            $niks
        )->get()->keyBy(function ($item) {
            return trim((string) data_get($item, 'nik', ''));
        });

        $this->pendMap = akses_pendidikan::whereIn(
            'nik',
            $niks
        )->get()->keyBy(function ($item) {
            return trim((string) data_get($item, 'nik', ''));
        });

        $this->kesMap = akseskesehatan::whereIn(
            'nik',
            $niks
        )->get()->keyBy(function ($item) {
            return trim((string) data_get($item, 'nik', ''));
        });

        /*
         * Beberapa project memakai nama model huruf kecil,
         * beberapa memakai StudlyCase. Daftar kandidat ini
         * membuat export tetap berjalan pada keduanya.
         */
        $this->tenagaMap = $this->fetchMap(
            [
                'App\\Models\\aksestenagakerja',
                'App\\Models\\Aksestenagakerja',
                'App\\Models\\AksesTenagaKerja',
            ],
            $niks
        );

        $this->sarprasMap = $this->fetchMap(
            [
                'App\\Models\\aksessarpras',
                'App\\Models\\Aksessarpras',
                'App\\Models\\AksesSarpras',
            ],
            $niks
        );

        $this->lainMap = $this->fetchMap(
            [
                'App\\Models\\laink',
                'App\\Models\\Laink',
            ],
            $niks
        );

        $this->cacheReady = true;
    }

    /**
     * Ambil data berdasarkan kandidat nama model.
     *
     * Collection kosong dikembalikan bila model belum tersedia,
     * sehingga proses export tidak langsung gagal.
     */
    protected function fetchMap(
        array $modelCandidates,
        array $niks
    ): Collection {
        foreach ($modelCandidates as $modelClass) {
            if (!class_exists($modelClass)) {
                continue;
            }

            return $modelClass::whereIn('nik', $niks)
                ->get()
                ->keyBy(function ($item) {
                    return trim(
                        (string) data_get($item, 'nik', '')
                    );
                });
        }

        return collect();
    }

    /**
     * Mapping lengkap per baris.
     */
    public function map($row): array
    {
        $this->buildCache();

        $nik = trim((string) $row->nik);

        $kk = optional(
            optional($row->detailkk)->kk
        )->nokk ?? '';

        $lok = $this->lokasiMap->get($nik);
        $ind = $this->individuMap->get($nik);
        $pend = $this->pendMap->get($nik);
        $kes = $this->kesMap->get($nik);
        $tenaga = $this->tenagaMap->get($nik);
        $sarpras = $this->sarprasMap->get($nik);
        $lain = $this->lainMap->get($nik);

        $values = [
            (string) $kk,
            $nik,
            $this->cellValue($row->nama ?? ''),
            $this->cellValue($row->alamat ?? ''),
            (string) data_get($ind, 'nohp', ''),
            (string) data_get($ind, 'nowa', ''),

            (string) data_get($lok, 'nik_kepala', ''),
            $this->cellValue(data_get($lok, 'tempat_tinggal', '')),
            $this->cellValue(data_get($lok, 'status_lahan', '')),
            $this->cellValue(data_get($lok, 'luas_lantai_tinggal', '')),
            $this->cellValue(data_get($lok, 'luas_tanah_tinggal', '')),
            $this->cellValue(data_get($lok, 'jenis_lantai_tinggal', '')),
            $this->cellValue(data_get($lok, 'dinding_sebagian', '')),
            $this->cellValue(data_get($lok, 'jendela', '')),
            $this->cellValue(data_get($lok, 'atap', '')),
            $this->cellValue(data_get($lok, 'penerangan', '')),
            $this->cellValue(data_get($lok, 'energi_masak', '')),
            $this->cellValue(data_get($lok, 'jika_kayu_jenis', '')),
            $this->cellValue(data_get($lok, 'tempat_sampah', '')),
            $this->cellValue(data_get($lok, 'mck', '')),
            $this->cellValue(data_get($lok, 'sumber_air_mandi', '')),
            $this->cellValue(data_get($lok, 'sumber_air_mck', '')),
            $this->cellValue(data_get($lok, 'sumber_air_minum', '')),
            $this->cellValue(data_get($lok, 'tempat_pembuangan_limbah', '')),
            $this->cellValue(data_get($lok, 'rumah_sutet', '')),
            $this->cellValue(data_get($lok, 'rumah_sungai', '')),
            $this->cellValue(data_get($lok, 'rumah_lereng_gunung', '')),
            $this->cellValue(data_get($lok, 'kondi_rumah_kumuh', '')),
        ];

        /*
         * Pendidikan: 9 kelompok x 3 kolom.
         */
        foreach (self::PENDIDIKAN as $item) {
            $this->appendTripletValues(
                $values,
                [$pend],
                $item['prefix']
            );
        }

        /*
         * Fasilitas kesehatan: 8 kelompok x 3 kolom.
         */
        foreach (self::FASILITAS_KESEHATAN as $item) {
            $this->appendTripletValues(
                $values,
                [$kes],
                $item['prefix']
            );
        }

        /*
         * Tenaga kesehatan: 5 kelompok x 3 kolom.
         *
         * Fallback ke akseskesehatan untuk project lama
         * yang masih menyimpan field tenaga kesehatan di sana.
         */
        foreach (self::TENAGA_KESEHATAN as $item) {
            $this->appendTripletValues(
                $values,
                [$tenaga, $kes],
                $item['prefix']
            );
        }

        /*
         * Sarana/prasarana: 6 kelompok x 5 kolom.
         */
        foreach (self::SARPRAS as $item) {
            $prefix = $item['prefix'];
            $sources = [$sarpras, $lok, $ind];

            $values[] = $this->firstValue(
                $sources,
                'jenistrasport_' . $prefix
            );

            $values[] = $this->firstValue(
                $sources,
                'pengtransportumum_' . $prefix
            );

            $values[] = $this->firstValue(
                $sources,
                'waktutempuh_' . $prefix
            );

            $values[] = $this->firstValue(
                $sources,
                'biaya_' . $prefix
            );

            $values[] = $this->firstValue(
                $sources,
                'kemudahan_' . $prefix
            );
        }

        /*
         * Transportasi umum sebelum dan sekarang.
         */
        $values[] = $this->firstValue(
            [$sarpras, $lain, $lok, $ind],
            'pengtransportsebelum'
        );

        $values[] = $this->firstValue(
            [$sarpras, $lain, $lok, $ind],
            'pengtransportsesudah'
        );

        /*
         * Pemanfaat program pemerintah.
         */
        foreach (self::PROGRAM_PEMERINTAH as $item) {
            $values[] = $this->firstValue(
                [$lain, $ind, $lok],
                $item['field']
            );
        }

        /*
         * Pengeluaran rata-rata per bulan.
         */
        $values[] = $this->firstValue(
            [$lain, $ind, $lok],
            'rata_rata'
        );

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

            if ($value === null) {
                continue;
            }

            if (
                is_string($value) &&
                trim($value) === ''
            ) {
                continue;
            }

            return $this->cellValue($value);
        }

        return '';
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
                ->filter(function ($item) {
                    return $item !== null &&
                        trim((string) $item) !== '';
                })
                ->map(function ($item) {
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
