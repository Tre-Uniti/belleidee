<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class UserDeletion
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
        $id = $request->route('users');
        $user = User::findOrFail($id); // Fetch the Support
        $viewUser = Auth::user();

        if($user->id == $viewUser->id)
        {
            return $response;
        }
        elseif($viewUser->type > 1)
        {
            return $response;
        }

        flash()->overlay('You must be this user or an admin to delete');
        return redirect('users/'. $user->id); // Not the Owner! Redirect back.
    }
}
