<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        // Получаем локаль из сессии или используем по умолчанию
        $locale = $request->session()->get('locale', config('app.locale'));
        
        // Устанавливаем локаль для приложения
        app()->setLocale($locale);
        
        return $next($request);
    }
}