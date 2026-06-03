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
        $nasabahHariIni = Nasabah::whereDate('created_at', today())->count();
        $nasabah = Nasabah::with('rekening')
        ->whereHas('rekening', function ($query) {
            $query->where('status_akun', 'non-aktif');
        })
        ->get();
        $jumlahNasabah = User::where('role_id','1')->count();
        $jumlahPending = Rekening::where('status_akun','non-aktif')->count();
        return view('costumerservice.dashboard', compact('user','cs','nasabahHariIni','nasabah','jumlahNasabah','jumlahPending'));
    }


    public function detail(String $id) {
        $user = Auth::user();
        $cs = $user->petugas;
        $nasabah = Nasabah::with('rekening','jurusan')->findOrFail($id);
        return view('costumerservice.crudnasabah.detail',compact('user','cs','nasabah'));
    }
}
