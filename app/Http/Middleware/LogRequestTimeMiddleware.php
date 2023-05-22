<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogRequestTimeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $start_time;
    public function handle(Request $request, Closure $next)
    {
        $this->start_time = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response){
        $end_time = microtime(true);
        $total_time = $end_time - $this->start_time;

        Log::info("Request Time", [
            'Total Time' => $total_time
        ]);
    }
}
