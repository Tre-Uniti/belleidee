<?php

namespace App\Listeners;

use App\Events\SponsorViewed;
use App\Sponsor;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChargeSponsor
{
    /**
     * Create the event listener.
     *
     * @param Sponsor $sponsor
     */
    public function __construct(Sponsor $sponsor)
    {
        $this->sponsor = $sponsor;
    }

    /**
     * Handle the event and increase views by 1 if not over budget else increase missed by 1.
     *
     * @param  SponsorViewed  $event
     * @return void
     */
    public function handle(SponsorViewed $event)
    {
        $sponsor = Sponsor::findOrFail($event->sponsor->id);

        if($sponsor->views < $sponsor->view_budget)
        {
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        }
        else
        {
            $sponsor->where('id', $sponsor->id)
                ->update(['missed' => $sponsor->missed + 1]);
        }
    }
}
