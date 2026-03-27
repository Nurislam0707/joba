<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Priority: route parameter -> session -> config
        $locale = $request->route('locale') ?? Session::get('locale') ?? config('app.locale');

        // Validate against allowed locales
        $allowed = config('app.locales') ?? config('app.available_locales') ?? ['en', 'ru', 'kz'];
        if ($locale && in_array($locale, $allowed, true)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            // ensure default is set
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}