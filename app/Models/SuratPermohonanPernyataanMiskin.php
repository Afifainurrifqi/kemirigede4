<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class SuratPermohonanPernyataanMiskin extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_permohonan_pernyataan_miskin';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'alamat',
        'no_hp',
        'nowa',
        'nama_pasien',
        'alamat_pasien',
        'diagnosa',
        'rumah_sakit_tujuan',
        'status_surat',
        'status_verif',
        'nomor_surat',
        'tanggal_surat'
    ];

    protected $dates = ['tanggal_surat', 'created_at', 'updated_at'];
}
