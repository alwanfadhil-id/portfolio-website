<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
        public function handle(Request $request, Closure $next)
        {
            // Skip middleware for login routes
            if ($request->is('admin/login') || $request->is('admin/login/submit')) {
                return $next($request);
            }

            // Check admin session
            if (!Session::has('admin_logged_in') || !Session::get('admin_logged_in')) {
                return redirect()->route('admin.login')
                    ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
            }

            return $next($request);
        }
}