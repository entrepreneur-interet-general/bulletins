<?php

namespace App;

use Mail;
use UnexpectedValueException;
use App\Mail\FillBulletinReminder;

class Project
{
    public $name;
    protected $notificationChannel;
    protected $members;
    public $logoUrl;

    const SUPPORTED_NOTIFICATION_CHANNELS = ['slack', 'email', null];

    public function __construct($name, $notificationChannel, array $members, $logoUrl, $isActive)
    {
        if (! in_array($notificationChannel, self::SUPPORTED_NOTIFICATION_CHANNELS)) {
            throw new UnexpectedValueException;
        }

        $this->name = $name;
        $this->notificationChannel = $notificationChannel;
        $this->members = $members;
        $this->logoUrl = $logoUrl;
        $this->isActive = $isActive;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    public function notify()
    {
        switch ($this->notificationChannel) {
            case 'slack':
                $this->slackNotify();
                break;

            case 'email':
                $this->emailNotify();
                break;

            default:
                return;
        }
    }

    private function emailNotify()
    {
        foreach ($this->members as $member) {
            Mail::to($member)->send(new FillBulletinReminder($this->name, config('app.url')));
        }
    }

    private function slackNotify()
    {
        $text = trans('notifications.individual_reminder', ['project' => $this->name, 'url' => config('app.url')]);

        foreach ($this->members as $member) {
            Slack::sendMessage($member, $text);
        }
    }
}
