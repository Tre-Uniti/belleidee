<?php

namespace App\Http\Middleware;

use App\Post;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPostOwner
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
        $id = $request->route('posts');
        $post = Post::findOrFail($id); // Fetch the post

        if($post->user_id == Auth::id())
        {
            return $response;
        }

        flash()->overlay('You must own this post to edit');
        return redirect('posts/'. $post->id); // Not the Owner! Redirect back.
    }
}
