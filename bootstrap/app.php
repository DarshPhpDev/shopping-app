<?php

use App\Http\Middleware\AuthenticateApiWithSanctum;
use App\Http\Middleware\EnsureJsonContentType;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prependToGroup('api', EnsureJsonContentType::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, $e, Request $request) {
            return match (true) {
                $e instanceof AuthenticationException => api_response()
                                                        ->error()
                                                        ->message('Unauthenticated!')
                                                        ->code(401)
                                                        ->send(),

                $e instanceof ValidationException => api_response()
                                                    ->error()
                                                    ->code(422)
                                                    ->message('Validation Errors!')
                                                    ->validationErrors($e->validator->messages()->get('*'))
                                                    ->send(),

                $e instanceof NotFoundHttpException => api_response()
                                                    ->error()
                                                    ->code(404)
                                                    ->send(),

                $e instanceof ThrottleRequestsException => api_response()
                                                    ->error()
                                                    ->code(429)
                                                    ->message('Too many requests. Please try again later.')
                                                    ->send(),

                default => api_response()
                        ->error()
                        ->code(500)
                        ->message($e->getMessage())
                        ->send(),
            };
        });
    })->create();
