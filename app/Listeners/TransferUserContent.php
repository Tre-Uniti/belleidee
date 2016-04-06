<?php

namespace App\Listeners;

use App\Adjudication;
use App\Beacon;
use App\BeaconRequest;
use App\Draft;
use App\Elevate;
use App\Events\TransferUser;
use App\Extension;
use App\Intolerance;
use App\Invite;
use App\Moderation;
use App\Notification;
use App\Post;
use App\Question;
use App\Sponsor;
use App\SponsorRequest;
use App\Support;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferUserContent
{
    /**
     * Create the event listener.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  TransferUser  $event
     * @return void
     */
    public function handle(TransferUser $event)
    {
        $user = User::findOrFail($event->user->id);
        $transferred = User::findOrFail(20);

        //Get all content by user->id for transfer
        $posts = Post::where('user_id', '=', $user->id)->get();
        $extensions = Extension::where('user_id', '=', $user->id)->get();
        $questions = Question::where('user_id', '=', $user->id)->get();
        $elevations = Elevate::where('user_id', '=', $user->id)->get();
        $intolerances = Intolerance::where('user_id', '=', $user->id)->get();
        $moderations = Moderation::where('user_id', '=', $user->id)->get();
        $adjudications = Adjudication::where('user_id', '=', $user->id)->get();
        $beaconRequests = BeaconRequest::where('user_id', '=', $user->id)->get();
        $sponsorRequests = SponsorRequest::where('user_id', '=', $user->id)->get();
        $drafts = Draft::where('user_id', '=', $user->id)->get();
        $invites = Invite::where('user_id', '=', $user->id)->get();
        $supports = Support::where('user_id', '=', $user->id)->get();
        $notifications = Notification::where('user_id', '=', $user->id)->get();
        $beacons = Beacon::where('user_id', '=', $user->id)->get();
        $beaconGuides = Beacon::where('guide', '=', $user->id)->get();
        $sponsors = Sponsor::where('user_id', '=', $user->id)->get();

        //Transfer all Content to Transferred User
        foreach($posts as $post)
        {
            $post->user_id = $transferred->id;
        }
        foreach($extensions as $extension)
        {
            $extension->user_id = $transferred->id;
        }
        foreach($questions as $question)
        {
            $question->user_id = $transferred->id;
        }
        foreach($elevations as $elevation)
        {
            $elevation->user_id = $transferred->id;
        }
        foreach($intolerances as $intolerance)
        {
            $intolerance->user_id = $transferred->id;
        }
        foreach($moderations as $moderation)
        {
            $moderation->user_id = $transferred->id;
        }
        foreach($adjudications as $adjudication)
        {
            $adjudication->user_id = $transferred->id;
        }
        foreach($invites as $invite)
        {
            $invite->user_id = $transferred->id;
        }
        foreach($supports as $support)
        {
            $support->user_id = $transferred->id;
        }
        foreach($beaconRequests as $beaconRequest)
        {
            $beaconRequest->user_id = $transferred->id;
        }
        foreach($sponsorRequests as $sponsorRequest)
        {
            $sponsorRequest->user_id = $transferred->id;
        }
        foreach($beacons as $beacon)
        {
            $beacon->user_id = $transferred->id;
        }
        foreach($beaconGuides as $beaconGuide)
        {
            $beaconGuide->user_id = $transferred->id;
        }
        foreach($sponsors as $sponsor)
        {
            $sponsor->user_id = $transferred->id;
        }

        //Delete all drafts for user
        foreach($drafts as $draft)
        {
            $draft->delete();
        }

        //Delete all notifications for user
        foreach($notifications as $notification)
        {
            $notification->delete();
        }

        //Detach all bookmarks
        $bookmarks = $user->bookmarks()->get();
        foreach ($bookmarks as $bookmark)
        {
            $user->bookmarks()->detach($bookmark->id);
        }

    }
}
