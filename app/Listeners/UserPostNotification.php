<?php

namespace App\Listeners;

use App\Events\PostExtended;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserPostNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  PostExtended  $event
     * @return void
     */
    public function handle(PostExtended $event)
    {
        dd($event);
    }
}
