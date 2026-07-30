<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class SuratDocxService
{
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
        $definition = $prepared['definition'];
        $data = $prepared['data'];
        $filename = $prepared['filename'];

        if ($pageFiles === []) {
            throw new RuntimeException('Halaman hasil render tidak ditemukan.');
        }

        $pageMeta = is_array($metadata['pages'] ?? null)
            ? $metadata['pages']
            : [];

        /*
         * Posisi dan gaya boleh berasal dari browser/PDF, tetapi isi nomor
         * selalu diambil ulang dari record surat pada server. Dengan demikian,
         * nomor surat A tidak mungkin terbawa ke surat B karena metadata lama.
         */
        $numberMeta = $this->buildNumberMetadata(
            $metadata['number'] ?? null,
            $definition,
            $data
        );

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
            $phpWord->getCompatibility()->setOoxmlVersion(15);
            $phpWord->setDefaultFontName('Times New Roman');
            $phpWord->setDefaultFontSize(11);

            $resolvedTextBoxLayouts = [];

            foreach ($savedPages as $index => $imagePath) {
                $meta = $pageMeta[$index] ?? [];
                $canvasWidth = max(
                    1.0,
                    (float) ($meta['width'] ?? $meta['canvasWidth'] ?? 794)
                );
                $canvasHeight = max(
                    1.0,
                    (float) ($meta['height'] ?? $meta['canvasHeight'] ?? 1123)
                );
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
                 * Background dan textbox ditempatkan pada story/layer Word
                 * yang sama. Jika background berada di header sementara teks
                 * berada di body, Word dapat menggambar teks di belakang gambar.
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
                    'wrappingStyle' => 'behind',
                    'marginLeft' => 0,
                    'marginTop' => 0,
                ]);

                if (
                    is_array($numberMeta)
                    && (int) ($numberMeta['pageIndex'] ?? -1) === $index
                    && trim((string) ($numberMeta['text'] ?? '')) !== ''
                ) {
                    $textBoxLayout = $this->addEditableNumberTextBox(
                        $section,
                        $numberMeta,
                        $pageWidthPt,
                        $pageHeightPt,
                        $canvasWidth,
                        $canvasHeight
                    );

                    $resolvedTextBoxLayouts[] = array_merge(
                        ['pageIndex' => $index],
                        $textBoxLayout
                    );
                }

                // Anchor minimal agar setiap section tetap mempunyai satu halaman.
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

            $docxPath = $jobDirectory . DIRECTORY_SEPARATOR . 'hasil.docx';
            IOFactory::createWriter($phpWord, 'Word2007')->save($docxPath);

            $this->hardenDocxLayout($docxPath, $resolvedTextBoxLayouts);

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

    /**
     * Menggabungkan style/posisi nomor dari konfigurasi dan metadata browser,
     * kemudian mengganti isinya dengan nomor milik record yang sedang diekspor.
     *
     * Prioritas isi nomor:
     * 1. field server pada `number_fields` / `number_field`;
     * 2. metadata hasil render PDF, hanya bila fallback diizinkan.
     */
    private function buildNumberMetadata(
        mixed $clientMetadata,
        array $definition,
        Model $data
    ): ?array {
        $configuredMetadata = is_array($definition['number_style'] ?? null)
            ? $definition['number_style']
            : [];

        $clientMetadata = is_array($clientMetadata)
            ? $clientMetadata
            : [];

        $numberMetadata = array_replace_recursive(
            $configuredMetadata,
            $clientMetadata
        );

        $numberText = $this->resolveDocumentNumber(
            $definition,
            $data,
            $clientMetadata
        );

        if ($numberText === null) {
            if ((bool) ($definition['number_required'] ?? false)) {
                throw new RuntimeException(
                    'Nomor surat tidak ditemukan pada data yang sedang diekspor.'
                );
            }

            return null;
        }

        // Nomor dari server tetap menjadi sumber utama, tetapi label baris
        // (misalnya "Nomor :") dipertahankan dari template PDF.
        $numberMetadata['text'] = $this->composeNumberLineText(
            $numberText,
            $definition,
            $clientMetadata
        );
        $numberMetadata['pageIndex'] = (int) (
            $numberMetadata['pageIndex']
            ?? $definition['number_page_index']
            ?? 0
        );

        return $numberMetadata;
    }

    /**
     * Mengambil nomor surat dinamis berdasarkan record saat ini.
     * Field dapat berbeda antarjenis surat, misalnya `nomor_surat` atau
     * `nomor_sppd`. Gunakan `number_fields` pada config untuk menentukan urutan.
     */
    private function resolveDocumentNumber(
        array $definition,
        Model $data,
        array $clientMetadata
    ): ?string {
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

        $fields = array_values(array_unique($fields));
        $numberText = null;

        foreach ($fields as $field) {
            $numberText = $this->normalizeNumberText(data_get($data, $field));

            if ($numberText !== null) {
                break;
            }
        }

        /*
         * Beberapa template lama membentuk nomor di Blade dan tidak menyimpannya
         * dalam model. Agar tetap kompatibel, teks hasil render PDF boleh dipakai
         * sebagai fallback. Nonaktifkan dengan:
         * `allow_client_number_fallback => false`.
         */
        if (
            $numberText === null
            && (bool) ($definition['allow_client_number_fallback'] ?? true)
        ) {
            $numberText = $this->normalizeNumberText(
                $clientMetadata['text'] ?? null
            );
        }

        if ($numberText === null) {
            return null;
        }

        if ((bool) ($definition['strip_number_label'] ?? false)) {
            $numberText = preg_replace(
                '/^(?:nomor|no\.?|reg\.?\s*no\.?)\s*:\s*/iu',
                '',
                $numberText
            ) ?? $numberText;
        }

        $prefix = (string) ($definition['number_prefix'] ?? '');
        $suffix = (string) ($definition['number_suffix'] ?? '');

        return $prefix . $numberText . $suffix;
    }

    /**
     * Membentuk satu baris lengkap, misalnya:
     * "Nomor : 471/001/409.47.5/2026".
     *
     * Label dapat diatur melalui `number_label` pada config. Bila tidak ada,
     * label hasil deteksi PDF digunakan. Default terakhir adalah "Nomor :".
     */
    private function composeNumberLineText(
        string $numberText,
        array $definition,
        array $clientMetadata
    ): string {
        $numberText = trim($numberText);

        if ((bool) ($definition['include_number_label'] ?? true) === false) {
            return $numberText;
        }

        // Hindari label ganda bila field server sudah menyimpan label lengkap.
        if (preg_match(
            '/^(?:nomor|no\.?|reg\.?\s*no\.?)\s*[:：]/iu',
            $numberText
        ) === 1) {
            return $numberText;
        }

        $label = $definition['number_label']
            ?? $clientMetadata['label']
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

    private function normalizeNumberText(mixed $value): ?string
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

    private function addEditableNumberTextBox(
        $section,
        array $numberMeta,
        float $pageWidthPt,
        float $pageHeightPt,
        float $sourceWidth,
        float $sourceHeight
    ): array {
        $alignment = strtolower(
            trim((string) ($numberMeta['alignment'] ?? 'center'))
        );

        if (! in_array($alignment, ['left', 'center', 'right'], true)) {
            $alignment = 'center';
        }

        $fontSize = $this->clamp(
            (float) ($numberMeta['fontSizePt'] ?? 11),
            7.0,
            20.0
        );

        [$leftPt, $topPt, $widthPt, $heightPt] =
            $this->resolveEditableTextGeometry(
                $numberMeta,
                $pageWidthPt,
                $pageHeightPt,
                $sourceWidth,
                $sourceHeight,
                $fontSize
            );

        $fontName = $this->normalizeFontName(
            (string) ($numberMeta['fontFamily'] ?? 'Times New Roman')
        );

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
            trim((string) ($numberMeta['text'] ?? '')),
            [
                'name' => $fontName,
                'size' => $fontSize,
                'bold' => (bool) ($numberMeta['bold'] ?? false),
                'italic' => (bool) ($numberMeta['italic'] ?? false),
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
            'fontFamily' => $fontName,
            'alignment' => $alignment,
        ];
    }

    /**
     * Mengubah koordinat hasil deteksi browser/PDF menjadi koordinat halaman
     * Word. Prioritas format metadata:
     *
     * 1. leftPt/topPt/widthPt/heightPt;
     * 2. box atau x/y/width/height dalam pixel canvas PDF;
     * 3. xRatio/yRatio/widthRatio/heightRatio.
     *
     * Alignment tidak lagi mengubah posisi kotak. Alignment hanya mengatur
     * teks di dalam kotak, sehingga posisi horizontal tetap sama dengan PDF.
     *
     * @return array{0: float, 1: float, 2: float, 3: float}
     */
    private function resolveEditableTextGeometry(
        array $metadata,
        float $pageWidthPt,
        float $pageHeightPt,
        float $sourceWidth,
        float $sourceHeight,
        float $fontSize
    ): array {
        $box = is_array($metadata['box'] ?? null)
            ? $metadata['box']
            : [];

        $sourceWidth = max(
            1.0,
            $this->firstNumeric([
                $metadata['canvasWidth'] ?? null,
                $metadata['sourceWidth'] ?? null,
                $box['canvasWidth'] ?? null,
                $box['sourceWidth'] ?? null,
                $sourceWidth,
            ]) ?? $sourceWidth
        );

        $sourceHeight = max(
            1.0,
            $this->firstNumeric([
                $metadata['canvasHeight'] ?? null,
                $metadata['sourceHeight'] ?? null,
                $box['canvasHeight'] ?? null,
                $box['sourceHeight'] ?? null,
                $sourceHeight,
            ]) ?? $sourceHeight
        );

        $leftPt = $this->firstNumeric([
            $metadata['leftPt'] ?? null,
            $metadata['xPt'] ?? null,
            $box['leftPt'] ?? null,
            $box['xPt'] ?? null,
        ]);

        $topPt = $this->firstNumeric([
            $metadata['topPt'] ?? null,
            $metadata['yPt'] ?? null,
            $box['topPt'] ?? null,
            $box['yPt'] ?? null,
        ]);

        $widthPt = $this->firstNumeric([
            $metadata['widthPt'] ?? null,
            $box['widthPt'] ?? null,
        ]);

        $heightPt = $this->firstNumeric([
            $metadata['heightPt'] ?? null,
            $box['heightPt'] ?? null,
        ]);

        $leftPx = $this->firstNumeric([
            $metadata['left'] ?? null,
            $metadata['x'] ?? null,
            $box['left'] ?? null,
            $box['x'] ?? null,
        ]);

        $topPx = $this->firstNumeric([
            $metadata['top'] ?? null,
            $metadata['y'] ?? null,
            $box['top'] ?? null,
            $box['y'] ?? null,
        ]);

        $widthPx = $this->firstNumeric([
            $metadata['width'] ?? null,
            $box['width'] ?? null,
        ]);

        $heightPx = $this->firstNumeric([
            $metadata['height'] ?? null,
            $box['height'] ?? null,
        ]);

        if ($leftPt === null) {
            $leftPt = $leftPx !== null
                ? ($leftPx / $sourceWidth) * $pageWidthPt
                : $pageWidthPt * $this->clamp(
                    (float) ($metadata['xRatio'] ?? 0.05),
                    0.0,
                    1.0
                );
        }

        if ($topPt === null) {
            $topPt = $topPx !== null
                ? ($topPx / $sourceHeight) * $pageHeightPt
                : $pageHeightPt * $this->clamp(
                    (float) ($metadata['yRatio'] ?? 0.20),
                    0.0,
                    1.0
                );
        }

        if ($widthPt === null) {
            $widthPt = $widthPx !== null
                ? ($widthPx / $sourceWidth) * $pageWidthPt
                : $pageWidthPt * $this->clamp(
                    (float) ($metadata['widthRatio'] ?? 0.90),
                    0.05,
                    1.0
                );
        }

        if ($heightPt === null) {
            $heightPt = $heightPx !== null
                ? ($heightPx / $sourceHeight) * $pageHeightPt
                : $pageHeightPt * $this->clamp(
                    (float) ($metadata['heightRatio'] ?? 0.025),
                    0.01,
                    0.25
                );
        }

        $anchorX = strtolower((string) ($metadata['anchorX'] ?? 'left'));
        $anchorY = strtolower((string) ($metadata['anchorY'] ?? 'top'));

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

        $leftPt += (float) ($metadata['horizontalCorrectionPt'] ?? 0.0);
        $topPt += (float) ($metadata['verticalCorrectionPt'] ?? -0.8);

        $widthPt = max(18.0, min($pageWidthPt, $widthPt));
        $heightPt = max($fontSize * 1.35, min($pageHeightPt, $heightPt));
        $leftPt = max(0.0, min($pageWidthPt - $widthPt, $leftPt));
        $topPt = max(0.0, min($pageHeightPt - $heightPt, $topPt));

        return [$leftPt, $topPt, $widthPt, $heightPt];
    }

    /**
     * Mengunci seluruh gambar halaman dan posisi textbox pada OOXML.
     *
     * - gambar tidak dapat dipilih, dipindahkan, diubah ukuran, atau diputar;
     * - anchor gambar dikunci terhadap halaman;
     * - textbox tetap dapat diedit, tetapi posisinya dikunci;
     * - warna teks dipaksa hitam dan tidak hidden.
     */
    private function hardenDocxLayout(
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
                            $style = $this->replaceVmlStyleProperty(
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
                                    $style = $this->replaceVmlStyleProperty(
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

                        // Textbox sengaja TIDAK dikunci posisinya agar admin
                        // dapat menyeret dan menyesuaikannya langsung di Word.
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

    private function replaceVmlStyleProperty(
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

    private function firstNumeric(array $values): ?float
    {
        foreach ($values as $value) {
            if (is_numeric($value)) {
                return (float) $value;
            }
        }

        return null;
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
