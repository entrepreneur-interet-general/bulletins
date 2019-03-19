<?php

namespace App\Mail;

use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WeeklyReport extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        $weekNumber = now()->format('Y-W');

        $reports = Report::forWeek($weekNumber)->get()->shuffle();
        $helpRequests = Report::forWeek($weekNumber)->orderBy('project')->pluck('help', 'project')->filter();
        $projectsNoInfo = config('app.projects')->unfilledProjectsFor($weekNumber)->map->name;

        $subject = 'Bilan de la semaine '.$weekNumber;

        return $this->markdown('emails.report', [
            'reports' => $reports,
            'weekNumber' => $weekNumber,
            'helpRequests' => $helpRequests,
            'projectsNoInfo' => $projectsNoInfo,
        ])->subject($subject);
    }
}
