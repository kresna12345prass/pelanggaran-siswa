<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WaliKelasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Izinkan jika user adalah 'wali_kelas' ATAU 'admin'
        if (Auth::check() && (Auth::user()->level == 'wali_kelas' || Auth::user()->level == 'admin')) {
            return $next($request);
        }

        return redirect()->route('login')->withErrors(['email' => 'Anda tidak memiliki hak akses Wali Kelas.']);
    }
}