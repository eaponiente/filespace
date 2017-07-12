<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AuthReseller
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
        if(! Auth::guard('resellers')->check())
            return redirect()->route('resellers');

        return $next($request);
    }
}
