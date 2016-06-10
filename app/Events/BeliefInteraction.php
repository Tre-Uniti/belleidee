<?php

namespace App\Events;

use App\Belief;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BeliefInteraction extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param $belief
     * @param $type
     */
    public function __construct($belief, $type)
    {
        $this->belief = $belief;
        $this->type = $type;
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
