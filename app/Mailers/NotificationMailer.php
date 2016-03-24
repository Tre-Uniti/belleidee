<?php

namespace App\Mailers;

use App\Beacon;
use App\BeaconRequest;
use App\Extension;
use App\Question;
use App\Sponsor;
use App\Support;
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

    //Send support request to Desk.com portal
    public function sendSupportNotification(Support $support)
    {
        $user = User::findOrFail($support->user_id);
        $view = 'emails.support';
        $data = compact('support', 'user');

        //Set to email for routing into Desk.com
        $user['email'] = 'tre-uniti@belle-idee.org';
        $subject = 'New Support Request from '. $user->handle;
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send out new Community Question to users
    public function sendCommunityQuestionNotification(Question $question)
    {
        $askedBy = User::findOrFail($question->user_id);
        $question = Question::findOrFail($question->id);
        $view = 'emails.question';

        $users = User::where('verified', '=', 1)->get();
        foreach($users as $user)
        {
            $subject = 'New Community Question';
            $data = compact('question', 'askedBy', 'user');
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
        $data = compact('user','beaconTitle');
        $subject = 'Your sponsor request did not become an Idee Beacon.';
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
}