<?php

namespace App\Exports;

use App\Models\datapenduduk;
use App\Models\lokasipemukiman; // Mongo
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
    protected array $allowedDatak = ['tetap', 'tidaktetap'];
    protected array $nikList = [];

    protected bool $cacheReady = false;

    protected Collection $lokasiMap;
    protected Collection $individuMap;
    protected Collection $pendMap;
    protected Collection $kesMap;

    /**
     * @param string|null $filterNik
     */
    public function __construct(protected ?string $filterNik = null)
    {
        /**
         * 1️⃣ Ambil SEMUA NIK dari Mongo yang nik_kepala TERISI
         */
        $this->nikList = lokasipemukiman::whereNotNull('nik_kepala')
            ->where('nik_kepala', '!=', '')
            ->pluck('nik')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        /**
         * 2️⃣ Jika export difilter per NIK
         */
        if ($this->filterNik) {
            $this->nikList = in_array($this->filterNik, $this->nikList, true)
                ? [$this->filterNik]
                : [];
        }
    }

    /**
     * Query utama MySQL
     */
    public function query()
    {
        if (empty($this->nikList)) {
            return datapenduduk::query()->whereRaw('1=0');
        }

        return datapenduduk::query()
            ->with(['detailkk.kk'])
            ->whereIn('Datak', $this->allowedDatak)
            ->whereIn('nik', $this->nikList);
    }

    /**
     * Header Excel
     */
    public function headings(): array
    {
        return [
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

            'PAUD JARAK',
            'PAUD WAKTU',
            'PAUD KEMUDAHAN',
        ];
    }

    /**
     * Format kolom angka panjang
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
     * Paksa TEXT untuk NIK, KK, No HP
     */
    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), ['A', 'B', 'E', 'F', 'G'], true)) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        if (is_numeric($value) && strlen((string)$value) >= 12) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * Build cache sekali saja (ANTI N+1)
     */
    protected function buildCache(): void
    {
        if ($this->cacheReady) return;

        $niks = $this->nikList;

        $this->lokasiMap   = lokasipemukiman::whereIn('nik', $niks)->get()->keyBy('nik');
        $this->individuMap = dataindividu::whereIn('nik', $niks)->get()->keyBy('nik');
        $this->pendMap     = akses_pendidikan::whereIn('nik', $niks)->get()->keyBy('nik');
        $this->kesMap      = akseskesehatan::whereIn('nik', $niks)->get()->keyBy('nik');

        $this->cacheReady = true;
    }

    /**
     * Mapping per baris
     */
    public function map($row): array
    {
        $this->buildCache();

        $kk   = optional(optional($row->detailkk)->kk)->nokk ?? '';
        $lok  = $this->lokasiMap->get($row->nik);
        $ind  = $this->individuMap->get($row->nik);
        $pend = $this->pendMap->get($row->nik);

        return [
            (string) $kk,
            (string) $row->nik,
            $row->nama ?? '',
            $row->alamat ?? '',
            (string) data_get($ind, 'nohp', ''),
            (string) data_get($ind, 'nowa', ''),

            (string) data_get($lok, 'nik_kepala', ''),
            data_get($lok, 'tempat_tinggal', ''),
            data_get($lok, 'status_lahan', ''),
            data_get($lok, 'luas_lantai_tinggal', ''),
            data_get($lok, 'luas_tanah_tinggal', ''),
            data_get($lok, 'jenis_lantai_tinggal', ''),
            data_get($lok, 'dinding_sebagian', ''),
            data_get($lok, 'jendela', ''),
            data_get($lok, 'atap', ''),
            data_get($lok, 'penerangan', ''),
            data_get($lok, 'energi_masak', ''),
            data_get($lok, 'jika_kayu_jenis', ''),
            data_get($lok, 'tempat_sampah', ''),
            data_get($lok, 'mck', ''),
            data_get($lok, 'sumber_air_mandi', ''),
            data_get($lok, 'sumber_air_mck', ''),
            data_get($lok, 'sumber_air_minum', ''),
            data_get($lok, 'tempat_pembuangan_limbah', ''),
            data_get($lok, 'rumah_sutet', ''),
            data_get($lok, 'rumah_sungai', ''),
            data_get($lok, 'rumah_lereng_gunung', ''),
            data_get($lok, 'kondi_rumah_kumuh', ''),

            data_get($pend, 'jaraktempuh_paud', ''),
            data_get($pend, 'waktutempuh_paud', ''),
            data_get($pend, 'kemudahan_paud', ''),
        ];
    }
}
