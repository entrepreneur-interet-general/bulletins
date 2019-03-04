<?php

namespace Tests\Feature;

use App\Report;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WriteReportTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::create(2019, 3, 8, 14, 59));
    }

    public function testCompleteForm()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response = $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
        ]);

        $response->assertOk();

        $this->assertCount(1, Report::all());

        $this->assertArraySubset([
            'week_number' => now()->format('Y-W'),
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => null,
        ], Report::first()->toArray());
    }

    public function testInvalidSpririt()
    {
        $this->submitForm([
            'spirit' => 'NOPE',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
        ])->assertSessionHasErrors('spirit');

        $this->assertCount(0, Report::all());
    }

    public function testInvalidProject()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'INVALID',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
        ])->assertSessionHasErrors('project');

        $this->assertCount(0, Report::all());
    }

    public function testInvalidPriorities()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => '',
            'victories' => 'It was a good week',
            'help' => '',
        ])->assertSessionHasErrors('priorities');

        $this->assertCount(0, Report::all());
    }

    public function testInvalidVictories()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => '',
            'help' => '',
        ])->assertSessionHasErrors('victories');

        $this->assertCount(0, Report::all());
    }

    public function testInvalidHelp()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => str_repeat('a', 301),
        ])->assertSessionHasErrors('help');

        $this->assertCount(0, Report::all());
    }

    public function testCannotFillDuringWeekEnd()
    {
        // Saturday: can't fill the form
        Carbon::setTestNow(Carbon::create(2019, 3, 9));

        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
        ])->assertStatus(403);

        $this->assertCount(0, Report::all());
    }

    private function submitForm($data)
    {
        return $this->post(route('reports.store'), $data);
    }
}
