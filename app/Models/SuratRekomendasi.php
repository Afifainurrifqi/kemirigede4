<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratRekomendasi extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_rekomendasi';

    protected $fillable = [
        // Data Pemohon
        'nama',
        'nik',
        'alamat',

        // Data Rekomendasi
        'perihal',
        'kegiatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu',
        'tempat',
        'keperluan',

        // Umum
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];
}
