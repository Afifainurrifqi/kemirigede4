<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratRekomendasiBbm extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_rekomendasi_bbm';

    protected $fillable = [
        'nik',
        'nama_lengkap',
        'no_hp',
        'alamat_usaha',
        'sektor_konsumen',
        'jenis_usaha_kegiatan',
        'jenis_alat',           // bisa array atau string (untuk tabel)
        'jumlah_alat',
        'fungsi_alat',
        'daya_alat',
        'kebutuhan_bbm',
        'jam_operasi',
        'konsumsi_bbm',
        'alokasi_pertalite',
        'tempat_pengambilan',
        'nomor_lembaga_penyalur',
        'lokasi_penyalur',
        'jangka_waktu',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
