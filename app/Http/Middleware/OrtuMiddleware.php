<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrtuMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->level == 'ortu') {
            return $next($request);
        }
        return redirect()->route('login')->withErrors(['username' => 'Hanya Orang Tua yang dapat mengakses halaman ini.']);
    }
}