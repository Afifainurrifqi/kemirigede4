<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_keterangan_penghasilan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_penghasilan';

    protected $fillable = [
        // Data Orang Tua / Wali
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'status',
        'pekerjaan',
        'alamat',
        'nominal_penghasilan',
        'keperluan',

        // Data Anak
        'nama_anak',
        'nik_anak',
        'jenis_kelamin_anak',
        'tempat_lahir_anak',
        'tanggal_lahir_anak',
        'sekolah_universitas',

        // Atribut Umum
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
