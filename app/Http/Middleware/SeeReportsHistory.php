<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeeReportsHistory
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->has('logged_in')) {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
