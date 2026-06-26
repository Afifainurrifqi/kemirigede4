<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_permohonan_pengantar_keabsahan_akta_kelahiran extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_permohonan_pengantar_keabsahan_akta_kelahiran';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'ttl_tempat',
        'ttl_tanggal',
        'alamat',
        'nowa',
        'status_surat',
        'status_verif',
        'nomor_surat',
        'nomor_urut',
        'tahun_nomor',
    ];

    protected $casts = [
        'ttl_tanggal' => 'date',
    ];
}
