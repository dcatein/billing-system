<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use App\Shared\Exceptions\DomainException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (DomainException $e, $request) {
            return response()->json([
                'status' => $e->getStatus(),
                'message' => $e->getMessage(),
            ], $e->getStatus());
        });

        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'status' => 422,
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], 422);
        });

    })
    ->create();
