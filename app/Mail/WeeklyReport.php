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
        $reports = Report::where('week_number', $weekNumber)->get()->shuffle();
        $projectsNoInfo = collect(config('app.projects'))->diff($reports->pluck('project'));
        $subject = 'Semaine '.$weekNumber;

        return $this->markdown('emails.report', compact('reports', 'weekNumber', 'projectsNoInfo'))->subject($subject);
    }
}
