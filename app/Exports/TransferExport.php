<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransferExport implements FromView
{
    protected $data;
    protected $judul;

    public function __construct($data, $judul)
    {
        $this->data = $data;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('exports.transfer', [
            'data' => $this->data,
            'judul' => $this->judul,
        ]);
    }
}