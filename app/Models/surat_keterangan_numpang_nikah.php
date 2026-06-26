<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_keterangan_numpang_nikah extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_numpang_nikah';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pekerjaan',
        'status_perkawinan',
        'alamat',

        'keperluan',
        'alamat_tujuan',
        'mulai_berangkat',
        'pembawaan',

        'jumlah_pengikut',
        'nama_pengikut',
        'umur_pengikut',
        'jenis_kelamin_pengikut',
        'hubungan_keluarga_pengikut',
        'keterangan_pengikut',

        'status_surat',
        'status_verif',
        'nowa',

        'nomor_surat',
        'nomor_urut',
        'tahun_nomor',
    ];

    protected $casts = [
        'tanggal_lahir' => 'datetime:Y-m-d',
        'mulai_berangkat' => 'datetime:Y-m-d',
        'jumlah_pengikut' => 'integer',
        'nama_pengikut' => 'array',
        'umur_pengikut' => 'array',
        'jenis_kelamin_pengikut' => 'array',
        'hubungan_keluarga_pengikut' => 'array',
        'keterangan_pengikut' => 'array',
        'nomor_urut' => 'integer',
        'tahun_nomor' => 'integer',
    ];
}
