<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class SuratKuasa extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_kuasa';

    protected $fillable = [
        // Pihak I (Pemberi Kuasa)
        'nama_pihak1',
        'jenis_kelamin_pihak1',
        'tempat_lahir_pihak1',
        'tanggal_lahir_pihak1',
        'agama_pihak1',
        'status_pihak1',
        'nik_pihak1',
        'pekerjaan_pihak1',
        'alamat_pihak1',

        // Pihak II (Penerima Kuasa)
        'nama_pihak2',
        'jenis_kelamin_pihak2',
        'tempat_lahir_pihak2',
        'tanggal_lahir_pihak2',
        'agama_pihak2',
        'status_pihak2',
        'nik_pihak2',
        'pekerjaan_pihak2',
        'alamat_pihak2',

        // Isi Kuasa
        'keterangan_kuasa',   // misal: pengambilan BPKB Motor...

        // Umum
        'nomor_surat',
        'status_surat',
        'status_verif',
        'nowa',
    ];
}
