<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login( Request $request) {
    // buat cek limit
    // kalo perlu hehe 
        $key = $request->email . $request->ip();

    // validasi login na
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

    // loginnya benar atau tidak
        if(Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();
            $request->session()->regenerate();

    // cek role user
            if($user->role === 'nasabah' ) {
                return redirect()->route('halaman.login')->with('success','Kamu Berhasil Masuk Ke Akun Nasabah');
            }

            if($user->role === 'teller') {
                return redirect()->route('halaman.login')->with('success','Kamu Berhasil Masuk Ke Akun Teller');
            }

            if($user->role === 'superVisor') {
                return redirect()->route('halaman.login')->with('success', 'Kamu Berhasil Masuk Ke Akun Super Visor');
            }

            if($user->role === 'customerSer') {
                return redirect()->route('halaman.login')->with('success','Kamu Berhasil Masuk Ke Akun Customer Serveice');
            } else {
                return redirect()->route('halaman.login')->with('failed' ,'Hak Akses Tidak Ada');
            }
        }


    }
}
