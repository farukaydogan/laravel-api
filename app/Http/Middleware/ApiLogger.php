<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLogger
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        if (env('APP_LOGGER', true)) {
            $startTime = LARAVEL_START;
            $endTime = microtime(true);
            $log = '[' . date('d/m/Y - H:i:s') . ']';
            $log .= '[' . ($endTime - $startTime) * 100 . 'ms]';
            $log .= '[' . $request->ip() . ']';
            $log .= '[' . $request->method() . ']';
            $log .= '[' . $request->fullUrl() . ']';
            // Log::info($log);
            $fileName = 'api-logger_' . date('d-m-Y') . '.log';
            \File::append(storage_path('logs' . DIRECTORY_SEPARATOR . $fileName), $log . "\n");
        }
    }
}
