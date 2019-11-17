<?php

namespace Tests\Feature;

use App\Date;
use App\Mail\WeeklyReport;
use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use UnexpectedValueException;

class WeeklyReportTest extends TestCase
{
    use RefreshDatabase;

    public function testInvalidWeek()
    {
        $this->expectException(UnexpectedValueException::class);

        new WeeklyReport('foo');
    }

    public function testForWeek()
    {
        $week = '2019-20';
        $names = config('app.projects')->names();

        factory(Report::class)->create(['week_number' => $week, 'project' => $names[0]]);
        factory(Report::class)->create(['week_number' => $week, 'project' => $names[1]]);
        factory(Report::class)->create(['week_number' => '2018-01']);

        factory(Date::class)->create(['date' => '2019-05-17']);
        factory(Date::class)->create(['date' => '2019-05-24']);
        factory(Date::class)->create(['date' => '2019-05-25']);

        $view = (new WeeklyReport($week))->build();

        $this->assertEquals($view->subject, 'Bulettins of the week 2019-20');

        $this->assertEquals($view->viewData['weekNumber'], $week);
        $this->assertEquals($view->viewData['reports']->pluck('id')->sort()->values(), Report::forWeek($week)->pluck('id')->sort()->values());
        $this->assertEquals($view->viewData['upcomingDates']->pluck('id'), Date::where('date', '2019-05-24')->pluck('id'));
    }
}
