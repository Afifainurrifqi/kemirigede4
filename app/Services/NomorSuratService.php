<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use MongoDB\Operation\FindOneAndUpdate;

class NomorSuratService
{
    public const KLASIFIKASI = '409.47.5';
    public const TIMEZONE = 'Asia/Jakarta';

    /**
     * Kode jenis surat resmi.
     *
     * Nilai null berarti kode belum ditetapkan atau memang bergantung pada isi
     * surat. Untuk jenis tersebut, isi field `kode_jenis_surat` pada record
     * sebelum status diubah menjadi Diterima + Terverifikasi.
     */
    protected array $prefixMap = [
        'ktp_kematian'                  => '472',
        'numpang_kk'                    => '471',
        'nama_alias'                    => '470',
        'nama_alias_ortu'               => '470',
        'pernyataan_jaminan'            => null,
        'belum_akta'                    => '472',
        'beda_nama_buku_nikah'          => '472',
        'anak_seorang_ibu'              => '472',
        'akta_barcode'                  => null,
        'sptjm_kematian'                => '472',
        'perubahan_pendidikan'          => '471',
        'pembetulan_data'               => '471',
        'izin_ikut_kk'                  => '471',
        'keabsahan_diri'                => '471',
        'keabsahan_anak'                => '472',
        'batal_pindah'                  => '471',
        'kehilangan'                    => '470',
        'pernah_menikah'                => '472',
        'tidak_mampu'                   => '465',
        'kematian_desa'                 => '472',
        'waris'                         => '593',
        'harga_tanah'                   => '590',
        'numpang_nikah'                 => '472',
        'skck'                          => null,
        'kepemilikan_aset'              => null,
        'usaha'                         => '580',
        'desa_miskin'                   => '465',
        'skm'                           => '365',
        'ahli_waris_desa'               => '470',
        'ghoib'                         => null,
        'penghasilan'                   => null,
        'domisili_lembaga'              => '147',
        'domisili_warga'                => '470',
        'desa_penduduk'                 => '470',
        'kepemilikan_dokumen'           => '470',
        'kesanggupan'                   => null,
        'jkn'                           => '365',
        'pernyataan_miskin'             => '365',
        'izin_keluarga'                 => '470',
        'kuasa'                         => null,
        'pembukaan_rekening'            => null,
        'perintah_tugas'                => '140',
        'sppd'                          => '090',
        'undangan'                      => '005',
        'rekomendasi'                   => null,
        'nota_angkutan'                 => null,
        'rekomendasi_bbm'               => '510',
        'permohonan_pernyataan_miskin'  => '365',
        'tebang_pohon'                  => '522.21',
        'formulir_user_id'              => null,
        'sptjm_suami_istri'             => null,
    ];

