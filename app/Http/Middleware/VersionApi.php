<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VersionApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $version)
    {
        if ($version == config('app.api_version')) return $next($request);
        return response()->json(["message" => "No api version $version"]);
    }
}