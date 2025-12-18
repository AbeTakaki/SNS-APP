<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at:'*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;

                if ($e instanceof HttpExceptionInterface) {
                    $status = $e->getStatusCode();
                }else {
                    if($e instanceof AuthenticationException) $status = Response::HTTP_UNAUTHORIZED;
                    if($e instanceof AuthorizationException) $status = Response::HTTP_FORBIDDEN;
                    if($e instanceof ValidationException) $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                }

                return response()->json([
                    'status' => $status,
                    'message' => $e->getMessage(),
                ], $status);
            }
        });
    })->create();
