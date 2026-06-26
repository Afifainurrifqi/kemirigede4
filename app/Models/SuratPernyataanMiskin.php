<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPernyataanMiskin extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_miskin';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'pekerjaan',
        'alamat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
