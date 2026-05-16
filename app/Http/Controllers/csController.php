<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Nasabah;
use App\Models\User;
use App\Models\Rekening;
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
        $allNasabah = Nasabah::with('rekening')->get();
        return view('costumerservice.keloladata', compact('user','cs','allNasabah'));
    }

    public function detail(String $id) {
        $user = Auth::user();
        $cs = $user->petugas;
        $nasabah = Nasabah::with('rekening')->findOrFail($id);
        return view('costumerservice.crudnasabah.detail',compact('user','cs','nasabah'));
    }
}
