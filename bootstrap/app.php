<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Enregistrer les middlewares
        $middleware->alias([
            'admin'               => \App\Http\Middleware\AdminMiddleware::class,
            'super_admin'         => \App\Http\Middleware\SuperAdminMiddleware::class,
            'chef_projet'         => \App\Http\Middleware\ChefProjetMiddleware::class,
            'must_change_password' => \App\Http\Middleware\MustChangePasswordMiddleware::class,
        ]);

        // Appliquer must_change_password à toutes les routes web
        $middleware->web(append: [
            \App\Http\Middleware\MustChangePasswordMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();