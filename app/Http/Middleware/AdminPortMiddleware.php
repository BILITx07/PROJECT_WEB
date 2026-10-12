<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPortMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $port = $request->getPort();
        
        // If accessed on port 8001, redirect to admin port 8000
        if ($port == 8001) {
            $scheme = $request->getScheme();
            $host = $request->getHost();
            return redirect($scheme . '://' . $host . ':8000' . $request->getRequestUri());
        }

        return $next($request);
    }
}
