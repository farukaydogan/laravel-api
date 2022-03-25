<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HttpHeader
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
        $response = $next($request);
        $response->header('X-Api-Version', '1.0.0');
        $response->header('X-Api-Custom', 'Test');
        return $response;
    }
}
