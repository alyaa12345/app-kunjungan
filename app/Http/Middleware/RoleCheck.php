<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // 1. Cek apakah user sudah login? Jika belum, suruh login.
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. LOGIKA UTAMA:
        // Bandingkan Role di Database dengan Role yang diminta Halaman
        // Contoh: Jika Database='kepala' DAN Halaman butuh='kepala' -> BOLEH MASUK.
        if (Auth::user()->role == $role) {
            return $next($request);
        }

        // 3. Jika tidak cocok, tendang keluar.
        return abort(403, 'Akses Ditolak! Halaman ini khusus untuk: ' . $role);
    }
}
