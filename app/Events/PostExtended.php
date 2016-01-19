<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostExtended extends Event
{
    use SerializesModels;

    public $userId;
    public $extensionId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $extensionId)
    {
        $this->userId = $userId;
        $this->extensionId = $extensionId;
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
