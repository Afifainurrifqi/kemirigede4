<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganDesaSebagaiPenduduk extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_desa_sebagai_penduduk';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'pekerjaan',
        'status',
        'alamat',
        'keterangan_tambahan',   // contoh: "istrinya bernama ... sedang bekerja di Hongkong"
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'tanggal_lahir' => 'datetime',
    ];
}
