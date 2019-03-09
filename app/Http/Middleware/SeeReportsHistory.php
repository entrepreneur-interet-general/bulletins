<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeeReportsHistory
{
    public function handle(Request $request, Closure $next)
    {
        $loggedIn = $request->session()->has('logged_in');

        if ($loggedIn or $request->hasValidSignature()) {
            return $next($request);
        }

        return redirect(route('login'));
    }
}
