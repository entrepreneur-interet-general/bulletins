<?php

namespace Tests\Feature;

use App\Report;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportsHistoryByWeekTest extends TestCase
{
    use RefreshDatabase;

    public function testWeekIndex()
    {
        $report = factory(Report::class)->create();

        $this->get(route('reports.week_index'))->assertRedirect(route('login'));
        // Intended URL has been saved in session
        $this->assertEquals(route('reports.week_index'), session()->get('url.intended'));

        $this
            ->withSession(['logged_in' => true])
            ->get(route('reports.week_index'))
            ->assertOk()
            ->assertViewHas('data');
    }

    public function testWeekHistory()
    {
        $report = factory(Report::class)->create();

        $this
            ->get(route('email_report', $report->week_number))
            ->assertRedirect(route('login'));

        $response = $this
            ->withSession(['logged_in' => true])
            ->get(route('email_report', $report->week_number));

        $response->assertOk();
    }
}
