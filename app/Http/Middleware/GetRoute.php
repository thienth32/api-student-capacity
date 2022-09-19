<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GetRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() == "GET") {
            if ($request->session()->has('url-history')) {
                $request->session()->push('url-history', [
                    "time" => date("Y-m-d H:i:s"),
                    "url" => $request->fullUrl()
                ]);
            } else {
                $request->session()->put('url-history', [
                    [
                        "time" => date("Y-m-d H:i:s"),
                        "url" => $request->fullUrl()
                    ]
                ]);
            }
        }
        return $next($request);
    }
}