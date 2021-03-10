<?php

namespace App\Http\Middleware;

use Closure;

class CheckComissao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->user()->userable->comissao != 1) {
            return redirect()->route('portal.home');
        }


        return $next($request);
    }
}
