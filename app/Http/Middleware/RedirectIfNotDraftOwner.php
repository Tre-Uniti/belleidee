<?php

namespace App\Http\Middleware;

use App\Draft;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotDraftOwner
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
        $id = $request->draft;
        $draft = Draft::findOrFail($id); // Fetch the Draft

        if($draft->user_id == Auth::id())
        {
            return $response;
        }

        flash()->overlay('You must own this draft to view or edit');
        return redirect('drafts'); // Not the Owner! Redirect back.
    }
}
