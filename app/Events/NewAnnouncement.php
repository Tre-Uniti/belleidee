<?php

namespace App\Events;

use App\Announcement;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewAnnouncement extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param Announcement $announcement
     * @internal param Beacon $beacon
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
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
