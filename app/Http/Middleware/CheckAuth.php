<?php

namespace App\Http\Middleware;

use Closure;
use Session;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckAuth extends Middleware
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
        if(!Session::get('CheckAuth'))
            return redirect('login');
        return $next($request);
    }
}
