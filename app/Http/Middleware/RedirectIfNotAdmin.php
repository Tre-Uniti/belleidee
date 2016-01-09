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
        if ($user->type < 1)
        {
            flash()->overlay('Access restricted to Admin and Guardian users only');
            return redirect()->back();
        }
        elseif ($user->type < 4)
        {
            flash()->overlay('Ascension level insufficient to view');
            return redirect()->back();
        }
        else
        {
            return $next($request);
        }

    }
}
