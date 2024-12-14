<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user() || !Auth::user()->email_verified_at) {
            return redirect()->route('verification.notice')->with('warning', 'Email Anda belum diverifikasi.');
        }

        return $next($request);
    }
}
