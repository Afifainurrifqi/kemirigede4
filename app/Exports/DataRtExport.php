<?php

namespace App\Exports;

use App\Models\Datart;
use DateTimeInterface;
use Generator;
use Illuminate\Contracts\Support\Arrayable;
use Maatwebsite\Excel\Concerns\FromGenerator;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class DataRtExport extends DefaultValueBinder implements
    FromGenerator,
    WithHeadings,
    WithCustomValueBinder,
    WithEvents,
    WithStrictNullComparison
{
    /**
     * Jumlah data RT yang diproses per batch.
     *
     * Nilai kecil menjaga penggunaan memori tetap stabil karena satu baris
     * memiliki ratusan kolom.
     */
    private int $chunkSize;

    public function __construct(int $chunkSize = 25)
    {
        $this->chunkSize = max(1, $chunkSize);
    }

    public function headings(): array
    {
        return array_map(
            static fn (array $column): string => $column['heading'],
            $this->columns()
        );
    }

    public function generator(): Generator
    {
        $page = 1;
        $sequence = 1;

        do {
            $baseRows = Datart::query()
                ->orderBy('nik')
                ->forPage($page, $this->chunkSize)
                ->get();

            if ($baseRows->isEmpty()) {
                break;
            }

            $niks = $baseRows
                ->pluck('nik')
                ->filter(static fn ($nik): bool => $nik !== null && $nik !== '')
                ->map(static fn ($nik): string => (string) $nik)
                ->values()
                ->all();

            $relatedRows = $this->loadRelatedRows($niks);

            foreach ($baseRows as $baseRow) {
                $nik = (string) ($baseRow->nik ?? '');
                $exportRow = [];

                foreach ($this->columns() as $column) {
                    if ($column['source'] === 'sequence') {
                        $exportRow[] = $sequence;
                        continue;
                    }

                    $model = $column['model'];
                    $attribute = $column['attribute'];

                    if ($model === Datart::class) {
                        $value = data_get($baseRow, $attribute);
                    } else {
                        $document = $relatedRows[$model][$nik] ?? null;
                        $value = $document ? data_get($document, $attribute) : null;
                    }

                    $exportRow[] = $this->normalizeValue($value);
                }

                yield $exportRow;
                $sequence++;
            }

            $page++;
        } while ($baseRows->count() === $this->chunkSize);
    }

    /**
     * Mengambil setiap collection terkait hanya satu kali per batch NIK.
     *
     * Ini menggantikan pola lama yang menjalankan query first() berulang kali
     * untuk setiap kolom dan setiap baris.
     */
    private function loadRelatedRows(array $niks): array
    {
        $result = [];

        foreach ($this->relatedModels() as $model) {
            if ($niks === []) {
                $result[$model] = [];
                continue;
            }

            $documents = $model::query()
                ->whereIn('nik', $niks)
                ->get()
                ->groupBy(static fn ($document): string => (string) ($document->nik ?? ''))
                ->map(static fn ($group) => $group->first());

            $result[$model] = $documents->all();
        }

        return $result;
    }

    private function relatedModels(): array
    {
        $models = [];

        foreach ($this->columns() as $column) {
            if (
                $column['source'] === 'model'
                && $column['model'] !== Datart::class
            ) {
                $models[] = $column['model'];
            }
        }

        return array_values(array_unique($models));
    }

    private function columns(): array
    {
        return config('data_rt_export.columns', []);
    }

    private function normalizeValue($value)
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d H:i:s');
        }

        if ($value instanceof \MongoDB\BSON\ObjectId) {
            return (string) $value;
        }

        if ($value instanceof Arrayable) {
            $value = $value->toArray();
        }

        if (is_array($value) || is_object($value)) {
            return json_encode(
                $value,
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            );
        }

        if (is_bool($value)) {
            return $value ? 'Ya' : 'Tidak';
        }

        return $value;
    }

    /**
     * Menjaga NIK, nomor telepon, dan angka panjang agar tidak dibulatkan
     * atau diubah menjadi notasi ilmiah oleh Excel.
     */
    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value)) {
            $trimmed = trim($value);

            if (
                preg_match('/^\d{12,}$/', $trimmed)
                || preg_match('/^0\d+$/', $trimmed)
            ) {
                $cell->setValueExplicit($value, DataType::TYPE_STRING);

                return true;
            }
        }

        return parent::bindValue($cell, $value);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => static function (AfterSheet $event): void {
                $columnCount = count(config('data_rt_export.columns', []));

                if ($columnCount < 1) {
                    return;
                }

                $lastColumn = Coordinate::stringFromColumnIndex($columnCount);
                $sheet = $event->sheet->getDelegate();

                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:{$lastColumn}1");
                $sheet->getStyle("A1:{$lastColumn}1")->getFont()->setBold(true);
                $sheet->getStyle("A1:{$lastColumn}1")
                    ->getAlignment()
                    ->setWrapText(true);
            },
        ];
    }
}
