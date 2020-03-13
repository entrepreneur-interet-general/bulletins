<?php

namespace App\Mail;

use App\Date;
use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use UnexpectedValueException;

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

    public function hasReports()
    {
        return Report::forWeek($this->week)->count() > 0;
    }

    public function build()
    {
        if (! $this->hasReports()) {
            throw new InvalidArgumentException('No reports for week '.$this->week);
        }

        $reports = Report::forWeek($this->week)->get()->shuffle();

        $helpRequests = Report::forWeek($this->week)->orderBy('project')->pluck('help', 'project')->filter();
        $projectsNoInfo = config('app.projects')->active()->unfilledProjectsFor($this->week)->map->name;

        $subject = trans('emails.subject', ['week' => $this->week]);

        return $this->markdown('emails.report', [
            'reports' => $reports,
            'upcomingDates' => $this->upcomingDates($reports),
            'weekNumber' => $this->week,
            'helpRequests' => $helpRequests,
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
