<?php

namespace App\Exports;

use App\Models\Bukti_Tf; 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;          // Diubah ke FromView
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;    // Agar lebar kolom otomatis pas

class BuktiTfExport implements FromView, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    // Constructor tetap dipertahankan untuk menangkap data filter
    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Logika query tetap dipertahankan
    public function queryData()
    {
        $query = Bukti_Tf::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('datetime_tgl', [
                $this->startDate . ' 00:00:00', 
                $this->endDate . ' 23:59:59'
            ]);
        }

        return $query->get(); // Kita ambil datanya dengan ->get() untuk dilempar ke view
    }

    // Fungsi view untuk merender file blade
    public function view(): View
    {
        return view('exports.bukti_tf', [
            'daftar_bukti' => $this->queryData(),
            'startDate' => $this->startDate,
            'endDate' => $this->endDate
        ]);
    }
}