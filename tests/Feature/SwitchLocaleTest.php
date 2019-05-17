<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SwitchLocaleTest extends TestCase
{
    use RefreshDatabase;

    public function testSwitchLocaleToFr()
    {
        $this->assertEquals(app()->getLocale(), 'en');

        $response = $this->get(route('home'));

        $response->assertOk()->assertSee(trans('layout.previous_bulletins', [], 'en'));

        $response = $this->get(route('setLocale', 'fr'));

        $response = $this->get(route('home'));
        $response->assertOk()->assertSee(trans('layout.previous_bulletins', [], 'fr'));
    }
}
