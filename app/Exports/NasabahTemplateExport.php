<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NasabahTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    /**
     * Tentukan header kolom untuk template excel import
     */
    public function headings(): array
    {
        return [
            'Nama Nasabah',
            'NIS/NIP',
            'ID Jurusan',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Jenis Kelamin',
            'Jenis Identitas',
            'Agama',
            'Pendidikan',
            'Jabatan',
            'No HP',
            'Email',
            'Alamat',
            'ID Desa',
            'ID Kecamatan',
            'ID Kabupaten',
            'ID Provinsi',
            'Kode Pos',
            'Nama Kontak Darurat',
            'No HP Kontak Darurat',
            'Hubungan Kontak Darurat',
            'Alamat Kontak Darurat'
        ];
    }

    /**
     * Berikan baris contoh data pada template Excel
     */
    public function array(): array
    {
        return [
            [
                'FACHRI PUTRA RAMADHAN',
                '232410333',
                '3',
                'CIAMIS',
                '2007-09-28',
                'Laki-Laki',
                'KTP',
                'Islam',
                'SD',
                'Siswa',
                '08123456789',
                'fachri@gmail.com',
                'Jl. Merdeka No. 12',
                '1101010001',
                '1101010',
                '1101',
                '11',
                '46252',
                'Bapak Fachri',
                '0888888888',
                'Orang Tua',
                'Jl. Merdeka No. 12'
            ]
        ];
    }
}