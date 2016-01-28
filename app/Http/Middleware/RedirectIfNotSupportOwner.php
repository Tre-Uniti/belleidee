<?php

namespace App\Http\Middleware;

use App\Support;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotSupportOwner
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
        $id = $request->route('supports');
        $support = Support::findOrFail($id); // Fetch the Support

        if($support->user_id == Auth::id())
        {
            return $response;
        }

        flash()->overlay('You must own this support request to view or edit');
        return redirect('supports'); // Not the Owner! Redirect back.
    }
}
