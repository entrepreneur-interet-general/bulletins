<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReferrerPolicy
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
            $response = $next($request);

            if (get_class($response) != StreamedResponse::class) {
                $response->header('Referrer-Policy', 'no-referrer, strict-origin-when-cross-origin');
            }

            return $response;
    }
}
