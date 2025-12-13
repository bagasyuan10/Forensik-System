<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN emailnya sesuai
        if (Auth::check() && Auth::user()->email === 'aqewtzy@gmail.com') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan admin, tendang ke halaman depan (Home)
        // Atau bisa pakai abort(403) untuk menampilkan error "Forbidden"
        return redirect('/')->with('error', 'Anda tidak memiliki akses Admin!');
    }
}