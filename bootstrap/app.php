<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureUserHasRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => EnsureUserHasRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

    if ($app->environment('production')) {
    $app->useStoragePath(env('APP_STORAGE_PATH', '/tmp/storage'));
    
    $app->configureMonologUsing(function ($monolog) {
        $monolog->pushHandler(new \Monolog\Handler\StreamHandler('php://stderr'));
    });
}