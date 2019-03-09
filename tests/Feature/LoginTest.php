<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testCanLoadForm()
    {
        $this->get(route('login'))->assertOk();
    }

    public function testInvalidSubmitForm()
    {
        session()->setPreviousUrl(route('login'));

        $this
            ->post(route('login'), ['password' => 'nope'])
            ->assertRedirect(route('login'))
            ->assertSessionHas('error');

        $this->assertFalse(session()->has('logged_in'));
    }

    public function testLoginSuccess()
    {
        $this
            ->post(route('login'), ['password' => config('app.report_secret')])
            ->assertSessionMissing('error')
            ->assertRedirect(route('reports.choose'));

        $this->assertTrue(session()->has('logged_in'));
    }
}
