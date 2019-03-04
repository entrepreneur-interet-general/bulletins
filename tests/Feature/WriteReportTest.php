<?php

namespace Tests\Feature;

use App\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WriteReportTest extends TestCase
{
    use RefreshDatabase;


    public function testCompleteForm()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response = $this->json('POST', '/reports/store', [
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => ''
        ]);

        $response->assertOk();

        $this->assertCount(1, Report::all());

        $this->assertArraySubset([
            'week_number' => now()->format('Y-W'),
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => null
        ], Report::first()->toArray());
    }
}
