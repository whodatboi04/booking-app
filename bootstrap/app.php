<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
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
            if ($request->is('api/auth/*') || $request->is('api/v1/*')  ) {
                $exceptionMap = [
                    InvalidOrderException::class => [
                        'message' => 'The order you placed is invalid or cannot be processed at this time.',
                        'status' => 500
                    ],
                    AuthorizationException::class => [
                        'message' => 'You are not authorized to perform this action. Please check your permissions.',
                        'status' => 401
                    ],
                    AccessDeniedHttpException::class => [
                        'message' => 'Access denied. You do not have the required privileges to access this resource.',
                        'status' => 401
                    ],
                    CommandNotFoundException::class => [
                        'message' => 'The specified command could not be found. Please verify the command name.',
                        'status' => 404
                    ],
                    MethodNotAllowedHttpException::class => [
                        'message' => 'The request method is not allowed for this endpoint. Please check the API documentation.',
                        'status' => 405
                    ],
                    JWTException::class => [
                        'message' => 'Your token is missing, expired, or invalid. Please log in again.',
                        'status' => 401
                    ],
                    NotFoundHttpException::class => [
                        'message' => 'The resource you’re trying to access doesn’t exist.',
                        'status' => 404
                    ],
                    ValidationException::class => [
                        'message' => $e->getMessage(),
                        'status' => 422
                    ]
                ];    
                foreach ($exceptionMap as $class => $details) {
                    if ($e instanceof $class) {
                        $response = [
                            'message' => $details['message'],
                            'status'  => $details['status'],
                            'success'  => $details['status'] < 400 ? true : false,
                        ];

                        if (config('app.env') === 'local') {
                            $response['error'] = $e->getMessage();
                        }
                        return response()->json($response, $details['status']);
                    }
                }
                $response = [
                    'message' => 'An unexpected error occurred. Please try again later.',
                    'status'  => false,
                ];
                if (config('app.env') === 'local') {
                    $response['error'] = $e->getMessage();
                }
                return response()->json($response, 500);
            }
        });
    })->create();
