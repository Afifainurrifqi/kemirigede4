<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPernyataanKepemilikanDokumenAsli extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_pernyataan_kepemilikan_dokumen_asli';

    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'no_hp',
        'alamat',
        'nama_dokumen',
        'nomor_dokumen',
        'nama_pemilik_dokumen',
        'tanggal_lahir_pemilik',
        'alamat_dokumen',
        'keterangan_tambahan',
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
