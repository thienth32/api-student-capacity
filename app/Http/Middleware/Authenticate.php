<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (auth()->check()) return route('login');
        if (auth()->user()->hasAnyRole(['admin', 'super admin', 'judge', 'teacher'])) return route('login');

        if (!$request->expectsJson()) {
            // $request->session()->put("url_before", $request->fullUrl());
            // dd($request->fullUrl());
            return route('login');
        }
    }
}