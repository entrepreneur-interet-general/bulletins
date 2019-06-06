<?php

namespace App\Mail;

use App\Date;
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

        if ($reports->isEmpty()) {
            return 'No reports';
        }

        $helpRequests = Report::forWeek($this->week)->orderBy('project')->pluck('help', 'project')->filter();
        $projectsNoInfo = config('app.projects')->unfilledProjectsFor($this->week)->map->name;

        $subject = trans('emails.subject', ['week' => $this->week]);

        return $this->markdown('emails.report', [
            'reports'        => $reports,
            'upcomingDates'  => $this->upcomingDates($reports),
            'weekNumber'     => $this->week,
            'helpRequests'   => $helpRequests,
            'projectsNoInfo' => $projectsNoInfo,
        ])->subject($subject);
    }

    private function upcomingDates($reports)
    {
        $friday = $reports->first()->endOfWeek;
        $nextFriday = $friday->copy()->addWeek(1);

        return Date::whereBetween('date', [$friday, $nextFriday])->orderBy('date')->get();
    }
}
