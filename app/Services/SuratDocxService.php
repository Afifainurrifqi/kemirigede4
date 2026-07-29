<?php

namespace App\Services;

use App\Services\Concerns\BuildsHybridDocx;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class SuratDocxService
{

    use BuildsHybridDocx;
    /**
     * Pastikan jenis surat terdaftar dan dokumen tersedia.
     */
    public function prepare(string $jenis, string $id): array
    {
        $definition = $this->resolveDefinition($jenis);
        $data = $this->findData($definition, $id);

        return [
            'definition' => $definition,
            'data' => $data,
            'filename' => $this->buildFilename($definition, $data, $id),
        ];
    }

    /**
     * PDF sumber dibuat dari Blade yang sama dengan Export PDF.
     * Browser kemudian meraster PDF ini agar tampilan Word tidak berubah.
     */
    public function streamPdf(string $jenis, string $id)
    {
        $prepared = $this->prepare($jenis, $id);
        $definition = $prepared['definition'];
        $data = $prepared['data'];

        $pdf = Pdf::loadView(
            $definition['view'],
            [
                'data' => $data,
                'surat' => $data,
            ]
        )->setPaper('A4', 'portrait');

        return $pdf->stream('sumber-docx.pdf');
    }



    /**
     * Buat DOCX hybrid:
     * - setiap halaman PDF menjadi background gambar;
     * - hanya nilai nomor surat yang menjadi teks Word editable.
     *
     * @param array<int, UploadedFile> $pageFiles
     */
    public function buildDocx(
        string $jenis,
        string $id,
        array $pageFiles,
        array $metadata
    ): BinaryFileResponse {
        $prepared = $this->prepare($jenis, $id);
        $filename = $prepared['filename'];

        if ($pageFiles === []) {
            throw new RuntimeException('Halaman hasil render tidak ditemukan.');
        }

        $pageMeta = $metadata['pages'] ?? [];
        $numberMeta = $metadata['number'] ?? null;

        $tempRoot = storage_path('app/docx_hybrid');
        File::ensureDirectoryExists($tempRoot, 0775, true);

        $jobDirectory = $tempRoot . DIRECTORY_SEPARATOR . (string) Str::uuid();
        File::ensureDirectoryExists($jobDirectory, 0775, true);

        try {
            $savedPages = [];

            foreach (array_values($pageFiles) as $index => $file) {
                if (! $file instanceof UploadedFile || ! $file->isValid()) {
                    throw new RuntimeException(
                        'File halaman ke-' . ($index + 1) . ' tidak valid.'
                    );
                }

                $extension = strtolower($file->getClientOriginalExtension());
                $extension = in_array($extension, ['jpg', 'jpeg', 'png'], true)
                    ? $extension
                    : 'jpg';

                $path = $jobDirectory . DIRECTORY_SEPARATOR
                    . 'page_' . ($index + 1) . '.' . $extension;

                $file->move($jobDirectory, basename($path));
                $savedPages[] = $path;
            }

            $phpWord = new PhpWord();
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(11);

            foreach ($savedPages as $index => $imagePath) {
                $meta = $pageMeta[$index] ?? [];
                $canvasWidth = max(1, (float) ($meta['width'] ?? 794));
                $canvasHeight = max(1, (float) ($meta['height'] ?? 1123));
                $isLandscape = $canvasWidth > $canvasHeight;

                // Ukuran A4 dalam point.
                $pageWidthPt = $isLandscape ? 841.89 : 595.28;
                $pageHeightPt = $isLandscape ? 595.28 : 841.89;

                $section = $phpWord->addSection([
                    'paperSize' => 'A4',
                    'orientation' => $isLandscape ? 'landscape' : 'portrait',
                    'marginTop' => 0,
                    'marginBottom' => 0,
                    'marginLeft' => 0,
                    'marginRight' => 0,
                    'headerHeight' => 0,
                    'footerHeight' => 0,
                ]);

                /*
                 * Gambar halaman ditempatkan absolut di header dan berada
                 * di belakang teks. Dengan demikian badan dokumen hanya
                 * berisi nomor surat yang dapat diedit.
                 */
                $header = $section->addHeader();
                $header->addImage($imagePath, [
                    'width' => $pageWidthPt,
                    'height' => $pageHeightPt,
                    'positioning' => 'absolute',
                    'posHorizontal' => 'left',
                    'posHorizontalRel' => 'page',
                    'posVertical' => 'top',
                    'posVerticalRel' => 'page',
                    'wrappingStyle' => 'behind',
                    'marginLeft' => 0,
                    'marginTop' => 0,
                ]);

                if (
                    is_array($numberMeta)
                    && (int) ($numberMeta['pageIndex'] ?? -1) === $index
                    && trim((string) ($numberMeta['text'] ?? '')) !== ''
                ) {
                    $xRatio = $this->clamp(
                        (float) ($numberMeta['xRatio'] ?? 0.30),
                        0.0,
                        0.95
                    );
                    $yRatio = $this->clamp(
                        (float) ($numberMeta['yRatio'] ?? 0.20),
                        0.0,
                        0.95
                    );

                    $xPt = $pageWidthPt * $xRatio;

                    $fontSize = $this->clamp(
                        (float) ($numberMeta['fontSizePt'] ?? 11),
                        7.0,
                        20.0
                    );

                    /*
                     * PHPWord menempatkan teks body berdasarkan kotak
                     * paragraf, bukan tepat pada top teks PDF. Akibatnya,
                     * nomor editable dapat turun sekitar satu baris.
                     *
                     * Koreksi dinamis ini mengangkat nomor agar sejajar
                     * dengan label "Nomor :" pada background PDF.
                     * Nilai tetap mengikuti ukuran font setiap surat.
                     */
                    $verticalCorrectionPt = $this->clamp(
                        (float) (
                            $numberMeta['verticalCorrectionPt']
                            ?? ($fontSize * 2.00)
                        ),
                        12.0,
                        24.0
                    );

                    $yPt = max(
                        0.0,
                        ($pageHeightPt * $yRatio) - $verticalCorrectionPt
                    );

                    $fontName = $this->normalizeFontName(
                        (string) ($numberMeta['fontFamily'] ?? 'Times New Roman')
                    );

                    $section->addText(
                        trim((string) $numberMeta['text']),
                        [
                            'name' => $fontName,
                            'size' => $fontSize,
                            'color' => '000000',
                        ],
                        [
                            'alignment' => 'left',
                            'spaceBefore' => (int) round($yPt * 20),
                            'spaceAfter' => 0,
                            'lineHeight' => 1.0,
                            'indentation' => [
                                'left' => (int) round($xPt * 20),
                            ],
                        ]
                    );
                } else {
                    // Menjamin section tetap menghasilkan satu halaman.
                    $section->addText('', ['size' => 1], [
                        'spaceBefore' => 0,
                        'spaceAfter' => 0,
                    ]);
                }
            }

            $docxPath = $jobDirectory . DIRECTORY_SEPARATOR . 'hasil.docx';
            IOFactory::createWriter($phpWord, 'Word2007')->save($docxPath);

            return response()
                ->download(
                    $docxPath,
                    $filename,
                    [
                        'Content-Type' =>
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ]
                )
                ->deleteFileAfterSend(true);
        } catch (\Throwable $e) {
            File::deleteDirectory($jobDirectory);
            throw $e;
        }
    }

    public function supports(string $jenis): bool
    {
        try {
            $this->resolveDefinition($jenis);
            return true;
        } catch (RuntimeException $e) {
            return false;
        }
    }



    private function resolveDefinition(string $jenis): array
    {
        $documents = config('surat_docx.documents', []);
        $normalized = $this->normalizeJenis($jenis);

        if (isset($documents[$normalized])) {
            return $documents[$normalized];
        }

        foreach ($documents as $definition) {
            foreach (($definition['aliases'] ?? []) as $alias) {
                if ($this->normalizeJenis((string) $alias) === $normalized) {
                    return $definition;
                }
            }
        }

        throw new RuntimeException(
            "Jenis surat '{$jenis}' belum terdaftar untuk ekspor DOCX."
        );
    }

    private function findData(array $definition, string $id): Model
    {
        $modelClass = $definition['model'] ?? null;

        if (! is_string($modelClass) || ! class_exists($modelClass)) {
            throw new RuntimeException('Model surat tidak ditemukan.');
        }

        /** @var Model $data */
        $data = $modelClass::findOrFail($id);

        return $data;
    }

    private function buildFilename(
        array $definition,
        Model $data,
        string $id
    ): string {
        $identity = null;

        foreach (($definition['filename_fields'] ?? []) as $field) {
            $value = data_get($data, $field);

            if (is_scalar($value) && trim((string) $value) !== '') {
                $identity = trim((string) $value);
                break;
            }
        }

        $identity ??= $id;

        $prefix = Str::slug(
            (string) ($definition['filename_prefix'] ?? 'surat'),
            '_'
        );

        $slug = Str::slug($identity, '_');
        $slug = $slug !== '' ? $slug : Str::slug($id, '_');

        return $prefix . '_' . $slug . '.docx';
    }

    private function normalizeJenis(string $jenis): string
    {
        return strtolower(
            preg_replace('/[^a-z0-9]+/i', '', $jenis) ?? ''
        );
    }

    private function normalizeFontName(string $font): string
    {
        $lower = strtolower($font);

        if (str_contains($lower, 'arial') || str_contains($lower, 'sans')) {
            return 'Arial';
        }

        if (str_contains($lower, 'times') || str_contains($lower, 'serif')) {
            return 'Times New Roman';
        }

        return 'Times New Roman';
    }

    private function clamp(float $value, float $min, float $max): float
    {
        return max($min, min($max, $value));
    }
}
