<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah admin sudah login
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek timeout session (30 menit)
        $lastActivity = Session::get('admin_last_activity');
        if ($lastActivity && now()->diffInMinutes($lastActivity) > 30) {
            Session::forget(['admin_logged_in', 'admin_last_activity']);
            return redirect()->route('admin.login')->with('error', 'Session telah berakhir, silakan login kembali.');
        }

        // Update last activity
        Session::put('admin_last_activity', now());

        return $next($request);
    }
}