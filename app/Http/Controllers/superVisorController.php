<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Bukti_Tf;

class superVisorController extends Controller
{
    public function index() {
        $user = Auth::user();
        $super = $user->petugas;
        return view('supervisor.dashboard', compact('user','super'));
    }

    public function verifikasi(){
        $bukti_tf = Bukti_Tf::all();
        return view('supervisor.verifikasi.transfer', compact('bukti_tf'));
    }

    public function detail($id){
        $data = Bukti_Tf::find($id);

        return view('supervisor.verifikasi.transfer.detail', compact('data'));
    }
}
