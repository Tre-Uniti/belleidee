<?php

namespace App\Http\Middleware;

use App\Notification;
use Closure;

class RedirectIfNotNotificationOwner
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
        $id = $request->notification;
        $notification = Notification::findOrFail($id); // Fetch the notification

        if($notification->source_user == Auth::id())
        {
            return $response;
        }

        flash()->overlay('This is not your notification');
        return redirect('notifications'); // Not the Owner! Redirect to their notifications.
    }
}
