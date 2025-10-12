<?php

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
        // Özel middleware alias'larını kaydet
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'bayi' => \App\Http\Middleware\BayiMiddleware::class,
            'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'store_admin' => \App\Http\Middleware\StoreAdminMiddleware::class,
            'dealer_admin' => \App\Http\Middleware\DealerAdminMiddleware::class,
            'webhook.verify' => \App\Http\Middleware\WebhookVerifyMiddleware::class,
            'desktop.verify' => \App\Http\Middleware\DesktopVerifyMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
