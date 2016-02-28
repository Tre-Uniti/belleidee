<?php

namespace App\Mailers;

use App\Extension;
use App\Question;
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

        $users = User::where('verified', '=', 1)->where('email', '=', 'bmcgoffin14@gmail.com')->get();
        foreach($users as $user)
        {
            $subject = 'New Community Question';
            $data = compact('question', 'askedBy', 'user');
            $this->sendTo($user, $subject, $view, $data);
        }
    }
}