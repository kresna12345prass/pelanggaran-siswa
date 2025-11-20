<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KepsekMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->level == 'kepsek' || Auth::user()->level == 'admin')) {
            // Admin boleh akses halaman kepsek
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['username' => 'Anda tidak memiliki hak akses Kepala Sekolah.']);
    }
}