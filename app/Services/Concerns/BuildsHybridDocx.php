<?php

namespace App\Services\Concerns;

use DOMDocument;
use DOMXPath;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use RuntimeException;
use ZipArchive;

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
        $numberMetadata = $this->buildHybridNumberMetadata(
            $jenis,
            $id,
            data_get($metadata, 'number')
        );

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

            $resolvedTextBoxLayouts = [];

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

                $sourceWidth = $this->normaliseHybridSourceDimension(
                    data_get($meta, 'width', data_get($meta, 'canvasWidth')),
                    $pageWidthPt
                );

                $sourceHeight = $this->normaliseHybridSourceDimension(
                    data_get($meta, 'height', data_get($meta, 'canvasHeight')),
                    $pageHeightPt
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

                /*
                 * Background dan textbox harus berada pada story/layer Word
                 * yang sama. Menaruh gambar di header dan textbox di body dapat
                 * membuat textbox berada di belakang gambar pada Word Desktop.
                 */
                $section->addImage($imagePath, [
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
                    $textBoxLayout = $this->addHybridEditableNumberTextBox(
                        $section,
                        $numberMetadata,
                        $pageWidthPt,
                        $pageHeightPt,
                        $sourceWidth,
                        $sourceHeight
                    );

                    $resolvedTextBoxLayouts[] = array_merge(
                        ['pageIndex' => $pageIndex],
                        $textBoxLayout
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

            $this->hardenHybridDocxLayout($outputPath, $resolvedTextBoxLayouts);

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

    /**
     * Menentukan metadata nomor surat dengan isi dinamis per record.
     *
     * Trait ini mencoba menggunakan method `prepare($jenis, $id)` milik service.
     * Bila service tidak memilikinya, class pengguna trait dapat menyediakan:
     *
     * protected function resolveHybridDocxNumberFromServer(
     *     string $jenis,
     *     string $id
     * ): mixed
     *
     * Nilai dari server selalu lebih diprioritaskan daripada teks request.
     */
    private function buildHybridNumberMetadata(
        string $jenis,
        string $id,
        mixed $clientMetadata
    ): ?array {
        $clientMetadata = is_array($clientMetadata)
            ? $clientMetadata
            : [];

        $definition = [];
        $data = null;
        $serverNumber = null;

        if (method_exists($this, 'prepare')) {
            $prepared = $this->prepare($jenis, $id);

            if (is_array($prepared)) {
                $definition = is_array($prepared['definition'] ?? null)
                    ? $prepared['definition']
                    : [];
                $data = $prepared['data'] ?? null;
            }
        }

        if (method_exists($this, 'resolveHybridDocxNumberFromServer')) {
            $serverNumber = $this->resolveHybridDocxNumberFromServer(
                $jenis,
                $id
            );
        }

        $configuredMetadata = is_array($definition['number_style'] ?? null)
            ? $definition['number_style']
            : [];

        $numberMetadata = array_replace_recursive(
            $configuredMetadata,
            $clientMetadata
        );

        $numberText = $this->normalizeHybridNumberText($serverNumber);

        if ($numberText === null && $data !== null) {
            $fields = [];

            if (is_string($definition['number_field'] ?? null)) {
                $fields[] = $definition['number_field'];
            }

            if (is_array($definition['number_fields'] ?? null)) {
                foreach ($definition['number_fields'] as $field) {
                    if (is_string($field) && trim($field) !== '') {
                        $fields[] = trim($field);
                    }
                }
            }

            if ($fields === []) {
                $fields = [
                    'nomor_surat',
                    'nomor_sppd',
                    'no_surat',
                    'nomor',
                ];
            }

            foreach (array_values(array_unique($fields)) as $field) {
                $numberText = $this->normalizeHybridNumberText(
                    data_get($data, $field)
                );

                if ($numberText !== null) {
                    break;
                }
            }
        }

        if (
            $numberText === null
            && (bool) ($definition['allow_client_number_fallback'] ?? true)
        ) {
            $numberText = $this->normalizeHybridNumberText(
                data_get($clientMetadata, 'text')
            );
        }

        if ($numberText === null) {
            if ((bool) ($definition['number_required'] ?? false)) {
                throw new RuntimeException(
                    'Nomor surat tidak ditemukan pada data yang sedang diekspor.'
                );
            }

            return null;
        }

        if ((bool) ($definition['strip_number_label'] ?? false)) {
            $numberText = preg_replace(
                '/^(?:nomor|no\.?|reg\.?\s*no\.?)\s*:\s*/iu',
                '',
                $numberText
            ) ?? $numberText;
        }

        $numberText = (string) (
            $definition['number_prefix'] ?? ''
        ) . $numberText . (string) (
            $definition['number_suffix'] ?? ''
        );

        $numberMetadata['text'] = $this->composeHybridNumberLineText(
            $numberText,
            $definition,
            $clientMetadata
        );

        $numberMetadata['pageIndex'] = (int) (
            data_get($numberMetadata, 'pageIndex')
            ?? ($definition['number_page_index'] ?? 0)
        );

        return $numberMetadata;
    }

    private function composeHybridNumberLineText(
        string $numberText,
        array $definition,
        array $clientMetadata
    ): string {
        $numberText = trim($numberText);

        if ((bool) ($definition['include_number_label'] ?? true) === false) {
            return $numberText;
        }

        if (preg_match(
            '/^(?:nomor|no\.?|reg\.?\s*no\.?)\s*[:：]/iu',
            $numberText
        ) === 1) {
            return $numberText;
        }

        $label = $definition['number_label']
            ?? data_get($clientMetadata, 'label')
            ?? 'Nomor :';

        $label = trim((string) $label);
        $label = preg_replace('/\s+/u', ' ', $label) ?? $label;

        if ($label === '') {
            $label = 'Nomor :';
        }

        if (preg_match('/[:：]\s*$/u', $label) !== 1) {
            $label .= ' :';
        }

        return trim($label . ' ' . $numberText);
    }

    private function normalizeHybridNumberText(mixed $value): ?string
    {
        if (! is_scalar($value)) {
            return null;
        }

        $text = html_entity_decode(
            (string) $value,
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $text = strip_tags($text);
        $text = str_replace(["\u{00A0}", "\xC2\xA0"], ' ', $text);
        $text = preg_replace('/[\t\r\n]+/u', ' ', $text) ?? $text;
        $text = preg_replace('/ {2,}/u', ' ', $text) ?? $text;
        $text = trim($text);

        return $text === '' ? null : $text;
    }

    private function addHybridEditableNumberTextBox(
        $section,
        array $number,
        float $pageWidthPt,
        float $pageHeightPt,
        float $sourceWidth,
        float $sourceHeight
    ): array {
        $alignment = strtolower(
            trim((string) data_get($number, 'alignment', 'center'))
        );

        if (! in_array($alignment, ['left', 'center', 'right'], true)) {
            $alignment = 'center';
        }

        $fontSize = max(
            7,
            min(18, (float) data_get($number, 'fontSizePt', 11))
        );

        [$leftPt, $topPt, $widthPt, $heightPt] =
            $this->resolveHybridEditableTextGeometry(
                $number,
                $pageWidthPt,
                $pageHeightPt,
                $sourceWidth,
                $sourceHeight,
                $fontSize
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
            trim((string) data_get($number, 'text', '')),
            [
                'name' => $fontFamily,
                'size' => $fontSize,
                'bold' => (bool) data_get($number, 'bold', false),
                'italic' => (bool) data_get($number, 'italic', false),
                'color' => '000000',
            ],
            [
                'alignment' => $alignment,
                'spaceBefore' => 0,
                'spaceAfter' => 0,
                'lineHeight' => 1,
                'keepNext' => false,
                'keepLines' => true,
            ]
        );

        return [
            'leftPt' => $leftPt,
            'topPt' => $topPt,
            'widthPt' => $widthPt,
            'heightPt' => $heightPt,
            'fontSizePt' => $fontSize,
            'fontFamily' => $fontFamily,
            'alignment' => $alignment,
        ];
    }

    /**
     * Mengubah koordinat canvas PDF menjadi koordinat halaman Word.
     * Alignment hanya mengatur teks dalam textbox dan tidak menggeser textbox.
     *
     * @return array{0: float, 1: float, 2: float, 3: float}
     */
    private function resolveHybridEditableTextGeometry(
        array $metadata,
        float $pageWidthPt,
        float $pageHeightPt,
        float $sourceWidth,
        float $sourceHeight,
        float $fontSize
    ): array {
        $box = is_array(data_get($metadata, 'box'))
            ? data_get($metadata, 'box')
            : [];

        $sourceWidth = max(
            1,
            $this->firstHybridNumeric([
                data_get($metadata, 'canvasWidth'),
                data_get($metadata, 'sourceWidth'),
                data_get($box, 'canvasWidth'),
                data_get($box, 'sourceWidth'),
                $sourceWidth,
            ]) ?? $sourceWidth
        );

        $sourceHeight = max(
            1,
            $this->firstHybridNumeric([
                data_get($metadata, 'canvasHeight'),
                data_get($metadata, 'sourceHeight'),
                data_get($box, 'canvasHeight'),
                data_get($box, 'sourceHeight'),
                $sourceHeight,
            ]) ?? $sourceHeight
        );

        $leftPt = $this->firstHybridNumeric([
            data_get($metadata, 'leftPt'),
            data_get($metadata, 'xPt'),
            data_get($box, 'leftPt'),
            data_get($box, 'xPt'),
        ]);

        $topPt = $this->firstHybridNumeric([
            data_get($metadata, 'topPt'),
            data_get($metadata, 'yPt'),
            data_get($box, 'topPt'),
            data_get($box, 'yPt'),
        ]);

        $widthPt = $this->firstHybridNumeric([
            data_get($metadata, 'widthPt'),
            data_get($box, 'widthPt'),
        ]);

        $heightPt = $this->firstHybridNumeric([
            data_get($metadata, 'heightPt'),
            data_get($box, 'heightPt'),
        ]);

        $leftPx = $this->firstHybridNumeric([
            data_get($metadata, 'left'),
            data_get($metadata, 'x'),
            data_get($box, 'left'),
            data_get($box, 'x'),
        ]);

        $topPx = $this->firstHybridNumeric([
            data_get($metadata, 'top'),
            data_get($metadata, 'y'),
            data_get($box, 'top'),
            data_get($box, 'y'),
        ]);

        $widthPx = $this->firstHybridNumeric([
            data_get($metadata, 'width'),
            data_get($box, 'width'),
        ]);

        $heightPx = $this->firstHybridNumeric([
            data_get($metadata, 'height'),
            data_get($box, 'height'),
        ]);

        if ($leftPt === null) {
            $leftPt = $leftPx !== null
                ? ($leftPx / $sourceWidth) * $pageWidthPt
                : $pageWidthPt * $this->clampHybridRatio(
                    data_get($metadata, 'xRatio', 0.05)
                );
        }

        if ($topPt === null) {
            $topPt = $topPx !== null
                ? ($topPx / $sourceHeight) * $pageHeightPt
                : $pageHeightPt * $this->clampHybridRatio(
                    data_get($metadata, 'yRatio', 0.20)
                );
        }

        if ($widthPt === null) {
            $widthPt = $widthPx !== null
                ? ($widthPx / $sourceWidth) * $pageWidthPt
                : $pageWidthPt * max(
                    0.05,
                    $this->clampHybridRatio(
                        data_get($metadata, 'widthRatio', 0.90)
                    )
                );
        }

        if ($heightPt === null) {
            $heightPt = $heightPx !== null
                ? ($heightPx / $sourceHeight) * $pageHeightPt
                : $pageHeightPt * max(
                    0.01,
                    $this->clampHybridRatio(
                        data_get($metadata, 'heightRatio', 0.025)
                    )
                );
        }

        $anchorX = strtolower((string) data_get($metadata, 'anchorX', 'left'));
        $anchorY = strtolower((string) data_get($metadata, 'anchorY', 'top'));

        if ($anchorX === 'center') {
            $leftPt -= $widthPt / 2;
        } elseif ($anchorX === 'right') {
            $leftPt -= $widthPt;
        }

        if ($anchorY === 'center') {
            $topPt -= $heightPt / 2;
        } elseif ($anchorY === 'bottom') {
            $topPt -= $heightPt;
        }

        $leftPt += (float) data_get($metadata, 'horizontalCorrectionPt', 0);
        $topPt += (float) data_get($metadata, 'verticalCorrectionPt', -0.8);

        $widthPt = max(18, min($pageWidthPt, $widthPt));
        $heightPt = max($fontSize * 1.35, min($pageHeightPt, $heightPt));
        $leftPt = max(0, min($pageWidthPt - $widthPt, $leftPt));
        $topPt = max(0, min($pageHeightPt - $heightPt, $topPt));

        return [$leftPt, $topPt, $widthPt, $heightPt];
    }

    /**
     * Mengunci gambar halaman dan posisi textbox langsung pada OOXML.
     */
    private function hardenHybridDocxLayout(
        string $docxPath,
        array $textBoxLayouts = []
    ): void
    {
        if (
            ! class_exists(ZipArchive::class)
            || ! class_exists(DOMDocument::class)
            || ! class_exists(DOMXPath::class)
        ) {
            return;
        }

        $zip = new ZipArchive();

        if ($zip->open($docxPath) !== true) {
            return;
        }

        try {
            $xmlFiles = [];
            $textBoxLayouts = array_values($textBoxLayouts);
            $textBoxLayoutIndex = 0;

            for ($index = 0; $index < $zip->numFiles; $index++) {
                $entryName = $zip->getNameIndex($index);

                if (! is_string($entryName)) {
                    continue;
                }

                if (
                    $entryName === 'word/document.xml'
                    || preg_match('/^word\/header\d+\.xml$/', $entryName) === 1
                ) {
                    $xmlFiles[] = $entryName;
                }
            }

            foreach ($xmlFiles as $xmlFile) {
                $xml = $zip->getFromName($xmlFile);

                if (! is_string($xml) || $xml === '') {
                    continue;
                }

                $dom = new DOMDocument('1.0', 'UTF-8');
                $dom->preserveWhiteSpace = true;
                $dom->formatOutput = false;

                if (! @$dom->loadXML($xml)) {
                    continue;
                }

                $xpath = new DOMXPath($dom);
                $namespaces = [
                    'w' => 'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                    'wp' => 'http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing',
                    'a' => 'http://schemas.openxmlformats.org/drawingml/2006/main',
                    'pic' => 'http://schemas.openxmlformats.org/drawingml/2006/picture',
                    'v' => 'urn:schemas-microsoft-com:vml',
                    'o' => 'urn:schemas-microsoft-com:office:office',
                    'w14' => 'http://schemas.microsoft.com/office/word/2010/wordml',
                ];

                foreach ($namespaces as $prefix => $namespace) {
                    $xpath->registerNamespace($prefix, $namespace);
                }

                $wordNamespace = $namespaces['w'];
                $drawingNamespace = $namespaces['a'];
                $vmlNamespace = $namespaces['v'];
                $officeNamespace = $namespaces['o'];

                if ($xmlFile === 'word/document.xml') {
                    foreach ($xpath->query('//w:txbxContent//w:r') ?: [] as $run) {
                        $runProperties = $xpath->query('./w:rPr', $run)?->item(0);

                        if ($runProperties === null) {
                            $runProperties = $dom->createElementNS(
                                $wordNamespace,
                                'w:rPr'
                            );
                            $run->insertBefore($runProperties, $run->firstChild);
                        }

                        foreach ([
                            'w:color',
                            'w:vanish',
                            'w:webHidden',
                            'w:highlight',
                            'w:shd',
                            'w14:textFill',
                            'w14:textOutline',
                        ] as $query) {
                            $nodes = $xpath->query('./' . $query, $runProperties);

                            if ($nodes === false) {
                                continue;
                            }

                            foreach (iterator_to_array($nodes) as $node) {
                                $runProperties->removeChild($node);
                            }
                        }

                        $color = $dom->createElementNS($wordNamespace, 'w:color');
                        $color->setAttributeNS($wordNamespace, 'w:val', '000000');
                        $runProperties->appendChild($color);
                    }

                    foreach (
                        $xpath->query('//v:shape[descendant::w:txbxContent]') ?: []
                        as $shape
                    ) {
                        $shape->setAttribute('filled', 'f');
                        $shape->setAttribute('stroked', 'f');
                        $shape->removeAttribute('fillcolor');
                        $shape->removeAttribute('strokecolor');

                        $layout = $textBoxLayouts[$textBoxLayoutIndex] ?? [];
                        $textBoxLayoutIndex++;

                        $style = (string) $shape->getAttribute('style');

                        foreach ([
                            'position' => 'absolute',
                            'z-index' => '251659264',
                            'mso-position-horizontal-relative' => 'page',
                            'mso-position-vertical-relative' => 'page',
                            'mso-wrap-style' => 'none',
                            'visibility' => 'visible',
                            'opacity' => '1',
                        ] as $property => $value) {
                            $style = $this->replaceHybridVmlStyleProperty(
                                $style,
                                $property,
                                $value
                            );
                        }

                        if ($layout !== []) {
                            foreach ([
                                'margin-left' => $layout['leftPt'] ?? null,
                                'margin-top' => $layout['topPt'] ?? null,
                                'width' => $layout['widthPt'] ?? null,
                                'height' => $layout['heightPt'] ?? null,
                            ] as $property => $value) {
                                if (is_numeric($value)) {
                                    $style = $this->replaceHybridVmlStyleProperty(
                                        $style,
                                        $property,
                                        number_format((float) $value, 3, '.', '') . 'pt'
                                    );
                                }
                            }
                        }

                        $shape->setAttribute('style', $style);

                        $lock = $xpath->query('./o:lock', $shape)?->item(0);

                        if ($lock === null) {
                            $lock = $dom->createElementNS(
                                $officeNamespace,
                                'o:lock'
                            );
                            $shape->appendChild($lock);
                        }

                        $lock->setAttributeNS($vmlNamespace, 'v:ext', 'edit');
                        foreach (['position', 'selection'] as $attribute) {
                            if ($lock->hasAttribute($attribute)) {
                                $lock->removeAttribute($attribute);
                            }
                        }
                        $lock->setAttribute('rotation', 't');
                        $lock->setAttribute('aspectratio', 't');

                        foreach ($xpath->query('./v:textbox', $shape) ?: [] as $textbox) {
                            $textbox->setAttribute('inset', '0,0,0,0');
                            $textbox->setAttribute('style', 'mso-fit-shape-to-text:false');
                        }

                        $alignment = strtolower((string) ($layout['alignment'] ?? 'center'));
                        $wordAlignment = match ($alignment) {
                            'left' => 'left',
                            'right' => 'right',
                            default => 'center',
                        };

                        foreach ($xpath->query('.//w:txbxContent//w:p', $shape) ?: [] as $paragraph) {
                            $paragraphProperties = $xpath->query('./w:pPr', $paragraph)?->item(0);

                            if ($paragraphProperties === null) {
                                $paragraphProperties = $dom->createElementNS(
                                    $wordNamespace,
                                    'w:pPr'
                                );
                                $paragraph->insertBefore(
                                    $paragraphProperties,
                                    $paragraph->firstChild
                                );
                            }

                            foreach ($xpath->query('./w:jc', $paragraphProperties) ?: [] as $node) {
                                $paragraphProperties->removeChild($node);
                            }

                            $justification = $dom->createElementNS($wordNamespace, 'w:jc');
                            $justification->setAttributeNS(
                                $wordNamespace,
                                'w:val',
                                $wordAlignment
                            );
                            $paragraphProperties->appendChild($justification);
                        }
                    }
                }

                foreach (
                    $xpath->query('//wp:anchor[descendant::pic:pic]') ?: []
                    as $anchor
                ) {
                    $anchor->setAttribute('locked', '1');
                    $anchor->setAttribute('behindDoc', '1');
                    $anchor->setAttribute('layoutInCell', '0');
                    $anchor->setAttribute('allowOverlap', '1');
                    $anchor->setAttribute('relativeHeight', '0');
                    $anchor->setAttribute('distT', '0');
                    $anchor->setAttribute('distB', '0');
                    $anchor->setAttribute('distL', '0');
                    $anchor->setAttribute('distR', '0');
                }

                foreach (
                    $xpath->query('//wp:cNvGraphicFramePr[ancestor::wp:anchor[descendant::pic:pic] or ancestor::wp:inline[descendant::pic:pic]]') ?: []
                    as $frameProperties
                ) {
                    $locks = $xpath->query('./a:graphicFrameLocks', $frameProperties)?->item(0);

                    if ($locks === null) {
                        $locks = $dom->createElementNS(
                            $drawingNamespace,
                            'a:graphicFrameLocks'
                        );
                        $frameProperties->appendChild($locks);
                    }

                    foreach ([
                        'noSelect',
                        'noMove',
                        'noResize',
                        'noChangeAspect',
                    ] as $attribute) {
                        $locks->setAttribute($attribute, '1');
                    }
                }

                foreach ($xpath->query('//pic:cNvPicPr') ?: [] as $pictureProperties) {
                    $locks = $xpath->query('./a:picLocks', $pictureProperties)?->item(0);

                    if ($locks === null) {
                        $locks = $dom->createElementNS(
                            $drawingNamespace,
                            'a:picLocks'
                        );
                        $pictureProperties->appendChild($locks);
                    }

                    foreach ([
                        'noSelect',
                        'noMove',
                        'noResize',
                        'noRot',
                        'noChangeAspect',
                        'noCrop',
                        'noEditPoints',
                    ] as $attribute) {
                        $locks->setAttribute($attribute, '1');
                    }
                }

                foreach (
                    $xpath->query('//v:shape[not(descendant::w:txbxContent)]') ?: []
                    as $shape
                ) {
                    $lock = $xpath->query('./o:lock', $shape)?->item(0);

                    if ($lock === null) {
                        $lock = $dom->createElementNS($officeNamespace, 'o:lock');
                        $shape->appendChild($lock);
                    }

                    $lock->setAttributeNS($vmlNamespace, 'v:ext', 'edit');

                    foreach ([
                        'selection',
                        'position',
                        'rotation',
                        'aspectratio',
                        'cropping',
                        'vertices',
                        'adjusthandles',
                        'grouping',
                        'shapetype',
                    ] as $attribute) {
                        $lock->setAttribute($attribute, 't');
                    }
                }

                $updatedXml = $dom->saveXML();

                if (is_string($updatedXml) && $updatedXml !== '') {
                    $zip->addFromString($xmlFile, $updatedXml);
                }
            }
        } finally {
            $zip->close();
        }
    }

    private function replaceHybridVmlStyleProperty(
        string $style,
        string $property,
        string $value
    ): string {
        $style = preg_replace(
            '/(?:^|;)\s*' . preg_quote($property, '/') . '\s*:[^;]*/i',
            '',
            $style
        ) ?? $style;

        $style = rtrim(trim($style), ';');

        return $style . ($style === '' ? '' : ';') . $property . ':' . $value;
    }

    private function firstHybridNumeric(array $values): ?float
    {
        foreach ($values as $value) {
            if (is_numeric($value)) {
                return (float) $value;
            }
        }

        return null;
    }

    private function normaliseHybridSourceDimension($value, float $fallback): float
    {
        if (! is_numeric($value) || (float) $value <= 0) {
            return $fallback;
        }

        return (float) $value;
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
