<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_permohonan_pengantar_keabsahan_akta_kelahiran_anak';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'ttl_tempat',
        'ttl_tanggal',
        'alamat',
        'nama_anak',           // ← Field baru untuk nama anak
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
