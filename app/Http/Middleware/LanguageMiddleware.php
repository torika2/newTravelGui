<?php

namespace App\Http\Middleware;

use Closure;
use App;
use auth;

class LanguageMiddleware
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
        App::setLocale(auth::user()->user_lang);
        return $next($request);
    }
}
