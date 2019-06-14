<?php

namespace Tests\Feature;

use App\Date;
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
            'key_date' => null,
            'key_date_description' => null,
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

        $this->get('/')->assertSee('Explo Code (already filled)');
    }

    public function testFillWithAKeyDate()
    {
        $response = $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
            'key_date' => $date = now()->addDays(5)->format('Y-m-d'),
            'key_date_description' => 'Date description',
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

        $this->assertArraySubset([
            'project' => 'Explo Code',
            'date' => $date,
            'description' => 'Date description',
        ], Date::first()->toArray());
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

    public function testCantFillDatesTwice()
    {
        $data = [
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => '',
            'key_date' => $date = now()->addDays(5)->format('Y-m-d'),
            'key_date_description' => 'Date description',
        ];

        Carbon::setTestNow(Carbon::create(2019, 1, 4));
        $this->submitForm($data)->assertStatus(200);

        $this->assertEquals(1, Report::count());
        $this->assertEquals(1, Date::count());

        Carbon::setTestNow(Carbon::create(2019, 3, 8));
        $this->submitForm($data)
            ->assertStatus(302)
            ->assertSessionHasErrors('key_date');

        $this->assertEquals(1, Report::count());
        $this->assertEquals(1, Date::count());
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

    public function testPartialFillForDateNoDescription()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => 'Send help',
            'key_date' => now()->addDays(20)->format('Y-m-d'),
        ])->assertSessionHasErrors('key_date_description');

        $this->assertEquals(0, Report::count());
    }

    public function testDateIsAValidDate()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => 'Send help',
            'key_date' => 'Foo',
        ])->assertSessionHasErrors('key_date');

        $this->assertEquals(0, Report::count());
    }

    public function testPartialFillForDateNoDate()
    {
        $this->submitForm([
            'spirit' => '🙂',
            'project' => 'Explo Code',
            'priorities' => 'Writing things!',
            'victories' => 'It was a good week',
            'help' => 'Send help',
            'key_date_description' => 'Description',
        ])->assertSessionHasErrors('key_date');

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
