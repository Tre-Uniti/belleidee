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
        if(Auth::user())
        {
            $viewUser = Auth::user();
            if($id == $viewUser->id)
            {
                return $response;
            }
            elseif($viewUser->type > 2)
            {
                return $response;
            }
        }
        else
        {
            flash()->overlay('Please register or login to continue');
            return redirect('/');
        }

        flash()->overlay('You must be this user or an admin to delete');
        return redirect('users/'. $id); // Not the Owner! Redirect back.
    }
}
