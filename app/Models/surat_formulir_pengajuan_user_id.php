<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class surat_formulir_pengajuan_user_id extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_formulir_pengajuan_user_id';

    protected $fillable = [
        'nomor_surat',
        'tanggal',
        'instansi_pemohon',      // Nama Desa / Lembaga
        'alamat_instansi',
        'nama_pemohon',          // Nama yang mengajukan
        'nik_pemohon',
        'jabatan_pemohon',
        'personil',              // Array JSON berisi daftar personil
        'nowa',
        'status_surat',
        'status_verif',
    ];

    protected $casts = [
        'personil' => 'array',   // MongoDB support array
        'tanggal'  => 'date',
    ];
}
