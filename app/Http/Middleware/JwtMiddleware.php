<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class JwtMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'success' => false,
                    'error' => 'Token Invalido',
                    'message' => 'Token Invalido',
                ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'success' => false,
                    'error' => 'Token Expirado',
                    'message' => 'Token Expirado'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Token No Encontrado Autorizacion',
                    'message' => 'Token No Encontrado Autorizacion'
                ]);
            }
        }
        return $next($request);
    }
}