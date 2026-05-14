<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $supervisor = $user->petugas;
        return view('supervisor.dashboard', compact('user','supervisor'));
    }

    public function datanasabah() {
        $user = Auth::user();
        $supervisor = $user->petugas;
        return view('supervisor.datanasabah', compact('user','supervisor'));
    }

    public function datapetugas() {
        $user = Auth::user();
        $supervisor = $user->petugas;
        return view('supervisor.datapetugas', compact('user','supervisor'));
    }

    public function registrasirekening() {
        $user = Auth::user();
        $supervisor = $user->petugas;
        return view('supervisor.verifikasi.registrasirekening', compact('user','supervisor'));
    }

    public function transfer() { 
        $user = Auth::user();
        $supervisor = $user->petugas;
        return view('supervisor.verifikasi.transfer', compact('user','supervisor'));
    }
}
