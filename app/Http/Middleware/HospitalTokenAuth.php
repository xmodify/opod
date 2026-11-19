<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Hospital;
use Laravel\Sanctum\PersonalAccessToken;

class HospitalTokenAuth
{
    /**
     * Handle an incoming request for hospital API authentication.
     * Supports Sanctum Bearer tokens, Apache CGI HTTP_AUTHORIZATION redirects,
     * request body tokens, and direct hospitals.token_api fallback.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. If already authenticated via default/sanctum guard
        if (Auth::guard('sanctum')->check()) {
            $user = Auth::guard('sanctum')->user();
            Auth::setUser($user);
            $request->setUserResolver(fn () => $user);
            return $next($request);
        }

        // 2. Extract token from all possible locations
        $token = $request->bearerToken();
        if (!$token) {
            $authHeader = $request->header('Authorization') 
                ?? $request->header('X-Authorization') 
                ?? $request->server('HTTP_AUTHORIZATION')
                ?? $request->server('REDIRECT_HTTP_AUTHORIZATION');
            if ($authHeader && preg_match('/Bearer\s+(.+)$/i', $authHeader, $matches)) {
                $token = trim($matches[1]);
            }
        }
        if (!$token) {
            $token = $request->input('token') ?? $request->input('api_token') ?? $request->query('token');
        }

        if (!$token) {
            return response()->json([
                'status'  => 'unauthorized',
                'message' => 'Unauthenticated: Token is missing from Authorization header (Bearer token) or request body.'
            ], 401);
        }

        $token = trim((string)$token);

        // 3. Try to resolve via Sanctum PersonalAccessToken directly
        $accessToken = PersonalAccessToken::findToken($token);
        if ($accessToken) {
            $hospital = $accessToken->tokenable;
            if ($hospital instanceof Hospital && ($hospital->is_active ?? true)) {
                $hospital = $hospital->withAccessToken($accessToken);
                Auth::setUser($hospital);
                Auth::guard('sanctum')->setUser($hospital);
                $request->setUserResolver(fn () => $hospital);
                return $next($request);
            }
        }

        // 4. Fallback: Check token_api directly in hospitals table
        $hospital = Hospital::where('token_api', $token)->where('is_active', true)->first();
        if ($hospital) {
            $hospital = $hospital->withAccessToken(new \Laravel\Sanctum\TransientToken);
            Auth::setUser($hospital);
            Auth::guard('sanctum')->setUser($hospital);
            $request->setUserResolver(fn () => $hospital);
            return $next($request);
        }

        return response()->json([
            'status'  => 'unauthorized',
            'message' => 'Unauthenticated: Invalid or expired token.'
        ], 401);
    }
}
