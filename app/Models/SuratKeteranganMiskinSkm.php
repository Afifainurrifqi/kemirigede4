<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganMiskinSkm extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_miskin_skm';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'pekerjaan',
        'alamat',
        'nowa',
        'status_surat',
        'status_verif',
    ];
}
