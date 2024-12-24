<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomVerifyEmail extends Notification
{
    protected $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('会員登録ありがとうございます！')
            ->view(
                'emails.register_confirm',
                [
                    'url' => $this->url,
                    'user' => $notifiable
                ]
            );
    }
}
