@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Form Surat Pernyataan Memilih Nama Alias Orang Tua</h4>

            <form action="{{ route('surat.namaaliasortu.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="nik">NIK <span class="text-danger">*</span></label>
                    <input class="form-control" id="nik" name="nik" required value="{{ old('nik') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama">Nama</label>
                    <input class="form-control" id="nama" name="nama" required value="{{ old('nama') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama_menyatakan">Nama Yang Menyatakan</label>
                    <input class="form-control" id="nama_menyatakan" name="nama_menyatakan" required value="{{ old('nama_menyatakan') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="no_akta_kelahiran">No. Akta Kelahiran</label>
                    <input class="form-control" id="no_akta_kelahiran" name="no_akta_kelahiran" value="{{ old('no_akta_kelahiran') }}">
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label" for="nama_ortu_ayah_tercatat">Nama Orang Tua Tercatat (Ayah)</label>
                    <input class="form-control" id="nama_ortu_ayah_tercatat" name="nama_ortu_ayah_tercatat" value="{{ old('nama_ortu_ayah_tercatat') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama_alias_ayah">Nama Alias (Ayah)</label>
                    <input class="form-control" id="nama_alias_ayah" name="nama_alias_ayah" value="{{ old('nama_alias_ayah') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama_ortu_ibu_tercatat">Nama Orang Tua Tercatat (Ibu)</label>
                    <input class="form-control" id="nama_ortu_ibu_tercatat" name="nama_ortu_ibu_tercatat" value="{{ old('nama_ortu_ibu_tercatat') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama_alias_ibu">Nama Alias (Ibu)</label>
                    <input class="form-control" id="nama_alias_ibu" name="nama_alias_ibu" value="{{ old('nama_alias_ibu') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama_alias_dihapus_1">Nama Alias yang Dihapus (1)</label>
                    <input class="form-control" id="nama_alias_dihapus_1" name="nama_alias_dihapus_1" value="{{ old('nama_alias_dihapus_1') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="nama_alias_dihapus_2">Nama Alias yang Dihapus (2)</label>
                    <input class="form-control" id="nama_alias_dihapus_2" name="nama_alias_dihapus_2" value="{{ old('nama_alias_dihapus_2') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="berdasarkan">Berdasarkan</label>
                    <textarea class="form-control" id="berdasarkan" name="berdasarkan" rows="2">{{ old('berdasarkan') }}</textarea>
                </div>

                <hr>

                <input type="hidden" name="status_surat" value="{{ old('status_surat', 'Pending') }}">
                <input type="hidden" name="status_verif" value="{{ old('status_verif', 'Belum Verifikasi') }}">

                <div class="mb-3">
                    <label class="form-label" for="nowa">No WhatsApp</label>
                    <input class="form-control" id="nowa" name="nowa" required value="{{ old('nowa') }}">
                </div>

                <button class="btn btn-primary mt-2" type="submit">Kirim</button>
            </form>
        </div>
    </div>
</div>

<script>
    function autofillData() {
        const nik = document.getElementById('nik').value.trim();
        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(result => {
                if (result.success) {
                    const d = result.data;
                    document.getElementById('nama').value = d.nama || '';
                    document.getElementById('alamat').value = d.alamat || '';
                } else {
                    alert(result.message || 'NIK tidak ditemukan');
                }
            })
            .catch(() => alert('Gagal mengambil data'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('nik').addEventListener('blur', autofillData);
    });
</script>
@endsection
