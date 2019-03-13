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
        $format = "Pour le moment nous n'avons pas de nouvelles du défi %s :sob: Votre mission : partager les nouvelles de la semaine à la promo en moins d'une heure. Attention, décollage à 15h ! :rocket: :point_right: %s";
        $text = sprintf($format, $this->name, config('app.url'));

        foreach ($this->members as $member) {
            Slack::sendMessage($member, $text);
        }
    }
}
