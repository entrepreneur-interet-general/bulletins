<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FillBulletinReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $url;

    public function __construct($project, $url)
    {
        $this->project = $project;
        $this->url = $url;
    }

    public function build()
    {
        return $this->markdown('emails.fill_reminder');
    }
}
