<?php

namespace App\Exports;

use App\Models\Bukti_Tf;
use Maatwebsite\Excel\Concerns\FromCollection;
// 1. PASTIKAN DUA CODE DI BAWAH INI SUDAH DI-IMPORT
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// 2. PASTIKAN DI SINI ADA 'implements WithHeadings'
class BuktiTfExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Bukti_Tf::all();
    }

    // 3. FUNGSI HEADINGS UNTUK MEMBUAT JUDUL KOLOM
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pengirim',
            'Nama Penerima',
            'No Rekening Penerima',
            'Nominal Transfer',
            'Nomor Telepon',
            'Status Verifikasi',
            'Tanggal Transaksi'
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->nama_pengirim,
            $item->nama_penerima,
            $item->id_rekening. ' ',
            'Rp ' . number_format($item->jumlah_transfer, 0, ',', '.'),
            $item->no_hp_pengirim,
            ucfirst($item->status_verifikasi),
            $item->datetime_tgl,
        ];
    }
}