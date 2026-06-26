<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class surat_pernyataan_batal_pindah_penduduk extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_batal_pindah_penduduk';

    protected $fillable = [
        'nama',
        'ttl_tempat',
        'ttl_tanggal',
        'alamat',
        'nik',
        'agama',
        'status',
        'ke_alamat',
        'alasan_batal',
        'alamat_asal',
        'nowa',
        'nomor_surat',
        'nomor_urut',
        'tahun_nomor',
        'status_surat',
        'status_verif',
    ];

    protected $casts = [
        'ttl_tanggal' => 'date',
    ];
}
