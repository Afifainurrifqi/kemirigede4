{{-- resources/views/datapenduduk/admindata.blade.php --}}

@extends(
    optional(Auth::user())->role === 'admin'
        ? 'layout.main2'
        : 'layout.main'
)

@section('content')

    {{-- ============================================================
        STYLE DATATABLES
    ============================================================ --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <style>
        #tabledatapenduduk_b {
            width: 100% !important;
            font-size: 13px;
        }

        #tabledatapenduduk_b th,
        #tabledatapenduduk_b td {
            white-space: nowrap;
            vertical-align: middle;
        }

        #tabledatapenduduk_b thead th {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px;
            padding: 5px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .dataTables_wrapper .dataTables_length select {
            padding: 4px 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 4px;
        }

        div.dataTables_processing {
            position: fixed;
            top: 50%;
            left: 50%;
            z-index: 9999;

            width: auto;
            min-width: 220px;
            height: auto;

            margin: 0;
            padding: 18px 25px;

            transform: translate(-50%, -50%);

            border: 1px solid #dee2e6;
            border-radius: 6px;

            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);

            font-weight: 600;
            text-align: center;
        }

        .import-warning-list {
            max-height: 350px;
            overflow-y: auto;
        }

        .file-information {
            padding: 12px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f8f9fa;
        }

        .action-button-container .btn {
            margin-right: 6px;
            margin-bottom: 6px;
        }
    </style>

    <div class="container-fluid">

        {{-- CSRF untuk request AJAX DataTables --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="row">
            <div class="col-12">

                {{-- ====================================================
                    PESAN BERHASIL
                ==================================================== --}}
                @if (session('msg'))
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">

                        <i class="fa fa-check-circle"></i>
                        {{ session('msg') }}

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- ====================================================
                    PESAN ERROR PROSES
                ==================================================== --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show"
                         role="alert">

                        <i class="fa fa-exclamation-circle"></i>
                        {{ session('error') }}

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- ====================================================
                    ERROR VALIDASI
                ==================================================== --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show"
                         role="alert">

                        <strong>
                            <i class="fa fa-exclamation-triangle"></i>
                            Terjadi kesalahan:
                        </strong>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- ====================================================
                    PERINGATAN HASIL IMPORT
                ==================================================== --}}
                @if (
                    session('import_warnings') &&
                    count(session('import_warnings')) > 0
                )
                    <div class="alert alert-warning alert-dismissible fade show"
                         role="alert">

                        <strong>
                            <i class="fa fa-exclamation-triangle"></i>
                            Beberapa baris tidak diimpor
                        </strong>

                        <p class="mb-2 mt-1">
                            Data berikut dilewati karena NIK sudah tersedia,
                            NIK ganda dalam file, atau isi baris tidak valid.
                        </p>

                        <div class="import-warning-list">
                            <ul class="mb-0">
                                @foreach (session('import_warnings') as $warning)
                                    <li>{{ $warning }}</li>
                                @endforeach
                            </ul>
                        </div>

                        @if (session('import_warning_overflow', 0) > 0)
                            <div class="mt-2">
                                <strong>
                                    Masih ada
                                    {{ session('import_warning_overflow') }}
                                    peringatan lain yang tidak ditampilkan.
                                </strong>
                            </div>
                        @endif

                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-label="Tutup">

                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                {{-- ====================================================
                    CARD DATA PENDUDUK
                ==================================================== --}}
                <div class="card">

                    <div class="card-header d-flex flex-wrap
                                justify-content-between align-items-center">

                        <div>
                            <h2 class="card-title mb-0">
                                Data Penduduk
                            </h2>

                            <small class="text-muted">
                                Pengelolaan data kependudukan
                            </small>
                        </div>

                    </div>

                    <div class="card-body">

                        {{-- ============================================
                            TOMBOL AKSI
                        ============================================ --}}
                        <div class="action-button-container d-flex flex-wrap mb-3">

                            {{-- Export Excel melalui Laravel Excel --}}
                            <a href="{{ route('export_excel') }}"
                               id="btnExportExcel"
                               class="btn btn-success">

                                <i class="fa fa-file-excel-o"></i>
                                Export Excel
                            </a>

                            {{-- Buka modal import --}}
                            <button type="button"
                                    class="btn btn-info"
                                    data-toggle="modal"
                                    data-target="#importModal">

                                <i class="fa fa-upload"></i>
                                Import XLSX
                            </button>

                            {{-- Tambah penduduk --}}
                            <a href="{{ url('datapenduduk/add') }}"
                               class="btn btn-primary">

                                <i class="fa fa-plus-circle"></i>
                                Tambah Penduduk
                            </a>

                        </div>

                        {{-- Informasi singkat --}}
                        <div class="alert alert-light border mb-3">

                            <i class="fa fa-info-circle text-info"></i>

                            Data tabel dimuat secara server-side. Export diproses
                            oleh server dan import hanya menerima file
                            <strong>XLSX</strong>.

                        </div>

                        {{-- ============================================
                            TABEL DATA PENDUDUK
                        ============================================ --}}
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered
                                          table-hover nowrap"
                                   id="tabledatapenduduk_b"
                                   style="width: 100%;">

                                <thead class="thead-light">
                                    <tr>
                                        <th>Action</th>
                                        <th>No</th>
                                        <th>Updated By</th>
                                        <th>No KK</th>
                                        <th>NIK</th>
                                        <th>Gelar Awal</th>
                                        <th>Nama</th>
                                        <th>Gelar Akhir</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Agama</th>
                                        <th>Pendidikan</th>
                                        <th>Pekerjaan</th>
                                        <th>Golongan Darah</th>
                                        <th>Status Perkawinan</th>
                                        <th>Tahun Perkawinan</th>
                                        <th>Hubungan</th>
                                        <th>Nama Ayah</th>
                                        <th>Nama Ibu</th>
                                        <th>Alamat</th>
                                        <th>RT</th>
                                        <th>RW</th>
                                        <th>Status Kependudukan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    {{-- Diisi oleh DataTables --}}
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ============================================================
        MODAL IMPORT XLSX
    ============================================================ --}}
    <div class="modal fade"
         id="importModal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="importModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered"
             role="document">

            <form action="{{ route('import_excel') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="formImport"
                  class="modal-content">

                @csrf

                <div class="modal-header">

                    <h5 class="modal-title"
                        id="importModalLabel">

                        <i class="fa fa-upload"></i>
                        Import Data Penduduk XLSX

                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Tutup">

                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <label for="file">
                            Pilih File XLSX
                            <span class="text-danger">*</span>
                        </label>

                        <input type="file"
                               name="file"
                               id="file"
                               class="form-control-file @error('file') is-invalid @enderror"
                               accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                               required>

                        @error('file')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Nama file yang dipilih --}}
                    <div id="selectedFileInformation"
                         class="file-information mb-3"
                         style="display: none;">

                        <div>
                            <strong>File:</strong>
                            <span id="selectedFileName">-</span>
                        </div>

                        <div>
                            <strong>Ukuran:</strong>
                            <span id="selectedFileSize">-</span>
                        </div>

                    </div>

                    <div class="alert alert-info">

                        <strong>
                            <i class="fa fa-info-circle"></i>
                            Ketentuan file:
                        </strong>

                        <ul class="mb-0 mt-2">
                            <li>File harus berformat XLSX.</li>
                            <li>Baris pertama wajib berisi header.</li>
                            <li>No KK dan NIK wajib tepat 16 digit.</li>
                            <li>Kolom No KK dan NIK harus berformat Text.</li>
                            <li>
                                Tanggal lahir disarankan menggunakan format
                                YYYY-MM-DD.
                            </li>
                            <li>
                                Nama agama, pendidikan, pekerjaan, golongan
                                darah, dan status harus sesuai data master.
                            </li>
                            <li>
                                NIK yang sudah ada di database tidak akan
                                diperbarui dan akan dilewati.
                            </li>
                            <li>
                                Apabila satu NIK muncul lebih dari sekali dalam
                                file, hanya data pertama yang diproses.
                            </li>
                        </ul>

                    </div>

                    <div class="alert alert-warning mb-0">

                        <strong>
                            <i class="fa fa-exclamation-triangle"></i>
                            Perhatian:
                        </strong>

                        Jangan menuliskan NIK atau No KK dalam notasi ilmiah,
                        misalnya <code>3.50519E+15</code>. Gunakan format sel
                        <strong>Text</strong> sebelum mengisi angkanya.

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-light"
                            data-dismiss="modal">

                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-success"
                            id="btnSubmitImport">

                        <i class="fa fa-upload"></i>
                        Import Data
                    </button>

                </div>

            </form>

        </div>
    </div>

    {{-- ============================================================
        JAVASCRIPT
    ============================================================ --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">

        var $ = jQuery.noConflict();

        $(document).ready(function () {

            /**
             * Nilai kosong tidak ditampilkan sebagai null.
             */
            function nilaiKosong(value) {
                if (
                    value === null ||
                    value === undefined
                ) {
                    return '';
                }

                return value;
            }

            /**
             * Mengubah kode jenis kelamin menjadi teks.
             */
            function mapJenisKelamin(value) {
                if (
                    value === null ||
                    value === undefined ||
                    value === ''
                ) {
                    return '';
                }

                var jenisKelamin = String(value)
                    .trim()
                    .toUpperCase()
                    .replace(/[^A-Z0-9]/g, '');

                var lakiLaki = [
                    '1',
                    'L',
                    'LK',
                    'LAKI',
                    'LAKILAKI',
                    'PRIA',
                    'MALE'
                ];

                var perempuan = [
                    '0',
                    '2',
                    'P',
                    'PR',
                    'PEREMPUAN',
                    'WANITA',
                    'FEMALE'
                ];

                if (lakiLaki.indexOf(jenisKelamin) !== -1) {
                    return 'Laki-laki';
                }

                if (perempuan.indexOf(jenisKelamin) !== -1) {
                    return 'Perempuan';
                }

                return value;
            }

            /**
             * Mengambil tahun dari tanggal perkawinan.
             */
            function ambilTahun(value) {
                if (
                    value === null ||
                    value === undefined ||
                    value === ''
                ) {
                    return '';
                }

                return String(value).substring(0, 4);
            }

            /**
             * Inisialisasi DataTables server-side.
             */
            var table = $('#tabledatapenduduk_b').DataTable({

                processing: true,
                serverSide: true,

                searching: true,
                ordering: true,
                paging: true,

                scrollX: true,
                autoWidth: false,

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                /**
                 * Tidak memakai DataTables Buttons.
                 * Export memakai Laravel Excel.
                 */
                dom: 'lfrtip',

                language: {
                    processing: 'Memuat data...',
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data yang ditampilkan',
                    infoFiltered: '(disaring dari _MAX_ data)',
                    loadingRecords: 'Memuat...',
                    zeroRecords: 'Data tidak ditemukan',
                    emptyTable: 'Belum ada data penduduk',

                    paginate: {
                        first: 'Pertama',
                        previous: 'Sebelumnya',
                        next: 'Berikutnya',
                        last: 'Terakhir'
                    }
                },

                ajax: {
                    url: '{{ route('datapenduduk.json') }}',
                    type: 'POST',

                    headers: {
                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]').attr('content')
                    },

                    error: function (xhr) {
                        console.error(
                            'DataTables error:',
                            xhr.responseText
                        );

                        var message =
                            'Data penduduk gagal dimuat.';

                        if (xhr.status === 419) {
                            message =
                                'Sesi telah berakhir. Silakan muat ulang halaman.';
                        } else if (xhr.status === 403) {
                            message =
                                'Anda tidak memiliki izin mengakses data.';
                        } else if (xhr.status === 500) {
                            message =
                                'Terjadi kesalahan server ketika memuat data.';
                        }

                        alert(message);
                    }
                },

                order: [
                    [6, 'asc']
                ],

                columnDefs: [
                    {
                        targets: [0, 1, 2],
                        orderable: false
                    },
                    {
                        targets: [0, 1, 2],
                        searchable: false
                    }
                ],

                columns: [

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        defaultContent: ''
                    },

                    {
                        data: null,
                        name: 'nomor',
                        orderable: false,
                        searchable: false,

                        render: function (data, type, row, meta) {
                            return (
                                meta.row +
                                meta.settings._iDisplayStart +
                                1
                            );
                        }
                    },

                    {
                        data: 'updated_by',
                        name: 'updated_by',
                        orderable: false,
                        searchable: false,
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'nokk',
                        name: 'nokk',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'nik',
                        name: 'nik',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'gelarawal',
                        name: 'gelarawal',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'nama',
                        name: 'nama',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'gelarakhir',
                        name: 'gelarakhir',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        defaultContent: '',

                        render: function (data) {
                            return mapJenisKelamin(data);
                        }
                    },

                    {
                        data: 'tempat_lahir',
                        name: 'tempat_lahir',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'tanggal_lahir',
                        name: 'tanggal_lahir',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'agama.nama',
                        name: 'agama.nama',
                        defaultContent: ''
                    },

                    {
                        data: 'pendidikan.nama',
                        name: 'pendidikan.nama',
                        defaultContent: ''
                    },

                    {
                        data: 'pekerjaan.nama',
                        name: 'pekerjaan.nama',
                        defaultContent: ''
                    },

                    {
                        data: 'goldar.nama',
                        name: 'goldar.nama',
                        defaultContent: ''
                    },

                    {
                        data: 'status.nama',
                        name: 'status.nama',
                        defaultContent: ''
                    },

                    {
                        data: 'tanggal_perkawinan',
                        name: 'tanggal_perkawinan',
                        defaultContent: '',

                        render: function (data) {
                            return ambilTahun(data);
                        }
                    },

                    {
                        data: 'hubungan',
                        name: 'hubungan',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'ayah',
                        name: 'ayah',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'ibu',
                        name: 'ibu',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'alamat',
                        name: 'alamat',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'rt',
                        name: 'rt',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'rw',
                        name: 'rw',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    },

                    {
                        data: 'datak',
                        name: 'datak',
                        defaultContent: '',

                        render: function (data) {
                            return nilaiKosong(data);
                        }
                    }

                ]

            });

            /**
             * Menampilkan informasi file yang dipilih.
             */
            $('#file').on('change', function () {

                var file = this.files[0];

                if (!file) {
                    $('#selectedFileInformation').hide();
                    $('#selectedFileName').text('-');
                    $('#selectedFileSize').text('-');

                    return;
                }

                var fileName = file.name;
                var fileExtension = fileName
                    .split('.')
                    .pop()
                    .toLowerCase();

                if (fileExtension !== 'xlsx') {
                    alert('File harus berformat XLSX.');

                    $(this).val('');

                    $('#selectedFileInformation').hide();

                    return;
                }

                var fileSizeMb = (
                    file.size /
                    1024 /
                    1024
                ).toFixed(2);

                if (file.size > (20 * 1024 * 1024)) {
                    alert('Ukuran file maksimal 20 MB.');

                    $(this).val('');

                    $('#selectedFileInformation').hide();

                    return;
                }

                $('#selectedFileName').text(fileName);
                $('#selectedFileSize').text(fileSizeMb + ' MB');
                $('#selectedFileInformation').show();

            });

            /**
             * Mencegah form import dikirim dua kali.
             */
            $('#formImport').on('submit', function () {

                var fileInput = $('#file');
                var submitButton = $('#btnSubmitImport');

                if (!fileInput.val()) {
                    alert('Silakan pilih file XLSX.');

                    return false;
                }

                submitButton.prop('disabled', true);

                submitButton.html(
                    '<i class="fa fa-spinner fa-spin"></i> ' +
                    'Memproses Import...'
                );

                return true;
            });

            /**
             * Indikator tombol export.
             */
            $('#btnExportExcel').on('click', function () {

                var button = $(this);

                if (button.hasClass('disabled')) {
                    return false;
                }

                button.addClass('disabled');

                button.html(
                    '<i class="fa fa-spinner fa-spin"></i> ' +
                    'Menyiapkan Excel...'
                );

                /*
                 * Browser tidak menyediakan callback langsung
                 * ketika file download selesai, sehingga tombol
                 * dikembalikan setelah beberapa detik.
                 */
                setTimeout(function () {

                    button.removeClass('disabled');

                    button.html(
                        '<i class="fa fa-file-excel-o"></i> ' +
                        'Export Excel'
                    );

                }, 5000);

            });

            /**
             * Apabila validasi file gagal, modal import
             * otomatis ditampilkan kembali.
             */
            @if ($errors->has('file'))
                $('#importModal').modal('show');
            @endif

        });

    </script>

@endsection
