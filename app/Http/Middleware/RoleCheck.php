<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil user yang sedang login
        $user = $request->user();

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        // Contoh penggunaan di route: 'role:petugas,kepala'
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak cocok, lempar ke halaman 403 (Forbidden) atau redirect
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
