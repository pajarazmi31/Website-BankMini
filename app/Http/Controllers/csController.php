<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class csController extends Controller
{
    public function index() {
        $user = Auth::user();
        $cs = $user->petugas;
        return view('costumerservice.dashboard', compact('user','cs'));
    }

    public function keloladata() {
        $user = Auth::user();
        $cs = $user->petugas;
        return view('costumerservice.keloladata', compact('user','cs'));
    }
}
