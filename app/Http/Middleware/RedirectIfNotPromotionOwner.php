<?php

namespace App\Http\Middleware;

use App\Promotion;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPromotionOwner
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
        $id = $request->promotion;
        $promotion = Promotion::findOrFail($id); // Fetch the Promotion
        $user = Auth::user();

        if($promotion->sponsor->user_id == $user->id)
        {
            return $response;
        }
        elseif($user->type > 2)
        {
            return $response;
        }

        flash()->overlay('You must own this promotion to view or edit');
        return redirect('sponsors/'. $promotion->sponsor->id); // Not the Owner! Redirect back.
    }
}
