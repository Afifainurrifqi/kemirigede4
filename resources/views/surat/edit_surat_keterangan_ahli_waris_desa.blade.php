@extends(Auth::user() && Auth::user()->role == 'admin' ? 'layout.main2' : 'layout.main')
@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Surat Keterangan Ahli Waris Desa</h4>
            <form action="{{ route('surat.ahliwarisdesa.update', $surat->_id) }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Data Almarhum/Almarhumah</h5>
                <div class="mb-3">
                    <label>Nama Almarhum/Almarhumah <span class="text-danger">*</span></label>
                    <input type="text" name="nama_almarhum" class="form-control" required value="{{ old('nama_almarhum', $surat->nama_almarhum) }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Hari Meninggal <span class="text-danger">*</span></label>
                        <input type="text" name="hari_meninggal" class="form-control" required value="{{ old('hari_meninggal', $surat->hari_meninggal) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Meninggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_meninggal" class="form-control" required value="{{ old('tanggal_meninggal', $surat->tanggal_meninggal ? \Carbon\Carbon::parse($surat->tanggal_meninggal)->format('Y-m-d') : '') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label>Tempat Meninggal <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_meninggal" class="form-control" required value="{{ old('tempat_meninggal', $surat->tempat_meninggal) }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nomor Surat Kematian <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_surat_kematian" class="form-control" required value="{{ old('nomor_surat_kematian', $surat->nomor_surat_kematian) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Surat Kematian <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_surat_kematian" class="form-control" required value="{{ old('tanggal_surat_kematian', $surat->tanggal_surat_kematian ? \Carbon\Carbon::parse($surat->tanggal_surat_kematian)->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <h5 class="mb-3 mt-4">Data Ahli Waris</h5>
                <div id="ahliWarisContainerEdit">
                    @if($surat->ahli_waris)
                        @foreach($surat->ahli_waris as $index => $waris)
                            <div class="border p-3 mb-3">
                                <h6>Ahli Waris {{ $index + 1 }}</h6>
                                <input type="hidden" name="ahli_waris[{{ $index }}][index]" value="{{ $index }}">
                                <div class="mb-2">
                                    <label>Nama</label>
                                    <input type="text" name="ahli_waris[{{ $index }}][nama]" class="form-control" value="{{ old('ahli_waris.' . $index . '.nama', $waris['nama'] ?? '') }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>No Akta/KK</label>
                                    <input type="text" name="ahli_waris[{{ $index }}][no_akta]" class="form-control" value="{{ old('ahli_waris.' . $index . '.no_akta', $waris['no_akta'] ?? '') }}">
                                </div>
                                <div class="mb-2">
                                    <label>Alamat</label>
                                    <textarea name="ahli_waris[{{ $index }}][alamat]" class="form-control" rows="2">{{ old('ahli_waris.' . $index . '.alamat', $waris['alamat'] ?? '') }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="btn btn-secondary mb-3" onclick="tambahAhliWarisEdit()">+ Tambah Ahli Waris</button>

                <h5 class="mb-3 mt-4">Data Simpanan</h5>
                <div class="mb-3">
                    <label>Nama Simpanan <span class="text-danger">*</span></label>
                    <input type="text" name="simpanan_nama" class="form-control" required value="{{ old('simpanan_nama', $surat->simpanan_nama) }}">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Jenis Simpanan <span class="text-danger">*</span></label>
                        <input type="text" name="simpanan_jenis" class="form-control" required value="{{ old('simpanan_jenis', $surat->simpanan_jenis) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Nomor Rekening <span class="text-danger">*</span></label>
                        <input type="text" name="simpanan_rekening" class="form-control" required value="{{ old('simpanan_rekening', $surat->simpanan_rekening) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>No WhatsApp <span class="text-danger">*</span></label>
                    <input type="text" name="nowa" class="form-control" required value="{{ old('nowa', $surat->nowa) }}">
                </div>

                <!-- Status -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Status Surat</label>
                        <select name="status_surat" class="form-control" required>
                            <option value="Pending" {{ old('status_surat', $surat->status_surat) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Di cek" {{ old('status_surat', $surat->status_surat) == 'Di cek' ? 'selected' : '' }}>Di cek</option>
                            <option value="Di terima" {{ old('status_surat', $surat->status_surat) == 'Di terima' ? 'selected' : '' }}>Di terima</option>
                            <option value="Ditolak" {{ old('status_surat', $surat->status_surat) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Status Verifikasi</label>
                        <select name="status_verif" class="form-control" required>
                            <option value="Belum Verifikasi" {{ old('status_verif', $surat->status_verif) == 'Belum Verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                            <option value="Terverifikasi" {{ old('status_verif', $surat->status_verif) == 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                        </select>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
function tambahAhliWarisEdit() {
    const container = document.getElementById('ahliWarisContainerEdit');
    const index = container.children.length;
    const html = `
        <div class="border p-3 mb-3">
            <h6>Ahli Waris Baru</h6>
            <input type="hidden" name="ahli_waris[${index}][index]" value="${index}">
            <div class="mb-2">
                <label>Nama <span class="text-danger">*</span></label>
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
