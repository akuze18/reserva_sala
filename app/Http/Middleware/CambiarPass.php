<?php

namespace App\Http\Middleware;

use Closure;

class CambiarPass
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
        if(actualUser()->cambiar_pass){
            return redirect()->route('nueva_pass');
        }
        return $next($request);
    }
}
