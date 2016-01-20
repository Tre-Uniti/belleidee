<?php

namespace App\Mailers;

use App\Extension;
use App\User;


class NotificationMailer extends Mailer
{

    public function sendExtensionNotification(Extension $extension)
    {
        $user = User::findOrFail($extension->source_user);
        $user['email'] = $user->email;
        $view = 'emails.extended';
        $data = compact('extension', 'user');
        $subject = 'Your post has been extended!';
        $this->sendTo($user, $subject, $view, $data);
    }

}