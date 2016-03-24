<?php

namespace App\Events;

use App\Beacon;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BeaconViewed extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Beacon $beacon
     */
    public function __construct(Beacon $beacon)
    {
        $this->beacon = $beacon;
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
