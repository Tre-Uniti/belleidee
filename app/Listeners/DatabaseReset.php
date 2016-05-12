<?php

namespace App\Listeners;

use App\Beacon;
use App\Events\MonthlyBeaconReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DatabaseReset
{
    /**
     * Create the event listener.
     *
     * @param Beacon $beacons
     */
    public function __construct(Beacon $beacons)
    {
        $this->beacons = $beacons;
    }

    /**
     * Handle the event.
     *
     * @param  MonthlyBeaconReset  $event
     * @return void
     */
    public function handle(MonthlyBeaconReset $event)
    {
        $beacons = $event->beacons;
            
        foreach($beacons as $beacon)
        {
            $beacon->tag_views = 0;
            $beacon->tag_usage = 0;
            $beacon->total_tag_usage = $beacon->total_usage + $beacon->tag_usage;
            $beacon->update();
        }
    }
}
