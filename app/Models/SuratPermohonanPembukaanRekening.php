<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPermohonanPembukaanRekening extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_permohonan_pembukaan_rekening';

    protected $fillable = [
        // Data Pemohon / Kepala Desa
        'nama_kepala_desa',
        'jabatan',
        'alamat_kepala_desa',

        // Data Rekening
        'atas_nama_rekening',
        'alamat_rekening',

        // Pejabat Berwenang
        'nama_pejabat1',
        'jabatan1',
        'nama_pejabat2',
        'jabatan2',

        // Umum
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
