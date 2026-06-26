<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_pernyataan_mengizinkan_ikut_kk extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_mengizinkan_ikut_kk';

    protected $fillable = [
        'nama',
        'nik',
        'ttl_tempat',
        'ttl_tanggal',
        'pekerjaan',
        'alamat',

        'nama_izin',
        'nik_izin',
        'ttl_tempat_izin',
        'ttl_tanggal_izin',
        'alamat_izin',

        'tujuan_pindah',
        'alasan_pindah',

        'nowa',
        'status_surat',
        'status_verif',
        'nomor_surat',
        'nomor_urut',
        'tahun_nomor',
    ];

    protected $casts = [
        'ttl_tanggal' => 'date',
        'ttl_tanggal_izin' => 'date',
    ];
}
