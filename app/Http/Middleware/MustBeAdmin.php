<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MustBeAdmin
{
    /**
     * Handle an incoming request.
     * //Middleware is like a layers of the onion.
     * //So when request comes to you app
     * //request working its way through series of onions
     * //until it hits the core of your application :)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()?->username !== 'admin'){
            abort(Response::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
