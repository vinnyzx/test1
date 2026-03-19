<?php

<<<<<<< HEAD
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckVerifiedIfAuthenticated;
=======
use App\Http\Middleware\AdminMiddleware;
>>>>>>> vinh
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
<<<<<<< HEAD
            'role' => CheckRole::class,
            'check.verified' => CheckVerifiedIfAuthenticated::class
=======
            'admin' => AdminMiddleware::class,
>>>>>>> vinh
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
