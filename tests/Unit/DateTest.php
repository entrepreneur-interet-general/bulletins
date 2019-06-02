<?php

namespace Tests\Unit;

use App\Date;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DateTest extends TestCase
{
    use RefreshDatabase;

    public function testForProject()
    {
        factory(Date::class)->create(['project' => 'A']);
        factory(Date::class)->create(['project' => 'B', 'date' => '2015-01-01']);
        factory(Date::class)->create(['project' => 'B', 'date' => '2015-01-02']);

        $this->assertEquals(1, Date::forProject('A')->count());
        $this->assertEquals(2, Date::forProject('B')->count());
    }

    public function testUpcoming()
    {
        $a = factory(Date::class)->create(['date' => now()]);
        $b = factory(Date::class)->create(['date' => now()->addDays(2)]);
        $c = factory(Date::class)->create(['date' => now()->subDays(1)]);

        $this->assertEquals(2, Date::upcoming()->count());
        $this->assertEquals(1, Date::past()->count());

        $this->assertTrue(Date::upcoming()->get()->contains($a));
        $this->assertTrue(Date::upcoming()->get()->contains($b));
        $this->assertTrue(Date::past()->get()->contains($c));
    }
}
