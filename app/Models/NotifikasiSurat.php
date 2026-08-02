<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as EloquentModel;

class NotifikasiSurat extends EloquentModel
{
    protected $connection = 'mongodb';

    protected $collection = 'notifikasi_surat';

    protected $fillable = [
        'surat_id',
        'model_type',
        'jenis_surat',
        'nama_pemohon',
        'target_url',
        'dibaca',
        'dibaca_at',
    ];

    protected $casts = [
        'dibaca'    => 'boolean',
        'dibaca_at' => 'datetime',
    ];
}
