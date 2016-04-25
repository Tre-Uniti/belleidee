<?php

namespace App\Listeners;

use App\Events\SetLocation;
use App\Post;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetrieveLatestLocation
{
    /**
     * Create the event listener.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  SetLocation  $event
     * @return void
     */
    public function handle(SetLocation $event)
    {
        $user = User::findOrFail($event->user->id);

        $post = Post::where('user_id', '=', $user->id)->orderby('created_at', 'desc')->first();
        $extension = Post::where('user_id', '=', $user->id)->orderby('created_at', 'desc')->first();

        if($post->created_at->format('M-d-Y') >= $extension->created_at->format('M-d-Y'))
        {
            $lat = $post->lat;
            $long = $post->long;
            $coordinates = [
                'lat' => $lat,
                'long' => $long
            ];
            session()->put('coordinates', $coordinates);
        }
        elseif($post->created_at->format('M-d-Y') <= $extension->created_at->format('M-d-Y'))
        {
            $lat = $extension->lat;
            $long = $extension->long;
            $coordinates = [
                'lat' => $lat,
                'long' => $long
            ];
            session()->put('coordinates', $coordinates);
        }
        else
        {
            $lat = NULL;
            $long = NULL;
            $coordinates = [
                'lat' => $lat,
                'long' => $long
            ];
            session()->put('coordinates', $coordinates);
        }

        flash()->overlay($lat);
    }
}
