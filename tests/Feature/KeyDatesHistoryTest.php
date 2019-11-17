<?php

namespace Tests\Feature;

use App\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KeyDatesHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function testDatesIndexNoDates()
    {
        $this->get(route('dates.index'))->assertRedirect(route('login'));

        $this
            ->withSession(['logged_in' => true])
            ->get(route('dates.index'))
            ->assertNotFound();
    }

    public function testDatesIndex()
    {
        factory(Date::class)->create();

        $this->get(route('dates.index'))->assertRedirect(route('login'));

        $this
            ->withSession(['logged_in' => true])
            ->get(route('dates.index'))
            ->assertOk();
    }
}