    /**
     * Pemetaan model ke jenis surat. Menggunakan string agar provider tetap
     * aman walaupun sebagian model belum tersedia pada instalasi tertentu.
     */
    protected array $modelTypeMap = [
        'App\\Models\\surat_pernyataan_tidak_bisa_melampirkan_ktp_kematian' => 'ktp_kematian',
        'App\\Models\\surat_keterangan_kehilangan' => 'kehilangan',
        'App\\Models\\surat_pernyataan_numpang_kk' => 'numpang_kk',
        'App\\Models\\SuratPermohonanPernyataanMiskin' => 'permohonan_pernyataan_miskin',
        'App\\Models\\SuratKuasa' => 'kuasa',
        'App\\Models\\suratketerangantidakmampu' => 'tidak_mampu',
        'App\\Models\\SuratNotaAngkutan' => 'nota_angkutan',
        'App\\Models\\surat_pernyataan_memilih_nama_alias' => 'nama_alias',
        'App\\Models\\SuratPernyataanMiskin' => 'pernyataan_miskin',
        'App\\Models\\nama_alias_ortu' => 'nama_alias_ortu',
        'App\\Models\\surat_pernyataan_dan_jaminan' => 'pernyataan_jaminan',
        'App\\Models\\surat_keterangan_desa_pernah_menikah' => 'pernah_menikah',
        'App\\Models\\surat_keterangan_kematian_desa' => 'kematian_desa',
        'App\\Models\\surat_keterangan_ahli_waris' => 'waris',
        'App\\Models\\SuratPernyataanKesanggupan' => 'kesanggupan',
        'App\\Models\\surat_pernyataan_kesanggupan' => 'kesanggupan',
        'App\\Models\\SuratPermohonanPembukaanRekening' => 'pembukaan_rekening',
        'App\\Models\\surat_permohonan_pembukaan_rekening' => 'pembukaan_rekening',
        'App\\Models\\surat_pernyataan_belum_akta' => 'belum_akta',
        'App\\Models\\surat_pernyataan_beda_nama_buku_nikah' => 'beda_nama_buku_nikah',
        'App\\Models\\surat_pernyataan_anak_seorang_nama_ibu' => 'anak_seorang_ibu',
        'App\\Models\\surat_pernyataan_akta_barcode_nomor_sama' => 'akta_barcode',
        'App\\Models\\surat_sptjm_kematian' => 'sptjm_kematian',
        'App\\Models\\surat_keterangan_harga_kepemilikan_tanah' => 'harga_tanah',
        'App\\Models\\SuratPerintahTugas' => 'perintah_tugas',
        'App\\Models\\SuratPengantarSkck' => 'skck',
        'App\\Models\\surat_pernyataan_perubahan_data_pendidikan' => 'perubahan_pendidikan',
        'App\\Models\\surat_pernyataan_pembetulan_data_tidak_merubah_lagi' => 'pembetulan_data',
        'App\\Models\\surat_pernyataan_mengizinkan_ikut_kk' => 'izin_ikut_kk',
        'App\\Models\\surat_permohonan_pengantar_keabsahan_akta_kelahiran' => 'keabsahan_diri',
        'App\\Models\\surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak' => 'keabsahan_anak',
        'App\\Models\\surat_pernyataan_batal_pindah_penduduk' => 'batal_pindah',
        'App\\Models\\surat_formulir_pengajuan_user_id' => 'formulir_user_id',
        'App\\Models\\surat_sptjm_suami_istri' => 'sptjm_suami_istri',
        'App\\Models\\surat_keterangan_numpang_nikah' => 'numpang_nikah',
        'App\\Models\\SuratKeteranganUsaha' => 'usaha',
        'App\\Models\\SuratKeteranganDesaMiskin' => 'desa_miskin',
        'App\\Models\\SuratKeteranganMiskinSkm' => 'skm',
        'App\\Models\\surat_keterangan_ahli_waris_desa' => 'ahli_waris_desa',
        'App\\Models\\surat_keterangan_ghoib' => 'ghoib',
        'App\\Models\\surat_keterangan_penghasilan' => 'penghasilan',
        'App\\Models\\SuratKeteranganDesaSebagaiPenduduk' => 'desa_penduduk',
        'App\\Models\\SuratKeteranganDomisiliLembaga' => 'domisili_lembaga',
        'App\\Models\\SuratRekomendasiBbm' => 'rekomendasi_bbm',
        'App\\Models\\SuratKeteranganDomisiliWarga' => 'domisili_warga',
        'App\\Models\\SuratRekomendasi' => 'rekomendasi',
        'App\\Models\\SuratIjinKeluarga' => 'izin_keluarga',
        'App\\Models\\SuratKeteranganKepemilikanAset' => 'kepemilikan_aset',
        'App\\Models\\SuratUndangan' => 'undangan',
        'App\\Models\\SuratPerintahPerjalananDinas' => 'sppd',
        'App\\Models\\SuratPermohonanTebangPohon' => 'tebang_pohon',
        'App\\Models\\SuratPernyataanTidakPunyaKartuJkn' => 'jkn',
        'App\\Models\\SuratPernyataanKepemilikanDokumenAsli' => 'kepemilikan_dokumen',
    ];

