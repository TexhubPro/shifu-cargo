<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Cashier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->status == false) {
            Auth::logout();
            return redirect()->route('login');
        }

        if ($user->role === 'cashier') {
            return $next($request);
        }

        return $this->redirectByRole($user->role);
    }

    protected function redirectByRole(?string $role): Response
    {
        if ($role === 'customer') {
            Auth::logout();
            return redirect()->route('login');
        }

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('manager'),
            'deliver' => redirect()->route('deliver'),
            'applicant' => redirect()->route('applicant'),
            default => redirect()->route('login'),
        };
    }
}
