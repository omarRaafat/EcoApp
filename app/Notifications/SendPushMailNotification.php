<?php

namespace App\Notifications;

use App\Notifications\SendPushNotification;
use Illuminate\Notifications\Messages\MailMessage;

class SendPushMailNotification extends SendPushNotification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['firebase','database','mail'];
    }

    /**
     * Get the Mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->line($this->message);
    }
}
