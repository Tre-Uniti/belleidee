<?php

namespace App\Mailers;

use App\Invite;
use App\Post;
use App\User;

class UserMailer extends Mailer
{

    public function sendEmailConfirmationTo(User $user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $subject = 'Please confirm your email';
        $this->sendTo($user, $subject, $view, $data);
    }
    public function sendEmailInviteTo(Invite $invite)
    {
        $user['email'] = $invite['email'];
        $view = 'emails.invite';
        $data = compact('invite');
        $subject = 'An Invitation to Belle-Idee';
        $this->sendTo($user, $subject, $view, $data);
    }
}