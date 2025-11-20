<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Import semua kelas middleware Anda
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KepsekMiddleware;
use App\Http\Middleware\GuruMiddleware;
use App\Http\Middleware\SiswaMiddleware;
use App\Http\Middleware\OrtuMiddleware;
use App\Http\Middleware\KesiswaanMiddleware;
use App\Http\Middleware\BkMiddleware;
use App\Http\Middleware\WaliKelasMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Daftarkan alias (nama panggilan) untuk middleware
        $middleware->alias([
            'admin'       => AdminMiddleware::class,
            'kepsek'      => KepsekMiddleware::class,
            'guru'        => GuruMiddleware::class,
            'siswa'       => SiswaMiddleware::class,
            'ortu'        => OrtuMiddleware::class,
            'kesiswaan'   => KesiswaanMiddleware::class,
            'bk'          => BkMiddleware::class,
            'wali_kelas'  => WaliKelasMiddleware::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();