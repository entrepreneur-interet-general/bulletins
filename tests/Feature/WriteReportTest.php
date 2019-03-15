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

        $this->assertEquals(1, Report::count());

        $this->assertArraySubset([
            'week_number' => now()->format('Y-W'),
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => null,
        ], Report::first()->toArray());

        $this->get('/')->assertSee('Explo Code (déjà renseigné)');
    }

    public function testCantFillTwiceForm()
    {
        $data = [
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
        ];

        $this->assertEquals(0, Report::count());

        $this->submitForm($data);

        $this->assertEquals(1, Report::count());

        $this->submitForm($data)->assertStatus(500);

        $this->assertEquals(1, Report::count());
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

        $this->assertEquals(0, Report::count());
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

        $this->assertEquals(0, Report::count());
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

        $this->assertEquals(0, Report::count());
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

        $this->assertEquals(0, Report::count());
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

        $this->assertEquals(0, Report::count());
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

        $this->assertEquals(0, Report::count());
    }

    private function submitForm($data)
    {
        return $this->post(route('reports.store'), $data);
    }
}