    /**
     * Alias lama agar controller yang sudah memanggil service tidak perlu
     * langsung diubah seluruhnya.
     */
    protected array $typeAliases = [
        'sktm' => 'tidak_mampu',
        'spktp' => 'ktp_kematian',
        'numpangkk' => 'numpang_kk',
        'alias' => 'nama_alias',
        'alias_ortu' => 'nama_alias_ortu',
        'jaminan' => 'pernyataan_jaminan',
        'belumakta' => 'belum_akta',
        'bedanama' => 'beda_nama_buku_nikah',
        'anakseorangibu' => 'anak_seorang_ibu',
        'aktabarcode' => 'akta_barcode',
        'perubahdatapendidikan' => 'perubahan_pendidikan',
        'pembetulandata' => 'pembetulan_data',
        'izinkk' => 'izin_ikut_kk',
        'sptjmkematian' => 'sptjm_kematian',
        'batal_pindah_penduduk' => 'batal_pindah',
    ];

    public function allModelMappings(): array
    {
        return $this->modelTypeMap;
    }

    public function allPrefixes(): array
    {
        return $this->prefixMap;
    }

    public function jenisFromModel(object|string $model): ?string
    {
        $class = is_object($model) ? get_class($model) : ltrim($model, '\\');

        if (isset($this->modelTypeMap[$class])) {
            return $this->modelTypeMap[$class];
        }

        foreach ($this->modelTypeMap as $modelClass => $jenis) {
            if (is_object($model) && is_a($model, $modelClass)) {
                return $jenis;
            }
        }

        return null;
    }

    public function normalizeJenis(string $jenis): string
    {
        $key = Str::of($jenis)
            ->lower()
            ->ascii()
            ->replaceMatches('/[^a-z0-9]+/', '_')
            ->trim('_')
            ->toString();

        return $this->typeAliases[$key] ?? $key;
    }

    public function prefix(string $jenis, mixed $recordOrPayload = null): ?string
    {
        $jenis = $this->normalizeJenis($jenis);

        if (!array_key_exists($jenis, $this->prefixMap) && is_object($recordOrPayload)) {
            $jenis = $this->jenisFromModel($recordOrPayload) ?? $jenis;
        }

        $hasConfiguredType = array_key_exists($jenis, $this->prefixMap);
        $configuredPrefix = $hasConfiguredType
            ? $this->prefixMap[$jenis]
            : null;

        // Kode resmi yang sudah ditetapkan tidak boleh dioverride dari form.
        if ($configuredPrefix !== null) {
            return $configuredPrefix;
        }

        // Override hanya dipakai untuk jenis yang memang dinamis/belum diberi kode.
        $override = $this->extractPrefixOverride($recordOrPayload);
        if ($override !== null) {
            return $override;
        }

        return null;
    }

    public function isAcceptedAndVerified(mixed $recordOrPayload): bool
    {
        $status = $this->readValue($recordOrPayload, 'status_surat');
        $verif = $this->readValue($recordOrPayload, 'status_verif');

        return $this->normalizeStatus($status) === 'diterima'
            && $this->normalizeStatus($verif) === 'terverifikasi';
    }

    public function format(string $jenis, int $urut, ?int $tahun = null, mixed $recordOrPayload = null): string
    {
        $tahun ??= now(self::TIMEZONE)->year;
        $prefix = $this->prefix($jenis, $recordOrPayload) ?? '...';
        $nnn = str_pad((string) $urut, 3, '0', STR_PAD_LEFT);

        return "{$prefix}/{$nnn}/" . self::KLASIFIKASI . "/{$tahun}";
    }

    public function placeholder(string $jenis, ?int $tahun = null, mixed $recordOrPayload = null): string
    {
        $tahun ??= $this->yearFromRecord($recordOrPayload);
        $prefix = $this->prefix($jenis, $recordOrPayload) ?? '...';

        return "{$prefix}/.../" . self::KLASIFIKASI . "/{$tahun}";
    }

