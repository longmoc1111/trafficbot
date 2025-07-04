<?php

use App\Http\Middleware\CheckAdminMiddleware;
use App\Http\Middleware\CheckUserMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:[
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/auth.php'
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "admin"=>CheckAdminMiddleware::class,
            "user"=>CheckUserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
