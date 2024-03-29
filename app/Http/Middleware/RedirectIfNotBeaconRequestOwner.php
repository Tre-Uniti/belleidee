<?php

namespace App\Http\Middleware;

use App\BeaconRequest;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotBeaconRequestOwner
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
        $id = $request->beaconRequest;
        $beaconRequest = BeaconRequest::findOrFail($id); // Fetch the Support
        $user = Auth::user();

        if($beaconRequest->user_id == $user->id)
        {
            return $response;
        }
        elseif($user->type > 2)
        {
            return $response;
        }

        flash()->overlay('You must own this beacon request to view or edit');
        return redirect('beaconRequests'); // Not the Owner! Redirect back.
    }
}
