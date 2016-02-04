<?php

namespace App\Mailers;

use App\Extension;
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

    //Send support request to Desk.com
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
}