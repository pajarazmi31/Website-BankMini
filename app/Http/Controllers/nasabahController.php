<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class nasabahController extends Controller
{
    public function index() {
        $user = Auth::user();
        $nasabah = $user->nasabah;
        return view('nasabah.dashboard', compact('user','nasabah'));
    }

    public function transfer() {
        $user = Auth::user();
        $nasabah = $user->nasabah;
        return view('nasabah.transfer', compact('user','nasabah'));
    }
}
