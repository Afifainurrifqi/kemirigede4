<?php

namespace App\Observers;

use App\Services\NomorSuratService;
use Illuminate\Database\Eloquent\Model;

class NomorSuratObserver
{
    private NomorSuratService $nomorSuratService;

    public function __construct(NomorSuratService $nomorSuratService)
    {
        $this->nomorSuratService = $nomorSuratService;
    }

    /**
     * Nomor ditetapkan tepat sebelum record disimpan saat kedua status telah
     * memenuhi syarat. Nomor yang sudah pernah ditetapkan tidak diubah lagi.
     */
    public function saving(Model $model): void
    {
        $this->nomorSuratService->assignToModelIfEligible($model);
    }
}
