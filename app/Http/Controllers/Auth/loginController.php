<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('failed', 'Email atau password salah');
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->role->nama_role;

        if ($role == 'nasabah') {
            return redirect()->route('nasabah.dashboard');
        }

        if ($role == 'supervisor') {
            return redirect()->route('supervisor.dashboard');
        }

        if (in_array($role, ['teller', 'customerservice'])) {

            $pending = VerifikasiLogin::create([
                'user_id' => $user->id,
                'status' => 'pending'
            ]);

            session([
                'verifikasi_login_id' => $pending->id,
                'user_id_verifikasi' => $user->id,
            ]);

            Auth::logout();

            return redirect()->route('auth.verifikasi');
        }

        Auth::logout();

        return back()->with('failed', 'Role tidak dikenali');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
