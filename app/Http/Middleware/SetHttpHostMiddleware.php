<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetHttpHostMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $_SERVER['HTTP_HOST'] = '123';

        return $next($request);
    }
}
