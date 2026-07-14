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
        Tampilan surat akan dipertahankan seperti PDF. Hanya nilai nomor surat yang dapat diedit.
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
                .replace(/\s+/g, ' ')
                .trim();
        }

        /**
         * Kelompokkan item teks PDF berdasarkan posisi baseline.
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

                let line = lines.find(existing =>
                    Math.abs(existing.baselineY - baselineY) <= Math.max(3, fontHeight * 0.22)
                );

                if (!line) {
                    line = {
                        baselineY,
                        top: baselineY - fontHeight,
                        height: fontHeight,
                        items: [],
                    };
                    lines.push(line);
                }

                line.top = Math.min(line.top, baselineY - fontHeight);
                line.height = Math.max(line.height, fontHeight);
                line.items.push({
                    raw: String(item.str),
                    text: cleanText(item.str),
                    x,
                    width,
                    top: baselineY - fontHeight,
                    height: fontHeight,
                    fontName: item.fontName,
                });
            }

            return lines.map(line => {
                line.items.sort((a, b) => a.x - b.x);
                line.text = cleanText(line.items.map(item => item.text).join(' '));
                line.xMin = Math.min(...line.items.map(item => item.x));
                line.xMax = Math.max(...line.items.map(item => item.x + item.width));
                return line;
            });
        }

        /**
         * Cari baris nomor surat pada bagian atas halaman pertama.
         */
        function findNumberLine(lines, viewport) {
            const strictPattern = /^\s*(nomor(?:\s+surat)?|no\.?|reg\.?\s*no)\s*:/i;
            const loosePattern = /\b(nomor(?:\s+surat)?|reg\.?\s*no|no\.?)\s*:/i;

            const candidates = lines
                .filter(line => line.top > viewport.height * 0.06)
                .filter(line => line.top < viewport.height * 0.48)
                .map(line => {
                    let score = 0;

                    if (strictPattern.test(line.text)) score += 100;
                    else if (loosePattern.test(line.text)) score += 35;

                    if (/undang-undang|perpres|permendagri|pasal/i.test(line.text)) {
                        score -= 120;
                    }

                    // Surat umumnya menempatkan nomor tepat setelah judul/kop.
                    score += Math.max(0, 40 - (line.top / viewport.height) * 100);

                    return { line, score };
                })
                .filter(candidate => candidate.score > 20)
                .sort((a, b) => b.score - a.score || a.line.top - b.line.top);

            return candidates[0]?.line ?? null;
        }

        /**
         * Sisakan label "Nomor:" pada background, lalu hapus hanya nilainya.
         */
        function maskNumberValue(context, line, textContent, viewport) {
            if (!line) return null;

            const fullText = cleanText(line.text);
            const colonIndex = fullText.indexOf(':');

            if (colonIndex < 0) return null;

            const editableText = cleanText(fullText.slice(colonIndex + 1));
            if (editableText === '') return null;

            let colonFound = false;
            let editableX = null;
            let selectedFontName = null;
            let selectedFontHeight = line.height;

            context.save();
            context.fillStyle = '#ffffff';

            for (const item of line.items) {
                const raw = item.raw;
                const itemColonIndex = raw.indexOf(':');

                if (!colonFound && itemColonIndex >= 0) {
                    colonFound = true;

                    const fraction = raw.length > 0
                        ? (itemColonIndex + 1) / raw.length
                        : 1;

                    const startX = item.x + item.width * fraction;
                    editableX = startX + 2;
                    selectedFontName = item.fontName;
                    selectedFontHeight = item.height;

                    const remainingWidth = Math.max(
                        0,
                        (item.x + item.width) - startX
                    );

                    if (remainingWidth > 1) {
                        context.fillRect(
                            startX - 1,
                            item.top - 2,
                            remainingWidth + 4,
                            item.height + 5
                        );
                    }

                    continue;
                }

                if (colonFound) {
                    if (editableX === null) editableX = item.x;
                    if (selectedFontName === null) selectedFontName = item.fontName;
                    selectedFontHeight = Math.max(selectedFontHeight, item.height);

                    context.fillRect(
                        item.x - 2,
                        item.top - 2,
                        item.width + 5,
                        item.height + 5
                    );
                }
            }

            context.restore();

            if (!colonFound || editableX === null) return null;

            const fontFamily =
                textContent.styles?.[selectedFontName]?.fontFamily
                || 'Times New Roman';

            return {
                text: editableText,
                xRatio: editableX / viewport.width,
                yRatio: line.top / viewport.height,
                fontSizePt: Math.max(7, selectedFontHeight / viewport.scale),
                fontFamily,
            };
        }

        function canvasToBlob(canvas) {
            return new Promise((resolve, reject) => {
                canvas.toBlob(
                    blob => blob ? resolve(blob) : reject(new Error('Gagal membuat gambar halaman.')),
                    'image/jpeg',
                    0.96
                );
            });
        }

        function filenameFromResponse(response) {
            const disposition = response.headers.get('Content-Disposition') || '';
            const utfMatch = disposition.match(/filename\*=UTF-8''([^;]+)/i);
            if (utfMatch) return decodeURIComponent(utfMatch[1]);

            const normalMatch = disposition.match(/filename="?([^";]+)"?/i);
            return normalMatch?.[1] || 'surat.docx';
        }

        async function startExport() {
            retryButton.disabled = true;
            actions.style.display = 'none';
            spinner.style.display = 'block';
            title.textContent = 'Menyiapkan dokumen Word';
            description.textContent =
                'Tampilan surat akan dipertahankan seperti PDF. Hanya nilai nomor surat yang dapat diedit.';

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
                    const scale = 2.0;
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
                        const textContent = await page.getTextContent();
                        const lines = buildTextLines(textContent, viewport);
                        const numberLine = findNumberLine(lines, viewport);
                        const detected = maskNumberValue(
                            context,
                            numberLine,
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
                        if (text.trim()) message = text.slice(0, 500);
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
                URL.revokeObjectURL(objectUrl);

                setProgress(100, numberMetadata
                    ? 'DOCX selesai. Nomor surat dapat diedit.'
                    : 'DOCX selesai. Nomor surat tidak ditemukan pada halaman pertama.'
                );

                spinner.style.display = 'none';
                title.textContent = 'Dokumen berhasil dibuat';
                description.textContent = numberMetadata
                    ? 'Tampilan surat dipertahankan sebagai background dan nilai nomor surat tetap editable.'
                    : 'Tampilan surat dipertahankan. Template ini tidak memiliki nomor surat yang terdeteksi.';
                actions.style.display = 'flex';
                retryButton.disabled = false;
            } catch (error) {
                console.error(error);
                spinner.style.display = 'none';
                progressBar.style.width = '100%';
                progressBar.style.background = '#dc2626';
                title.textContent = 'Export DOCX gagal';
                description.textContent = 'Periksa koneksi internet dan pastikan PHPWord sudah terpasang.';
                statusElement.textContent = error.message || 'Terjadi kesalahan.';
                statusElement.classList.add('error');
                actions.style.display = 'flex';
                retryButton.disabled = false;
            }
        }

        retryButton.addEventListener('click', () => {
            progressBar.style.background = '#2563eb';
            statusElement.classList.remove('error');
            startExport();
        });

        startExport();
    })();
</script>
</body>
</html>
