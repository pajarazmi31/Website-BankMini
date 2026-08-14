<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class cekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        // Ambil role aktif dari session (akan kita set di Controller Login nanti)
        $activeRole = session('active_role') ?? $user->role->nama_role;

        if ($activeRole != $role) {
            abort(403, 'Akses Di Tolak. Anda sedang login sebagai ' . $activeRole);
        }

        return $next($request);
    }
}
