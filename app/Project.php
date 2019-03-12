<?php

namespace App;

use App\Notifications\PersonalReminderToFillForm;
use Illuminate\Support\Facades\Notification;

class Project
{
    public $name;
    protected $notificationChannel;
    protected $members;

    public function __construct($name, $notificationChannel, array $members)
    {
        if ($notificationChannel !== 'slack') {
            throw new UnexpectedValueException;
        }

        $this->name = $name;
        $this->notificationChannel = $notificationChannel;
        $this->members = $members;
    }

    public function notify()
    {
        foreach ($this->members as $member) {
            Notification::route('slack', config('app.slack_webhook'))
                ->notify(new PersonalReminderToFillForm($member));
        }
    }
}
