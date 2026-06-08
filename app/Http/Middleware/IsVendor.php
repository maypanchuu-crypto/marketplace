<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsVendor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // approved vendor
        if (Auth::check() && Auth::user()->role === 'vendor' && Auth::user()->vendor_status === 'approved') {
            return $next($request);
        }

        // not a vendor or not approved
        return redirect()->route('dashboard')->with('error', 'Access Denied! You are not a registered vendor.');
    }
}
