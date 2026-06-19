<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PetugasTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new MainTemplateSheet(),
            new RoleReferenceSheet(),
        ];
    }
}

class MainTemplateSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Contoh baris data dummy dengan kolom kelas
        return collect([
            [
                'Nama Lengkap Contoh',
                'XII RPL 1', // Kolom Kelas
                'contoh@email.com',
                'password123',
                'Isi dengan ID Role dari sheet sebelah'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Petugas',
            'Kelas',
            'Email',
            'Password',
            'Role ID (Lihat Sheet Referensi Role)'
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}

class RoleReferenceSheet implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Menampilkan role yang relevan sesuai query index Anda
        return Role::whereIn('nama_role', ['supervisor', 'customerservice', 'teller'])
            ->get(['id', 'nama_role']);
    }

    public function headings(): array
    {
        return ['ID Role', 'Nama Role'];
    }

    public function title(): string
    {
        return 'Referensi ID Role';
    }
}