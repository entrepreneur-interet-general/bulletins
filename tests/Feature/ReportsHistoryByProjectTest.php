<?php

namespace Tests\Feature;

use App\Report;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportsHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function testRedirectedOnIndex()
    {
        $response = $this->get(route('reports.choose'));

        $response->assertRedirect(route('reports.index', $this->projectNames()[0]));
    }

    public function testIndexNotLoggedIn()
    {
        $this->get(route('reports.index', $this->projectNames()[0]))->assertRedirect(route('login'));
    }

    public function testIndexLoggedIn()
    {
        Carbon::setTestNow(Carbon::create(2019, 3, 15, 14));

        $this
            ->withSession(['logged_in' => true])
            ->get(route('reports.index', $this->projectNames()[0]))->assertStatus(404);

        $notPublished = factory(Report::class)->create([
            'project' => $this->projectNames()[0],
            'week_number' => '2019-11',
        ]);

        $dummy = factory(Report::class)->create(['project' => $this->projectNames()[1]]);

        $report = factory(Report::class)->create([
            'project' => $this->projectNames()[0],
            'week_number' => '2019-10',
        ]);
        $response = $this
            ->withSession(['logged_in' => true])
            ->get(route('reports.index', $report->project));

        $response
            ->assertStatus(200)
            ->assertViewIs('reports.index')
            ->assertViewHas('projects', collect([$dummy->project, $report->project])->sort()->values())
            ->assertViewHas('currentProject', $report->projectObject())
            ->assertViewHas('shareUrl', URL::signedRoute('reports.index', $report->project))
            ->assertViewHas('downloadUrl', URL::signedRoute('reports.export', $report->project))
            ->assertViewHas('reports', Report::where('project', $report->project)->where('week_number', '2019-10')->get()->groupBy->month);
    }

    public function testIndexWithSignature()
    {
        $report = factory(Report::class)->create();

        $this->get(URL::signedRoute('reports.index', $report->project))->assertOk();
    }

    private function projectNames()
    {
        return config('app.projects')->map->name;
    }
}
