<?php

namespace App\Http\Middleware;

use App\Extension;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotExtensionOwner
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
        $id = $request->extension;
        $extension = Extension::findOrFail($id); // Fetch the extension

        if($extension->user_id == Auth::id())
        {
            return $response;
        }

        flash()->overlay('You must own this extension to edit');
        return redirect('extensions/'. $extension->id); // Not the Owner! Redirect back.
    }
}
