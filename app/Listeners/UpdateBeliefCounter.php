<?php

namespace App\Listeners;

use App\Belief;
use App\Events\BeliefInteraction;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBeliefCounter
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  BeliefInteraction $event
     */
    public function handle(BeliefInteraction $event)
    {
        $belief = Belief::where('name', '=', $event->belief)->first();

    switch ($event->type) {
        //Update beacons
        case "+beacon":
            $belief->beacons = $belief->beacons + 1;
            break;
        case "-beacon":
            $belief->beacons = $belief->beacons - 1;
            break;
        //Update posts
        case "+post":
            $belief->posts = $belief->posts + 1;
            break;
        case "-post":
            $belief->posts = $belief->posts - 1;
            break;
        //Update extensions
        case "+extension":
            $belief->extensions = $belief->extensions + 1;
            break;
        case "-extension":
            $belief->extensions = $belief->extensions - 1;
            break;
        //Update legacy posts
        case "+legacy_post":
            $belief->legacy_posts = $belief->legacy_posts + 1;
            break;
        case "-legacy_post":
            $belief->legacy_posts = $belief->legacy_posts - 1;
            break;

        default:
            echo "No type given" . $event->type . $event->belief;
    }
        //Update belief in database
        $belief->update();
    }
}