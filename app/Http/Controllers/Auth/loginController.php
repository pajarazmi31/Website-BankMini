<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\VerifikasiLogin;

class loginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Jika ini adalah submit dari Pop-up Modal (Pilih Role)
        if ($request->filled('pilih_role') && session()->has('temp_user_id')) {
            Auth::loginUsingId(session('temp_user_id'));
            $user = Auth::user();
            $pilihanRole = $request->pilih_role;
            
            session()->forget('temp_user_id'); 
        } 
        // 2. Jika ini adalah login pertama kali dari Form Utama
        else {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return back()->with('failed', 'Email atau password salah');
            }

            $user = Auth::user();
            $roleUtama = $user->role ? $user->role->nama_role : null;
            $roleKedua = $user->role2 ? $user->role2->nama_role : null;

            // Jika punya 2 role, tahan proses dan tampilkan modal
            if ($roleKedua) {
                Auth::logout(); 
                session(['temp_user_id' => $user->id]); 
                
                return view('auth.login', [
                    'showRoleModal' => true,
                    'roleUtama' => $roleUtama,
                    'roleKedua' => $roleKedua
                ]);
            }

            $pilihanRole = $roleUtama;
        }

        $roleUtama = $user->role ? $user->role->nama_role : null;
        $roleKedua = $user->role2 ? $user->role2->nama_role : null;

        if ($pilihanRole !== $roleUtama && $pilihanRole !== $roleKedua) {
            Auth::logout();
            return redirect()->route('login')->with('failed', 'Role tidak valid.');
        }

        $request->session()->regenerate();
        session(['active_role' => $pilihanRole]);

        if ($pilihanRole == 'nasabah') {
            return redirect()->route('nasabah.dashboard');
        }

        if ($pilihanRole == 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        }

        if (in_array($pilihanRole, ['teller', 'customerservice'])) {
            $pending = VerifikasiLogin::create([
                'user_id' => $user->id,
                'status' => 'pending'
            ]);

            session([
                'verifikasi_login_id' => $pending->id,
                'user_id_verifikasi' => $user->id,
                'role_verifikasi' => $pilihanRole 
            ]);

            Auth::logout();
            return redirect()->route('auth.verifikasi');
        }

        Auth::logout();
        return redirect()->route('login')->with('failed', 'Role tidak dikenali');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}