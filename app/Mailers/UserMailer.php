<?php

namespace App\Mailers;

use App\Invite;
use App\Post;
use App\User;
use Illuminate\Contracts\Mail\Mailer;

class UserMailer
{
    protected $mailer;
    protected $from = 'zoko@belle-idee.org';
    protected $to;
    protected $view;
    protected $data = [];
    protected $title;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmailConfirmationTo(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.confirm';
        $this->data = compact('user');
        $this->title = 'Please confirm your email';
        $this->deliver();
    }
    public function sendEmailInviteTo(Invite $invite)
    {
        $this->to = $invite->email;
        $this->view = 'emails.invite';
        $this->data = compact('invite');
        $this->title = 'An Invitation to Belle-Idee';
        $this->deliver();
    }
    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message)
        {
            $message->from($this->from, 'Zoko')
                    ->to($this->to)
                    ->subject($this->title);
        });
    }
}