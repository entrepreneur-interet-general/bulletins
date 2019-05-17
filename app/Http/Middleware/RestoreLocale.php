<?php

namespace App\Http\Middleware;

use Closure;

class RestoreLocale
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
        app()->setLocale($request->session()->get('locale', config()->get('app.locale')));

        return $next($request);
    }
}
