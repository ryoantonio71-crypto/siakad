<?php

use App\Http\Middleware\NoStoreHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureHasROle;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //tamu yang membuka halaman terlindungi dialihkan kesini
        $middleware->redirectGuestsTo(fn () => route('login'));

        //pengguna login yang membuka halaman khusus tamu dialihkan kesini
        $middleware->redirectUsersTo(fn () => route('dashboard'));

        $middleware->alias([
            'role'=> EnsureHasROle::class,
        ]);

        $middleware->appendToGroup('web', [
            NoStoreHeaders::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
