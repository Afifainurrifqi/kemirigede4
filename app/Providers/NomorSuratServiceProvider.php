<?php

namespace App\Providers;

use App\Console\Commands\RepairNomorSurat;
use App\Observers\NomorSuratObserver;
use App\Services\NomorSuratService;
use Illuminate\Support\ServiceProvider;

class NomorSuratServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NomorSuratService::class);
    }

    public function boot(NomorSuratService $service): void
    {
        foreach (array_keys($service->allModelMappings()) as $modelClass) {
            if (class_exists($modelClass)) {
                $modelClass::observe(NomorSuratObserver::class);
            }
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                RepairNomorSurat::class,
            ]);
        }
    }
}
