<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ViewerAuth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        then: function ($router) {
            Route::prefix('api')
                ->middleware('api')
                ->name('api.v1.')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/api.php'));
        }
    )
    // ->withBroadcasting(
    //     __DIR__.'/../routes/channels.php',
    //     ['prefix' => 'api', 'middleware' => ['api']]
    // )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
