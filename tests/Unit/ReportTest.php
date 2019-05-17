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
            [$date, $expected] = $test;
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
            [$date, $expected] = $test;
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

    public function testStartOfWeek()
    {
        $report = factory(Report::class)->make(['week_number' => '2019-10']);
        $report2 = factory(Report::class)->make(['week_number' => '2019-01']);

        $this->assertEquals(Carbon::create(2019, 3, 4), $report->startOfWeek);
        $this->assertEquals(Carbon::create(2018, 12, 31), $report2->startOfWeek);
    }

    public function testEndOfWeek()
    {
        $report = factory(Report::class)->make(['week_number' => '2019-10']);
        $report2 = factory(Report::class)->make(['week_number' => '2019-01']);

        $this->assertEquals(Carbon::create(2019, 3, 8), $report->endOfWeek);
        $this->assertEquals(Carbon::create(2019, 1, 4), $report2->endOfWeek);
    }

    public function testMonth()
    {
        $report = factory(Report::class)->make(['week_number' => '2019-10']);
        $report2 = factory(Report::class)->make(['week_number' => '2019-01']);

        $this->assertEquals('March 2019', $report->month);
        $this->assertEquals('December 2018', $report2->month);
    }

    public function testScopeWeek()
    {
        $report = factory(Report::class)->create(['week_number' => '2019-10']);
        $report2 = factory(Report::class)->create(['week_number' => '2019-01']);

        $this->assertEquals(collect([$report->id]), Report::forWeek('2019-10')->pluck('id'));
        $this->assertEquals(collect([$report2->id]), Report::forWeek('2019-01')->pluck('id'));
    }

    public function testScopePublished()
    {
        $report = factory(Report::class)->create(['week_number' => '2019-09']);
        $report2 = factory(Report::class)->create(['week_number' => '2019-10']);

        $tests = [
            [Carbon::create(2019, 3, 4), [$report->id]],
            [Carbon::create(2019, 3, 5), [$report->id]],
            [Carbon::create(2019, 3, 7), [$report->id]],
            [Carbon::create(2019, 3, 8, 14, 59), [$report->id]],
            [Carbon::create(2019, 3, 8, 15), [$report->id, $report2->id]],
            [Carbon::create(2019, 3, 9), [$report->id, $report2->id]],
            [Carbon::create(2019, 3, 10), [$report->id, $report2->id]],
            [Carbon::create(2019, 3, 11), [$report->id, $report2->id]],
        ];

        foreach ($tests as $test) {
            [$date, $expected] = $test;
            Carbon::setTestNow($date);

            $this->assertEquals(collect($expected), Report::published()->orderBy('id')->pluck('id'));
        }
    }
}
