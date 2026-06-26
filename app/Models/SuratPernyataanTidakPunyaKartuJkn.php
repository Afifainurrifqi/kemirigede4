<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPernyataanTidakPunyaKartuJkn extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_tidak_punya_kartu_jkn';

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
