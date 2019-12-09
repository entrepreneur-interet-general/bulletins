<?php

namespace App;

use App\Mail\FillBulletinReminder;
use Illuminate\Support\Carbon;
use Mail;
use UnexpectedValueException;

class Project
{
    public $name;
    protected $channel;
    protected $members;
    public $logoUrl;

    const SUPPORTED_NOTIFICATION_CHANNELS = ['slack', 'email', null];

    public function __construct(array $attributes)
    {
        if (! in_array($attributes['channel'], self::SUPPORTED_NOTIFICATION_CHANNELS)) {
            throw new UnexpectedValueException;
        }

        $this->name = $attributes['name'];
        $this->channel = $attributes['channel'];
        $this->members = $attributes['members'];
        $this->logoUrl = $attributes['logoUrl'];
        $this->endsOn = is_null($attributes['endsOn']) ? null : Carbon::parse($attributes['endsOn']);
    }

    public function isActive()
    {
        return is_null($this->endsOn) || $this->endsOn->isFuture();
    }

    public function notify()
    {
        switch ($this->channel) {
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
