<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class surat_sptjm_suami_istri extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_sptjm_suami_istri';

    protected $fillable = [
        'nama_deklaran',
        'nik_deklaran',
        'ttl_deklaran',           // Tempat / Tanggal Lahir
        'pekerjaan_deklaran',
        'alamat_deklaran',

        'nama_pasangan',
        'nik_pasangan',
        'ttl_pasangan',
        'alamat_pasangan',

        'nomor_kk',
        'nowa',

        'status_surat',
        'status_verif',
    ];
}
