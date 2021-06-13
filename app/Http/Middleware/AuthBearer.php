<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class AuthBearer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('auth_key', $request->bearerToken())->first();
        if (!Str::startsWith($request->header('Authorization'), 'Bearer') || $user === null) {
            return response([
                'message' => 'Unauthorized',
            ], 401);
        }
        return $next($request);
    }
}
