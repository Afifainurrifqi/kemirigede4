<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Membuat DOCX</title>

    <style>
        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
            background: #f3f6fa;
        }

        .export-card {
            width: min(560px, 100%);
            padding: 28px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.10);
            text-align: center;
        }

        .spinner {
            width: 48px;
            height: 48px;
            margin: 0 auto 18px;
            border: 5px solid #dbeafe;
            border-top-color: #2563eb;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        h1 {
            margin: 0 0 10px;
            font-size: 21px;
        }

        p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
        }

        .progress {
            height: 9px;
            margin: 20px 0 10px;
            overflow: hidden;
            background: #e2e8f0;
            border-radius: 999px;
        }

        .progress-bar {
            width: 4%;
            height: 100%;
            background: #2563eb;
            border-radius: inherit;
            transition: width 0.25s ease;
        }

        .status {
            min-height: 22px;
            margin-top: 8px;
            color: #334155;
            font-size: 13px;
        }

        .actions {
            display: none;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 0 16px;
            border: 0;
            border-radius: 9px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            color: #fff;
            background: #2563eb;
        }

        .btn-light {
            color: #334155;
            background: #e2e8f0;
        }

        .error {
            color: #b91c1c;
        }
    </style>
</head>
<body>
<div class="export-card">
    <div id="spinner" class="spinner"></div>
    <h1 id="title">Menyiapkan dokumen Word</h1>
    <p id="description">
        Tampilan surat akan dipertahankan seperti PDF. Baris nomor surat tetap dapat diedit.
    </p>

    <div class="progress">
        <div id="progressBar" class="progress-bar"></div>
    </div>

    <div id="status" class="status">Memuat PDF sumber...</div>

    <div id="actions" class="actions">
        <button type="button" id="retryButton" class="btn btn-primary">
            Coba Lagi
        </button>
        <a href="{{ $backUrl }}" class="btn btn-light">Kembali</a>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    (() => {
        'use strict';

        const sourceUrl = @json($sourceUrl);
        const buildUrl = @json($buildUrl);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        const statusElement = document.getElementById('status');
        const progressBar = document.getElementById('progressBar');
        const spinner = document.getElementById('spinner');
        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const actions = document.getElementById('actions');
        const retryButton = document.getElementById('retryButton');

        pdfjsLib.GlobalWorkerOptions.workerSrc =
            'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        function setProgress(percent, message) {
            progressBar.style.width = `${Math.max(4, Math.min(100, percent))}%`;
            statusElement.textContent = message;
        }

        function cleanText(value) {
            return String(value ?? '')
                .replace(/\u00a0/g, ' ')
                .replace(/\s+/g, ' ')
                .trim();
        }

        function compactText(value) {
            return cleanText(value)
                .replace(/\s+/g, '')
                .replace(/：/g, ':');
        }

        function normalizeFontFamily(value) {
            const family = cleanText(value).replace(/["']/g, '');

            if (!family) {
                return 'Times New Roman';
            }

            if (/times|serif/i.test(family)) {
                return 'Times New Roman';
            }

            if (/arial|helvetica|sans/i.test(family)) {
                return 'Arial';
            }

            return family;
        }

        /**
         * Mengelompokkan item teks PDF berdasarkan baseline.
         * rawText digabung tanpa spasi tambahan agar teks terfragmentasi seperti
         * "Nomo" + "r:" tetap terbaca sebagai "Nomor:".
         */
        function buildTextLines(textContent, viewport) {
            const lines = [];

            for (const item of textContent.items) {
                if (!item.str || cleanText(item.str) === '') {
                    continue;
                }

                const transform = pdfjsLib.Util.transform(
                    viewport.transform,
                    item.transform
                );

                const x = transform[4];
                const baselineY = transform[5];
                const fontHeight = Math.max(
                    7,
                    Math.hypot(transform[2], transform[3])
                );
                const width = Math.max(
                    1,
                    Number(item.width || 0) * viewport.scale
                );

                const tolerance = Math.max(3, fontHeight * 0.25);
                let line = lines.find(existing =>
                    Math.abs(existing.baselineY - baselineY) <= tolerance
                );

                if (!line) {
                    line = {
                        baselineY,
                        top: baselineY - fontHeight,
                        bottom: baselineY + Math.max(1, fontHeight * 0.12),
                        height: fontHeight,
                        items: [],
                    };
                    lines.push(line);
                }

                line.top = Math.min(line.top, baselineY - fontHeight);
                line.bottom = Math.max(
                    line.bottom,
                    baselineY + Math.max(1, fontHeight * 0.12)
                );
                line.height = Math.max(line.height, fontHeight);
                line.items.push({
                    raw: String(item.str),
                    text: cleanText(item.str),
                    x,
                    width,
                    top: baselineY - fontHeight,
                    bottom: baselineY + Math.max(1, fontHeight * 0.12),
                    height: fontHeight,
                    baselineY,
                    fontName: item.fontName,
                });
            }

            return lines.map(line => {
                line.items.sort((a, b) => a.x - b.x);
                line.rawText = line.items.map(item => item.raw).join('');
                line.spacedText = cleanText(
                    line.items.map(item => item.text).join(' ')
                );
                line.xMin = Math.min(...line.items.map(item => item.x));
                line.xMax = Math.max(...line.items.map(item => item.x + item.width));
                return line;
            });
        }

        function extractNumberParts(line) {
            let colonFound = false;
            const labelParts = [];
            const valueParts = [];

            for (const item of line.items) {
                const raw = String(item.raw).replace(/：/g, ':');
                const colonIndex = raw.indexOf(':');

                if (!colonFound && colonIndex >= 0) {
                    colonFound = true;

                    const before = raw.slice(0, colonIndex);
                    const after = raw.slice(colonIndex + 1);

                    if (cleanText(before)) {
                        labelParts.push(before);
                    }

                    if (cleanText(after)) {
                        valueParts.push(after);
                    }

                    continue;
                }

                if (colonFound) {
                    valueParts.push(raw);
                } else {
                    labelParts.push(raw);
                }
            }

            if (!colonFound) {
                return null;
            }

            const labelCompact = compactText(labelParts.join(''))
                .toLowerCase()
                .replace(/\.$/, '');

            let label = null;

            if (/^nomor(?:surat)?$/.test(labelCompact)) {
                label = 'Nomor :';
            } else if (/^no$/.test(labelCompact)) {
                label = 'No :';
            } else if (/^reg\.?no$/.test(labelCompact)) {
                label = 'Reg. No :';
            }

            if (!label) {
                return null;
            }

            const value = cleanText(valueParts.join(' '));

            if (!value) {
                return null;
            }

            return {
                label,
                value,
                fullText: `${label} ${value}`,
            };
        }

        /**
         * Menentukan kandidat nomor surat di area atas halaman pertama.
         */
        function findNumberLine(lines, viewport) {
            const candidates = lines
                .map(line => ({
                    line,
                    parts: extractNumberParts(line),
                }))
                .filter(candidate => candidate.parts)
                .filter(candidate => candidate.line.top > viewport.height * 0.045)
                .filter(candidate => candidate.line.top < viewport.height * 0.52)
                .map(candidate => {
                    const { line, parts } = candidate;
                    let score = 120;

                    const normalized = compactText(parts.fullText).toLowerCase();

                    if (/undang-?undang|perpres|permendagri|pasal/.test(normalized)) {
                        score -= 200;
                    }

                    // Nomor utama umumnya berada dekat bagian judul/kop.
                    score += Math.max(
                        0,
                        55 - (line.top / viewport.height) * 110
                    );

                    // Kandidat yang dekat pusat halaman lebih mungkin nomor surat utama.
                    const centerDelta = Math.abs(
                        ((line.xMin + line.xMax) / 2) - (viewport.width / 2)
                    ) / viewport.width;

                    if (centerDelta <= 0.18) {
                        score += 35;
                    }

                    return { line, parts, score };
                })
                .sort((a, b) =>
                    b.score - a.score || a.line.top - b.line.top
                );

            return candidates[0] ?? null;
        }

        /**
         * Menghapus seluruh baris nomor dari background.
         * Seluruh label dan nilai akan ditulis ulang di Word sebagai satu textbox.
         * Ini mencegah masking memotong huruf terakhir pada kata "Nomor".
         */
        function maskWholeNumberLine(context, candidate, textContent, viewport) {
            if (!candidate) {
                return null;
            }

            const { line, parts } = candidate;
            const horizontalPadding = Math.max(4, line.height * 0.22);
            const verticalPadding = Math.max(3, line.height * 0.18);

            const maskLeft = Math.max(0, line.xMin - horizontalPadding);
            const maskTop = Math.max(0, line.top - verticalPadding);
            const maskRight = Math.min(
                viewport.width,
                line.xMax + horizontalPadding
            );
            const maskBottom = Math.min(
                viewport.height,
                line.bottom + verticalPadding
            );

            context.save();
            context.fillStyle = '#ffffff';
            context.fillRect(
                maskLeft,
                maskTop,
                Math.max(1, maskRight - maskLeft),
                Math.max(1, maskBottom - maskTop)
            );
            context.restore();

            const dominantItem = line.items.reduce((selected, item) =>
                item.height > selected.height ? item : selected
            , line.items[0]);

            const sourceStyle = textContent.styles?.[dominantItem.fontName] ?? {};
            const fontFamily = normalizeFontFamily(sourceStyle.fontFamily);
            const fontSizePt = Math.max(
                7,
                dominantItem.height / viewport.scale
            );

            const centerDelta = Math.abs(
                ((line.xMin + line.xMax) / 2) - (viewport.width / 2)
            ) / viewport.width;

            const isCentered = centerDelta <= 0.18;

            let xRatio;
            let widthRatio;
            let alignment;

            if (isCentered) {
                // Gunakan area halaman yang lebar dan alignment center.
                // Posisi horizontal tidak lagi bergantung pada lebar teks hasil ekstraksi.
                xRatio = 0.05;
                widthRatio = 0.90;
                alignment = 'center';
            } else {
                xRatio = Math.max(0, line.xMin / viewport.width);
                widthRatio = Math.min(
                    1 - xRatio,
                    Math.max(
                        0.22,
                        ((line.xMax - line.xMin) + line.height * 3) / viewport.width
                    )
                );
                alignment = 'left';
            }

            return {
                text: parts.fullText,
                label: parts.label,
                value: parts.value,
                xRatio,
                yRatio: Math.max(0, line.top / viewport.height),
                baselineRatio: Math.max(0, line.baselineY / viewport.height),
                widthRatio,
                heightRatio: Math.max(
                    0.018,
                    (line.height * 1.65) / viewport.height
                ),
                fontSizePt,
                lineHeightPt: Math.max(fontSizePt, fontSizePt * 1.05),
                fontFamily,
                alignment,
                bold: false,
                verticalCorrectionPt: -0.8,
                detection: {
                    rawText: line.rawText,
                    spacedText: line.spacedText,
                    maskLeftRatio: maskLeft / viewport.width,
                    maskTopRatio: maskTop / viewport.height,
                    maskWidthRatio: (maskRight - maskLeft) / viewport.width,
                    maskHeightRatio: (maskBottom - maskTop) / viewport.height,
                },
            };
        }

        function canvasToBlob(canvas) {
            return new Promise((resolve, reject) => {
                canvas.toBlob(
                    blob => blob
                        ? resolve(blob)
                        : reject(new Error('Gagal membuat gambar halaman.')),
                    'image/jpeg',
                    0.97
                );
            });
        }

        function filenameFromResponse(response) {
            const disposition = response.headers.get('Content-Disposition') || '';
            const utfMatch = disposition.match(/filename\*=UTF-8''([^;]+)/i);

            if (utfMatch) {
                return decodeURIComponent(utfMatch[1]);
            }

            const normalMatch = disposition.match(/filename="?([^";]+)"?/i);
            return normalMatch?.[1] || 'surat.docx';
        }

        async function startExport() {
            retryButton.disabled = true;
            actions.style.display = 'none';
            spinner.style.display = 'block';
            progressBar.style.background = '#2563eb';
            statusElement.classList.remove('error');
            title.textContent = 'Menyiapkan dokumen Word';
            description.textContent =
                'Tampilan surat akan dipertahankan seperti PDF. Baris nomor surat tetap dapat diedit.';

            try {
                setProgress(8, 'Memuat PDF sumber...');

                const loadingTask = pdfjsLib.getDocument({
                    url: sourceUrl,
                    withCredentials: true,
                });

                const pdf = await loadingTask.promise;
                const renderedPages = [];
                const pageMetadata = [];
                let numberMetadata = null;

                for (let pageIndex = 0; pageIndex < pdf.numPages; pageIndex++) {
                    const pageNumber = pageIndex + 1;

                    setProgress(
                        12 + Math.round((pageIndex / pdf.numPages) * 55),
                        `Memproses halaman ${pageNumber} dari ${pdf.numPages}...`
                    );

                    const page = await pdf.getPage(pageNumber);
                    const scale = 2.25;
                    const viewport = page.getViewport({ scale });

                    const canvas = document.createElement('canvas');
                    canvas.width = Math.ceil(viewport.width);
                    canvas.height = Math.ceil(viewport.height);

                    const context = canvas.getContext('2d', { alpha: false });
                    context.fillStyle = '#ffffff';
                    context.fillRect(0, 0, canvas.width, canvas.height);

                    await page.render({
                        canvasContext: context,
                        viewport,
                        background: '#ffffff',
                    }).promise;

                    if (pageIndex === 0) {
                        const textContent = await page.getTextContent({
                            normalizeWhitespace: false,
                            disableCombineTextItems: false,
                        });
                        const lines = buildTextLines(textContent, viewport);
                        const numberCandidate = findNumberLine(lines, viewport);
                        const detected = maskWholeNumberLine(
                            context,
                            numberCandidate,
                            textContent,
                            viewport
                        );

                        if (detected) {
                            numberMetadata = {
                                pageIndex,
                                ...detected,
                            };
                        }
                    }

                    renderedPages.push(await canvasToBlob(canvas));
                    pageMetadata.push({
                        width: canvas.width,
                        height: canvas.height,
                        widthPt: viewport.width / scale,
                        heightPt: viewport.height / scale,
                        scale,
                    });
                }

                setProgress(72, 'Menyusun file DOCX...');

                const formData = new FormData();

                renderedPages.forEach((blob, index) => {
                    formData.append(
                        `pages[${index}]`,
                        blob,
                        `page_${index + 1}.jpg`
                    );
                });

                formData.append('metadata', JSON.stringify({
                    version: 2,
                    pages: pageMetadata,
                    number: numberMetadata,
                }));

                const response = await fetch(buildUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/json',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    let message = `Gagal membuat DOCX (${response.status}).`;
                    const contentType = response.headers.get('content-type') || '';

                    if (contentType.includes('application/json')) {
                        const json = await response.json();
                        message = json.message || message;
                    } else {
                        const text = await response.text();

                        if (text.trim()) {
                            message = text.slice(0, 500);
                        }
                    }

                    throw new Error(message);
                }

                const blob = await response.blob();
                const filename = filenameFromResponse(response);
                const objectUrl = URL.createObjectURL(blob);
                const link = document.createElement('a');

                link.href = objectUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                link.remove();

                setTimeout(() => URL.revokeObjectURL(objectUrl), 2000);

                setProgress(
                    100,
                    numberMetadata
                        ? 'DOCX selesai. Baris nomor surat dapat diedit.'
                        : 'DOCX selesai. Nomor surat tidak ditemukan pada halaman pertama.'
                );

                spinner.style.display = 'none';
                title.textContent = 'Dokumen berhasil dibuat';
                description.textContent = numberMetadata
                    ? 'Baris nomor ditulis ulang sebagai teks Word agar tidak terpotong dan lebih presisi.'
                    : 'Tampilan surat dipertahankan. Template ini tidak memiliki nomor surat yang terdeteksi.';
                actions.style.display = 'flex';
                retryButton.disabled = false;
            } catch (error) {
                console.error(error);
                spinner.style.display = 'none';
                progressBar.style.width = '100%';
                progressBar.style.background = '#dc2626';
                title.textContent = 'Export DOCX gagal';
                description.textContent =
                    'Periksa koneksi, PDF sumber, dan pemasangan PHPWord.';
                statusElement.textContent = error.message || 'Terjadi kesalahan.';
                statusElement.classList.add('error');
                actions.style.display = 'flex';
                retryButton.disabled = false;
            }
        }

        retryButton.addEventListener('click', startExport);
        startExport();
    })();
</script>
</body>
</html>
