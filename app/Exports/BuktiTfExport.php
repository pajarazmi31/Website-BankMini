<?php

namespace App\Exports;

// Menggunakan model yang sesuai dengan file asli kamu
use App\Models\Bukti_Tf; 
use Maatwebsite\Excel\Concerns\FromQuery; // 1. Diubah dari FromCollection ke FromQuery
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class BuktiTfExport implements FromQuery, WithHeadings, WithMapping // 2. Daftarkan FromQuery di sini
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    // 3. Constructor untuk menangkap data filter tanggal dari Controller
    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // 4. Ganti fungsi collection() menjadi query()
    public function query()
    {
        // Mulai query dasar dari model Bukti_Tf
        $query = Bukti_Tf::query();

        // Jika filter tanggal diisi oleh user, lakukan penyaringan rentang tanggal
        if ($this->startDate && $this->endDate) {
            // Sesuaikan kolom tanggalnya, di sini saya pakai 'created_at' 
            // (Jika di tabelmu nama kolomnya 'datetime_tgl', ganti menjadi 'datetime_tgl')
            $query->whereBetween('datetime_tgl', [
                $this->startDate . ' 00:00:00', 
                $this->endDate . ' 23:59:59'
            ]);
        }

        return $query;
    }

    // 5. HEADING TETAP DIPERTAHANKAN (Aman tidak berubah)
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pengirim',
            'Nama Penerima',
            'No Rekening Penerima',
            'Nominal Admin',
            'Nominal Transfer',
            'Nomor Telepon',
            'Status Verifikasi',
            'Tanggal Transaksi'
        ];
    }

    // 6. MAPPING TETAP DIPERTAHANKAN (Aman tidak berubah)
    public function map($item): array
    {
        return [
            $item->id,
            $item->nama_pengirim,
            $item->nama_penerima,
            $item->id_rekening . ' ',
            'Rp ' . number_format($item->nominal_admin, 0, ',', '.'),
            'Rp ' . number_format($item->jumlah_transfer, 0, ',', '.'),
            $item->no_hp_pengirim,
            ucfirst($item->status_verifikasi),
            $item->datetime_tgl,
        ];
    }
}