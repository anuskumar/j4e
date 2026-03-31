<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $userType
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->user_type !== $userType) {
            // Redirect to appropriate home based on user type
            $userType = Auth::user()->user_type;
            if ($userType === 'superadmin') {
                return redirect()->route('admin.home');
            } elseif ($userType === 'customer') {
                return redirect()->route('customer.home');
            } elseif ($userType === 'reseller') {
                return redirect()->route('reseller.home');
            }
            
            return redirect()->route('login');
        }

        return $next($request);
    }
}

