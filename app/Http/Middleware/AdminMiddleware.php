<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Daftar route yang dikecualikan dari middleware
        $excludedRoutes = [
            'admin/login',
            'admin/login/*',
            'admin/authenticate'
        ];

        // Skip middleware untuk route yang dikecualikan
        foreach ($excludedRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // Check admin session dengan lebih spesifik
        if (!Session::has('admin_logged_in') || Session::get('admin_logged_in') !== true) {
            // Clear any corrupted session data
            Session::forget(['admin_logged_in', 'admin_id', 'admin_name']);
            
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        // Verifikasi admin_id masih valid
        if (!Session::has('admin_id') || !Session::get('admin_id')) {
            Session::flush();
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Session tidak valid, silakan login kembali.']);
        }

        return $next($request);
    }
}