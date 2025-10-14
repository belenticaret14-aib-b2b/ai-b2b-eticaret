<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...existing code...
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // ...existing code...
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'bayi' => \App\Http\Middleware\BayiMiddleware::class,
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
        'super_admin' => \App\Http\Middleware\SuperAdminMiddleware::class,
        'store_admin' => \App\Http\Middleware\StoreAdminMiddleware::class,
        'dealer_admin' => \App\Http\Middleware\DealerAdminMiddleware::class,
        'webhook_verify' => \App\Http\Middleware\WebhookVerifyMiddleware::class,
        'desktop_verify' => \App\Http\Middleware\DesktopVerifyMiddleware::class,
        'theme' => \App\Http\Middleware\ThemeMiddleware::class,
    ];
}
