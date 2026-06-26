<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_pernyataan_perubahan_data_pendidikan extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_perubahan_data_pendidikan';

    protected $fillable = [
        'nama',
        'nik',
        'ttl_tempat',
        'ttl_tanggal',
        'pekerjaan',
        'alamat',

        // Data Subjek
        'nama_subjek',
        'nik_subjek',

        // Perubahan Pendidikan
        'pendidikan_lama',
        'pendidikan_baru',
        'alasan_perubahan',

        // Data Pendukung (Baru)
        'jenis_data_pendukung',      // Ijazah / Surat Keterangan Pengganti Ijazah
        'nomor_dokumen_pendukung',
        'tanggal_diterbitkan',
        'instansi_penerbit',

        // Umum
        'nowa',
        'status_surat',
        'status_verif',
        'nomor_surat',
        'nomor_urut',
        'tahun_nomor',
    ];

    protected $casts = [
        'ttl_tanggal'         => 'date',
        'tanggal_diterbitkan' => 'date',
    ];
}
