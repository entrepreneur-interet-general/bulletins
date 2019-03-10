<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class RemindToFillForm extends Notification
{
    use Queueable;

    protected $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $content = "Hello ! Vous n'avez pas encore rempli le bilan de la semaine. :point_right: ".config('app.url');

        return (new SlackMessage)
                    ->to($this->username)
                    ->content($content);
    }
}
