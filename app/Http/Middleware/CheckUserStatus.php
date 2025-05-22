<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status !== 'Active') {
            Auth::logout();
            return redirect()->route('show.login')->withErrors(['account' => 'Your account is inactive']);
        }

        return $next($request);
    }
}
