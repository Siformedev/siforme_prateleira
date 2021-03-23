<?php

namespace App\Http\Middleware;

use App\AuditAndLog;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            AuditAndLog::createLog(Auth::user()->id, 'Reacessou o sistema', 'null', @Auth::user()->userable->contract_id);
            return redirect('/home');
        }

        return $next($request);
    }
}
