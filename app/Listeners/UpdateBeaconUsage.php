<?php

namespace App\Listeners;

use App\Beacon;
use App\Events\BeaconViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateBeaconUsage
{
    /**
     * Create the event listener.
     *
     * @param Beacon $beacon
     */
    public function __construct(Beacon $beacon)
    {
        $this->beacon = $beacon;
    }

    /**
     * Handle the event.
     *
     * @param  BeaconViewed  $event
     * @return void
     */
    public function handle(BeaconViewed $event)
    {
        $beacon = Beacon::findOrFail($event->beacon->id);

        //Add 1 to the Beacon views
        $beacon->where('id', $beacon->id)
            ->update(['tag_views' => $beacon->tag_views + 1]);
    }
}
