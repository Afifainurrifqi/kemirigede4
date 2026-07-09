@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-4">Form Surat Keterangan Ahli Waris Desa (Admin)</h4>
                <form action="{{ route('surat.ahliwarisdesa.store') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Data Almarhum/Almarhumah</h5>
                    <div class="mb-3">
                        <label>Nama Almarhum/Almarhumah <span class="text-danger">*</span></label>
                        <input type="text" name="nama_almarhum" class="form-control" required
                            value="{{ old('nama_almarhum') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Hari Meninggal <span class="text-danger">*</span></label>
                            <input type="text" name="hari_meninggal" class="form-control" required
                                value="{{ old('hari_meninggal') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Meninggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_meninggal" class="form-control" required
                                value="{{ old('tanggal_meninggal') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Tempat Meninggal <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_meninggal" class="form-control" required
                            value="{{ old('tempat_meninggal') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nomor Surat Keterangan Kematian <span class="text-danger">*</span></label>
                            <input type="text" name="nomor_surat_kematian" class="form-control" required
                                value="{{ old('nomor_surat_kematian') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tanggal Surat Kematian <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_surat_kematian" class="form-control" required
                                value="{{ old('tanggal_surat_kematian') }}">
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Data Ahli Waris (bisa tambah lebih dari satu)</h5>
                    <div id="ahliWarisContainer">
                        <!-- Dynamic fields akan ditambah via JS -->
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" onclick="tambahAhliWaris()">+ Tambah Ahli
                        Waris</button>

                    <h5 class="mb-3 mt-4">Data Simpanan</h5>
                    <div class="mb-3">
                        <label>Nama Simpanan <span class="text-danger">*</span></label>
                        <input type="text" name="simpanan_nama" class="form-control" required
                            value="{{ old('simpanan_nama') }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Jenis Simpanan <span class="text-danger">*</span></label>
                            <input type="text" name="simpanan_jenis" class="form-control" required
                                value="{{ old('simpanan_jenis') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="simpanan_rekening" class="form-control" required
                                value="{{ old('simpanan_rekening') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>No WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="nowa" class="form-control" required value="{{ old('nowa') }}">
                    </div>

                    <!-- Status Admin -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Status Surat <span class="text-danger">*</span></label>
                            <select name="status_surat" class="form-control" required>
                                <option value="Pending">Pending</option>
                                <option value="Di cek">Di cek</option>
                                <option value="Di terima">Di terima</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Status Verifikasi <span class="text-danger">*</span></label>
                            <select name="status_verif" class="form-control" required>
                                <option value="Belum Verifikasi">Belum Verifikasi</option>
                                <option value="Terverifikasi">Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    function tambahAhliWaris() {
        const container = document.getElementById('ahliWarisContainer');
        const index = container.children.length;
        const html = `
        <div class="border p-3 mb-3">
            <h6>Ahli Waris ${index + 1}</h6>
            <input type="hidden" name="ahli_waris[${index}][index]" value="${index}">
            <div class="mb-2">
                <label>Nama</label>
                <input type="text" name="ahli_waris[${index}][nama]" class="form-control" required>
            </div>
            <div class="mb-2">
                <label>No Akta/KK</label>
                <input type="text" name="ahli_waris[${index}][no_akta]" class="form-control">
            </div>
            <div class="mb-2">
                <label>Alamat</label>
                <textarea name="ahli_waris[${index}][alamat]" class="form-control" rows="2"></textarea>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
    }
</script>
