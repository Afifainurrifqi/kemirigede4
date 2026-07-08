<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pernyataan Beda Nama Buku Nikah</title>
    <link rel="stylesheet" href="{{ asset('assets4/dist/style.css') }}">
</head>

<body>
    <div id="preloader">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <div class="header-area" id="headerArea">
        <div class="container">
            <div class="header-content header-style-five d-flex align-items-center justify-content-between">
                <div class="back-button">
                    <a href="{{ route('surat.pengajuan_surat') }}"><i class="bi bi-arrow-left-short"></i></a>
                </div>
                <div class="page-heading">
                    <h6 class="mb-0">Pernyataan Beda Nama Buku Nikah</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ route('surat.userbedanama.store') }}">
                        @csrf

                        <h6 class="mb-2">Data Pemohon</h6>

                        <!-- NIK (WAJIB ADA ID) -->
                        <div class="mb-3">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" name="nik" id="nik" class="form-control"
                                value="{{ old('nik') }}" required>
                        </div>

                        <!-- Nama -->
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama') }}" required>
                        </div>

                        <!-- Tempat & Tanggal Lahir -->
                        <div class="mb-3">
                            <label class="form-label">Tempat/Tanggal Lahir</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="text" name="ttl_tempat" id="ttl_tempat" class="form-control"
                                        placeholder="Tempat" value="{{ old('ttl_tempat') }}" required>
                                </div>
                                <div class="col-6">
                                    <input type="date" name="ttl_tanggal" id="ttl_tanggal" class="form-control"
                                        value="{{ old('ttl_tanggal') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Pekerjaan -->
                        <div class="mb-3">
                            <label class="form-label">Pekerjaan</label>
                            <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                                <option value="">-- Pilih pekerjaan --</option>
                                @foreach (['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'TIDAK/BELUM SEKOLAH', 'KARYAWAN SWASTA', 'IBU RUMAH TANGGA', 'WIRASWASTA', 'TENTARA NASIONAL INDONESIA (TNI)', 'KEPOLISIAN RI (POLRI)', 'DOSEN', 'GURU', 'Guru agama', 'KEPALA DESA', 'PERANGKAT DESA', 'Pegawai Kantor Desa', 'BIDAN', 'DOKTER', 'PERAWAT', 'PETANI/PEKEBUN PEMILIK LAHAN', 'BURUH TANI/PERKEBUNAN', 'PEDAGANG', 'PEGAWAI NEGERI SIPIL (PNS)', 'BURUH HARIAN LEPAS', 'SOPIR', 'KARYAWAN BUMN', 'PENSIUNAN', 'PEMBANTU RUMAH TANGGA', 'BURUH PETERNAKAN', 'KONSTRUKSI', 'PELAUT', 'NELAYAN/PERIKANAN', 'KARYAWAN HONORER', 'PETERNAK', 'MEKANIK', 'PENATA RIAS', 'TUKANG LAS/PANDAI BESI', 'INDUSTRI', 'USTADZ/MUBALIGH', 'TABIB', 'BURUH NELAYAN/PERIKANAN', 'JURU MASAK', 'SENIMAN', 'AKUNTAN', 'Petani/Pekebun penyewa', 'TKI', 'Lainnya'] as $job)
                                    <option value="{{ $job }}"
                                        {{ old('pekerjaan') == $job ? 'selected' : '' }}>
                                        {{ $job }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                        </div>

                        <hr class="my-3">

                        <h6 class="mb-2">Kesesuaian Nama</h6>

                        <div class="mb-3">
                            <label class="form-label">Nama Yang Sesuai</label>
                            <input type="text" name="nama_sesuai" class="form-control"
                                value="{{ old('nama_sesuai') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sumber data Nama</label>
                            <input type="text" name="sumber_data_nama" class="form-control"
                                placeholder="contoh: Buku Nikah, KTP, KK" value="{{ old('sumber_data_nama') }}"
                                required>
                        </div>

                        <input type="hidden" name="status_surat" value="Pending">
                        <input type="hidden" name="status_verif" value="Belum Verifikasi">

                        <div class="mb-3">
                            <label class="form-label">No WhatsApp</label>
                            <input type="text" name="nowa" class="form-control" value="{{ old('nowa') }}"
                                required>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-primary px-4" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Nav -->
    <div class="footer-nav-area" id="footerNav">
        <div class="container px-0">
            <div class="footer-nav position-relative">
                <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                    <li class="active">
                        <a href="{{ route('surat.pengajuan_surat') }}">
                            <i class="bi bi-house"></i><span>Beranda</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets4/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets4/dist/js/active.js') }}"></script>

    <!-- Autofill Script -->
    <script>
        function setSelectValue(selectId, value) {
            const select = document.getElementById(selectId);
            if (!select) return;

            const dbValue = (value || '').trim();
            const normalizedDb = dbValue.toUpperCase();

            let found = false;

            for (let i = 0; i < select.options.length; i++) {
                const optionValue = select.options[i].value.trim().toUpperCase();

                if (optionValue === normalizedDb) {
                    select.selectedIndex = i;
                    found = true;
                    break;
                }
            }

            if (!found && dbValue !== '') {
                const newOption = new Option(dbValue, dbValue, true, true);
                select.add(newOption);
            }
        }

        function autofillBedaNama() {
            const nik = document.getElementById('nik').value.trim();
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
                        document.getElementById('alamat').value = d.alamat || '';

                        setSelectValue('pekerjaan', d.pekerjaan);
                    }
                })
                .catch(err => console.log(err));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const nikInput = document.getElementById('nik');

            if (nikInput) {
                nikInput.addEventListener('blur', autofillBedaNama);
                nikInput.addEventListener('change', autofillBedaNama);
            }
        });
    </script>
</body>

</html>
