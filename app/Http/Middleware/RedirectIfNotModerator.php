<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotModerator
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
        if ($user->type < 1)
        {
            flash()->overlay('Must be a Moderator to view this page.');
            return redirect()->back();
        }
        else
        {
            return $next($request);
        }

    }
}
