<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotGlobalMod
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
        $user = Auth::user();
        if ($user->type < 2)
        {
            flash()->overlay('Must be a Global Moderator to view this page.');
            return redirect()->back();
        }
        else
        {
            return $next($request);
        }
    }
}
