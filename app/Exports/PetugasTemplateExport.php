<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PetugasTemplateExport implements FromCollection, WithHeadings, WithTitle
{
    public function collection()
    {
        // Contoh baris data dummy tanpa kolom Role ID
        return collect([
            [
                'Nama Lengkap Contoh',
                'XII RPL 1',
                'contoh@email.com',
                'password123'
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Nama Petugas',
            'Kelas',
            'Email',
            'Password'
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}