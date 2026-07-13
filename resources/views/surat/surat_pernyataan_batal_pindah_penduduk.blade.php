@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">Buat Surat Pernyataan Batal Pindah Penduduk</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.batal_pindah.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control"
                                value="{{ old('nik') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Tempat Lahir</label>
                            <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control"
                                value="{{ old('ttl_tempat') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control"
                                value="{{ old('ttl_tanggal') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Agama</label>
                            <select name="agama" id="agama" class="form-control" required>
                                <option value="">-- Pilih Agama --</option>
                                @foreach ($agama ?? [] as $item)
                                    <option value="{{ $item->nama }}" {{ old('agama') == $item->nama ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Perkawinan</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach ($status ?? [] as $item)
                                    <option value="{{ $item->nama }}"
                                        {{ old('status') == $item->nama ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Ke Alamat (Tujuan Pindah yang Dibatalkan) <span class="text-danger">*</span></label>
                        <textarea name="ke_alamat" class="form-control" rows="2" required>{{ old('ke_alamat') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Dikarenakan (Alasan Batal Pindah) <span class="text-danger">*</span></label>
                        <textarea name="alasan_batal" class="form-control" rows="2" required>{{ old('alasan_batal') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Dan Akan Menetap Sesuai Alamat Asal di <span class="text-danger">*</span></label>
                        <textarea name="alamat_asal" class="form-control" rows="2" required>{{ old('alamat_asal') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat</label>
                            <select name="status_surat" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Di cek">Di cek</option>
                                <option value="Di terima">Di terima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi</label>
                            <select name="status_verif" class="form-control">
                                <option value="Belum Verifikasi">Belum Verifikasi</option>
                                <option value="Terverifikasi">Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Surat</button>
                    <a href="{{ route('surat.keluar') }}" class="btn btn-secondary ms-2">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function normalizeValue(value) {
            return (value || '')
                .toString()
                .trim()
                .toUpperCase()
                .replace(/\s+/g, ' ');
        }

        function setSelectValue(id, value) {
            const select = document.getElementById(id);
            if (!select || !value) return;

            const dbValue = normalizeValue(value);

            for (let i = 0; i < select.options.length; i++) {
                const optionValue = normalizeValue(select.options[i].value);
                const optionText = normalizeValue(select.options[i].text);

                if (optionValue === dbValue || optionText === dbValue) {
                    select.selectedIndex = i;
                    return;
                }
            }

            select.add(new Option(value, value, true, true));
        }

        function autofill() {
            const nikInput = document.getElementById('nik');
            if (!nikInput) return;

            const nik = nikInput.value.trim();
            if (nik.length < 10) return;

            fetch(`/datapenduduk/lookup/${nik}`)
                .then(res => res.json())
                .then(result => {
                    console.log(result);

                    if (result.success && result.data) {
                        const d = result.data;

                        document.getElementById('nama').value = d.nama || '';
                        document.getElementById('ttl_tempat').value = d.tempat_lahir || '';

                        document.getElementById('ttl_tanggal').value = d.tanggal_lahir ?
                            d.tanggal_lahir.substring(0, 10) :
                            '';

                        const alamatValue =
                            d.alamat ||
                            d.alamat_lengkap ||
                            d.alamat_domisili ||
                            '';

                        document.getElementById('alamat').value = alamatValue;

                        const alamatAsal = document.getElementById('alamat_asal');
                        if (alamatAsal) {
                            alamatAsal.value = alamatValue;
                        }

                        setSelectValue(
                            'agama',
                            d.agama ||
                            d.nama_agama ||
                            d.agama_nama ||
                            d.agama_id
                        );

                        setSelectValue(
                            'status',
                            d.status_perkawinan ||
                            d.status_kawin ||
                            d.status_pernikahan ||
                            d.status
                        );
                    }
                })
                .catch(err => console.log(err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');

            if (nikInput) {
                nikInput.addEventListener('blur', autofill);
                nikInput.addEventListener('change', autofill);
            }
        });
    </script>
@endsection
