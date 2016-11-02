<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\DBHelper;
use Auth;

class TenantDBMiddleware
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
        DBHelper::configureConnection(Auth::user()->db_alias);
        return $next($request);
    }
}
