<?php

namespace App\Events;

use App\Events\Event;
use App\Sponsor;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SponsorViewed extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Sponsor $sponsor
     */
    public function __construct(Sponsor $sponsor)
    {
        $this->sponsor = $sponsor;
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
