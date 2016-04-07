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
use App\Sponsorship;
use App\Support;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $sourceExtensions = Extension::where('source_user', '=', $user->id)->get();
        $questions = Question::where('user_id', '=', $user->id)->get();
        $elevations = Elevate::where('user_id', '=', $user->id)->get();
        $sourceElevations = Elevate::where('source_user', '=', $user->id)->get();
        $intolerances = Intolerance::where('user_id', '=', $user->id)->get();
        $moderations = Moderation::where('user_id', '=', $user->id)->get();
        $adjudications = Adjudication::where('user_id', '=', $user->id)->get();
        $beaconRequests = BeaconRequest::where('user_id', '=', $user->id)->get();
        $sponsorRequests = SponsorRequest::where('user_id', '=', $user->id)->get();
        $drafts = Draft::where('user_id', '=', $user->id)->get();
        $invites = Invite::where('user_id', '=', $user->id)->get();
        $supports = Support::where('user_id', '=', $user->id)->get();
        $notifications = Notification::where('user_id', '=', $user->id)->get();
        $sourceNotifications = Notification::where('source_user', '=', $user->id)->get();
        $beacons = Beacon::where('manager', '=', $user->id)->get();
        $beaconGuides = Beacon::where('guide', '=', $user->id)->get();
        $sponsors = Sponsor::where('user_id', '=', $user->id)->get();
        $sponsorships = Sponsorship::where('user_id', '=', $user->id)->get();

        //Transfer all Content to Transferred User
        foreach($posts as $post)
        {
            $post->where('id', $post->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($extensions as $extension)
        {
            $extension->where('id', $extension->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($sourceExtensions as $sourceExtension)
        {
            $sourceExtension->where('id', $sourceExtension->id)
                ->update(['source_user' => $transferred->id]);
        }
        foreach($questions as $question)
        {
            $question->where('id', $question->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($elevations as $elevation)
        {
            $elevation->where('id', $elevation->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($sourceElevations as $sourceElevation)
        {
            $sourceElevation->where('id', $sourceElevation->id)
                ->update(['source_user' => $transferred->id]);
        }
        foreach($intolerances as $intolerance)
        {
            $intolerance->where('id', $intolerance->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($moderations as $moderation)
        {
            $moderation->where('id', $moderation->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($adjudications as $adjudication)
        {
            $adjudication->where('id', $adjudication->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($invites as $invite)
        {
            $invite->delete();
        }
        foreach($supports as $support)
        {
            $support->where('id', $support->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($beaconRequests as $beaconRequest)
        {
            $beaconRequest->where('id', $beaconRequest->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($sponsorRequests as $sponsorRequest)
        {
            $sponsorRequest->where('id', $sponsorRequest->id)
                ->update(['user_id' => $transferred->id]);
        }
        foreach($beacons as $beacon)
        {
            $beacon->where('id', $beacon->id)
                ->update(['manager' => $transferred->id]);
        }
        foreach($beaconGuides as $beaconGuide)
        {
            $beaconGuide->where('id', $beaconGuide->id)
                ->update(['guide' => $transferred->id]);
        }
        foreach($sponsors as $sponsor)
        {
            $sponsor->where('id', $sponsor->id)
                ->update(['user_id' => $transferred->id]);
        }
        //Delete all notifications for user
        foreach($sourceNotifications as $sourceNotification)
        {
            $sourceNotification->where('id', $sourceNotification->id)
                ->update(['user_id' => $transferred->id]);
        }


        //Delete all drafts for user
        foreach($drafts as $draft)
        {
            Storage::delete($draft->draft_path);
            $draft->delete();
        }

        //Delete all notifications for user
        foreach($notifications as $notification)
        {
            $notification->delete();
        }
        //Update all notifications for other users
        foreach($notifications as $notification)
        {
            $notification->delete();
        }

        
        //Delete all Sponsorships
        foreach($sponsorships as $sponsorship)
        {
            $sponsorship->delete();
        }

        //Detach all bookmarks
        $bookmarks = $user->bookmarks()->get();
        foreach ($bookmarks as $bookmark)
        {
            $user->bookmarks()->detach($bookmark->id);
        }
        
    }
}
