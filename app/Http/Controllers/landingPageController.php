<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class landingPageController extends Controller
{
    public function index(){
        // Mengambil data tabel transaksi yang id-nya cuma 2
        $biaya_admin = Transaksi::findOrFail(2);

        return view('index', compact('biaya_admin'));
    }
}
