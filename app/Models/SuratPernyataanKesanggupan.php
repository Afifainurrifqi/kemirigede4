<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPernyataanKesanggupan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_kesanggupan';

    protected $fillable = [
        'nama',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kegiatan',
        'hari',
        'tanggal_kegiatan',
        'waktu',
        'tempat_kegiatan',
        'keterangan_tambahan',
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
