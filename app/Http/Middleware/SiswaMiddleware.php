<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->level == 'siswa') {
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['username' => 'Hanya Siswa yang dapat mengakses halaman ini.']);
    }
}