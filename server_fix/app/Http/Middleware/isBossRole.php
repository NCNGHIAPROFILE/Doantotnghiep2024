<?php

namespace App\Http\Middleware;

use App\Models\RoleCompany;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class isBossRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken();
            if (!$token || $token == '' || $token === null || empty($token)) {
                return response()->json(['message' => 'User is not a login']);
            }
            $user = JWTAuth::parseToken()->authenticate();
            if(!$user){
                return response()->json(['message' => 'User is not a login']);
            }
            if ($user->role == "admin") {
                return $next($request);
            }
            return response()->json(['message' => 'User is not a admin']);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['message' => 'User is not a login']);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'Token khong dung']);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['message' => 'User is not a login']);
        }
    }
}
