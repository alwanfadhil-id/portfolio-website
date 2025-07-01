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
        // Cek apakah admin sudah login
        if (!Session::has('admin_logged_in') || !Session::get('admin_logged_in')) {
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Silakan login terlebih dahulu.']);
        }

        // Cek apakah session admin_id masih valid
        if (!Session::has('admin_id')) {
            Session::flush();
            return redirect()->route('admin.login')
                ->withErrors(['auth' => 'Session tidak valid, silakan login kembali.']);
        }

         if ($request->is('admin/login')) {
        return $next($request); // jangan redirect kalau ini halaman login
        }

        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }

        return $next($request);
    }
}