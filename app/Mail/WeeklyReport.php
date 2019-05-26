<?php

namespace App\Mail;

use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use UnexpectedValueException;
use Illuminate\Queue\SerializesModels;

class WeeklyReport extends Mailable
{
    use Queueable, SerializesModels;

    private $week;

    public function __construct($week = null)
    {
        $this->week = $week ?? now()->format('Y-W');

        if (! preg_match('/^\d{4}-\d{2}$/', $this->week)) {
            throw new UnexpectedValueException($week.' is not a valid week.');
        }
    }

    public function build()
    {
        $reports = Report::forWeek($this->week)->get()->shuffle();
        $helpRequests = Report::forWeek($this->week)->orderBy('project')->pluck('help', 'project')->filter();
        $projectsNoInfo = config('app.projects')->unfilledProjectsFor($this->week)->map->name;

        $subject = trans('emails.subject', ['week' => $this->week]);

        return $this->markdown('emails.report', [
            'reports'        => $reports,
            'weekNumber'     => $this->week,
            'helpRequests'   => $helpRequests,
            'projectsNoInfo' => $projectsNoInfo,
        ])->subject($subject);
    }
}
