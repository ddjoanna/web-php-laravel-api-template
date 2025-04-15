<?php

use App\Services\ApiResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, $request) {
            $response = app(ApiResponse::class);
            if ($e instanceof Illuminate\Validation\ValidationException) {
                return $response->error(422, '資料錯誤', $e->errors());
            }

            if ($e instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
                return $response->error(404, '找不到資料', null);
            }

            if ($e instanceof App\Exceptions\NotFoundException) {
                return $response->error(404, '找不到資料', null);
            }

            if ($e instanceof Illuminate\Auth\AuthenticationException) {
                return $response->error(401, '未登入', null);
            }

            // 預設的錯誤處理
            return $response->error(500, '發生錯誤', app()->isLocal() ? $e->getMessage() : null);
        });
    })->create();
