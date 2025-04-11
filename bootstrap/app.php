<?php

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
            if ($e instanceof Illuminate\Validation\ValidationException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => '資料錯誤',
                    'errors' => $e->errors(),
                    'data' => null,
                ], 422);
            }

            if ($e instanceof Illuminate\Database\Eloquent\ModelNotFoundException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => '找不到資料',
                    'errors' => null,
                    'data' => null,
                ], 404);
            }

            if ($e instanceof App\Exceptions\NotFoundException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => '找不到資料',
                    'errors' => null,
                    'data' => null,
                ], 404);
            }

            if ($e instanceof Illuminate\Auth\AuthenticationException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => '未登入',
                    'errors' => null,
                    'data' => null,
                ], 401);
            }

            // 預設的錯誤處理
            return response()->json([
                'status' => 'failed',
                'message' => '發生錯誤',
                'error' => app()->isLocal() ? $e->getMessage() : null,
                'data' => null,
            ], 500);
        });
    })->create();
