<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
        ->HEADER('Access-Control-Allow-Origin', '*')
        ->HEADER('Access-Control-Allow-Credentials', true)
        ->HEADER('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->HEADER('Access-Control-Allow-Header','X-Requested-With, content-type, X-Token-Auth, Authorization');
    }
}
