<?php

namespace App\Http\Middleware;

use App\SponsorRequest;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotSponsorRequestOwner
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
        $id = $request->route('sponsorRequests');
        $sponsorRequest = SponsorRequest::findOrFail($id); // Fetch the Support
        $user = Auth::user();

        if($sponsorRequest->user_id == $user->id)
        {
            return $response;
        }
        elseif($user->type > 2)
        {
            return $response;
        }

        flash()->overlay('You must own this sponsor request to view or edit');
        return redirect('sponsorRequests'); // Not the Owner! Redirect back.
    }
}
