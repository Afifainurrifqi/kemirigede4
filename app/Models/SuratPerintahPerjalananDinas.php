<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratPerintahPerjalananDinas extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_perintah_perjalanan_dinas';

    protected $fillable = [
        'nomor_sppd',
        'tanggal_surat',

        // Pejabat yang memberi perintah
        'pejabat_pemberi_perintah',

        // Pegawai yang diperintah
        'nama_pegawai',
        'pangkat_golongan',
        'jabatan',
        'instansi',

        // Detail Perjalanan
        'maksud_perjalanan',
        'alat_angkutan',
        'tempat_berangkat',
        'tempat_tujuan',
        'lama_perjalanan',
        'tanggal_berangkat',
        'tanggal_kembali',

        // Anggaran
        'instansi_anggaran',
        'sumber_anggaran',

        // Umum
        'status_surat',
        'status_verif',
        'nowa',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_kembali'   => 'date',
        'tanggal_surat'     => 'date',
    ];
}
