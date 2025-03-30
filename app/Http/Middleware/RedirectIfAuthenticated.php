<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated as Redirected;

class RedirectIfAuthenticated extends Redirected
{
    
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (Auth::check()) {
            return (Auth::user()->user_type === 'student')
                ? redirect()->route('student.dashboard')
                : redirect()->route('faculty.dashboard');
        }

        return $next($request);
    }
}
