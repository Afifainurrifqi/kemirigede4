@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container-fluid py-3">
  <div class="row">
    <div class="col-lg-12 mx-auto">

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
          </ul>
        </div>
      @endif

      <div class="card shadow-sm">
        <div class="card-header">
          <h5 class="mb-0">Form Pernyataan Beda Nama Buku Nikah</h5>
        </div>

        <div class="card-body">
          <form action="{{ route('surat.bedanama.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label class="form-label">NIK <span class="text-danger">*</span></label>
              <input type="text" id="nik" name="nik" class="form-control" required value="{{ old('nik') }}">
            </div>

            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" id="nama" name="nama" class="form-control" required value="{{ old('nama') }}">
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tempat Lahir</label>
                  <input type="text" id="ttl_tempat" name="ttl_tempat" class="form-control" required value="{{ old('ttl_tempat') }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Tanggal Lahir</label>
                  <input type="date" id="ttl_tanggal" name="ttl_tanggal" class="form-control" required value="{{ old('ttl_tanggal') }}">
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Pekerjaan</label>
              <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                <option value="">-- Pilih pekerjaan --</option>
                @foreach (['BELUM/TIDAK BEKERJA','PELAJAR/MAHASISWA','KARYAWAN SWASTA','IBU RUMAH TANGGA','WIRASWASTA','PETANI/PEKEBUN','BURUH TANI','PEDAGANG','PEGAWAI NEGERI SIPIL (PNS)','KARYAWAN HONORER','Lainnya'] as $job)
                  <option value="{{ $job }}" {{ old('pekerjaan') == $job ? 'selected' : '' }}>{{ $job }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea id="alamat" name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama yang Sesuai (yang akan dicantumkan di Akta)</label>
              <input type="text" id="nama_sesuai" name="nama_sesuai" class="form-control" required value="{{ old('nama_sesuai') }}">
            </div>

            <div class="mb-3">
              <label class="form-label">Sumber Data Nama</label>
              <input type="text" id="sumber_data_nama" name="sumber_data_nama" class="form-control" placeholder="Buku Nikah / KTP / KK" required value="{{ old('sumber_data_nama') }}">
            </div>

            <div class="mb-3">
              <label class="form-label">Status Surat</label>
              <select name="status_surat" class="form-control" required>
                @foreach (['Pending','Di cek','Di terima','Ditolak'] as $st)
                  <option value="{{ $st }}" {{ old('status_surat', 'Pending') == $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Status Verifikasi</label>
              <select name="status_verif" class="form-control" required>
                @foreach (['Belum Verifikasi','Terverifikasi'] as $sv)
                  <option value="{{ $sv }}" {{ old('status_verif', 'Belum Verifikasi') == $sv ? 'selected' : '' }}>{{ $sv }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">No WhatsApp</label>
              <input type="text" id="nowa" name="nowa" class="form-control" required value="{{ old('nowa') }}">
            </div>

            <div class="text-end">
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Autofill NIK --}}
<script>
  function autofillBedaNama() {
    const nik = document.getElementById('nik').value.trim();
    if (nik.length < 10) return;

    fetch(`/datapenduduk/lookup/${nik}`)
      .then(res => res.json())
      .then(result => {
        if (result.success && result.data) {
          const d = result.data;
          document.getElementById('nama').value       = d.nama || '';
          document.getElementById('ttl_tempat').value = d.tempat_lahir || '';
          document.getElementById('ttl_tanggal').value = d.tanggal_lahir ? d.tanggal_lahir.substring(0,10) : '';
          document.getElementById('alamat').value     = d.alamat || '';
          document.getElementById('pekerjaan').value  = d.pekerjaan || '';
        }
      })
      .catch(err => console.log(err));
  }

  document.addEventListener('DOMContentLoaded', function() {
    const nikInput = document.getElementById('nik');
    if (nikInput) nikInput.addEventListener('blur', autofillBedaNama);
  });
</script>
@endsection
