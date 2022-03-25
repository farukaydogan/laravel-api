<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Str;

class ApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        if ($auth) {
            $token = str_replace('Bearer ', '', $auth);
            if (!$token) {
                return response()->json([
                    'message' => 'No Bearer Token!',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
            $user = User::whereApiToken($token)->first();
            if (!$user) {
                return response()->json([
                    'message' => 'Invalid Bearer Token!',
                ], JsonResponse::HTTP_UNAUTHORIZED);
            }
            auth()->setUser($user);
            // $user::whereApiToken($token)->update(['api_token'=>Str::random(60)]);
            return $next($request);
        }
        return response()->json([
            'message' => 'Unauthorized, not a valid Bearer Token!',
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }
}
