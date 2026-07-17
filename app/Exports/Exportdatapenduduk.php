<?php

namespace App\Exports;

use App\Models\Datapenduduk;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class Exportdatapenduduk extends StringValueBinder implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithCustomValueBinder
{
    /**
     * Query data yang akan diekspor.
     *
     * FromQuery membuat data diproses secara bertahap/chunk,
     * sehingga lebih aman untuk jumlah data besar.
     */
    public function query()
    {
        return Datapenduduk::query()
            ->with([
                'detailkk.kk',
                'agama',
                'pendidikan',
                'pekerjaan',
                'goldar',
                'status',
            ])
            ->whereIn('Datak', [
                'tetap',
                'tidaktetap',
            ])
            ->orderBy('id', 'asc');
    }

    /**
     * Menentukan isi dan urutan setiap baris Excel.
     */
    public function map($penduduk): array
    {
        return [
            // (string) $penduduk->id,

            // No KK dibuat string agar 16 digit tidak berubah.
            (string) ($penduduk->detailkk?->kk?->nokk ?? ''),

            // NIK dibuat string agar 16 digit tidak berubah.
            (string) ($penduduk->nik ?? ''),

            $penduduk->gelarawal ?? '',
            $penduduk->nama ?? '',
            $penduduk->gelarakhir ?? '',

            $this->formatJenisKelamin(
                $penduduk->jenis_kelamin
            ),

            $penduduk->tempat_lahir ?? '',

            $penduduk->tanggal_lahir
                ? date(
                    'Y-m-d',
                    strtotime($penduduk->tanggal_lahir)
                )
                : '',

            $penduduk->agama?->nama ?? '',
            $penduduk->pendidikan?->nama ?? '',
            $penduduk->pekerjaan?->nama ?? '',
            $penduduk->goldar?->nama ?? '',
            $penduduk->status?->nama ?? '',

            // Mengikuti tampilan DataTables: hanya tahun.
            $penduduk->tanggal_perkawinan
                ? date(
                    'Y',
                    strtotime($penduduk->tanggal_perkawinan)
                )
                : '',

            $penduduk->hubungan ?? '',
            $penduduk->ayah ?? '',
            $penduduk->ibu ?? '',
            $penduduk->alamat ?? '',

            (string) (
                $penduduk->RT
                ?? $penduduk->rt
                ?? ''
            ),

            (string) (
                $penduduk->RW
                ?? $penduduk->rw
                ?? ''
            ),

            $penduduk->Datak
                ?? $penduduk->datak
                ?? '',
        ];
    }

    /**
     * Header Excel.
     */
    public function headings(): array
    {
        return [
            // 'ID',
            'No KK',
            'NIK',
            'Gelar Awal',
            'Nama',
            'Gelar Akhir',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Pendidikan',
            'Pekerjaan',
            'Golongan Darah',
            'Status Perkawinan',
            'Tahun Perkawinan',
            'Hubungan Dalam Keluarga',
            'Nama Ayah',
            'Nama Ibu',
            'Alamat',
            'RT',
            'RW',
            'Status Kependudukan',
        ];
    }

    /**
     * Mengubah kode jenis kelamin menjadi keterangan.
     */
    private function formatJenisKelamin($jenisKelamin): string
    {
        $jenisKelamin = strtoupper(
            trim((string) $jenisKelamin)
        );

        return match ($jenisKelamin) {
            '1',
            'L',
            'LK',
            'LAKI-LAKI',
            'LAKI LAKI',
            'PRIA' => 'Laki-laki',

            '0',
            '2',
            'P',
            'PR',
            'PEREMPUAN',
            'WANITA' => 'Perempuan',

            default => $jenisKelamin,
        };
    }
}
