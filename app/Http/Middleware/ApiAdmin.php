<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class ApiAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $accessToken = $request->header('Access-Token');
        if ($accessToken !== null) {
            $user = \App\Models\User::where('access_token', $accessToken)->first();
            if ($user->role_id == '2') {
                return $next($request);
            }
            return redirect('/api/allpost');
        }
    }
}
