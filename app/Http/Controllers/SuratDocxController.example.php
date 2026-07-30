<?php

namespace App\Http\Controllers;

use App\Services\SuratDocxService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SuratDocxController extends Controller
{
    public function __construct(
        private readonly SuratDocxService $docxService
    ) {
    }

    public function sourcePdf(string $jenis, string $id)
    {
        return $this->docxService->streamPdf($jenis, $id);
    }

    public function export(Request $request, string $jenis, string $id)
    {
        $validated = $request->validate([
            'pages' => ['required', 'array', 'min:1'],
            'pages.*' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:15360'],
            'metadata' => ['required'],
        ]);

        $metadata = $validated['metadata'];

        if (is_string($metadata)) {
            $metadata = json_decode($metadata, true);
        }

        if (! is_array($metadata)) {
            throw ValidationException::withMessages([
                'metadata' => 'Metadata export DOCX tidak valid.',
            ]);
        }

        return $this->docxService->buildDocx(
            $jenis,
            $id,
            $request->file('pages', []),
            $metadata
        );
    }
}
