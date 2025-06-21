<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login DAN merupakan admin
        if (Auth::check() && Auth::user()->is_admin == 1) {
            // Jika ya, lanjutkan request ke controller tujuan (dashboard)
            return $next($request);
        }

        // Jika tidak, hentikan proses dan tampilkan halaman "403 Forbidden"
        // atau arahkan ke halaman lain
        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES.');
        // atau: return redirect('/')->with('error', 'Anda tidak memiliki hak akses.');
    }
}
