<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AcceptJSON
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->header('Content-Type') !== 'application/json') {
            return response()->json([
                'success' => false,
                'message' => 'Only application/json requests are allowed.'
            ], 415);
        }

        $raw = $request->getContent();
        if ($raw === '' && empty($request->all())) {
            return response()->json([
                'success' => false,
                'message' => 'Request body cannot be empty.'
            ], 400);
        }

        json_decode($raw);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'success' => false,
                'message' => 'Malformed JSON body.'
            ], 400);
        }

        return $next($request);
    }
}
