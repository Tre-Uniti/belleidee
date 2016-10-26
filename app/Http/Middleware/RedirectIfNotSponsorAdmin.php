<?php

namespace App\Http\Middleware;

use App\Sponsor;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotSponsorAdmin
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
        $response = $next($request);
        $tag = $request->route('tag');
        $sponsor = Sponsor::where('sponsor_tag', '=', $tag)->first(); // Fetch the Sponsor
        $user = Auth::user();

        if($sponsor->user_id == $user->id)
        {
            return $response;
        }
        elseif($user->type > 1)
        {
            return $response;
        }

        flash()->overlay('You must be an admin or the owner of this sponsor to view');
        return redirect('sponsors/'. $sponsor->sponsor_tag); // Not the Owner! Redirect back.
    }
}
