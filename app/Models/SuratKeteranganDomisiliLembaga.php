<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKeteranganDomisiliLembaga extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_domisili_lembaga';

    protected $fillable = [
        // Data Lembaga
        'nama_lembaga',
        'jenis_kegiatan',
        'alamat_lembaga',

        // Data Pengurus (Ketua)
        'nama_pengurus',
        'nik_pengurus',
        'alamat_pengurus',

        // Data Umum
        'nomor_surat',
        'keterangan_tambahan',   // untuk keperluan
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