    /**
     * Digunakan oleh seluruh Blade PDF. Nomor permanen ditampilkan apabila
     * sudah tersimpan; selain itu tampil format bertitik.
     */
    public function display(mixed $record, string $jenis): string
    {
        $nomor = trim((string) $this->readValue($record, 'nomor_surat'));

        if ($nomor !== '') {
            return $nomor;
        }

        return $this->placeholder($jenis, null, $record);
    }

    /**
     * Kompatibel dengan controller lama yang membangun array payload.
     */
    public function maybeAssignNomorSurat($modelOrNull, array &$payload, string $jenis = 'default'): void
    {
        $jenis = $this->normalizeJenis($jenis);
        $merged = $this->mergeModelAndPayload($modelOrNull, $payload);

        if (!$this->isAcceptedAndVerified($merged)) {
            return;
        }

        $existingNumber = $payload['nomor_surat']
            ?? ($modelOrNull?->nomor_surat ?? null);

        if ($this->hasPermanentNumber($existingNumber)) {
            return;
        }

        $prefix = $this->prefix($jenis, $merged);
        if ($prefix === null) {
            Log::warning('Nomor surat tidak dibuat karena kode jenis belum ditetapkan.', [
                'jenis' => $jenis,
                'model' => is_object($modelOrNull) ? get_class($modelOrNull) : null,
                'id' => is_object($modelOrNull) && method_exists($modelOrNull, 'getKey')
                    ? (string) $modelOrNull->getKey()
                    : null,
            ]);
            return;
        }

        $tahun = now(self::TIMEZONE)->year;
        $urut = $this->nextForPrefix($prefix, $tahun);

        $payload['kode_jenis_surat'] = $prefix;
        $payload['nomor_urut'] = $urut;
        $payload['tahun_nomor'] = $tahun;
        $payload['nomor_surat'] = $this->format($jenis, $urut, $tahun, $merged);
        $payload['nomor_ditetapkan_at'] = now(self::TIMEZONE);
    }

    /**
     * Dipanggil observer saat model akan disimpan.
     */
    public function assignToModelIfEligible(Model $model, ?string $jenis = null): bool
    {
        $jenis ??= $this->jenisFromModel($model);

        if ($jenis === null || !$this->isAcceptedAndVerified($model)) {
            return false;
        }

        if ($this->hasPermanentNumber($model->getAttribute('nomor_surat'))) {
            return false;
        }

        $prefix = $this->prefix($jenis, $model);
        if ($prefix === null) {
            Log::warning('Status surat sudah diterima dan terverifikasi, tetapi kode jenis surat belum tersedia.', [
                'jenis' => $jenis,
                'model' => get_class($model),
                'id' => (string) $model->getKey(),
            ]);
            return false;
        }

        $tahun = now(self::TIMEZONE)->year;
        $urut = $this->nextForPrefix($prefix, $tahun);

        $model->setAttribute('kode_jenis_surat', $prefix);
        $model->setAttribute('nomor_urut', $urut);
        $model->setAttribute('tahun_nomor', $tahun);
        $model->setAttribute('nomor_surat', $this->format($jenis, $urut, $tahun, $model));
        $model->setAttribute('nomor_ditetapkan_at', now(self::TIMEZONE));

        return true;
    }

    /**
     * Counter atomik per KODE JENIS + TAHUN.
     * Semua jenis yang memakai kode 472 berbagi urutan 472 pada tahun yang sama.
     */
    public function nextForPrefix(string $prefix, int $tahun): int
    {
        $prefix = $this->validatePrefix($prefix);
        $collection = $this->counterCollection();
        $key = $this->counterKey($prefix, $tahun);

        $doc = $collection->findOneAndUpdate(
            ['_id' => $key],
            [
                '$inc' => ['seq' => 1],
                '$set' => [
                    'prefix' => $prefix,
                    'tahun' => $tahun,
                    'updated_at' => now(self::TIMEZONE),
                ],
                '$setOnInsert' => [
                    'created_at' => now(self::TIMEZONE),
                ],
            ],
            [
                'upsert' => true,
                'returnDocument' => FindOneAndUpdate::RETURN_DOCUMENT_AFTER,
            ]
        );

        return (int) ($doc['seq'] ?? 1);
    }

