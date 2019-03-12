<?php

namespace Tests\Unit;

use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;

    public function testNames()
    {
        $this->assertEquals(config('app.projects')->map->name, config('app.projects')->names());
    }

    public function testFilledProjectsFor()
    {
        $this->assertCount(0, config('app.projects')->filledProjectsFor('2019-10'));

        $report = factory(Report::class)->create();

        $this->assertCount(1, config('app.projects')->filledProjectsFor($report->week_number));
        $this->assertCount(0, config('app.projects')->filledProjectsFor('2000-10'));
    }

    public function testUnfilledProjectsFor()
    {
        $totalProjects = config('app.projects')->count();

        $this->assertCount($totalProjects - 0, config('app.projects')->unfilledProjectsFor('2019-10'));

        $report = factory(Report::class)->create();

        $this->assertCount($totalProjects - 1, config('app.projects')->unfilledProjectsFor($report->week_number));
        $this->assertCount($totalProjects - 0, config('app.projects')->unfilledProjectsFor('2000-10'));
    }
}
