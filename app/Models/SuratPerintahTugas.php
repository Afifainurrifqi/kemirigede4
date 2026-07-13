<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPerintahTugas extends Eloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'surat_perintah_tugas';

    protected $fillable = [
        // Dasar surat dapat ditambah sesuai kebutuhan
        'dasar',

        // Diperintahkan kepada, dapat lebih dari satu orang
        'penerima_tugas',

        // Uraian lengkap bagian "Untuk"
        'untuk',

        // Data umum aplikasi
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'dasar' => 'array',
        'penerima_tugas' => 'array',
    ];

    public $timestamps = true;
}
