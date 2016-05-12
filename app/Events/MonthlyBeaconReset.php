<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MonthlyBeaconReset extends Event
{
    use SerializesModels;

    


    /**
     * Create a new event instance.
     *
     * 
     */
    public function __construct()
    {
        
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
