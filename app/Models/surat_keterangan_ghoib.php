<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_keterangan_ghoib extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_ghoib';

    protected $fillable = [
        'nik',
        'nama_pemohon',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'kewarganegaraan',
        'agama',
        'status',
        'pekerjaan',
        'alamat',
        'nama_suami_istri',
        'tanggal_hilang',
        'tanggal_pernyataan',
        'keperluan',
        'keterangan_tambahan',
        'status_surat',
        'status_verif',
        'nowa',
        'nomor_surat',
    ];

    // Tambahkan ini supaya tidak dianggap SQL
    public $timestamps = false; // kalau tidak pakai created_at / updated_at
}
