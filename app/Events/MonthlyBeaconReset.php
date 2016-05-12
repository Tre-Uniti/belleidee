<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MonthlyBeaconReset extends Event
{
    use SerializesModels;

    public $beacons;


    /**
     * Create a new event instance.
     *
     * @param $beacons
     */
    public function __construct($beacons)
    {
        $this->beacons = $beacons;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
