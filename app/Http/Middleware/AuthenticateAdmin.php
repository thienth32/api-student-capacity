<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthenticateAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'super admin', 'judge', 'teacher']))
            return $this->redirectToCatch($request);
        return $next($request);
    }

    public function redirectToCatch($request)
    {
        if (!$request->expectsJson()) {
            throw new AuthenticationException(
                'Unauthenticated.',
                [],
                auth()->check() ? route('logout') : route('login')
            );
        }
    }
}