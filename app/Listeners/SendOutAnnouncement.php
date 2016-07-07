<?php

namespace App\Listeners;

use App\Announcement;
use App\Beacon;
use App\Events\NewAnnouncement;
use App\Mailers\NotificationMailer;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOutAnnouncement
{
    /**
     * Create the event listener.
     *
     * @param Announcement $announcement
     */
    public function __construct(Announcement $announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Handle the event.
     *
     * @param  NewAnnouncement $event
     * @param NotificationMailer $mailer
     */
    public function handle(NewAnnouncement $event, NotificationMailer $mailer)
    {
        $beacon = Beacon::where('id', '=', $this->announcement->beacon_id)->first();

        $users = User::where('last_tag', '=', $beacon->beacon_tag)->get();

        //Email users with notification of Beacon deactivation and reassignment
        $mailer->sendBeaconAnnouncementNotification($beacon, $users, $this->announcement);
    }
}
