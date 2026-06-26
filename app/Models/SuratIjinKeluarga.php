<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratIjinKeluarga extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_ijin_keluarga';

    protected $fillable = [
        // Suami
        'nama_suami',
        'tempat_lahir_suami',
        'tanggal_lahir_suami',
        'jenis_kelamin_suami',
        'pekerjaan_suami',
        'alamat_suami',

        // Istri
        'nama_istri',
        'tempat_lahir_istri',
        'tanggal_lahir_istri',
        'jenis_kelamin_istri',
        'pekerjaan_istri',
        'alamat_istri',
        'negara_tujuan',
        'sebagai',

        // Umum
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
