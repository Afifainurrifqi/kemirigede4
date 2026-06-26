<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class SuratPermohonanTebangPohon extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_permohonan_tebang_pohon';

    protected $fillable = [
        'nik',
        'nama',
        'jabatan',
        'alamat',
        'no_hp',
        'nowa',
        'alasan_tebang',
        'status_surat',
        'status_verif',
        'nomor_surat',
        'tanggal_surat'
    ];

    protected $dates = ['tanggal_surat', 'created_at', 'updated_at'];
}
