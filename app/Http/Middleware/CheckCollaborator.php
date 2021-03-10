<?php

namespace App\Http\Middleware;

use Closure;

class CheckCollaborator
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

        if (auth()->user()->userable_type != 'App\Collaborator') {
            return back();
        }


        return $next($request);
    }
}
