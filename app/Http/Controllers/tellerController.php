<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class tellerController extends Controller
{
    public function index() {
        $user = Auth::user();
        $teller = $user->petugas;
        return view('teller.dashboard', compact('user','teller'));
    }

    public function penarikan() {
        $user = Auth::user();
        $teller = $user->petugas;
        return view('teller.penarikan', compact('user','teller'));
    }

    public function setoran() {
        $user = Auth::user();
        $teller = $user->petugas;
        return view('teller.setoran', compact('user','teller'));
    }

    public function transfer() {
        $user = Auth::user();
        $teller = $user->petugas;
        return view('teller.transfer', compact('user','teller'));
    }
}
