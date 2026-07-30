/**
 * Mengambil bounding box elemen nomor terhadap halaman/canvas PDF.
 * `text` dikirim sebagai fallback untuk template lama. Backend tetap mengganti
 * nilainya dengan nomor dari database apabila field server tersedia.
 */
export function buildNumberMetadata({
    pageIndex,
    numberElement,
    pageElement,
    text,
}) {
    if (!(numberElement instanceof Element)) {
        throw new TypeError('numberElement tidak valid.');
    }

    if (!(pageElement instanceof Element)) {
        throw new TypeError('pageElement tidak valid.');
    }

    const numberRect = numberElement.getBoundingClientRect();
    const pageRect = pageElement.getBoundingClientRect();
    const style = window.getComputedStyle(numberElement);
    const alignment = ['left', 'center', 'right'].includes(style.textAlign)
        ? style.textAlign
        : 'left';

    return {
        pageIndex,
        text: String(text ?? numberElement.textContent ?? '').trim(),
        box: {
            left: numberRect.left - pageRect.left,
            top: numberRect.top - pageRect.top,
            width: numberRect.width,
            height: numberRect.height,
            canvasWidth: pageRect.width,
            canvasHeight: pageRect.height,
        },
        alignment,
        fontFamily: style.fontFamily.replace(/["']/g, ''),
        fontSizePt: Number.parseFloat(style.fontSize) * 72 / 96,
        bold: Number.parseInt(style.fontWeight, 10) >= 600,
        italic: style.fontStyle === 'italic',
        horizontalCorrectionPt: 0,
        verticalCorrectionPt: -0.8,
    };
}

/**
 * Contoh pengiriman file hasil raster dan metadata ke endpoint Laravel.
 */
export async function sendDocxExport({
    endpoint,
    csrfToken,
    pageBlobs,
    pageSizes,
    numberMetadata,
}) {
    const formData = new FormData();

    pageBlobs.forEach((blob, index) => {
        formData.append('pages[]', blob, `page_${index + 1}.png`);
    });

    formData.append('metadata', JSON.stringify({
        pages: pageSizes,
        number: numberMetadata,
    }));

    const response = await fetch(endpoint, {
        method: 'POST',
        headers: {
            Accept: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData,
    });

    if (!response.ok) {
        const message = await response.text();
        throw new Error(message || 'Export DOCX gagal.');
    }

    return response.blob();
}
