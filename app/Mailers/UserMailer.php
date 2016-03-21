<?php

namespace App\Mailers;

use App\Invite;
use App\Post;
use App\User;

class UserMailer extends Mailer
{

    //Send confirmation email to new user
    public function sendEmailConfirmationTo(User $user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $subject = 'Please confirm your email';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send invite email to new email from existing user
    public function sendEmailInviteTo(Invite $invite)
    {
        $user['email'] = $invite['email'];
        $view = 'emails.invite';
        $data = compact('invite');
        $subject = 'An Invitation to Belle-Idee';
        $this->sendTo($user, $subject, $view, $data);
    }

    //Send informational email to newly confirmed user
    public function sendEmailConfirmedUser(User $user)
    {
        $view = 'emails.confirmed';
        $data = compact('user');
        $subject = 'Welcome to Belle-Idee';
        $this->sendTo($user, $subject, $view, $data);
    }
}