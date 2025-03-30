<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\NoCache;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Register middleware correctly
        $middleware->group('web', [
            \Illuminate\Session\Middleware\StartSession::class, // Add this!
            \App\Http\Middleware\NoCache::class, // NoCache Middleware
            \App\Http\Middleware\VerifyCsrfToken::class, // CSRF Protection
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
