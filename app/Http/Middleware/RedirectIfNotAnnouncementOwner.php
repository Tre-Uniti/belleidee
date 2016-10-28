<?php

namespace App\Http\Middleware;

use App\Announcement;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAnnouncementOwner
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
        $id = $request->route('announcements');
        $announcement = Announcement::findOrFail($id); // Fetch the Announcement
        $user = Auth::user();

        if($announcement->beacon->manager == $user->id)
        {
            return $response;
        }
        elseif($user->type > 2)
        {
            return $response;
        }

        flash()->overlay('You must own this announcement to view or edit');
        return redirect('beacons/'. $announcement->beacon->beacon_tag); // Not the Owner! Redirect back.
    }
}
