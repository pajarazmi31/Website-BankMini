<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SetoranExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {

            return [

                $item->id,
                $item->id_rekening,
                $item->nama_lengkap,
                $item->nama_penyetor,
                $item->jumlah_penyetoran,
                $item->total_biaya,
                $item->created_at,

            ];

        });
    }

    public function headings(): array
    {
        return [

            'ID Setoran',
            'No Rekening',
            'Nama Nasabah',
            'Nama Penyetor',
            'Nominal',
            'Total Biaya',
            'Tanggal'

        ];
    }
}