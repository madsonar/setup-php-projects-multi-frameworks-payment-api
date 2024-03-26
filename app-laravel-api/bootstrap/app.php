<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $statusCode = $e instanceof ModelNotFoundException ? 404 : 500;
                if ($e instanceof HttpException) {
                    $statusCode = $e->getStatusCode();
                }

                $response = [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];

                if (config('app.debug')) {
                    $response['trace'] = $e->getTrace();
                }

                return response()->json($response, $statusCode);
            }
        });

        $exceptions->report(function (Throwable $e) {
        });
    })->create();
