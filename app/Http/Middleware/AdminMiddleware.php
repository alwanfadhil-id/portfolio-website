<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Force HTTPS in production
        if (!$request->secure() && app()->environment('production')) {
            return redirect()->secure($request->getRequestUri());
        }

        // Debug only in non-production
        if (app()->environment(['local', 'development'])) {
            Log::info('AdminMiddleware: Checking request', [
                'url' => $request->url(),
                'path' => $request->path(),
                'session_id' => Session::getId(),
                'admin_logged_in' => Session::get('admin_logged_in'),
                'admin_id' => Session::get('admin_id')
            ]);
        }

        // Check admin session
        if (!Session::has('admin_logged_in') || 
            Session::get('admin_logged_in') !== true || 
            !Session::has('admin_id')) {
            
            if (app()->environment(['local', 'development'])) {
                Log::warning('AdminMiddleware: Access denied - no valid session');
            }
            
            // Clear any partial session data
            Session::forget(['admin_logged_in', 'admin_id', 'admin_name']);
            
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        // Verify admin_id is valid
        $adminId = Session::get('admin_id');
        if (!$adminId || !is_numeric($adminId)) {
            if (app()->environment(['local', 'development'])) {
                Log::warning('AdminMiddleware: Invalid admin_id', ['admin_id' => $adminId]);
            }
            
            Session::flush();
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Session tidak valid, silakan login kembali.']);
        }

        if (app()->environment(['local', 'development'])) {
            Log::info('AdminMiddleware: Access granted for admin_id: ' . $adminId);
        }
        
        return $next($request);
    }
}