<?php

namespace Tests\Feature;

use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsProjectExportTest extends TestCase
{
    use RefreshDatabase;

    public function testExport()
    {
        $report = factory(Report::class)->create();

        $this
            ->get(route('reports.export', $report->project))
            ->assertRedirect(route('login'));

        $response = $this
            ->withSession(['logged_in' => true])
            ->get(route('reports.export', $report->project));

        $response->assertOk();
        $response->assertHeader('content-disposition');
    }
}
