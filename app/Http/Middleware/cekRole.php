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
        $user = Auth::user();
        $userRole = $user->role->nama_role;

        if( $userRole != $role ) {
            abort(403, 'Akses Di Tolak');
        }

        return $next($request);
    }
}
