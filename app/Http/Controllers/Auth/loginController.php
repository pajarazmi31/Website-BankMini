<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class loginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login( Request $request) {
    // buat cek limit
    // kalo perlu hehe
        // $key = $request->email . $request->ip();

    // validasi login na
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

    // loginnya benar atau tidak
        if(Auth::attempt($request->only('email','password'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = $user->role->nama_role;

    // cek role user
            if($role == 'nasabah' ) {
                return redirect()->route('nasabah.dashboard')->with('success','Kamu Berhasil Masuk Ke Akun Nasabah');
            }

            if($role == 'teller') {
                return redirect()->route('teller.dashboard')->with('success','Kamu Berhasil Masuk Ke Akun Teller');
            }

            if($role == 'supervisor') {
                return redirect()->route('supervisor.dashboard')->with('success', 'Kamu Berhasil Masuk Ke Akun Super Visor');
            }

            if($role == 'customerservice') {
                return redirect()->route('cs.dashboard')->with('success','Kamu Berhasil Masuk Ke Akun Customer Serveice');
            }
        } else {
            return back()->with('failed','kamu gak punya hak akses');
        }
    }

    public function logout(Request $request) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login');
    }
}
