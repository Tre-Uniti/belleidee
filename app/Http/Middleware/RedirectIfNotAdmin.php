<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
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
        if ($user->type < 3)
        {
            flash()->overlay('Must be an Admin or Guardian to view this page');
            return redirect()->back();
        }
        else
        {
            return $next($request);
        }

    }
}
