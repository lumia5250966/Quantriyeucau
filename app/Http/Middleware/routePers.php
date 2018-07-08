<?php

namespace App\Http\Middleware;


use Closure;

class routePers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->session()->has('infoLogin')){
            return $next($request);
        }
        else{
            return redirect('/login');
        }

        // Check if a user is logged in.
    }
}
