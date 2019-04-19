<?php

namespace App;

use UnexpectedValueException;

class Project
{
    public $name;
    protected $notificationChannel;
    protected $members;
    public $logoUrl;

    public function __construct($name, $notificationChannel, array $members, $logoUrl)
    {
        if ($notificationChannel !== 'slack' and ! is_null($notificationChannel)) {
            throw new UnexpectedValueException;
        }

        $this->name = $name;
        $this->notificationChannel = $notificationChannel;
        $this->members = $members;
        $this->logoUrl = $logoUrl;
    }

    public function notify()
    {
        if (is_null($this->notificationChannel)) {
            return;
        }

        $text = trans('notifications.individual_reminder', ['project' => $this->name, 'url' => config('app.url')]);

        foreach ($this->members as $member) {
            Slack::sendMessage($member, $text);
        }
    }
}
