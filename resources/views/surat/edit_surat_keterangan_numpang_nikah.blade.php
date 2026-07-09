@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')

@php

use Carbon\Carbon;


/* =========================
   DATA PENGIKUT
========================= */

$namaPengikut = old('nama_pengikut', $surat->nama_pengikut ?? []);
$umurPengikut = old('umur_pengikut', $surat->umur_pengikut ?? []);
$jenisKelaminPengikut = old('jenis_kelamin_pengikut', $surat->jenis_kelamin_pengikut ?? []);
$hubunganKeluargaPengikut = old('hubungan_keluarga_pengikut', $surat->hubungan_keluarga_pengikut ?? []);
$keteranganPengikut = old('keterangan_pengikut', $surat->keterangan_pengikut ?? []);


$jumlahPengikut = old(
    'jumlah_pengikut',
    $surat->jumlah_pengikut ?? count((array)$namaPengikut)
);



/* =========================
   FORMAT TANGGAL
========================= */

$tanggalLahirValue = '';

if(old('tanggal_lahir')){
    $tanggalLahirValue = old('tanggal_lahir');
}
elseif(!empty($surat->tanggal_lahir)){

    if($surat->tanggal_lahir instanceof MongoDB\BSON\UTCDateTime){

        $tanggalLahirValue =
        Carbon::instance($surat->tanggal_lahir->toDateTime())
        ->format('Y-m-d');

    }else{

        $tanggalLahirValue =
        Carbon::parse($surat->tanggal_lahir)
        ->format('Y-m-d');

    }
}



$mulaiBerangkatValue = '';

if(old('mulai_berangkat')){
    $mulaiBerangkatValue = old('mulai_berangkat');
}
elseif(!empty($surat->mulai_berangkat)){

    if($surat->mulai_berangkat instanceof MongoDB\BSON\UTCDateTime){

        $mulaiBerangkatValue =
        Carbon::instance($surat->mulai_berangkat->toDateTime())
        ->format('Y-m-d');

    }else{

        $mulaiBerangkatValue =
        Carbon::parse($surat->mulai_berangkat)
        ->format('Y-m-d');

    }
}



/* =========================
   LIST PEKERJAAN
========================= */

$jobs = [

'BELUM/TIDAK BEKERJA',
'PELAJAR/MAHASISWA',
'TIDAK/BELUM SEKOLAH',
'KARYAWAN SWASTA',
'IBU RUMAH TANGGA',
'WIRASWASTA',
'TENTARA NASIONAL INDONESIA (TNI)',
'KEPOLISIAN RI (POLRI)',
'DOSEN',
'GURU',
'Guru agama',
'KEPALA DESA',
'PERANGKAT DESA',
'Pegawai Kantor Desa',
'BIDAN',
'DOKTER',
'PERAWAT',
'PETANI/PEKEBUN PEMILIK LAHAN',
'BURUH TANI/PERKEBUNAN',
'PEDAGANG',
'PEGAWAI NEGERI SIPIL (PNS)',
'BURUH HARIAN LEPAS',
'SOPIR',
'KARYAWAN BUMN',
'PENSIUNAN',
'PEMBANTU RUMAH TANGGA',
'BURUH PETERNAKAN',
'KONSTRUKSI',
'PELAUT',
'NELAYAN/PERIKANAN',
'KARYAWAN HONORER',
'PETERNAK',
'MEKANIK',
'PENATA RIAS',
'TUKANG LAS/PANDAI BESI',
'INDUSTRI',
'USTADZ/MUBALIGH',
'TABIB',
'BURUH NELAYAN/PERIKANAN',
'JURU MASAK',
'SENIMAN',
'AKUNTAN',
'Petani/Pekebun penyewa',
'TKI',
'Lainnya'

];


$pekerjaanTerpilih = old(
    'pekerjaan',
    $surat->pekerjaan ?? ''
);


/*
    JIKA DATABASE PUNYA VALUE
    TAPI TIDAK ADA DI ARRAY
    TAMBAHKAN
*/

if(
    !empty($pekerjaanTerpilih)
    &&
    !in_array($pekerjaanTerpilih,$jobs)
){

    $jobs[]=$pekerjaanTerpilih;

}


@endphp



<div class="container">

@if($errors->any())

<div class="alert alert-danger">

<ul>
@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach
</ul>

</div>

@endif



<div class="card shadow-sm">

