<?php

namespace Tests\Unit;

use App\Report;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function testReportCanBeFilled()
    {
        $tests = [
            [Carbon::create(2019, 3, 4), true],
            [Carbon::create(2019, 3, 5), true],
            [Carbon::create(2019, 3, 7), true],
            [Carbon::create(2019, 3, 8, 14, 59), true],
            [Carbon::create(2019, 3, 8, 15), false],
            [Carbon::create(2019, 3, 9), false],
            [Carbon::create(2019, 3, 10), false],
            [Carbon::create(2019, 3, 11), true],
        ];

        foreach ($tests as $test) {
            list($date, $expected) = $test;
            Carbon::setTestNow($date);

            $this->assertEquals($expected, Report::canBeFilled());
        }
    }

    public function testlatestPublishedWeek()
    {
        $tests = [
            [Carbon::create(2019, 3, 4), '2019-09'],
            [Carbon::create(2019, 3, 5), '2019-09'],
            [Carbon::create(2019, 3, 7), '2019-09'],
            [Carbon::create(2019, 3, 8, 14, 59), '2019-09'],
            [Carbon::create(2019, 3, 8, 15), '2019-10'],
            [Carbon::create(2019, 3, 9), '2019-10'],
            [Carbon::create(2019, 3, 10), '2019-10'],
            [Carbon::create(2019, 3, 11), '2019-10'],
        ];

        foreach ($tests as $test) {
            list($date, $expected) = $test;
            Carbon::setTestNow($date);

            $message = 'Wrong week for '.$date;

            $this->assertEquals($expected, Report::latestPublishedWeek(), $message);
        }
    }

    public function testProjectObject()
    {
        $report = factory(Report::class)->create();

        $this->assertInstanceOf(\App\Project::class, $report->projectObject());
        $this->assertEquals($report->project, $report->projectObject()->name);
    }
}
