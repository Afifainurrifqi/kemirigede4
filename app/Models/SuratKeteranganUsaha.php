<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganUsaha extends Eloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'surat_keterangan_usaha';

    protected $fillable = [
        'nama',
        'nama_usaha',
        'alamat',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kewarganegaraan',
        'keperluan',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
