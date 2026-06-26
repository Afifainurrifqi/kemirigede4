@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Tambah Surat Keluar</h4>

                <form action="{{ route('suratpernyataantidakbisamelampirkanktpkematian.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <h5 class="mb-4">Data Pelapor</h5>

                    <div class="mb-3">
                        <label for="nik_pelapor" class="form-label">NIK Pelapor <span class="text-danger">*</span></label>
                        <input type="text" name="nik_pelapor" id="nik_pelapor" class="form-control" required
                            value="{{ old('nik_pelapor') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nama_pelapor" class="form-label">Nama Pelapor <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pelapor" id="nama_pelapor" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tempat_lahir_pelapor" class="form-label">Tempat Lahir Pelapor <span
                                class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir_pelapor" id="tempat_lahir_pelapor" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir_pelapor" class="form-label">Tanggal Lahir Pelapor <span
                                class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir_pelapor" id="tanggal_lahir_pelapor" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin_pelapor" class="form-label">Jenis Kelamin Pelapor <span
                                class="text-danger">*</span></label>
                        <select name="jenis_kelamin_pelapor" id="jenis_kelamin_pelapor" class="form-control" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan_pelapor" class="form-label">Pekerjaan Pelapor <span
                                class="text-danger">*</span></label>
                        <input type="text" name="pekerjaan_pelapor" id="pekerjaan_pelapor" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_pelapor" class="form-label">Alamat Pelapor <span
                                class="text-danger">*</span></label>
                        <input type="text" name="alamat_pelapor" id="alamat_pelapor" class="form-control" required>
                    </div>

                    <hr>

                    <h5 class="mb-4">Data Jenazah</h5>

                    <div class="mb-3">
                        <label for="nik_jenazah" class="form-label">NIK Jenazah <span class="text-danger">*</span></label>
                        <input type="text" name="nik_jenazah" id="nik_jenazah" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama_jenazah" class="form-label">Nama Jenazah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jenazah" id="nama_jenazah" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_lahir_jenazah" class="form-label">Tanggal Lahir Jenazah
                            <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir_jenazah" id="tanggal_lahir_jenazah" class="form-control"
                            required value="{{ old('tanggal_lahir_jenazah') }}">
                    </div>

                    <!-- Jenis Kelamin Jenazah -->
                    <div class="mb-3">
                        <label for="jenis_kelamin_jenazah" class="form-label">Jenis Kelamin Jenazah <span
                                class="text-danger">*</span></label>
                        <select name="jenis_kelamin_jenazah" id="jenis_kelamin_jenazah" class="form-control" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_jenazah" class="form-label">Alamat Jenazah <span
                                class="text-danger">*</span></label>
                        <input type="text" name="alamat_jenazah" id="alamat_jenazah" class="form-control" required
                            value="{{ old('alamat_jenazah') }}">
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="alasan" class="form-label">Alasan Tidak Bisa Melampirkan KTP
                            <span class="text-danger">*</span></label>
                        <input type="text" name="alasan" id="alasan" class="form-control" required
                            value="{{ old('alasan') }}">
                    </div>

                    <div class="mb-3">
                        <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control" required
                            value="{{ old('nowa') }}">
                    </div>

                    <!-- Hidden select untuk status surat dan verif -->
                    <select name="status_surat" id="status_surat" class="form-select d-none" required>
                        <option value="Pending" selected>Pending</option>
                    </select>

                    <select name="status_verif" id="status_verif" class="form-select d-none" required>
                        <option value="Belum Verifikasi" selected>Belum Verifikasi</option>
                    </select>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan</button>
                    </div>
            </div>
        </div>
    </div>
    </form>
    </div>
    </div>
    </div>


      <script>
            function autofillData(nikFieldId, prefix) {
                const nik = document.getElementById(nikFieldId).value.trim();
                if (nik.length < 10) return;

                fetch(`/datapenduduk/lookup/${nik}`)
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            const d = result.data;

                            if (prefix === 'pelapor') {
                                document.getElementById('nama_pelapor').value = d.nama;
                                document.getElementById('tempat_lahir_pelapor').value = d.tempat_lahir;
                                document.getElementById('tanggal_lahir_pelapor').value = d.tanggal_lahir;
                                document.getElementById('jenis_kelamin_pelapor').value = d.jenis_kelamin;
                                document.getElementById('pekerjaan_pelapor').value = d.pekerjaan;
                                document.getElementById('alamat_pelapor').value = d.alamat;
                            } else if (prefix === 'jenazah') {
                                document.getElementById('nama_jenazah').value = d.nama;
                                document.getElementById('tanggal_lahir_jenazah').value = d.tanggal_lahir;
                                document.getElementById('jenis_kelamin_jenazah').value = d.jenis_kelamin;
                                document.getElementById('alamat_jenazah').value = d.alamat;
                            }
                        } else {
                            alert(result.message);
                        }
                    })
                    .catch(() => alert('Gagal mengambil data'));
            }

            document.addEventListener('DOMContentLoaded', () => {
                // Autofill Pelapor
                document.getElementById('nik_pelapor').addEventListener('blur', () => {
                    autofillData('nik_pelapor', 'pelapor');
                });

                // Autofill Jenazah
                document.getElementById('nik_jenazah').addEventListener('blur', () => {
                    autofillData('nik_jenazah', 'jenazah');
                });
            });
        </script>
@endsection
