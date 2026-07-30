@php
    $nomorService = app(\App\Services\NomorSuratService::class);
    $jenisNomor = $nomorService->normalizeJenis($jenis ?? '');
    $prefixMap = $nomorService->allPrefixes();
    $kodeHarusDiisi = array_key_exists($jenisNomor, $prefixMap)
        && $prefixMap[$jenisNomor] === null;
    $recordSurat = $surat ?? $data ?? null;
@endphp

@if($kodeHarusDiisi)
    <div class="mb-3">
        <label for="kode_jenis_surat" class="form-label">
            Kode Jenis Surat <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="kode_jenis_surat"
            id="kode_jenis_surat"
            class="form-control @error('kode_jenis_surat') is-invalid @enderror"
            value="{{ old('kode_jenis_surat', data_get($recordSurat, 'kode_jenis_surat')) }}"
            placeholder="Contoh: 472, 090, atau 522.21"
            pattern="\d{3}(\.\d+)*"
            maxlength="20"
            required
        >

        <small class="text-muted">
            Wajib diisi sebelum status menjadi Di terima dan Terverifikasi.
        </small>

        @error('kode_jenis_surat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@endif
