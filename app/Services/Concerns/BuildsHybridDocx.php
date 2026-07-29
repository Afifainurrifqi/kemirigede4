<?php

namespace App\Services\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use RuntimeException;

trait BuildsHybridDocx
{
    /**
     * Membuat DOCX hybrid dari gambar halaman PDF.
     *
     * Background halaman dipasang absolut terhadap halaman Word.
     * Baris nomor surat ditulis sebagai satu textbox absolut agar label
     * "Nomor", "No", atau "Reg. No" tidak tertutup dan posisinya stabil.
     *
     * @param  array<int, UploadedFile>  $pages
     * @param  array<string, mixed>  $metadata
     */
    public function buildDocx(
        string $jenis,
        string $id,
        array $pages,
        array $metadata
    ) {
        if ($pages === []) {
            throw new RuntimeException('Tidak ada gambar halaman untuk dibuat menjadi DOCX.');
        }

        $pageMetadata = data_get($metadata, 'pages', []);
        $numberMetadata = data_get($metadata, 'number');

        if (! is_array($pageMetadata) || count($pageMetadata) !== count($pages)) {
            throw new RuntimeException('Metadata halaman DOCX tidak sesuai.');
        }

        $tempDirectory = storage_path(
            'app/tmp/docx-hybrid/' . Str::uuid()->toString()
        );

        File::ensureDirectoryExists($tempDirectory);

        $storedPages = [];
        $outputPath = $tempDirectory . DIRECTORY_SEPARATOR . 'hasil.docx';

        try {
            foreach ($pages as $index => $uploadedPage) {
                if (! $uploadedPage instanceof UploadedFile || ! $uploadedPage->isValid()) {
                    throw new RuntimeException(
                        'Gambar halaman ke-' . ($index + 1) . ' tidak valid.'
                    );
                }

                $extension = strtolower(
                    $uploadedPage->getClientOriginalExtension() ?: 'jpg'
                );

                if (! in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
                    $extension = 'jpg';
                }

                $filename = sprintf(
                    'page_%02d.%s',
                    $index + 1,
                    $extension
                );

                $uploadedPage->move($tempDirectory, $filename);
                $storedPages[$index] = $tempDirectory
                    . DIRECTORY_SEPARATOR
                    . $filename;
            }

            $phpWord = new PhpWord();
            $phpWord->getCompatibility()->setOoxmlVersion(15);

            foreach ($storedPages as $pageIndex => $imagePath) {
                $meta = $pageMetadata[$pageIndex] ?? [];

                $pageWidthPt = $this->normaliseHybridPagePoint(
                    data_get($meta, 'widthPt'),
                    595.276
                );

                $pageHeightPt = $this->normaliseHybridPagePoint(
                    data_get($meta, 'heightPt'),
                    841.890
                );

                $sectionStyle = [
                    'pageSizeW' => (int) round($pageWidthPt * 20),
                    'pageSizeH' => (int) round($pageHeightPt * 20),
                    'marginTop' => 0,
                    'marginRight' => 0,
                    'marginBottom' => 0,
                    'marginLeft' => 0,
                    'headerHeight' => 0,
                    'footerHeight' => 0,
                    'gutter' => 0,
                ];

                if ($pageIndex > 0) {
                    $sectionStyle['breakType'] = 'nextPage';
                }

                $section = $phpWord->addSection($sectionStyle);

                $header = $section->addHeader();
                $header->addImage($imagePath, [
                    'width' => $pageWidthPt,
                    'height' => $pageHeightPt,
                    'unit' => 'pt',
                    'positioning' => 'absolute',
                    'posHorizontal' => 'left',
                    'posHorizontalRel' => 'page',
                    'posVertical' => 'top',
                    'posVerticalRel' => 'page',
                    'marginLeft' => 0,
                    'marginTop' => 0,
                    'wrappingStyle' => 'behind',
                ]);

                if (
                    is_array($numberMetadata)
                    && (int) data_get($numberMetadata, 'pageIndex', -1) === $pageIndex
                    && filled(data_get($numberMetadata, 'text'))
                ) {
                    $this->addHybridEditableNumberTextBox(
                        $section,
                        $numberMetadata,
                        $pageWidthPt,
                        $pageHeightPt
                    );
                }

                $section->addText(
                    ' ',
                    [
                        'name' => 'Arial',
                        'size' => 1,
                        'color' => 'FFFFFF',
                    ],
                    [
                        'spaceBefore' => 0,
                        'spaceAfter' => 0,
                        'lineHeight' => 1,
                    ]
                );
            }

            $writer = IOFactory::createWriter($phpWord, 'Word2007');
            $writer->save($outputPath);

            $safeJenis = Str::slug($jenis, '_');
            $safeId = Str::slug($id, '_');
            $downloadName = trim($safeJenis . '_' . $safeId, '_') . '.docx';

            return response()
                ->download(
                    $outputPath,
                    $downloadName,
                    [
                        'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                    ]
                )
                ->deleteFileAfterSend(true);
        } catch (\Throwable $exception) {
            File::deleteDirectory($tempDirectory);
            throw $exception;
        }
    }

    private function addHybridEditableNumberTextBox(
        $section,
        array $number,
        float $pageWidthPt,
        float $pageHeightPt
    ): void {
        $xRatio = $this->clampHybridRatio(data_get($number, 'xRatio', 0.05));
        $yRatio = $this->clampHybridRatio(data_get($number, 'yRatio', 0));
        $widthRatio = $this->clampHybridRatio(data_get($number, 'widthRatio', 0.90));
        $heightRatio = $this->clampHybridRatio(data_get($number, 'heightRatio', 0.025));

        $leftPt = $pageWidthPt * $xRatio;
        $topPt = $pageHeightPt * $yRatio;
        $widthPt = max(72, $pageWidthPt * $widthRatio);
        $heightPt = max(18, $pageHeightPt * $heightRatio);

        $verticalCorrectionPt = (float) data_get(
            $number,
            'verticalCorrectionPt',
            -0.8
        );

        $topPt = max(0, $topPt + $verticalCorrectionPt);

        if ($leftPt + $widthPt > $pageWidthPt) {
            $widthPt = max(72, $pageWidthPt - $leftPt);
        }

        $alignment = strtolower(
            (string) data_get($number, 'alignment', 'left')
        );

        if (! in_array($alignment, ['left', 'center', 'right'], true)) {
            $alignment = 'left';
        }

        $fontSize = max(
            7,
            min(18, (float) data_get($number, 'fontSizePt', 11))
        );

        $fontFamily = trim(
            (string) data_get($number, 'fontFamily', 'Times New Roman')
        );

        if ($fontFamily === '') {
            $fontFamily = 'Times New Roman';
        }

        $textBox = $section->addTextBox([
            'width' => $widthPt,
            'height' => $heightPt,
            'unit' => 'pt',
            'positioning' => 'absolute',
            'posHorizontal' => 'left',
            'posHorizontalRel' => 'page',
            'posVertical' => 'top',
            'posVerticalRel' => 'page',
            'marginLeft' => $leftPt,
            'marginTop' => $topPt,
            'wrappingStyle' => 'infront',
            'borderSize' => 0,
            'innerMarginTop' => 0,
            'innerMarginRight' => 0,
            'innerMarginBottom' => 0,
            'innerMarginLeft' => 0,
        ]);

        $textBox->addText(
            (string) data_get($number, 'text', ''),
            [
                'name' => $fontFamily,
                'size' => $fontSize,
                'bold' => (bool) data_get($number, 'bold', false),
                'color' => '000000',
            ],
            [
                'alignment' => $alignment,
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'lineHeight' => 1,
                'keepNext' => true,
                'keepLines' => true,
            ]
        );
    }

    private function normaliseHybridPagePoint($value, float $fallback): float
    {
        if (! is_numeric($value)) {
            return $fallback;
        }

        $value = (float) $value;

        if ($value < 100 || $value > 2000) {
            return $fallback;
        }

        return $value;
    }

    private function clampHybridRatio($value): float
    {
        if (! is_numeric($value)) {
            return 0;
        }

        return max(0, min(1, (float) $value));
    }
}
