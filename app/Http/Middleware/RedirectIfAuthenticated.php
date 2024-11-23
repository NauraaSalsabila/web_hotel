<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // Cek apakah sesi admin aktif
            if (Auth::guard('admin')->check()) {
                if ($guard == 'customer') {
                    // Jika customer mencoba mengakses halaman login admin
                    return redirect()->route('admin_home');
                }
            }

            // Cek apakah sesi customer aktif
            if (Auth::guard('customer')->check()) {
                if ($guard == 'admin') {
                    // Jika admin mencoba mengakses halaman login customer
                    return redirect()->route('home');
                }
            }
        }

        return $next($request);
    }
}



