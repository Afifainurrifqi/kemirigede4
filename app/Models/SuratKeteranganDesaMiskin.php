<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganDesaMiskin extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_desa_miskin';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kewarganegaraan',
        'alamat',
        'keperluan',
        'nowa',
        'status_surat',
        'status_verif',
    ];
}