    public function setCounter(string $prefix, int $tahun, int $value): void
    {
        $prefix = $this->validatePrefix($prefix);

        $this->counterCollection()->updateOne(
            ['_id' => $this->counterKey($prefix, $tahun)],
            [
                '$set' => [
                    'seq' => max(0, $value),
                    'prefix' => $prefix,
                    'tahun' => $tahun,
                    'updated_at' => now(self::TIMEZONE),
                ],
                '$setOnInsert' => [
                    'created_at' => now(self::TIMEZONE),
                ],
            ],
            ['upsert' => true]
        );
    }

    public function parseOfficialNumber(?string $nomor): ?array
    {
        $nomor = trim((string) $nomor);
        $classification = preg_quote(self::KLASIFIKASI, '/');

        if (!preg_match('/^(?<prefix>\d{3}(?:\.\d+)*)\/(?<urut>\d{3})\/' . $classification . '\/(?<tahun>\d{4})$/', $nomor, $matches)) {
            return null;
        }

        return [
            'prefix' => $matches['prefix'],
            'urut' => (int) $matches['urut'],
            'tahun' => (int) $matches['tahun'],
        ];
    }

    private function hasPermanentNumber(mixed $value): bool
    {
        $number = trim((string) $value);

        if ($number === '') {
            return false;
        }

        return !str_contains($number, '...')
            && !str_contains($number, '---');
    }

    private function counterCollection(): mixed
    {
        return DB::connection('mongodb')
            ->getMongoDB()
            ->selectCollection('counters');
    }

    private function counterKey(string $prefix, int $tahun): string
    {
        return "surat_keluar:{$prefix}:{$tahun}";
    }

    private function normalizeStatus(mixed $value): string
    {
        return preg_replace(
            '/[^a-z0-9]+/',
            '',
            Str::lower(trim((string) $value))
        ) ?? '';
    }

    private function extractPrefixOverride(mixed $recordOrPayload): ?string
    {
        foreach (['kode_jenis_surat', 'kode_surat', 'nomor_jenis_surat'] as $field) {
            $value = trim((string) $this->readValue($recordOrPayload, $field));
            if ($value !== '') {
                return $this->validatePrefix($value);
            }
        }

        return null;
    }

    private function validatePrefix(string $prefix): string
    {
        $prefix = preg_replace('/\s+/', '', trim($prefix)) ?? '';

        if (!preg_match('/^\d{3}(?:\.\d+)*$/', $prefix)) {
            throw new \InvalidArgumentException(
                "Kode jenis surat '{$prefix}' tidak valid. Gunakan contoh 472, 090, atau 522.21."
            );
        }

        return $prefix;
    }

    private function readValue(mixed $source, string $key): mixed
    {
        if (is_array($source)) {
            return $source[$key] ?? null;
        }

        if (is_object($source)) {
            if (method_exists($source, 'getAttribute')) {
                return $source->getAttribute($key);
            }

            return $source->{$key} ?? null;
        }

        return null;
    }

    private function mergeModelAndPayload(mixed $model, array $payload): array
    {
        $result = [];

        foreach ([
            'status_surat',
            'status_verif',
            'kode_jenis_surat',
            'kode_surat',
            'nomor_jenis_surat',
            'nomor_surat',
            'tahun_nomor',
        ] as $field) {
            $result[$field] = $payload[$field]
                ?? $this->readValue($model, $field);
        }

        return $result;
    }

    private function yearFromRecord(mixed $record): int
    {
        $storedYear = (int) $this->readValue($record, 'tahun_nomor');
        if ($storedYear >= 2000 && $storedYear <= 2100) {
            return $storedYear;
        }

        return now(self::TIMEZONE)->year;
    }
}
