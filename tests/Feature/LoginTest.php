<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testCanLoadForm()
    {
        config(['app.reports_password_hint' => 'Password hint']);

        $this->get(route('login'))->assertOk()->assertSee('Password hint');

        config(['app.reports_password_hint' => null]);

        $this->get(route('login'))->assertOk()->assertDontSee('text-quote');
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
