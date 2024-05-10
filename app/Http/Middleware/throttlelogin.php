<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
 use Symfony\Component\HttpFoundation\Response;
 
use Illuminate\Routing\Middleware\ThrottleRequests;


class throttlelogin
{
    
    protected $limiter;

    public function __construct(\Illuminate\Routing\Middleware\ThrottleRequests $limiter)
    {
        $this->limiter = $limiter;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->limiter->tooManyAttempts($this->throttleKey($request), 5, 60)) {
            return response()->json(['message' => 'Too many login attempts. Try again later.'], 429);
        }

        $response = $next($request);

        if ($response->getStatusCode() === 401) {
            $this->limiter->hit($this->throttleKey($request), 60);
        }

        return $response;
    }

    protected function throttleKey(Request $request)
    {
        return $request->input('email') . '|' . $request->ip();
    }
}