<div class="card-body">


<h4 class="mb-4">
Edit Surat Keterangan Numpang Nikah
</h4>



<form action="{{route('surat.numpangnikah.update',$surat->_id)}}" method="POST">

@csrf
@method('PUT')



<h5>Data Pemohon</h5>



<div class="mb-3">

<label>NIK</label>

<input type="text"
name="nik"
id="nik"
class="form-control"
value="{{old('nik',$surat->nik)}}">

</div>




<div class="mb-3">

<label>Nama</label>

<input type="text"
name="nama"
id="nama"
class="form-control"
value="{{old('nama',$surat->nama)}}">

</div>



<div class="mb-3">

<label>Tempat Lahir</label>

<input type="text"
name="tempat_lahir"
id="tempat_lahir"
class="form-control"
value="{{old('tempat_lahir',$surat->tempat_lahir)}}">

</div>




<div class="mb-3">

<label>Tanggal Lahir</label>

<input type="date"
name="tanggal_lahir"
id="tanggal_lahir"
class="form-control"
value="{{$tanggalLahirValue}}">

</div>




<div class="mb-3">

<label>Agama</label>

<select name="agama"
id="agama"
class="form-control">


<option value="">
-- Pilih Agama --
</option>


@foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agama)

<option value="{{$agama}}"
{{old('agama',$surat->agama)==$agama?'selected':''}}>

{{$agama}}

</option>


@endforeach


</select>

</div>





<div class="mb-3">

<label>Pekerjaan</label>


<select name="pekerjaan"
id="pekerjaan"
class="form-control">


<option value="">
-- Pilih Pekerjaan --
</option>



@foreach($jobs as $job)


<option value="{{$job}}"

{{trim($pekerjaanTerpilih)==trim($job)?'selected':''}}

>

{{$job}}

</option>


@endforeach



</select>


</div>




<div class="mb-3">

<label>Status Perkawinan</label>


<select name="status_perkawinan"
id="status_perkawinan"
class="form-control">


<option value="">
-- Pilih Status --
</option>


@foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $status)


<option value="{{$status}}"

{{old('status_perkawinan',$surat->status_perkawinan)==$status?'selected':''}}

>

{{$status}}

</option>


@endforeach


</select>


</div>





<div class="mb-3">

<label>Alamat</label>

<textarea name="alamat"
id="alamat"
class="form-control"
rows="3">{{old('alamat',$surat->alamat)}}</textarea>


</div>


<hr>


<h5>Keterangan Numpang Nikah</h5>


<div class="mb-3">

<label>Keperluan</label>

<input type="text"
name="keperluan"
class="form-control"
value="{{old('keperluan',$surat->keperluan)}}">

</div>



<div class="mb-3">

<label>Alamat Tujuan</label>

<textarea name="alamat_tujuan"
class="form-control">{{old('alamat_tujuan',$surat->alamat_tujuan)}}</textarea>

</div>




<div class="mb-3">

<label>Mulai Berangkat</label>

<input type="date"
name="mulai_berangkat"
class="form-control"
value="{{$mulaiBerangkatValue}}">


</div>




<div class="mb-3">

<label>Pembawaan</label>

<input type="text"
name="pembawaan"
class="form-control"
value="{{old('pembawaan',$surat->pembawaan)}}">


</div>





<div class="mb-3">

<label>No WhatsApp</label>

<input type="text"
name="nowa"
class="form-control"
value="{{old('nowa',$surat->nowa)}}">


</div>




<div class="mb-3">

<label>Status Surat</label>

<select name="status_surat"
class="form-control">


@foreach(['Pending','Di cek','Di terima','Ditolak'] as $s)


<option value="{{$s}}"
{{old('status_surat',$surat->status_surat)==$s?'selected':''}}>

{{$s}}

</option>


@endforeach


</select>

</div>




<div class="mb-3">

<label>Status Verifikasi</label>


<select name="status_verif"
class="form-control">


@foreach(['Belum Verifikasi','Terverifikasi'] as $s)


<option value="{{$s}}"
{{old('status_verif',$surat->status_verif)==$s?'selected':''}}>

{{$s}}

</option>


@endforeach


</select>


</div>




<button class="btn btn-primary">
Update
</button>



<a href="{{route('surat.keluar')}}"
class="btn btn-secondary">

Kembali

</a>



</form>


</div>

</div>


</div>


@endsection
