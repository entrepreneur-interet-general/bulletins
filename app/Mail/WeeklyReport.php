<?php

namespace App\Mail;

use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class WeeklyReport extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        $weekNumber = (new Carbon())->format('Y-W');
        $reports = Report::where('week_number', $weekNumber)->orderBy('project', 'asc')->get()->shuffle();
        $projectsNoInfo = collect(config('app.projects'))->diff($reports->pluck('project'));

        return $this->markdown('emails.report', compact('reports', 'weekNumber', 'projectsNoInfo'));
    }
}
