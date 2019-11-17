<?php

namespace App\Console;

use App\Mail\WeeklyReport;
use App\Slack;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $text = trans('notifications.general_reminder', ['url' => config('app.url')]);
            Slack::sendMessage(config('app.slack_general_channel'), $text);
        })->timezone(config('app.report_timezone'))->fridays()->at('10:00');

        $schedule->call(function () {
            $this->unfilledProjects()->map->notify();
        })->timezone(config('app.report_timezone'))->fridays()->at('14:00');

        $schedule->call(function () {
            $this->unfilledProjects()->map->notify();
        })->timezone(config('app.report_timezone'))->fridays()->at('14:45');

        $schedule->call(function () {
            Mail::to(config('app.report_email'))->send(new WeeklyReport);
        })->timezone(config('app.report_timezone'))->fridays()->at('15:05');
    }

    private function unfilledProjects()
    {
        $currentWeek = now()->format('Y-W');

        return config('app.projects')->active()->unfilledProjectsFor($currentWeek);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
