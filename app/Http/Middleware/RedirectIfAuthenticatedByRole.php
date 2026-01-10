<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()?->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'deliver' => redirect()->route('deliver'),
                'applicant' => redirect()->route('applicant'),
                'manager' => redirect()->route('manager'),
                'cashier' => redirect()->route('cashier'),
                default => redirect()->route('cashier'),
            };
        }

        return $next($request);
    }
}
