<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Simple session check using session() helper
        if (!session('admin_logged_in') || !session('admin_id')) {
            
            Log::info('Admin middleware: Access denied', [
                'url' => $request->url(),
                'admin_logged_in' => session('admin_logged_in'),
                'admin_id' => session('admin_id'),
                'session_id' => session()->getId()
            ]);
            
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        return $next($request);
    }
}