<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransferExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {

            $biayaAdmin = $item->total_biaya - $item->jumlah_transfer;

            return [
                'Tanggal'           => $item->created_at->format('d-m-Y H:i'),
                'Rekening Pengirim' => $item->id_rekening_pengirim,
                'Rekening Penerima' => $item->id_rekening_penerima,
                'Nominal Transfer'  => 'Rp ' . number_format($item->jumlah_transfer, 0, ',', '.'),
                'Biaya Admin'       => 'Rp ' . number_format($biayaAdmin, 0, ',', '.'),
                'Total Biaya'       => 'Rp ' . number_format($item->total_biaya, 0, ',', '.'),
                'Catatan'           => $item->catatan ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Rekening Pengirim',
            'Rekening Penerima',
            'Nominal Transfer',
            'Biaya Admin',
            'Total Biaya',
            'Catatan'
        ];
    }
}