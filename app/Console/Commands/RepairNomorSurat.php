<?php

namespace App\Console\Commands;

use App\Services\NomorSuratService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RepairNomorSurat extends Command
{
    protected $signature = 'surat:perbaiki-nomor
                            {--tahun= : Batasi satu tahun, contoh 2026}
                            {--renumber : Nomori ulang semua surat diterima + terverifikasi}
                            {--commit : Simpan perubahan. Tanpa opsi ini hanya simulasi}';

    protected $description = 'Sinkronkan counter dan perbaiki nomor surat per kode jenis dan tahun';

    public function handle(NomorSuratService $service): int
    {
        $tahunFilter = $this->option('tahun') !== null
            ? (int) $this->option('tahun')
            : null;
        $renumber = (bool) $this->option('renumber');
        $commit = (bool) $this->option('commit');

        if ($tahunFilter !== null && ($tahunFilter < 2000 || $tahunFilter > 2100)) {
            $this->error('Nilai --tahun tidak valid.');
            return self::FAILURE;
        }

        $groups = [];
        $unknownCodes = [];

        foreach ($service->allModelMappings() as $modelClass => $jenis) {
            if (!class_exists($modelClass)) {
                continue;
            }

            foreach ($modelClass::all() as $record) {
                if (!$service->isAcceptedAndVerified($record)) {
                    continue;
                }

                $year = $this->resolveYear($record, $tahunFilter);
                if ($tahunFilter !== null && $year !== $tahunFilter) {
                    continue;
                }

                $prefix = $service->prefix($jenis, $record);
                if ($prefix === null) {
                    $unknownCodes[] = [
                        'model' => $modelClass,
                        'id' => (string) $record->getKey(),
                        'jenis' => $jenis,
                    ];
                    continue;
                }

                $key = $prefix . '|' . $year;
                $groups[$key]['prefix'] = $prefix;
                $groups[$key]['year'] = $year;
                $groups[$key]['items'][] = [
                    'record' => $record,
                    'jenis' => $jenis,
                    'sort_at' => $this->sortTimestamp($record),
                ];
            }
        }

        ksort($groups);
        $changed = 0;
        $invalidExisting = 0;

        foreach ($groups as $group) {
            usort($group['items'], static function (array $a, array $b): int {
                $timeCompare = $a['sort_at'] <=> $b['sort_at'];
                if ($timeCompare !== 0) {
                    return $timeCompare;
                }

                return strcmp(
                    (string) $a['record']->getKey(),
                    (string) $b['record']->getKey()
                );
            });

            $prefix = $group['prefix'];
            $year = $group['year'];
            $max = 0;

            if (!$renumber) {
                foreach ($group['items'] as $item) {
                    $parsed = $service->parseOfficialNumber(
                        $item['record']->getAttribute('nomor_surat')
                    );

                    if ($parsed !== null
                        && $parsed['prefix'] === $prefix
                        && $parsed['tahun'] === $year) {
                        $max = max($max, $parsed['urut']);
                    }
                }
            }

            foreach ($group['items'] as $item) {
                /** @var Model $record */
                $record = $item['record'];
                $current = trim((string) $record->getAttribute('nomor_surat'));
                $parsed = $service->parseOfficialNumber($current);

                if (!$renumber && $current !== '' && $parsed === null) {
                    $invalidExisting++;
                    $this->warn(
                        "Lewati nomor lama tidak sesuai: {$current} ({$prefix}, ID {$record->getKey()}). " .
                        'Gunakan --renumber untuk menggantinya.'
                    );
                    continue;
                }

                if (!$renumber && $parsed !== null) {
                    continue;
                }

                $max++;
                $newNumber = $service->format(
                    $item['jenis'],
                    $max,
                    $year,
                    $record
                );

                $this->line(
                    sprintf(
                        '%s | %s | %s -> %s',
                        $prefix,
                        get_class($record),
                        $record->getKey(),
                        $newNumber
                    )
                );

                if ($commit) {
                    $record->setAttribute('kode_jenis_surat', $prefix);
                    $record->setAttribute('nomor_urut', $max);
                    $record->setAttribute('tahun_nomor', $year);
                    $record->setAttribute('nomor_surat', $newNumber);
                    $record->setAttribute(
                        'nomor_ditetapkan_at',
                        $record->getAttribute('nomor_ditetapkan_at')
                            ?: now(NomorSuratService::TIMEZONE)
                    );

                    Model::withoutEvents(static function () use ($record): void {
                        $record->save();
                    });
                }

                $changed++;
            }

            if ($commit) {
                $service->setCounter($prefix, $year, $max);
            }

            $this->info("Counter {$prefix}/{$year}: {$max}");
        }

        foreach ($unknownCodes as $item) {
            $this->warn(
                "Kode jenis belum diisi: {$item['jenis']} | {$item['model']} | ID {$item['id']}"
            );
        }

        $mode = $commit ? 'DISIMPAN' : 'SIMULASI';
        $this->newLine();
        $this->info("Mode {$mode}. Perubahan: {$changed} record.");
        $this->line("Nomor lama tidak sesuai yang dilewati: {$invalidExisting}.");
        $this->line('Record tanpa kode jenis: ' . count($unknownCodes) . '.');

        if (!$commit) {
            $this->comment('Jalankan kembali dengan --commit setelah hasil simulasi diperiksa.');
        }

        return self::SUCCESS;
    }

    private function resolveYear(Model $record, ?int $forcedYear): int
    {
        if ($forcedYear !== null) {
            return $forcedYear;
        }

        $stored = (int) $record->getAttribute('tahun_nomor');
        if ($stored >= 2000 && $stored <= 2100) {
            return $stored;
        }

        foreach ([
            'nomor_ditetapkan_at',
            'verified_at',
            'updated_at',
            'created_at',
        ] as $field) {
            $value = $record->getAttribute($field);
            if (!empty($value)) {
                try {
                    return Carbon::parse($value)
                        ->timezone(NomorSuratService::TIMEZONE)
                        ->year;
                } catch (\Throwable) {
                    // Lanjut ke sumber tanggal berikutnya.
                }
            }
        }

        return now(NomorSuratService::TIMEZONE)->year;
    }

    private function sortTimestamp(Model $record): int
    {
        foreach ([
            'nomor_ditetapkan_at',
            'verified_at',
            'updated_at',
            'created_at',
        ] as $field) {
            $value = $record->getAttribute($field);
            if (!empty($value)) {
                try {
                    return Carbon::parse($value)->timestamp;
                } catch (\Throwable) {
                    // Lanjut.
                }
            }
        }

        return PHP_INT_MAX;
    }
}
