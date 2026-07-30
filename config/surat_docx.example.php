<?php

/*
|--------------------------------------------------------------------------
| Contoh konfigurasi export DOCX surat
|--------------------------------------------------------------------------
|
| Gabungkan properti number_* di bawah ini ke config/surat_docx.php milik
| aplikasi. Jangan mengganti daftar model/view yang sudah benar tanpa perlu.
|
*/

return [
    'documents' => [
        'suratketeranganusaha' => [
            'model' => \App\Models\SuratKeteranganUsaha::class,
            'view' => 'surat.pdf_surat_keterangan_usaha',
            'aliases' => ['surat-keterangan-usaha', 'surat_keterangan_usaha'],
            'filename_prefix' => 'surat_keterangan_usaha',
            'filename_fields' => ['nomor_surat', 'nama', 'id'],

            // Nomor selalu dibaca dari record yang sedang diekspor.
            'number_fields' => ['nomor_surat'],
            'number_required' => true,
            'allow_client_number_fallback' => false,

            // Nilai ini boleh menjadi fallback bila browser tidak mengirim box.
            'number_page_index' => 0,
            'number_style' => [
                'xRatio' => 0.25,
                'yRatio' => 0.20,
                'widthRatio' => 0.50,
                'heightRatio' => 0.03,
                'alignment' => 'center',
                'fontFamily' => 'Times New Roman',
                'fontSizePt' => 11,
                'verticalCorrectionPt' => -0.8,
            ],
        ],

        'suratperintahperjalanandinas' => [
            'model' => \App\Models\SuratPerintahPerjalananDinas::class,
            'view' => 'surat.pdf_surat_perintah_perjalanan_dinas',
            'aliases' => ['sppd', 'surat-perintah-perjalanan-dinas'],
            'filename_prefix' => 'sppd',
            'filename_fields' => ['nomor_sppd', 'nomor_surat', 'id'],

            // SPPD dapat memakai nama field yang berbeda.
            'number_fields' => ['nomor_sppd', 'nomor_surat'],
            'number_required' => true,
            'allow_client_number_fallback' => false,
            'number_page_index' => 0,
        ],

        'suratlamatanpafieldnomor' => [
            'model' => \App\Models\SuratLama::class,
            'view' => 'surat.pdf_surat_lama',
            'filename_prefix' => 'surat_lama',
            'filename_fields' => ['id'],

            /*
             * Template lama membentuk nomor langsung di Blade. Dalam kondisi
             * ini metadata dari PDF boleh menjadi fallback. Nilainya tetap
             * berbeda untuk setiap surat karena diambil dari hasil render saat
             * export, bukan hardcode dalam service.
             */
            'number_fields' => ['nomor_surat'],
            'number_required' => false,
            'allow_client_number_fallback' => true,
            'number_page_index' => 0,
        ],
    ],
];
