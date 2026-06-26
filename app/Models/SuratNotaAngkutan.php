<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratNotaAngkutan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_nota_angkutan';

    protected $fillable = [
        // Data Pengirim / Pemilik
        'nama_pengirim',
        'nik',
        'alamat_pengirim',
        'bukti_kepemilikan',
        'nomor_bukti_kepemilikan',

        // Data Angkutan
        'jenis_kayu',
        'jumlah',
        'volume',
        'alat_angkut',
        'tempat_muat',

        // Data Penerima / Tujuan
        'nama_penerima',
        'alamat_penerima',

        // Masa Berlaku
        'tanggal_mulai',
        'tanggal_selesai',

        // Umum
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
    ];
}
