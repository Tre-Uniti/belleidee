<?php

namespace App\Http\Middleware;

use App\Beacon;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotBeaconAdmin
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
        $id = $request->route('id');
        $beacon = Beacon::findOrFail($id); // Fetch the Beacon
        $user = Auth::user();

        if($beacon->manager == $user->id)
        {
            return $response;
        }
        elseif($user->type > 2)
        {
            return $response;
        }

        flash()->overlay('You must be an admin or the owner of this beacon to view');
        return redirect('beacons/'. $beacon->beacon_tag); // Not the Owner! Redirect back.
    }
}
