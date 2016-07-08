<?php

namespace App\Mailers;

use App\Beacon;
use App\Extension;
use App\Question;
use App\Sponsor;
use App\User;

class NotificationMailer extends Mailer
{

    //Send email to owner of post that was extended
    public function sendExtensionNotification(Extension $extension)
    {
        $user = User::findOrFail($extension->source_user);
        $user['email'] = $user->email;
        $view = 'emails.extended';
        $data = compact('extension', 'user');
        $subject = 'Your post has been extended!';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send email to owner of extension that was extended
    public function sendExtenceptionNotification(Extension $extension)
    {
        $user = User::findOrFail($extension->source_user);
        $user['email'] = $user->email;
        $view = 'emails.extenception';
        $data = compact('extension', 'user');
        $subject = 'Your extension has been extended!';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send out new Community Question to users
    public function sendCommunityQuestionNotification(Question $question)
    {
        $askedBy = User::findOrFail($question->user_id);
        $question = Question::findOrFail($question->id);
        $view = 'emails.question';

        $users = User::where('verified', '=', 1)->where('frequency', '>', 1)->get();
        foreach($users as $user)
        {
            $subject = 'New Community Question';
            $data = compact('question', 'askedBy', 'user');
            $this->sendTo($user, $subject, $view, $data);
        }
    }

    //Send out notification to users with content reassigned on Beacon deactivation
    public function sendBeaconDeactivationNotification(Beacon $beacon, $users)
    {
        $view = 'emails.beaconDeactivated';
        
        foreach($users as $id)
        {
            $user = User::findOrFail($id);
            $subject = 'Content reassigned from deactivated Beacon';
            $data = compact('beacon', 'user');
            $this->sendTo($user, $subject, $view, $data);
        }
    }

    //Send email to owner of request the Beacon was deleted
    public function sendBeaconDeletedNotification(User $user, $beaconTitle)
    {
        $view = 'emails.beaconDeleted';
        $data = compact('user','beaconTitle');
        $subject = 'Your beacon request did not become an Idee Beacon.';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send email to owner of request the Beacon was created
    public function sendBeaconCreatedNotification(User $user, Beacon $beacon)
    {
        $view = 'emails.beaconCreated';
        $data = compact('beacon', 'user');
        $subject = 'Your beacon request has become an Idee Beacon!';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send email to owner of request the Sponsor was deleted
    public function sendSponsorDeletedNotification(User $user, $sponsorTitle)
    {
        $view = 'emails.sponsorDeleted';
        $data = compact('user','sponsorTitle');
        $subject = 'Your sponsor request did not become an Idee Sponsor.';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send email to owner of request the Beacon was created
    public function sendSponsorCreatedNotification(User $user, Sponsor $sponsor)
    {
        $view = 'emails.sponsorCreated';
        $data = compact('sponsor', 'user');
        $subject = 'Your sponsor request has become an Idee Sponsor!';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send email to owner of request the Beacon was created
    public function sendMonthlyBeaconReport()
    {
        $beacons = Beacon::where('stripe_plan', '>', 0)->get();
        $view = 'emails.beaconReport';
        foreach($beacons as $beacon)
        {
            $data = compact('beacon');
            $user['email'] = $beacon->email;
            $subject = 'Monthly Beacon Report: ' . $beacon->beacon_tag;
            $this->sendTo($user, $subject, $view, $data);
        }

    }
    
    //Send monthly report email to owner of Sponsor
    public function sendMonthlySponsorReport()
    {
        $sponsors = Sponsor::where('status', '=', 'Live')->get();
        $view = 'emails.sponsorReport';
        foreach($sponsors as $sponsor)
        {
            $data = compact('sponsor');
            $user['email'] = $sponsor->email;
            $subject = 'Monthly Sponsor Report: ' . $sponsor->name;
            $this->sendTo($user, $subject, $view, $data);
        }

    }

    //Send out notification to users with content reassigned on Beacon deactivation
    public function sendBeaconAnnouncementNotification($announcement)
    {
        $view = 'emails.beaconAnnouncement';

        $beacon = Beacon::where('id', '=', $announcement->beacon_id)->first();

        $users = User::where('last_tag', '=', $beacon->beacon_tag)->get();

        foreach($users as $user)
        {
            $subject = 'New Announcement from '. $beacon->name;
            $data = compact('beacon', 'user', 'announcement');
            $this->sendTo($user, $subject, $view, $data);
        }
    }
}
