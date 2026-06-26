<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratUndangan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_undangan';

    protected $fillable = [
        // Data Undangan
        'kepada_yth',
        'perihal',
        'hari',
        'tanggal_acara',
        'jam',
        'tempat',
        'acara',
        'keterangan_tambahan',

        // Umum
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'tanggal_acara' => 'date',
    ];
}
