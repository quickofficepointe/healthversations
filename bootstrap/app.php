<?php

use App\Http\Middleware\admin;
use App\Http\Middleware\super;
use App\Http\Middleware\user;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    // Register middleware aliases
    $middleware->alias([
        'admin' => \App\Http\Middleware\admin::class,
        'user' => \App\Http\Middleware\User::class,
        'superuser' => \App\Http\Middleware\Super::class,
        'check.profile.updated' => \App\Http\Middleware\CheckProfileUpdate::class,
    ]);

    // Exclude CSRF verification for specific routes
    $middleware->validateCsrfTokens(except: [
        'payment/success',
        'payment/fail',
        'payment/error',
        'payment/try-later',
    ]);
})

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();