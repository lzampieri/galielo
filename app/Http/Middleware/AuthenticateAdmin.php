<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateAdmin
{
    public function handle($request, Closure $next)
    {
        if( auth()->user() ) {
            if( auth()->user()->isadmin ){
                return $next($request);
            }
        }
        return redirect( route('login-google') );
    }
}
