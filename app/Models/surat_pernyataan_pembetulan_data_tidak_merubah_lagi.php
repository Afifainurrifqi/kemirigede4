<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_pernyataan_pembetulan_data_tidak_merubah_lagi extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_pembetulan_data_tidak_merubah_lagi';

    protected $fillable = [
        'nama',
        'nik',
        'alamat',
        'uraian_pembetulan',           // Isi data yang diperbaiki
        'data_pendukung_1',
        'data_pendukung_2',
        'data_pendukung_3',
        'data_pendukung_4',
        'data_pendukung_5',
        'nowa',
        'status_surat',
        'status_verif',
        'nomor_surat',
        'nomor_urut',
        'tahun_nomor',
    ];

    protected $casts = [
        'ttl_tanggal' => 'date', // jika suatu saat ditambahkan
    ];
}
