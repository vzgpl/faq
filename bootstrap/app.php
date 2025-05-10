<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'api.client' => \App\Http\Middleware\ApiClientMiddleware::class,
        ]);
        // глобальный стек:
       // $middleware->append();

        // в группу middleware:
         $middleware->appendToGroup('api', \Illuminate\Http\Middleware\HandleCors::class);
         $middleware->appendToGroup('api', \App\Http\Middleware\CorsMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
