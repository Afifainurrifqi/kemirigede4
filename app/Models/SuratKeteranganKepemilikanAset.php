<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganKepemilikanAset extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_kepemilikan_aset';

    protected $fillable = [
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'pekerjaan',
        'alamat',
        'pendapatan_bulanan',
        'pekarangan',
        'sawah',
        'perkebunan',
        'mobil',
        'sepeda_motor',
        'perhiasan_emas',
        'lainnya',
        'kepemilikan_rumah',
        'keterangan_tambahan',
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
