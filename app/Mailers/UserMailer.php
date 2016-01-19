<?php

namespace App\Mailers;

use App\Invite;
use App\Post;
use App\User;

class UserMailer extends Mailer
{
    protected $mailer;
    protected $from = 'tre-uniti@belle-idee.org';
    protected $to;
    protected $view;
    protected $data = [];
    protected $title;


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

    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message)
        {
            $message->from($this->from, 'Tre-Uniti')
                    ->to($this->to)
                    ->subject($this->title);
        });
    }
}