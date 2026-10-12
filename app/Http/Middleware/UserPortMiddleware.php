<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPortMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $port = $request->getPort();
        
        // If accessed on port 8000, redirect to user port 8001
        if ($port == 8000) {
            $scheme = $request->getScheme();
            $host = $request->getHost();
            return redirect($scheme . '://' . $host . ':8001' . $request->getRequestUri());
        }

        return $next($request);
    }
}
