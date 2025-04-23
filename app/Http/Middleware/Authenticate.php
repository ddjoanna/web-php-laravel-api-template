<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as MiddlewareAuthenticate;

class Authenticate extends MiddlewareAuthenticate
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            abort(response()->json(['message' => 'Unauthenticated.'], 401));
        }
    }
}
