@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Pernyataan dan Jaminan</h4>
                <form action="{{ route('surat.pernyataandanjaminan.store') }}" method="POST">
                    @csrf

                    <h6 class="mb-2">A. Identitas Pembuat Pernyataan (Penjamin)</h6>
                    <div class="mb-3">
                        <label class="form-label">NIK Penjamin <span class="text-danger">*</span></label>
                        <input class="form-control" name="nik_pembuat" id="nik_pembuat" required
                            value="{{ old('nik_pembuat') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Penjamin</label>
                        <input class="form-control" name="nama_pembuat" id="nama_pembuat" required
                            value="{{ old('nama_pembuat') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Penjamin</label>
                        <textarea class="form-control" name="alamat_pembuat" id="alamat_pembuat" rows="2" required>{{ old('alamat_pembuat') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hubungan dengan Terjamin</label>
                        <input class="form-control" name="hubungan_dengan_terjamin" required
                            value="{{ old('hubungan_dengan_terjamin') }}">
                    </div>

                    <h6 class="mb-2 mt-3">B. Identitas Pihak yang Dijamin</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Terjamin</label>
                        <input class="form-control" name="nama_terjamin" id="nama_terjamin" required
                            value="{{ old('nama_terjamin') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIK Terjamin</label>
                        <input class="form-control" name="nik_terjamin" id="nik_terjamin" required
                            value="{{ old('nik_terjamin') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Terjamin</label>
                        <textarea class="form-control" name="alamat_terjamin" id="alamat_terjamin" rows="2" required>{{ old('alamat_terjamin') }}</textarea>
                    </div>

                    <h6 class="mb-2 mt-3">C. Pernyataan & Jaminan</h6>
                    <div class="mb-3">
                        <label class="form-label">Uraian Pernyataan</label>
                        <textarea class="form-control" name="uraian_pernyataan" rows="3" required>{{ old('uraian_pernyataan') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bentuk Jaminan</label>
                        <input class="form-control" name="bentuk_jaminan" value="{{ old('bentuk_jaminan') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Berlaku Mulai</label>
                            <input type="date" class="form-control" name="berlaku_mulai" required
                                value="{{ old('berlaku_mulai') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berlaku Sampai</label>
                            <input type="date" class="form-control" name="berlaku_sampai"
                                value="{{ old('berlaku_sampai') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Berdasarkan</label>
                        <textarea class="form-control" name="berdasarkan" rows="2">{{ old('berdasarkan') }}</textarea>
                    </div>

                    {{-- status hidden default --}}
                    <div class="mb-3">
                        <label for="status_surat" class="form-label">Status Surat</label>
                        <select name="status_surat" id="status_surat" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach (['Pending', 'Di cek', 'Di terima', 'Ditolak'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status_surat') == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status_verif" class="form-label">Status Verifikasi</label>
                        <select name="status_verif" id="status_verif" class="form-control" required>
                            <option value="">-- Pilih Verifikasi --</option>
                            @foreach (['Belum Verifikasi', 'Terverifikasi'] as $verif)
                                <option value="{{ $verif }}" {{ old('status_verif') == $verif ? 'selected' : '' }}>
                                    {{ $verif }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No WhatsApp</label>
                        <input class="form-control" name="nowa" value="{{ old('nowa') }}" required>
                    </div>

                    <button class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function setValue(id, value) {
            const el = document.getElementById(id);
            if (el) {
                el.value = value || '';
            }
        }

        function autofillPenduduk(nikId, namaId, alamatId) {
            const nikInput = document.getElementById(nikId);
            if (!nikInput) return;

            const nik = nikInput.value.trim();

            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    console.log('HASIL LOOKUP:', result);

                    if (!result.success) {
                        alert(result.message || 'NIK tidak ditemukan');
                        return;
                    }

                    const d = result.data;

                    setValue(namaId, d.nama);
                    setValue(alamatId, d.alamat);
                })
                .catch(error => {
                    console.error(error);
                    alert('Gagal mengambil data penduduk');
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikPembuat = document.getElementById('nik_pembuat');
            const nikTerjamin = document.getElementById('nik_terjamin');

            if (nikPembuat) {
                nikPembuat.addEventListener('blur', function() {
                    autofillPenduduk('nik_pembuat', 'nama_pembuat', 'alamat_pembuat');
                });
            }

            if (nikTerjamin) {
                nikTerjamin.addEventListener('blur', function() {
                    autofillPenduduk('nik_terjamin', 'nama_terjamin', 'alamat_terjamin');
                });
            }
        });
    </script>
@endsection
