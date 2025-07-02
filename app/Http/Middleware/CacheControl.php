<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        if (!auth()->check() && $request->isMethod('GET')) {
            $response->header('Cache-Control', 'public, max-age=3600');
        }
        
        return $response;
    }
}