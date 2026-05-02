<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'User not found.',
                ], Response::HTTP_UNAUTHORIZED);
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token has expired.',
            ], Response::HTTP_UNAUTHORIZED);

        } catch (TokenInvalidException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token is invalid.',
            ], Response::HTTP_UNAUTHORIZED);

        } catch (JWTException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token not provided.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
