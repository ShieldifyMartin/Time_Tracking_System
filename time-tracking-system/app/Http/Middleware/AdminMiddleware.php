<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ensure the user is authenticated and has the 'admin' role
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // If not authorized, redirect or return an error
        return redirect('/')->with('error', 'Unauthorized access');
    }
}
