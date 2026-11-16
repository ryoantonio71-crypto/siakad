<?php

use App\Http\Middleware\NoStoreHeaders;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EnsureHasROle;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
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
        // semua error pada /api/* dijawab JSON, walau tanpa header Accept
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

         // pesan 404 yang ringkas, tanpa membocorkan nama kelas model
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Data atau alamat tidak ditemukan.',
                ], 404);
            }
        });
    })     
    ->create();
