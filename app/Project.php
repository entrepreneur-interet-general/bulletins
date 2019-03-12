<?php

namespace App;

use UnexpectedValueException;

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
        $text = "Hello ! Vous n'avez pas encore rempli le bilan de la semaine. :point_right: ".config('app.url');

        foreach ($this->members as $member) {
            Slack::sendMessage($member, $text);
        }
    }
}
