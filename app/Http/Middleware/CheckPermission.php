<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Alternative.
 * Currently unavailable.
 * To use: go to bootstrap/app.php
 */
class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = Auth::user();

        $role = $user->role()->with('permissions')->first();

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'No role assigned.'
            ], 403);
        }

        $permissions = $role->permissions->pluck('name');

        if (!$permissions->contains($permission)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to perform this action.'
            ], 403);
        }

        return $next($request);
    }
}
