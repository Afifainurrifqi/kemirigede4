<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class surat_pelaporan_capil extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pelaporan_capil';

    protected $fillable = [
        // A. Data Pelapor
        'nama_pelapor',
        'nik_pelapor',
        'nomor_kk_pelapor',
        'kewarganegaraan_pelapor',

        // Jenis Pelaporan (bisa multiple)
        'jenis_pelaporan', // array: ['kelahiran', 'kematian', dll]

        // Data Subjek (bisa berbeda tergantung jenis)
        'nama_subjek',
        'nik_subjek',
        'ttl_subjek',
        'alamat_subjek',

        // Data Saksi
        'nama_saksi1',
        'nik_saksi1',
        'nama_saksi2',
        'nik_saksi2',

        // Data Orang Tua (untuk kelahiran/kematian)
        'nama_ayah',
        'nik_ayah',
        'nama_ibu',
        'nik_ibu',

        // Data Anak (untuk kelahiran)
        'nama_anak',
        'jenis_kelamin_anak',
        'tempat_lahir_anak',
        'tanggal_lahir_anak',

        // Umum
        'nomor_kk',
        'nowa',

        'status_surat',
        'status_verif',
    ];

    protected $casts = [
        'jenis_pelaporan' => 'array',
    ];
}
