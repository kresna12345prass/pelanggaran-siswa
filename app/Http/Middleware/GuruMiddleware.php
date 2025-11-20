<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuruMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->level == 'guru' || Auth::user()->level == 'admin')) {
             // Admin boleh akses halaman guru
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['username' => 'Anda tidak memiliki hak akses Guru.']);
    }
}