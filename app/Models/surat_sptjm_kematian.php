<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_sptjm_kematian extends Eloquent
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'surat_sptjm_kematian';

    protected $fillable = [
        'nama',
        'nik',
        'ttl_tempat',
        'ttl_tanggal',
        'pekerjaan',
        'alamat',

        // Data Jenazah
        'nama_jenazah',
        'nik_jenazah',
        'ttl_tempat_jenazah',
        'ttl_tanggal_jenazah',
        'jenis_kelamin',
        'anak_ke',
        'nama_ayah_kandung',
        'nama_ibu_kandung',

        // Tambahan baru
        'tanggal_kematian',
        'surat_kematian_dari',

        // Saksi
        'nama_saksi_1',
        'nik_saksi_1',
        'nama_saksi_2',
        'nik_saksi_2',

        // Umum
        'nowa',
        'status_surat',
        'status_verif',
    ];

    protected $casts = [
        'ttl_tanggal'         => 'date',
        'ttl_tanggal_jenazah' => 'date',
        'tanggal_kematian'    => 'date',
        'anak_ke'             => 'integer',
    ];
}
