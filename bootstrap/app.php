<?php

use App\Facades\Toast;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;
use Illuminate\Foundation\Application;
use App\Http\Middleware\VerfiyEmailAdmin;
use App\Http\Middleware\HandleInertiaRequests;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
        $middleware->alias([
            'auth_admin' => Admin::class,
            'verify_email_admin' => VerfiyEmailAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if (!app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
                return Inertia::render('ErrorPage', ['status' => $response->getStatusCode()])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            if ($response->getStatusCode() === 419) {
                Toast::error('Sessão expirada! Por favor, tente novamente.');
                return back()->withInput();
            }

            return $response;
        });
    })->create();
