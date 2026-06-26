<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganDomisiliWarga extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_domisili_warga';

    protected $fillable = [
        'nik',                    // ← TAMBAHKAN INI
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status',
        'pekerjaan',
        'alamat_asal',
        'alamat_domisili',
        'keterangan_tambahan',
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
