<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BkMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->level === 'bk') {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya BK/Konselor yang dapat mengakses halaman ini.');
    }
}
