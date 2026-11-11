<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Http\Request;

class LanguageManager
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
        $locale = $request->user()?->getAttribute('preferred_locale') ?: session('locale', 'en');
        if (in_array($locale, ['en', 'es'], true)) {
            App::setLocale($locale);
            session()->put('locale', $locale);
        }

        return $next($request);
    }
}
