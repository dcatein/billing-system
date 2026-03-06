<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// class ResolveTenant
// {
//     public function handle($request, Closure $next)
//     {
//         if (Auth::check()) {
//             app()->instance('tenant_id', Auth::user()->tenant_id);
//         }

//         return $next($request);
//     }
// }


class ResolveTenant
{
    public function handle($request, Closure $next)
    {
        if ($user = $request->user()) {
            app()->instance('tenant_id', $user->tenant_id);
        }

        return $next($request);
    }
}