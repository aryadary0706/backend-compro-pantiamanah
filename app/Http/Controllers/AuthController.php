<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * Login — kembalikan JWT access token.
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid credentials.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout — invalidate token yang sedang aktif.
     */
    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status'  => 'success',
            'message' => 'Successfully logged out.',
        ]);
    }

    /**
     * Refresh — tukar token lama dengan token baru.
     */
    public function refresh(): JsonResponse
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Could not refresh token.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($newToken);
    }

    /**
     * Me — kembalikan data user yang sedang login.
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data'   => Auth::guard('api')->user(),
        ]);
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    private function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'status'       => 'success',
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'expires_in'   => config('jwt.ttl') * 60, // ambil dari config/jwt.php
        ]);
    }
}
