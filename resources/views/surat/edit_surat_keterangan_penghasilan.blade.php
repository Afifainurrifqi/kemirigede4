@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')

@section('content')
<div class="container py-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Penghasilan</h4>

            <form action="{{ route('surat.penghasilan.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="text-primary mb-3">Data Orang Tua / Wali (Pemohon)</h5>

                <div class="mb-3">
                    <label for="nik" class="form-label">NIK Pemohon <span class="text-danger">*</span></label>
                    <input type="text" name="nik" id="nik" class="form-control"
                        value="{{ old('nik', $surat->nik) }}" required>
                </div>

                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                        value="{{ old('nama_lengkap', $surat->nama_lengkap) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control"
                            value="{{ old('tempat_lahir', $surat->tempat_lahir) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir', !empty($surat->tanggal_lahir) ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('Y-m-d') : '') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="agama" class="form-label">Agama <span class="text-danger">*</span></label>
                        <select name="agama" id="agama" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Islam" {{ old('agama', $surat->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $surat->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $surat->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $surat->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Budha" {{ old('agama', $surat->agama) == 'Budha' ? 'selected' : '' }}>Budha</option>
                            <option value="Khonghucu" {{ old('agama', $surat->agama) == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                        <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control"
                            value="{{ old('kewarganegaraan', $surat->kewarganegaraan ?? 'Indonesia') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($status as $item)
                            <option value="{{ $item->nama }}"
                                {{ old('status', $surat->status) == $item->nama ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        @foreach ($pekerjaan as $item)
                            <option value="{{ $item->nama }}"
                                {{ old('pekerjaan', $surat->pekerjaan) == $item->nama ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="2" required>{{ old('alamat', $surat->alamat) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nominal_penghasilan" class="form-label">Nominal Penghasilan / Bulan <span class="text-danger">*</span></label>
                        <input type="text" name="nominal_penghasilan" id="nominal_penghasilan" class="form-control"
                            value="{{ old('nominal_penghasilan', $surat->nominal_penghasilan) }}"
                            placeholder="Contoh: Rp 1.000.000 - Rp 1.500.000" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="keperluan" class="form-label">Peruntukan/Keperluan Surat <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" id="keperluan" class="form-control"
                            value="{{ old('keperluan', $surat->keperluan) }}"
                            placeholder="Contoh: Persyaratan Beasiswa Universitas Brawijaya" required>
                    </div>
                </div>

                <h5 class="text-success mt-4 mb-3">Data Anak</h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nik_anak" class="form-label">NIK Anak <span class="text-danger">*</span></label>
                        <input type="text" name="nik_anak" id="nik_anak" class="form-control"
                            value="{{ old('nik_anak', $surat->nik_anak) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_anak" class="form-label">Nama Lengkap Anak <span class="text-danger">*</span></label>
                        <input type="text" name="nama_anak" id="nama_anak" class="form-control"
                            value="{{ old('nama_anak', $surat->nama_anak) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="jenis_kelamin_anak" class="form-label">Jenis Kelamin Anak <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin_anak" id="jenis_kelamin_anak" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-Laki" {{ old('jenis_kelamin_anak', $surat->jenis_kelamin_anak) == 'Laki-Laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin_anak', $surat->jenis_kelamin_anak) == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tempat_lahir_anak" class="form-label">Tempat Lahir Anak <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir_anak" id="tempat_lahir_anak" class="form-control"
                            value="{{ old('tempat_lahir_anak', $surat->tempat_lahir_anak) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="tanggal_lahir_anak" class="form-label">Tanggal Lahir Anak <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir_anak" id="tanggal_lahir_anak" class="form-control"
                            value="{{ old('tanggal_lahir_anak', !empty($surat->tanggal_lahir_anak) ? \Carbon\Carbon::parse($surat->tanggal_lahir_anak)->format('Y-m-d') : '') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sekolah_universitas" class="form-label">Nama Sekolah / Instansi Universitas <span class="text-danger">*</span></label>
                    <input type="text" name="sekolah_universitas" id="sekolah_universitas" class="form-control"
                        value="{{ old('sekolah_universitas', $surat->sekolah_universitas) }}"
                        placeholder="Contoh: Universitas Brawijaya" required>
                </div>

                {{-- <h5 class="text-secondary mt-4 mb-3">Verifikasi & Penomoran</h5>
                <div class="mb-3">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" name="nomor_surat" id="nomor_surat" class="form-control"
                        value="{{ old('nomor_surat', $surat->nomor_surat) }}">
                </div> --}}

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nowa" class="form-label">No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" id="nowa" class="form-control"
                            value="{{ old('nowa', $surat->nowa) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_surat" class="form-label">Status Surat <span class="text-danger">*</span></label>
                        <select name="status_surat" id="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status_verif" class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                        <select name="status_verif" id="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-5">Perbarui Data Surat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('nik').addEventListener('blur', function() {
        let nik = this.value.trim();

        if (nik.length < 10) return;

        fetch(`/datapenduduk/lookup/${nik}`)
            .then(res => res.json())
            .then(res => {
                if (res.success && res.data) {
                    document.getElementById('nama_lengkap').value = res.data.nama || '';
                    document.getElementById('tempat_lahir').value = res.data.tempat_lahir || '';
                    document.getElementById('tanggal_lahir').value = res.data.tanggal_lahir || '';
                    document.getElementById('jenis_kelamin').value = res.data.jenis_kelamin || '';
                    document.getElementById('alamat').value = res.data.alamat || '';
                    document.getElementById('status').value = res.data.status || '';
                }
            });
    });
</script>
@endsection
