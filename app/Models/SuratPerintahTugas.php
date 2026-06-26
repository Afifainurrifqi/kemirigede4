<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPerintahTugas extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_perintah_tugas';

    protected $fillable = [
        // Penerima Tugas
        'nama_penerima',
        'jabatan_penerima',
        'nik_penerima',

        // Kegiatan
        'untuk_mengikuti',
        'hari',
        'tanggal_kegiatan',
        'waktu_mulai',
        'tempat_kegiatan',
        'keterangan_tugas',

        // Dasar (bisa multiple)
        'dasar',

        // Umum
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'dasar' => 'array',
        'tanggal_kegiatan' => 'date',
    ];
}
