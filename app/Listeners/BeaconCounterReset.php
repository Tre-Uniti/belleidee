<?php

namespace App\Listeners;

use App\Beacon;
use App\Events\MonthlyBeaconReset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BeaconCounterReset
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
     * @param  MonthlyBeaconReset  $event
     * @return void
     */
    public function handle(MonthlyBeaconReset $event)
    {
        $beacons = Beacon::latest()->get();

        foreach($beacons as $beacon)
        {
            $beacon->total_tag_usage = $beacon->total_tag_usage + $beacon->tag_usage;
            $beacon->tag_views = 0;
            $beacon->tag_usage = 0;
            $beacon->update();
        }
    }
}
