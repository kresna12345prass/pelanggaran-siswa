<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KesiswaanMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->level == 'kesiswaan') {
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['username' => 'Anda tidak memiliki hak akses Kesiswaan.']);
    }
}
