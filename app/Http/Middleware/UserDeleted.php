<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserDeleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->deleted == 1) {
            Auth::guard('api')->logout();
            return response()->json(['success' => false,'message' => 'Email not registered with us.','result' => '']);
        } else {
            return $next($request);
        }
    }
}
