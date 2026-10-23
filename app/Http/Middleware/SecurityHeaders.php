<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /*
        |--------------------------------------------------------------------------
        | CSP nonce
        |--------------------------------------------------------------------------
        |
        | Generate one nonce per HTTP response. Blade views that contain
        | inline <script> or <style> tags must use this nonce:
        |
        | <script nonce="{{ request()->attributes->get('csp_nonce') }}">
        | <style nonce="{{ request()->attributes->get('csp_nonce') }}">
        |
        | This lets us remove 'unsafe-inline' from CSP.
        |
        */
        $nonce = base64_encode(random_bytes(16));

        $request->attributes->set('csp_nonce', $nonce);

        $response = $next($request);

        /*
        |--------------------------------------------------------------------------
        | X-Content-Type-Options
        |--------------------------------------------------------------------------
        */
        $response->headers->set(
            'X-Content-Type-Options',
            'nosniff'
        );

        /*
        |--------------------------------------------------------------------------
        | X-Frame-Options
        |--------------------------------------------------------------------------
        */
        $response->headers->set(
            'X-Frame-Options',
            'SAMEORIGIN'
        );

        /*
        |--------------------------------------------------------------------------
        | Content Security Policy
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | - unsafe-inline has been removed.
        | - unsafe-eval has been removed.
        | - broad https: wildcards have been removed.
        |
        | If an inline <script> or <style> is required, add the nonce:
        |
        | <script nonce="{{ request()->attributes->get('csp_nonce') }}">
        | <style nonce="{{ request()->attributes->get('csp_nonce') }}">
        |
        | The external domains below are retained because they are present
        | in the current application configuration / login page.
        |
        */
        $csp = implode('; ', [
            "default-src 'self'",

            // JavaScript
            "script-src 'self' 'nonce-{$nonce}' " .
                "https://accounts.google.com " .
                "https://cdn.jsdelivr.net " .
                "https://stackpath.bootstrapcdn.com",

            // CSS
            "style-src 'self' 'nonce-{$nonce}' " .
                "https://fonts.googleapis.com " .
                "https://cdn.jsdelivr.net " .
                "https://stackpath.bootstrapcdn.com",

            // Fonts
            "font-src 'self' " .
                "https://fonts.gstatic.com " .
                "https://fonts.googleapis.com " .
                "data:",

            // Images
            // No generic "https:" wildcard.
            "img-src 'self' data: blob: " .
                "https://accounts.google.com " .
                "https://lh3.googleusercontent.com " .
                "https://lh4.googleusercontent.com " .
                "https://lh5.googleusercontent.com " .
                "https://lh6.googleusercontent.com",

            // AJAX / Fetch / API / WebSocket
            // Keep same-origin by default. Add your API domains explicitly
            // if the frontend calls a different origin.
            "connect-src 'self' " .
                "https://accounts.google.com",

            // Google Sign-In / OAuth iframe
            "frame-src 'self' " .
                "https://accounts.google.com",

            // Prevent other sites from framing this application
            "frame-ancestors 'self'",

            // HTML forms
            "form-action 'self' https://accounts.google.com",

            // Base URL restriction
            "base-uri 'self'",

            // Object/embed restrictions
            "object-src 'none'",

            // Workers
            "worker-src 'self' blob:",

            // Manifest
            "manifest-src 'self'",
        ]);

        $response->headers->set(
            'Content-Security-Policy',
            $csp
        );

        /*
        |--------------------------------------------------------------------------
        | Referrer-Policy
        |--------------------------------------------------------------------------
        */
        $response->headers->set(
            'Referrer-Policy',
            'strict-origin-when-cross-origin'
        );

        /*
        |--------------------------------------------------------------------------
        | Permissions-Policy
        |--------------------------------------------------------------------------
        */
        $response->headers->set(
            'Permissions-Policy',
            implode(', ', [
                'accelerometer=()',
                'autoplay=()',
                'camera=()',
                'clipboard-read=()',
                'clipboard-write=()',
                'geolocation=()',
                'gyroscope=()',
                'magnetometer=()',
                'microphone=()',
                'payment=()',
                'usb=()',
                'fullscreen=(self)',
            ])
        );

        /*
        |--------------------------------------------------------------------------
        | Strict-Transport-Security (HSTS)
        |--------------------------------------------------------------------------
        |
        | Do not send HSTS on localhost/http development.
        |
        */
        if ($request->isSecure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }
}
