<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        return null;
    }

    public function handle($request, Closure $next, ...$guards)
    {
        try {
            return parent::handle($request, $next, ...$guards);
        } catch (AuthenticationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }
    }
}
