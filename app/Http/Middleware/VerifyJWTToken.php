<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class VerifyJWTToken extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                throw new Exception('User not found');
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Token is not valid'
            ], 401);
        }

        return $next($request);
    }
}
