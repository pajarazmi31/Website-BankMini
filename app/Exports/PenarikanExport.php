<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenarikanExport implements FromCollection, WithHeadings
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
                'Nama Penarik'      => $item->nama_penarik,
                'No Rekening'       => $item->id_rekening,
                'Jumlah Penarikan'  => $item->jumlah_penarikan,
                'Petugas'           => $item->petugas->nama_petugas ?? '-',
                'Tanggal'           => $item->created_at->format('d-m-Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Penarik',
            'No Rekening',
            'Jumlah Penarikan',
            'Petugas',
            'Tanggal'
        ];
    }
}