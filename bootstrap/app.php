<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mockery\Exception\InvalidOrderException;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Exception $e, Request $request) {
            if($request->is('api/*')) {
                if($e instanceof InvalidOrderException ){
                    return response()->json([
                        'message' => $e->getMessage(),
                        'status'  => false,
                    ], 500);
                }
                if($e instanceof AuthorizationException ){
                    return response()->json([
                        'message' => $e->getMessage(),
                        'status'  => false
                    ], 401);
                }
                if($e instanceof AccessDeniedHttpException ){
                    return response()->json([
                        'message' => $e->getMessage(),
                        'status'  => false
                    ], 401);
                }
                if($e instanceof CommandNotFoundException ){
                    return response()->json([
                        'message' => $e->getMessage(),
                        'status'  => false
                    ], 404);
                }

                if($e instanceof MethodNotAllowedHttpException ){
                    return response()->json([
                        'message' => 'Method not allowed',
                        'status'  => false
                    ], 405);
                }

                if($e instanceof NotFoundHttpException){
                    return response()->json([
                        'message' => 'Request not found.',
                        'status'  => false
                    ], 404);
                }

                if($e instanceof JWTException){
                    return response()->json([
                        'message' => 'Unauthorize.',
                        'status'  => false
                    ], 404);
                }
            }
        });
    })->create();
