<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class UserAuth
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
        if( ! Auth::check() )
            return redirect()->to('/');
        
        return $next($request);
    }
}
