<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class surat_keterangan_ahli_waris_desa extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'surat_keterangan_ahli_waris_desa';

    protected $fillable = [
        'nama_almarhum',
        'tanggal_meninggal',
        'hari_meninggal',
        'tempat_meninggal',
        'nomor_surat_kematian',
        'tanggal_surat_kematian',
        'ahli_waris',           // array of heirs
        'simpanan_nama',
        'simpanan_jenis',
        'simpanan_rekening',
        'status_surat',
        'status_verif',
        'nowa',
        'nomor_surat',          // untuk nomor surat otomatis
    ];
}
